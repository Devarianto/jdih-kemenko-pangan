@extends('layouts.app')

@section('page-title', 'Manajemen Partisipasi Publik')

@section('content')

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('admin.partisipasi.index') }}" class="filter-bar">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau unit kerja..." class="form-control filter-select" style="min-width: 240px;">

        <select name="filter_status" class="form-control filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pengajuan" {{ request('filter_status') == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
            <option value="pembahasan" {{ request('filter_status') == 'pembahasan' ? 'selected' : '' }}>Pembahasan
            </option>
            <option value="uji_publik" {{ request('filter_status') == 'uji_publik' ? 'selected' : '' }}>Partisipasi
                Publik</option>
            <option value="pasca_partisipasi" {{ request('filter_status') == 'pasca_partisipasi' ? 'selected' : '' }}>
                Pasca Partisipasi Publik</option>
            <option value="harmonisasi" {{ request('filter_status') == 'harmonisasi' ? 'selected' : '' }}>Harmonisasi
            </option>
            <option value="penetapan" {{ request('filter_status') == 'penetapan' ? 'selected' : '' }}>Penetapan</option>
            <option value="selesai" {{ request('filter_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>

        <select name="filter_jenis" class="form-control filter-select" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="Peraturan Presiden" {{ request('filter_jenis') == 'Peraturan Presiden' ? 'selected' : '' }}>
                Peraturan Presiden</option>
            <option value="Peraturan Menteri Koordinator" {{ request('filter_jenis') == 'Peraturan Menteri Koordinator' ? 'selected' : '' }}>Peraturan Menteri Koordinator</option>
            <option value="Keputusan Menteri Koordinator" {{ request('filter_jenis') == 'Keputusan Menteri Koordinator' ? 'selected' : '' }}>Keputusan Menteri Koordinator</option>
            <option value="Instruksi Menteri Koordinator" {{ request('filter_jenis') == 'Instruksi Menteri Koordinator' ? 'selected' : '' }}>Instruksi Menteri Koordinator</option>
        </select>

        <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">Cari</button>

        @if(request('search') || request('filter_status') || request('filter_jenis'))
            <a href="{{ route('admin.partisipasi.index') }}" class="filter-reset-link">✕ Hapus Filter</a>
        @endif
    </form>

    <div class="card">
        <div class="card-title">Daftar Regulasi & Status Partisipasi Publik</div>

        {{-- Desktop: tabel biasa --}}
        <div class="table-scroll desktop-only-table">
            <table id="partisipasiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Periode Partisipasi Publik</th>
                        <th>Tanggapan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($regulasi as $i => $reg)
                        @php
                            // Sama seperti di halaman Pengajuan Regulasi: tentukan stage yang ditampilkan
                            if ($reg->status === 'selesai') {
                                $displayStage = 'selesai';
                            } elseif ($reg->current_stage === 'uji_publik' && $reg->pasca_partisipasi_dimulai) {
                                $displayStage = 'pasca_partisipasi';
                            } else {
                                $displayStage = $reg->current_stage;
                            }

                            $stageLabels = [
                                'pengajuan' => 'Pengajuan',
                                'pembahasan' => 'Pembahasan',
                                'uji_publik' => 'Partisipasi Publik',
                                'pasca_partisipasi' => 'Pasca Partisipasi Publik',
                                'harmonisasi' => 'Harmonisasi',
                                'penetapan' => 'Penetapan',
                                'selesai' => 'Selesai',
                            ];

                            $hasTanggapan = $reg->tanggapan->count() > 0;
                            $canAccess = true;
                            $aksiLabel = $hasTanggapan ? 'Kelola & Tanggapan' : 'Atur Uji Publik';
                        @endphp
                        <tr>
                            <td>{{ $regulasi->firstItem() + $i }}</td>
                            <td>{{ $reg->judul }}</td>
                            <td style="font-size: 12px;">{{ $reg->jenis }}</td>
                            <td>
                                <span class="reg-status-dot stage-{{ $displayStage }}">
                                    <span class="reg-status-dot-circle"></span>
                                    {{ $stageLabels[$displayStage] ?? $displayStage }}
                                </span>
                            </td>
                            <td style="font-size: 12px; color: #4a5568;">
                                @if($reg->partisipasiPublik)
                                    <div style="display:flex; flex-direction:column; gap:3px;">
                                        <span style="color:#6b7280;">Mulai &nbsp;</span>
                                        <strong>{{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_mulai)->format('d M Y') }}</strong>
                                        <span style="color:#6b7280; margin-top:2px;">Selesai</span>
                                        <strong>{{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_selesai)->format('d M Y') }}</strong>
                                    </div>
                                @else
                                    <span style="color: #ccc; font-style: italic; font-size: 11.5px;">Belum diset</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $realVisibleRow = $reg->tanggapan->where('is_hidden', false)->count();
                                    $tampilRow = $reg->partisipasiPublik
                                        ? $reg->partisipasiPublik->displayMasukanCount($realVisibleRow)
                                        : $realVisibleRow;
                                    $adjRow = (int) ($reg->partisipasiPublik->masukan_tambahan ?? 0);
                                @endphp
                                <strong>{{ $reg->tanggapan->count() }}</strong> masukan
                                @if(auth()->user()->role === 'super_admin' && $adjRow !== 0)
                                    <div style="font-size: 11px; color: #0d47a1; font-weight: 600; margin-top: 2px;">
                                        Tampil di publik: {{ $tampilRow }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($canAccess)
                                    <a href="{{ route('admin.partisipasi.show', $reg->id) }}"
                                        class="btn-detail">{{ $aksiLabel }}</a>
                                @else
                                    <span class="aksi-none">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #aaa; padding: 32px;">
                                @if(request('filter_status') || request('filter_jenis'))
                                    Tidak ada regulasi yang cocok dengan filter ini.
                                @else
                                    Belum ada regulasi.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile: daftar kartu ringkas (bukan tabel di-CSS-paksa) --}}
        <div class="mobile-only-cards">
            @forelse($regulasi as $i => $reg)
                @php
                    if ($reg->status === 'selesai') {
                        $displayStage = 'selesai';
                    } elseif ($reg->current_stage === 'uji_publik' && $reg->pasca_partisipasi_dimulai) {
                        $displayStage = 'pasca_partisipasi';
                    } else {
                        $displayStage = $reg->current_stage;
                    }

                    $stageLabels = [
                        'pengajuan' => 'Pengajuan',
                        'pembahasan' => 'Pembahasan',
                        'uji_publik' => 'Partisipasi Publik',
                        'pasca_partisipasi' => 'Pasca Partisipasi Publik',
                        'harmonisasi' => 'Harmonisasi',
                        'penetapan' => 'Penetapan',
                        'selesai' => 'Selesai',
                    ];

                    $hasTanggapan = $reg->tanggapan->count() > 0;
                    $canAccess = true;
                    $aksiLabel = $hasTanggapan ? 'Kelola & Tanggapan' : 'Atur Uji Publik';
                @endphp
                <div class="reg-card">
                    <div class="reg-card-top">
                        <span class="reg-status-dot stage-{{ $displayStage }}">
                            <span class="reg-status-dot-circle"></span>
                            {{ $stageLabels[$displayStage] ?? $displayStage }}
                        </span>
                        <span class="reg-card-date">{{ $reg->tanggapan->count() }} masukan</span>
                    </div>
                    <div class="reg-card-title">{{ $reg->judul }}</div>
                    <div class="reg-card-meta">{{ $reg->jenis }}</div>
                    <div class="reg-card-periode">
                        @if($reg->partisipasiPublik)
                            Mulai <strong>{{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_mulai)->format('d M Y') }}</strong>
                            &nbsp;·&nbsp;
                            Selesai
                            <strong>{{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_selesai)->format('d M Y') }}</strong>
                        @else
                            <span style="color:#ccc; font-style: italic;">Periode belum diset</span>
                        @endif
                    </div>
                    @if($canAccess)
                        <div class="reg-card-actions">
                            <a href="{{ route('admin.partisipasi.show', $reg->id) }}" class="btn btn-detail">{{ $aksiLabel }}</a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state" style="text-align:center;color:#aaa;padding:32px 16px;">
                    @if(request('filter_status') || request('filter_jenis'))
                        Tidak ada regulasi yang cocok dengan filter ini.
                    @else
                        Belum ada regulasi.
                    @endif
                </div>
            @endforelse
        </div>

        @if($regulasi->hasPages())
            <div class="pagination-wrap">
                {{ $regulasi->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

    <style>
        .table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-select {
            width: auto;
            min-width: 180px;
            font-size: 13px;
            padding: 8px 12px;
        }

        .filter-reset-link {
            font-size: 12.5px;
            color: #a32626;
            text-decoration: none;
            font-weight: 600;
        }

        .filter-reset-link:hover {
            text-decoration: underline;
        }

        .aksi-none {
            color: #c7cbd6;
            font-size: 13px;
        }

        .pagination-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrap nav>div {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ══════════════════ RESPONSIVE ══════════════════ */

        @media (max-width: 768px) {
            .filter-select {
                min-width: 0;
                flex: 1 1 200px;
            }
        }

        /* Mobile: sembunyikan tabel, tampilkan daftar kartu ringkas */
        .mobile-only-cards {
            display: none;
        }

        @media (max-width: 640px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select {
                width: 100%;
                flex: 0 1 auto;
            }

            .desktop-only-table {
                display: none;
            }

            .mobile-only-cards {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .reg-card {
                border: 1px solid #ebedf2;
                border-radius: 12px;
                padding: 14px 16px;
            }

            .reg-card-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                margin-bottom: 8px;
            }

            .reg-card-date {
                font-size: 11.5px;
                color: #9aa1b1;
                flex-shrink: 0;
            }

            .reg-card-title {
                font-size: 13.5px;
                font-weight: 600;
                color: #1a1a2e;
                line-height: 1.4;
                overflow-wrap: break-word;
            }

            .reg-card-meta {
                font-size: 12px;
                color: #8a93a6;
                margin-top: 4px;
            }

            .reg-card-periode {
                font-size: 11.5px;
                color: #6b7280;
                margin-top: 8px;
                padding-top: 8px;
                border-top: 1px dashed #eef0f5;
            }

            .reg-card-actions {
                display: grid;
                grid-template-columns: 1fr;
                gap: 8px;
                margin-top: 12px;
            }

            .reg-card-actions .btn {
                font-size: 12.5px;
                padding: 9px 10px;
                box-sizing: border-box;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* ── Status dot base ── */
        .reg-status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            border-radius: 20px;
            padding: 4px 12px 4px 8px;
            white-space: nowrap;
            letter-spacing: 0.01em;
            color: #5a6380;
            background: #f4f5f9;
            border: 1px solid #e8eaf2;
        }

        .reg-status-dot-circle {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
            background: currentColor;
        }

        /* Pengajuan — abu-abu */
        .stage-pengajuan {
            color: #64748b;
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        /* Pembahasan — biru */
        .stage-pembahasan {
            color: #3b5ec7;
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        /* Partisipasi Publik — ungu */
        .stage-uji_publik {
            color: #8b5cb4;
            background: #faf5ff;
            border-color: #e9d5ff;
        }

        /* Pasca Partisipasi Publik — merah tua */
        .stage-pasca_partisipasi {
            color: #cf7878;
            background: #fef2f2;
            border-color: #fecaca;
        }

        /* Harmonisasi — oranye */
        .stage-harmonisasi {
            color: #c06744;
            background: #fff7ed;
            border-color: #fed7aa;
        }

        /* Penetapan — kuning */
        .stage-penetapan {
            color: #bd8638;
            background: #fefce8;
            border-color: #fef08a;
        }

        /* Selesai — hijau */
        .stage-selesai {
            color: #52a772;
            background: #f0fdf4;
            border-color: #bbf7d0;
        }
    </style>

@endsection