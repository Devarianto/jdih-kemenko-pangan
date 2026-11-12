@extends('layouts.app')

@section('page-title', 'Dashboard Eksekutif')

@section('content')

    @php
        $user = auth()->user();
        $isSuperAdmin = $user->role === 'super_admin';

        $stageColors = [
            'pengajuan' => '#64748b',
            'pembahasan' => '#3b5ec7',
            'uji_publik' => '#8b5cb4',
            'pasca_partisipasi' => '#cf7878',
            'harmonisasi' => '#c06744',
            'penetapan' => '#bd8638',
            'selesai' => '#52a772',
        ];
        $stageLabels = [
            'pengajuan' => 'Pengajuan',
            'pembahasan' => 'Pembahasan',
            'uji_publik' => 'Partisipasi Publik',
            'pasca_partisipasi' => 'Pasca Partisipasi',
            'harmonisasi' => 'Harmonisasi',
            'penetapan' => 'Penetapan',
            'selesai' => 'Selesai',
        ];
        $stageOrder = ['pengajuan', 'pembahasan', 'uji_publik', 'pasca_partisipasi', 'harmonisasi', 'penetapan', 'selesai'];

        // Hitung jumlah per stage dari regulasiTerbaru (semua data, bukan hanya 5 terbaru)
        // Controller harus kirim $regulasiSemuaStage atau kita pakai $tahapan yang sudah ada
        // Sementara pakai $tahapan dari controller, map ke stage baru
        $stageCounts = array_fill_keys($stageOrder, 0);
        foreach ($regulasiTerbaru as $r) {
            if ($r->status === 'selesai') {
                $stageCounts['selesai']++;
            } elseif ($r->current_stage === 'uji_publik' && $r->pasca_partisipasi_dimulai) {
                $stageCounts['pasca_partisipasi']++;
            } elseif (isset($stageCounts[$r->current_stage])) {
                $stageCounts[$r->current_stage]++;
            }
        }

        // Regulasi yang "mandek" — belum selesai & sudah lama tidak ada update
        $stuckThresholdDays = 14;
        $now = \Carbon\Carbon::now();
        $stuckRegulasi = collect($regulasiTerbaru)
            ->filter(fn($r) => $r->status !== 'selesai')
            ->map(function ($r) use ($now) {
                $lastTouch = $r->updated_at ?? $r->tgl_usulan;
                $r->days_stuck = $lastTouch ? $now->diffInDays(\Carbon\Carbon::parse($lastTouch)) : 0;
                $r->stage_key = ($r->current_stage === 'uji_publik' && $r->pasca_partisipasi_dimulai)
                    ? 'pasca_partisipasi'
                    : ($r->current_stage ?? 'pengajuan');
                return $r;
            })
            ->filter(fn($r) => $r->days_stuck >= $stuckThresholdDays)
            ->sortByDesc('days_stuck')
            ->take(5)
            ->values();
    @endphp

    @php
        $jam = (int) $now->format('G');
        $sapaan = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 19 ? 'Selamat sore' : 'Selamat malam'));
        $rawNama = $user->display_name ?: $user->name;
        $namaUser = trim(preg_replace('/\s*\([^)]*\)/', '', $rawNama)) ?: $rawNama;
        $inisial = collect(preg_split('/\s+/', $namaUser))
            ->map(fn($w) => preg_replace('/[^a-zA-Z0-9]/u', '', $w))
            ->filter()
            ->take(2)
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->implode('');
        $jumlahPending = $pendingUjiPublik->count();
        $jumlahDitolak = $isSuperAdmin ? 0 : $rejectedUjiPublik->count();
        $perluPerhatian = $isSuperAdmin ? $jumlahPending : ($jumlahDitolak + $stuckRegulasi->count());
    @endphp

    <div class="dash-wrap">

        {{-- ═══ HERO / SELAMAT DATANG ═══ --}}
        <section class="dash-hero slide-in" aria-label="Selamat datang">
            <div class="dash-hero-main">
                <div class="dash-hero-avatar" aria-hidden="true">{{ $inisial ?: 'U' }}</div>
                <div class="dash-hero-text">
                    <div class="dash-hero-date">{{ $now->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                    <h2 class="dash-hero-title">{{ $sapaan }}, {{ $namaUser }}!</h2>
                    <div class="dash-hero-meta">
                        <span class="hero-chip">{{ $isSuperAdmin ? 'Super Admin' : 'Operator e-Regulasi' }}</span>
                        @if(!$isSuperAdmin && $user->unit_kerja)
                            <span class="hero-chip hero-chip-soft">{{ $user->unit_kerja }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dash-hero-actions">
                <a href="{{ route('regulasi.create') }}" class="hero-btn hero-btn-primary">
                    <i class="fa fa-plus-circle"></i> Ajukan Regulasi Baru
                </a>
                <a href="{{ route('regulasi.index') }}" class="hero-btn">
                    <i class="fa fa-folder-open"></i> Daftar Pengajuan
                </a>
                <a href="{{ route('admin.partisipasi.index') }}" class="hero-btn">
                    <i class="fa fa-comments"></i> Partisipasi Publik
                </a>
            </div>
        </section>

        {{-- ═══ STAT ROW ═══ --}}
        <div class="dash-stats">
            <div class="dash-stat is-clickable accent-indigo" data-filter="all" tabindex="0" role="button">
                <div class="dash-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6" />
                        <path d="M9 13h6M9 17h6M9 9h1" />
                    </svg>
                </div>
                <div class="dash-stat-body">
                    <div class="dash-stat-top">{{ $isSuperAdmin ? 'Total regulasi' : 'Total Regulasi' }}</div>
                    <div class="dash-stat-num" data-counter="{{ $stats['total_rancangan'] }}">0</div>
                    <div class="dash-stat-sub">{{ $isSuperAdmin ? 'Semua unit kerja' : $user->unit_kerja }}</div>
                </div>
            </div>
            <div class="dash-stat is-clickable accent-amber" data-filter="proses" tabindex="0" role="button">
                <div class="dash-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                </div>
                <div class="dash-stat-body">
                    <div class="dash-stat-top">Dalam Proses</div>
                    <div class="dash-stat-num" data-counter="{{ $stats['total_proses'] }}">0</div>
                    <div class="dash-stat-sub">Pembahasan s/d Harmonisasi</div>
                </div>
            </div>
            <div class="dash-stat is-clickable accent-green" data-filter="selesai" tabindex="0" role="button">
                <div class="dash-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                </div>
                <div class="dash-stat-body">
                    <div class="dash-stat-top">{{ $isSuperAdmin ? 'Selesai / penetapan' : 'Selesai' }}</div>
                    <div class="dash-stat-num" data-counter="{{ $stats['total_selesai'] }}">0</div>
                    <div class="dash-stat-sub">{{ $isSuperAdmin ? 'Tahun ini' : 'Penetapan' }}</div>
                </div>
            </div>
            <div class="dash-stat accent-blue">
                <div class="dash-stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div class="dash-stat-body">
                    <div class="dash-stat-top">{{ $isSuperAdmin ? 'Total tanggapan' : 'Tanggapan Masuk' }}</div>
                    <div class="dash-stat-num" data-counter="{{ $stats['total_tanggapan'] }}">0</div>
                    <div class="dash-stat-sub">
                        @if($isSuperAdmin)
                            {{ $stats['masukan_masyarakat'] }} masyarakat &middot; {{ $stats['masukan_instansi'] }} instansi
                        @else
                            Untuk unit kerja ini
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ NOTIFIKASI OPERATOR ═══ --}}
        @if(!$isSuperAdmin)
            @if($rejectedUjiPublik->isNotEmpty())
                <div class="dash-banner banner-warn slide-in">
                    ⚠️ <strong>{{ $rejectedUjiPublik->count() }} request Partisipasi Publik</strong> ditolak Super Admin. Silakan
                    tinjau dan ajukan ulang.
                    <div style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($rejectedUjiPublik as $reg)
                            <a href="{{ route('regulasi.show', $reg->id) }}"
                                class="dash-chip-link">{{ Str::limit($reg->judul, 40) }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- ═══ SUPER ADMIN: pending approval ═══ --}}
        @if($isSuperAdmin && $pendingUjiPublik->isNotEmpty())
            <div class="dash-card approval-card slide-in">
                <div class="dash-card-title approval-title">⏱ Menunggu Persetujuan Partisipasi Publik
                    ({{ $pendingUjiPublik->count() }})</div>
                <div class="approval-list">
                    @foreach($pendingUjiPublik as $reg)
                        <div class="approval-row">
                            <div>
                                <div class="approval-judul">{{ $reg->judul }}</div>
                                <div class="approval-meta">
                                    {{ $reg->unit_kerja }} &middot; Diajukan {{ optional($reg->updated_at)->format('d M Y') }}
                                    @if($reg->partisipasiPublik)
                                        &middot; Periode:
                                        {{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_mulai)->isoFormat('D MMM Y') }} —
                                        {{ \Carbon\Carbon::parse($reg->partisipasiPublik->tgl_selesai)->isoFormat('D MMM Y') }}
                                    @endif
                                </div>
                            </div>
                            <div class="approval-actions">
                                <form action="{{ route('regulasi.uji-publik.approve', $reg) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-pill btn-pill-approve">✓ Setujui</button>
                                </form>
                                <form action="{{ route('regulasi.uji-publik.reject', $reg) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-pill btn-pill-reject">✕ Tolak</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif(!$isSuperAdmin && $pendingUjiPublik->isNotEmpty())
            <div class="dash-banner banner-info slide-in">
                ⏳ <strong>{{ $pendingUjiPublik->count() }} request Partisipasi Publik</strong> sedang menunggu persetujuan Super
                Admin.
            </div>
        @endif

        {{-- ═══ GRAFIK + DETAIL ═══ --}}
        <div class="dash-grid-2">

            <div class="dash-card">
                <div class="dash-card-title">Sebaran Tahap Regulasi{{ $isSuperAdmin ? '' : ' — ' . $user->unit_kerja }}</div>

                <div class="bar-legend">
                    @foreach($stageOrder as $sk)
                        @if($stageCounts[$sk] > 0)
                            <span class="legend-item">
                                <span class="legend-dot" style="background: {{ $stageColors[$sk] }};"></span>
                                {{ $stageLabels[$sk] }}
                            </span>
                        @endif
                    @endforeach
                </div>

                <div class="bar-chart-wrap">
                    <div class="bar-chart" id="barChart">
                        @php $maxVal = max(max($stageCounts) ?: 1, 1); @endphp
                        @foreach($stageOrder as $sk)
                            @php
                                $jumlah = $stageCounts[$sk];
                                $pct = $jumlah > 0 ? max(6, round(($jumlah / $maxVal) * 100)) : 0;
                                $color = $stageColors[$sk];
                                $label = $stageLabels[$sk];
                            @endphp
                            <div class="bar-col" data-stage="{{ $sk }}">
                                <div class="bar-track">
                                    @if($jumlah > 0)
                                        <div class="bar-fill" style="--target-height: {{ $pct }}%; background: {{ $color }};">
                                            <span class="bar-value-top">{{ $jumlah }}</span>
                                            <div class="bar-tooltip">{{ $label }}: <strong>{{ $jumlah }}</strong> regulasi</div>
                                        </div>
                                    @endif
                                </div>
                                <span class="bar-label">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>{{-- end bar-chart-wrap --}}
            </div>

            <div class="dash-card">
                @if($isSuperAdmin)
                    <div class="dash-card-title">Regulasi per Unit Kerja</div>
                    <div class="unit-list">
                        @foreach($perUnitKerja as $item)
                            <div class="unit-row" data-unit="{{ $item->unit_kerja ?? '' }}" data-total="{{ $item->jumlah }}">
                                <span>{{ $item->unit_kerja ?? '-' }}</span>
                                <span class="unit-count" id="unit-count-{{ $loop->index }}">{{ $item->jumlah }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="dash-card-title">Status Pengajuan Partisipasi Publik</div>
                    <div class="status-request-list">
                        <div class="sr-row">
                            <span class="sr-label">Menunggu persetujuan</span>
                            <span class="sr-num">{{ $pendingUjiPublik->count() }}</span>
                        </div>
                        <div class="sr-row">
                            <span class="sr-label">Ditolak (perlu diajukan ulang)</span>
                            <span class="sr-num">{{ $rejectedUjiPublik->count() }}</span>
                        </div>
                        <div class="sr-row">
                            <span class="sr-label">Disetujui bulan ini</span>
                            <span class="sr-num">{{ $approvedThisMonth }}</span>
                        </div>
                    </div>

                    {{-- Regulasi yang mandek — belum selesai & lama tanpa update --}}
                    <div class="dash-card-title" style="margin-top: 22px; padding-top: 18px; border-top: 1px solid #f3f5fa;">
                        Regulasi Perlu Tindak Lanjut
                        @if($stuckRegulasi->isNotEmpty())
                            <span class="stuck-title-badge">{{ $stuckRegulasi->count() }}</span>
                        @endif
                    </div>
                    @if($stuckRegulasi->isEmpty())
                        <div class="stuck-empty">Tidak ada regulasi tanpa perkembangan &gt; {{ $stuckThresholdDays }} hari.</div>
                    @else
                        <div class="stuck-list">
                            @foreach($stuckRegulasi as $r)
                                @php
                                    $severity = $r->days_stuck >= 30 ? 'critical' : 'warn';
                                @endphp
                                <a href="{{ route('regulasi.show', $r->id) }}" class="stuck-row">
                                    <div class="stuck-row-main">
                                        <div class="stuck-judul">{{ Str::limit($r->judul, 38) }}</div>
                                        <div class="stuck-meta">
                                            <span class="stuck-stage-dot"></span>
                                            {{ $stageLabels[$r->stage_key] ?? $r->stage_key }}
                                        </div>
                                    </div>
                                    <span class="stuck-days stuck-days-{{ $severity }}">{{ $r->days_stuck }} hari</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

        </div>

        {{-- ═══ REGULASI TERBARU ═══ --}}
        <div class="dash-card">
            <div style="display:flex; justify-content: space-between; align-items: center;">
                <div class="dash-card-title" id="regulasiTerbaruTitle">
                    Regulasi Terbaru{{ $isSuperAdmin ? ' — Semua Unit' : ' — ' . $user->unit_kerja }}
                </div>
                <button type="button" class="filter-reset-btn" id="filterResetBtn" style="display:none;">✕ Hapus
                    Filter</button>
            </div>

            <div class="regulasi-list" id="regulasiTable">
                @forelse($regulasiTerbaru as $reg)
                    @php
                        if ($reg->status === 'selesai') {
                            $ds = 'selesai';
                        } elseif ($reg->current_stage === 'uji_publik' && $reg->pasca_partisipasi_dimulai) {
                            $ds = 'pasca_partisipasi';
                        } else {
                            $ds = $reg->current_stage ?? 'pengajuan';
                        }
                    @endphp
                    <div class="regulasi-row" data-row-stage="{{ $ds }}" data-row-unit="{{ $reg->unit_kerja }}">
                        <a href="{{ route('regulasi.show', $reg->id) }}" class="regulasi-link">
                            <div>
                                <div class="regulasi-judul">{{ $reg->judul }}</div>
                                <div class="regulasi-meta">{{ $reg->unit_kerja }} &middot;
                                    {{ $reg->tgl_usulan?->format('d M Y') }}
                                </div>
                            </div>
                            <span class="reg-status-dot stage-{{ $ds }}">
                                <span class="reg-status-dot-circle"></span>
                                {{ $stageLabels[$ds] ?? $ds }}
                            </span>
                        </a>
                    </div>
                @empty
                    <p style="text-align:center; color:#aaa; padding: 24px; font-size: 13px;">Belum ada regulasi.</p>
                @endforelse
            </div>
            <p id="filterEmptyMsg" style="display:none; text-align:center; color:#aaa; padding:24px; font-size: 13px;">
                Tidak ada regulasi dengan tahap ini di daftar terbaru.
            </p>
        </div>

    </div>

    <style>
        .dash-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── Hero / Selamat datang ── */
        .dash-hero {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 26px 30px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(120deg, #0f2b48 0%, #1d4ed8 60%, #0e9f8e 130%);
            box-shadow: 0 12px 30px rgba(15, 43, 72, 0.22);
        }

        .dash-hero::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
            pointer-events: none;
        }

        .dash-hero-main {
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 0;
            flex: 1 1 420px;
            position: relative;
            z-index: 1;
        }

        .dash-hero-avatar {
            flex-shrink: 0;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.18);
            border: 2px solid rgba(255, 255, 255, 0.45);
        }

        .dash-hero-text {
            min-width: 0;
        }

        .dash-hero-date {
            font-size: 12px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .dash-hero-title {
            margin: 4px 0 8px;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.25;
            color: #fff;
            word-break: break-word;
        }

        .dash-hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 0;
        }

        .hero-chip {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #d4af37;
            color: #1f2937;
        }

        .hero-chip-soft {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
        }

        .dash-hero-sub {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.55;
            opacity: 0.92;
            max-width: 560px;
        }

        .dash-hero-actions {
            position: relative;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: background 0.15s ease, transform 0.15s ease;
        }

        .hero-btn:hover {
            background: rgba(255, 255, 255, 0.26);
            color: #fff;
            transform: translateY(-1px);
        }

        .hero-btn-primary {
            background: #fff;
            color: #0f2b48;
            border-color: #fff;
        }

        .hero-btn-primary:hover {
            background: #eef2ff;
            color: #0f2b48;
        }

        @media (max-width: 640px) {
            .dash-hero {
                padding: 18px 16px;
                border-radius: 14px;
                gap: 14px;
            }

            .dash-hero-main {
                flex-direction: row;
                align-items: flex-start;
                gap: 12px;
                flex: 1 1 100%;
            }

            .dash-hero-avatar {
                width: 46px;
                height: 46px;
                font-size: 17px;
                margin-top: 2px;
            }

            .dash-hero-date {
                font-size: 11px;
            }

            .dash-hero-title {
                font-size: 18.5px;
                margin: 2px 0 6px;
            }

            .dash-hero-meta {
                gap: 6px;
                margin-bottom: 8px;
            }

            .hero-chip {
                font-size: 11px;
                padding: 2px 10px;
            }

            .dash-hero-sub {
                font-size: 12.5px;
                line-height: 1.45;
            }

            .dash-hero-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .hero-btn {
                width: 100%;
                justify-content: center;
                padding: 9px 10px;
                font-size: 12px;
                text-align: center;
            }

            .hero-btn-primary {
                grid-column: 1 / -1;
                padding: 10px 14px;
                font-size: 13px;
            }
        }

        /* ── Stat row ── */
        .dash-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .dash-stat {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #fff;
            border: 1px solid #edeef3;
            border-radius: 14px;
            padding: 20px 22px;
            transition: box-shadow 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
        }

        .dash-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent, #c7cad6);
            opacity: 0.85;
        }

        .dash-stat.is-clickable {
            cursor: pointer;
        }

        .dash-stat.is-clickable:hover {
            box-shadow: 0 10px 24px rgba(20, 30, 60, 0.07);
            transform: translateY(-2px);
            border-color: #dde0e9;
        }

        .dash-stat.is-active-filter {
            border-color: #2d3a55;
            box-shadow: 0 0 0 1px #2d3a55 inset;
        }

        .dash-stat.accent-indigo {
            --accent: #4f5fc7;
        }

        .dash-stat.accent-amber {
            --accent: #c99a3f;
        }

        .dash-stat.accent-green {
            --accent: #52a772;
        }

        .dash-stat.accent-blue {
            --accent: #3f8fc9;
        }

        .dash-stat-icon {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            color: var(--accent, #8a90a6);
            opacity: 0.85;
        }

        .dash-stat-icon svg {
            width: 100%;
            height: 100%;
        }

        .dash-stat-body {
            min-width: 0;
            flex: 1;
        }

        .dash-stat-top {
            font-size: 12.5px;
            color: #6b7280;
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .dash-stat-num {
            font-size: 30px;
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 8px;
            letter-spacing: -0.01em;
        }

        .dash-stat-sub {
            font-size: 11.5px;
            color: #9aa1b1;
            margin-top: 4px;
        }

        /* ── Banner ── */
        .dash-banner {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
        }

        .banner-warn {
            background: #fff4e0;
            color: #8a5a00;
            border: 1px solid #ffe1ab;
        }

        .banner-info {
            background: #fff8e1;
            color: #8a5a00;
            border: 1px solid #ffe9b8;
        }

        .dash-chip-link {
            display: inline-block;
            background: white;
            border: 1px solid #ffe1ab;
            color: #8a5a00;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 14px;
            text-decoration: none;
        }

        /* ── Card ── */
        .dash-card {
            background: #fff;
            border: 1px solid #ebedf2;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(20, 30, 60, 0.03);
        }

        .dash-card-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #1f2a44;
            margin-bottom: 16px;
        }

        /* ── Approval card ── */
        .approval-card {
            border-left: 3px solid #e08a2c;
            padding-left: 18px;
        }

        .approval-title {
            color: #b3650f;
        }

        .approval-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .approval-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f1ec;
        }

        .approval-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .approval-judul {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .approval-meta {
            font-size: 11.5px;
            color: #9aa1b1;
            margin-top: 2px;
        }

        .approval-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-pill {
            border-radius: 16px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid #dadfe8;
            background: #fff;
            color: #2d3a55;
            transition: background 0.15s ease, transform 0.1s ease;
        }

        .btn-pill:hover {
            transform: translateY(-1px);
        }

        .btn-pill-approve {
            color: #1d6b30;
            border-color: #c4e3c8;
        }

        .btn-pill-approve:hover {
            background: #eef9ef;
        }

        .btn-pill-reject {
            color: #a32626;
            border-color: #f0c9c9;
        }

        .btn-pill-reject:hover {
            background: #fdf0f0;
        }

        /* ── Grid 2 kolom ── */
        .dash-grid-2 {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 18px;
        }

        /* ── Legend ── */
        .bar-legend {
            display: flex;
            gap: 14px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .legend-item {
            font-size: 12px;
            color: #4b5563;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }

        /* ── Bar chart ── */
        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            height: 190px;
            padding: 0 4px;
        }

        .bar-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
            height: 100%;
            justify-content: flex-end;
        }

        .bar-track {
            width: 100%;
            height: 160px;
            display: flex;
            align-items: flex-end;
            border-bottom: 1px solid #eef0f4;
        }

        .bar-fill {
            position: relative;
            width: 70%;
            margin: 0 auto;
            height: 0%;
            border-radius: 4px 4px 0 0;
            animation: grow-bar 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            animation-delay: 0.1s;
            display: flex;
            justify-content: center;
            cursor: pointer;
        }

        .bar-fill:hover {
            filter: brightness(1.1);
        }

        @keyframes grow-bar {
            from {
                height: 0%;
            }

            to {
                height: var(--target-height);
            }
        }

        #barChart.has-hover .bar-col:not(.is-hovered) {
            opacity: 0.3;
            transition: opacity 0.2s;
        }

        #barChart .bar-col {
            transition: opacity 0.2s;
        }

        #barChart .bar-col.is-hovered {
            opacity: 1;
        }

        .bar-value-top {
            position: absolute;
            top: -20px;
            font-size: 12px;
            font-weight: 700;
            color: #333;
        }

        .bar-label {
            font-size: 10px;
            color: #6b7280;
            text-align: center;
            line-height: 1.3;
        }

        .bar-tooltip {
            position: absolute;
            bottom: calc(100% + 14px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            background: #1a1a2e;
            color: white;
            font-size: 11.5px;
            padding: 6px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            z-index: 5;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }

        .bar-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #1a1a2e;
        }

        .bar-fill:hover .bar-tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* ── Per unit kerja ── */
        .unit-list {
            display: flex;
            flex-direction: column;
        }

        .unit-row {
            display: flex;
            justify-content: space-between;
            padding: 11px 0;
            border-bottom: 1px solid #f3f5fa;
            font-size: 13.5px;
            color: #2d3a55;
        }

        .unit-row:last-child {
            border-bottom: none;
        }

        .unit-count {
            font-weight: 700;
            color: #1a1a2e;
        }

        /* ── Status request ── */
        .status-request-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .sr-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #f8f9fb;
        }

        .sr-label {
            font-size: 12.5px;
            color: #565f73;
            font-weight: 500;
        }

        .sr-num {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
        }

        /* ── Regulasi mandek ── */
        .stuck-title-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 17px;
            height: 17px;
            padding: 0 5px;
            margin-left: 6px;
            border-radius: 9px;
            background: #eceef3;
            color: #4b5568;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0;
            vertical-align: middle;
        }

        .stuck-empty {
            font-size: 12.5px;
            color: #8a93a6;
            background: #f8f9fb;
            border: 1px solid #eef0f5;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .stuck-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stuck-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: #fafafc;
            border: 1px solid #f0f1f6;
            text-decoration: none;
            transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
        }

        .stuck-row:hover {
            background: #f5f6fb;
            border-color: #e4e7f2;
            transform: translateX(2px);
        }

        .stuck-row-main {
            min-width: 0;
        }

        .stuck-judul {
            font-size: 12.5px;
            font-weight: 600;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stuck-meta {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #9aa1b1;
            margin-top: 2px;
        }

        .stuck-stage-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
            background: #c5c8d6;
        }

        .stuck-days {
            flex-shrink: 0;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 12px;
            white-space: nowrap;
            color: #5a6380;
            background: #eef0f5;
        }

        .stuck-days-critical {
            color: #1a1a2e;
            background: #e4e6ee;
        }

        /* ── Regulasi terbaru ── */
        .regulasi-list {
            display: flex;
            flex-direction: column;
        }

        .regulasi-row {
            border-bottom: 1px solid #f3f5fa;
            transition: opacity 0.2s ease;
        }

        .regulasi-row:last-child {
            border-bottom: none;
        }

        .regulasi-row.row-hidden {
            display: none;
        }

        .regulasi-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 4px;
            text-decoration: none;
            transition: background 0.15s ease;
            border-radius: 6px;
        }

        .regulasi-link:hover {
            background: #f8faff;
        }

        .regulasi-judul {
            font-size: 13.5px;
            font-weight: 600;
            color: #1a1a2e;
        }

        .regulasi-meta {
            font-size: 11.5px;
            color: #9aa1b1;
            margin-top: 2px;
        }

        /* ── Status dot badge ── */
        .reg-status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            border-radius: 20px;
            padding: 4px 10px 4px 8px;
            white-space: nowrap;
            letter-spacing: 0.01em;
            flex-shrink: 0;
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

        /* ── Filter reset ── */
        .filter-reset-btn {
            background: #f0f3fb;
            border: 1px solid #dbe2f5;
            color: #5066a3;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.15s ease;
            margin-bottom: 16px;
        }

        .filter-reset-btn:hover {
            background: #e3e9fb;
        }

        .slide-in {
            animation: slide-in-fade 0.4s ease both;
        }

        @keyframes slide-in-fade {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* ══════════════════════════════════════════
               RESPONSIVE DASHBOARD
            ══════════════════════════════════════════ */

        /* Tablet (≤900px) */
        @media (max-width: 900px) {
            .dash-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .dash-grid-2 {
                grid-template-columns: 1fr;
            }

            .dash-stat {
                padding: 16px 18px;
            }

            .dash-stat-num {
                font-size: 26px;
            }
        }

        /* Mobile (≤640px) */
        @media (max-width: 640px) {
            .dash-wrap {
                gap: 14px;
            }

            /* Stat cards — 2 kolom rapat */
            .dash-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .dash-stat {
                padding: 14px 14px;
                border-radius: 12px;
                flex-direction: row;
                align-items: flex-start;
                gap: 12px;
            }

            .dash-stat-icon {
                width: 18px;
                height: 18px;
                margin-top: 2px;
            }

            .dash-stat-num {
                font-size: 22px;
                margin-top: 4px;
            }

            .dash-stat-top {
                font-size: 11.5px;
            }

            .dash-stat-sub {
                font-size: 10.5px;
            }

            /* Cards */
            .dash-card {
                padding: 16px;
                border-radius: 12px;
            }

            .dash-card-title {
                font-size: 13.5px;
                margin-bottom: 12px;
                line-height: 1.35;
            }

            .dash-stat.is-clickable:active {
                transform: scale(0.98);
            }

            /* Approval rows — stack vertikal */
            .approval-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .approval-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .btn-pill {
                padding: 6px 12px;
                font-size: 11.5px;
            }

            .approval-judul {
                font-size: 13px;
            }

            .approval-meta {
                font-size: 11px;
            }

            /* Bar chart — scroll horizontal di mobile */
            .bar-chart-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 4px;
            }

            .bar-chart {
                min-width: 420px;
                gap: 8px;
                height: 160px;
            }

            .bar-track {
                height: 130px;
            }

            .bar-label {
                font-size: 9px;
            }

            .bar-value-top {
                font-size: 10px;
                top: -18px;
            }

            .bar-legend {
                gap: 10px;
            }

            .legend-item {
                font-size: 11px;
            }

            .legend-dot {
                width: 7px;
                height: 7px;
            }

            /* Unit / status request */
            .unit-row {
                font-size: 12.5px;
                padding: 9px 0;
            }

            .sr-row {
                padding: 10px 12px;
            }

            .sr-label {
                font-size: 12px;
            }

            .sr-num {
                font-size: 18px;
            }

            /* Stuck list */
            .stuck-row {
                padding: 9px 10px;
            }

            .stuck-judul {
                font-size: 12px;
            }

            .stuck-days {
                font-size: 10.5px;
                padding: 2px 7px;
            }

            /* Regulasi terbaru */
            .regulasi-link {
                padding: 12px 6px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .regulasi-judul {
                font-size: 13px;
                line-height: 1.4;
            }

            .regulasi-meta {
                font-size: 11.5px;
                margin-top: 3px;
            }

            .reg-status-dot {
                font-size: 10.5px;
                padding: 3px 9px 3px 7px;
            }

            .reg-status-dot-circle {
                width: 6px;
                height: 6px;
            }

            /* Filter reset btn */
            .filter-reset-btn {
                font-size: 11.5px;
                padding: 5px 10px;
            }

            /* Banner */
            .dash-banner {
                font-size: 12.5px;
                padding: 10px 14px;
            }

            .dash-chip-link {
                font-size: 11.5px;
                padding: 3px 8px;
            }
        }

        /* Tiny (≤380px) */
        @media (max-width: 380px) {
            .dash-stats {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .dash-stat-num {
                font-size: 20px;
            }

            .dash-card {
                padding: 14px;
            }
        }
    </style>

    <script>
        (function () {
            // ── Counter animasi angka ──
            document.querySelectorAll('[data-counter]').forEach(function (el) {
                var target = parseInt(el.getAttribute('data-counter'), 10) || 0;
                var startTime = null;
                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / 700, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target);
                    if (progress < 1) requestAnimationFrame(step);
                    else el.textContent = target;
                }
                requestAnimationFrame(step);
            });

            var DEFAULT_SHOW = 5;

            // Grup filter stat card — "proses" mencakup semua tahap aktif
            var stageGroups = {
                proses: ['pembahasan', 'uji_publik', 'pasca_partisipasi', 'harmonisasi'],
                selesai: ['penetapan', 'selesai'],
            };

            var resetBtn = document.getElementById('filterResetBtn');
            var emptyMsg = document.getElementById('filterEmptyMsg');
            var list = document.getElementById('regulasiTable');
            var activeCards = document.querySelectorAll('.dash-stat.is-clickable');
            var currentFilter = 'all';

            function updateUnitKerja(filterKey, matchedStages) {
                var allRows = list.querySelectorAll('.regulasi-row[data-row-unit]');
                var unitCounts = {};
                allRows.forEach(function (row) {
                    var unit = row.getAttribute('data-row-unit');
                    var stage = row.getAttribute('data-row-stage');
                    var match = filterKey === 'all' || matchedStages.indexOf(stage) !== -1;
                    if (match && unit) unitCounts[unit] = (unitCounts[unit] || 0) + 1;
                });
                document.querySelectorAll('.unit-row').forEach(function (row) {
                    var unit = row.getAttribute('data-unit');
                    var countEl = row.querySelector('.unit-count');
                    if (!countEl) return;
                    if (filterKey === 'all') {
                        countEl.textContent = row.getAttribute('data-total');
                        row.style.opacity = '1';
                    } else {
                        var count = unitCounts[unit] || 0;
                        countEl.textContent = count;
                        row.style.opacity = count === 0 ? '0.35' : '1';
                    }
                });
            }

            function applyFilter(filterKey) {
                currentFilter = filterKey;
                var rows = list.querySelectorAll('.regulasi-row[data-row-stage]');
                var visibleCount = 0;
                var matchedStages = filterKey === 'all' ? [] : (stageGroups[filterKey] || [filterKey]);

                rows.forEach(function (row) {
                    var stage = row.getAttribute('data-row-stage');
                    var show;
                    if (filterKey === 'all') {
                        var idx = Array.from(rows).indexOf(row);
                        show = idx < DEFAULT_SHOW;
                    } else {
                        show = matchedStages.indexOf(stage) !== -1;
                    }
                    row.classList.toggle('row-hidden', !show);
                    if (show) visibleCount++;
                });

                emptyMsg.style.display = (visibleCount === 0 && filterKey !== 'all') ? 'block' : 'none';
                list.style.display = (visibleCount === 0 && filterKey !== 'all') ? 'none' : '';
                resetBtn.style.display = filterKey === 'all' ? 'none' : 'inline-block';

                activeCards.forEach(function (card) {
                    card.classList.toggle('is-active-filter',
                        card.getAttribute('data-filter') === filterKey && filterKey !== 'all');
                });

                updateUnitKerja(filterKey, matchedStages);
            }

            applyFilter('all');

            activeCards.forEach(function (card) {
                card.addEventListener('click', function () {
                    applyFilter(card.getAttribute('data-filter'));
                    document.getElementById('regulasiTerbaruTitle').scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
                card.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') card.click();
                });
            });

            resetBtn.addEventListener('click', function () { applyFilter('all'); });

            // ── Dim effect bar chart ──
            var barChart = document.getElementById('barChart');
            if (barChart) {
                barChart.querySelectorAll('.bar-col').forEach(function (col) {
                    col.addEventListener('mouseenter', function () {
                        barChart.classList.add('has-hover');
                        col.classList.add('is-hovered');
                    });
                    col.addEventListener('mouseleave', function () {
                        barChart.classList.remove('has-hover');
                        col.classList.remove('is-hovered');
                    });
                });
            }

            // ── Klik bar → filter daftar ──
            document.querySelectorAll('.bar-fill').forEach(function (bar) {
                bar.addEventListener('click', function () {
                    var stage = bar.closest('.bar-col').getAttribute('data-stage');
                    currentFilter = stage;
                    var rows = list.querySelectorAll('.regulasi-row[data-row-stage]');
                    var visibleCount = 0;
                    rows.forEach(function (row) {
                        var show = row.getAttribute('data-row-stage') === stage;
                        row.classList.toggle('row-hidden', !show);
                        if (show) visibleCount++;
                    });
                    emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
                    list.style.display = visibleCount === 0 ? 'none' : '';
                    resetBtn.style.display = 'inline-block';
                    activeCards.forEach(function (c) { c.classList.remove('is-active-filter'); });
                    updateUnitKerja(stage, [stage]);
                    document.getElementById('regulasiTerbaruTitle').scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            });
        })();
    </script>

@endsection