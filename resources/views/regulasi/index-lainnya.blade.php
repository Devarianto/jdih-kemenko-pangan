@extends('layouts.app')

@section('page-title', 'Pengajuan Regulasi')

@section('content')

    <div class="page-header-row">
        <h2 class="page-header-title">Pengajuan Regulasi Kemenko</h2>
        <input type="text" placeholder="Cari di halaman ini..." class="search-input" id="searchInput">
    </div>

    <div class="role-toggle-row">
        <a href="{{ route('regulasi.index') }}" class="btn btn-outline" style="font-size: 13px;">Pengajuan Regulasi
            {{ auth()->user()->unit_kerja ?? '' }}</a>
        <a href="{{ route('regulasi.lainnya') }}" class="btn btn-primary" style="font-size: 13px;">Pengajuan Regulasi
            Kemenko</a>
    </div>

    <div class="info-banner">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#4a72c4"
            stroke-width="2" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <span>Data di bawah adalah seluruh regulasi yang diajukan oleh unit kerja di lingkungan Kemenko Pangan. Halaman ini
            bersifat <strong>hanya baca</strong>.</span>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('regulasi.lainnya') }}" class="filter-bar">
        <select name="filter_status" class="form-control filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pengajuan" {{ request('filter_status') == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
            <option value="pembahasan" {{ request('filter_status') == 'pembahasan' ? 'selected' : '' }}>Pembahasan</option>
            <option value="uji_publik" {{ request('filter_status') == 'uji_publik' ? 'selected' : '' }}>Partisipasi Publik
            </option>
            <option value="pasca_partisipasi" {{ request('filter_status') == 'pasca_partisipasi' ? 'selected' : '' }}>Pasca
                Partisipasi Publik</option>
            <option value="harmonisasi" {{ request('filter_status') == 'harmonisasi' ? 'selected' : '' }}>Harmonisasi</option>
            <option value="penetapan" {{ request('filter_status') == 'penetapan' ? 'selected' : '' }}>Penetapan</option>
            <option value="selesai" {{ request('filter_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>

        <select name="filter_jenis" class="form-control filter-select" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="Peraturan Menteri Koordinator" {{ request('filter_jenis') == 'Peraturan Menteri Koordinator' ? 'selected' : '' }}>Peraturan Menteri Koordinator</option>
            <option value="Peraturan Presiden" {{ request('filter_jenis') == 'Peraturan Presiden' ? 'selected' : '' }}>
                Peraturan Presiden</option>
            <option value="Peraturan Menteri" {{ request('filter_jenis') == 'Peraturan Menteri' ? 'selected' : '' }}>Peraturan
                Menteri</option>
        </select>

        @if(request('filter_status') || request('filter_jenis'))
            <a href="{{ route('regulasi.lainnya') }}" class="filter-reset-link">✕ Hapus Filter</a>
        @endif
    </form>

    <div class="card">
        <div class="table-scroll desktop-only-table">
            <table id="regulasiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Judul</th>
                        <th>Unit Kerja</th>
                        <th>Tgl Usulan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
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
                        @endphp
                        <tr>
                            <td>{{ $regulasi->firstItem() + $i }}</td>
                            <td>{{ $reg->jenis }}</td>
                            <td>{{ $reg->judul }}</td>
                            <td>{{ $reg->unit_kerja }}</td>
                            <td>{{ $reg->tgl_usulan?->format('d M Y') }}</td>
                            <td>
                                <span class="reg-status-dot stage-{{ $displayStage }}">
                                    <span class="reg-status-dot-circle"></span>
                                    {{ $stageLabels[$displayStage] ?? $displayStage }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #aaa; padding: 32px;">
                                @if(request('filter_status') || request('filter_jenis'))
                                    Tidak ada regulasi yang cocok dengan filter ini.
                                @else
                                    Belum ada regulasi dari unit kerja lain.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile: daftar kartu ringkas --}}
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
                @endphp
                <div class="reg-card">
                    <div class="reg-card-top">
                        <span class="reg-status-dot stage-{{ $displayStage }}">
                            <span class="reg-status-dot-circle"></span>
                            {{ $stageLabels[$displayStage] ?? $displayStage }}
                        </span>
                        <span class="reg-card-date">{{ $reg->tgl_usulan?->format('d M Y') }}</span>
                    </div>
                    <div class="reg-card-title">{{ $reg->judul }}</div>
                    <div class="reg-card-meta">{{ $reg->jenis }} &middot; {{ $reg->unit_kerja }}</div>
                </div>
            @empty
                <div class="empty-state" style="text-align:center;color:#aaa;padding:32px 16px;">
                    @if(request('filter_status') || request('filter_jenis'))
                        Tidak ada regulasi yang cocok dengan filter ini.
                    @else
                        Belum ada regulasi dari unit kerja lain.
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
        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .page-header-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .page-header-row .search-input {
            flex-shrink: 0;
        }

        .role-toggle-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .info-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f0f4ff;
            border: 1px solid #d4e0fb;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 18px;
            color: #1e3a6e;
            font-size: 13px;
        }

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

        .pagination-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        /* ══════════════════ RESPONSIVE ══════════════════ */

        @media (max-width: 768px) {
            .page-header-row .search-input {
                width: 100%;
                flex: 1 1 100%;
            }

            .filter-select {
                min-width: 0;
                flex: 1 1 200px;
            }

            .role-toggle-row .btn {
                flex: 1 1 auto;
                text-align: center;
            }
        }

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

            .info-banner {
                align-items: flex-start;
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
        }

        /* ── Status dot base ── */
        .reg-status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            border-radius: 20px;
            padding: 4px 10px 4px 8px;
            white-space: nowrap;
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

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#regulasiTable tbody tr').forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>

@endsection