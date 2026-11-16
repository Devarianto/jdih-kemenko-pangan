@extends('public')

@section('hero-title', 'Partisipasi Publik Rancangan Peraturan')
@section('hero-desc', 'Daftar rancangan peraturan perundang-undangan Kementerian Koordinator Bidang Pangan yang dibuka untuk konsultasi publik. Silakan pelajari draf naskah dan sampaikan masukan Anda.')

@push('head')
    <style>
        /* Hero section dibuat fixed & lebih ringkas khusus pada halaman /partisipasi-publik */
        header .header-bot {
            display: none !important;
        }

        /* Header tetap transparan & teks/logo tetap putih saat scrolldown di halaman ini */
        body header.floating,
        body header.white {
            background: transparent !important;
            box-shadow: none !important;
        }
        body header.floating::before,
        body header.white::before {
            height: 0 !important;
            background-color: transparent !important;
        }
        body header.floating .logo .white,
        body header.white .logo .white,
        html body header.floating:not(.show-burger) .logo img.white,
        html body header.white:not(.show-burger) .logo img.white {
            display: block !important;
        }
        body header.floating .logo .black,
        body header.white .logo .black,
        html body header.floating:not(.show-burger) .logo img.black,
        html body header.white:not(.show-burger) .logo img.black {
            display: none !important;
        }
        body header.floating nav > ul > li > a,
        body header.white nav > ul > li > a,
        body header.floating nav > ul > li > a.nav-parent-link,
        body header.white nav > ul > li > a.nav-parent-link {
            color: #ffffff !important;
        }
        body header.floating nav > ul > li.active > a,
        body header.white nav > ul > li.active > a {
            color: #fbbf24 !important;
        }
        body header.floating .theme-toggle-btn,
        body header.white .theme-toggle-btn {
            border-color: rgba(255, 255, 255, 0.3) !important;
            background: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
        }
        body header.floating .theme-toggle-btn:hover,
        body header.white .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.22) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
        }
        body header.floating .toggle-menu span,
        body header.white .toggle-menu span {
            background-color: #ffffff !important;
        }

        .banner-middle.pub-hero-banner {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            height: auto !important;
            min-height: 0 !important;
            padding: 96px 0 36px !important;
            box-shadow: 0 8px 24px rgba(0, 32, 96, 0.12);
        }

        .banner-middle.pub-hero-banner .wave {
            bottom: -1px !important;
            height: 32px !important;
            overflow: hidden;
            pointer-events: none;
        }

        .banner-middle.pub-hero-banner .wave svg {
            height: 32px !important;
            display: block;
        }

        section.middle {
            position: relative;
            z-index: 10;
            padding-top: 245px !important;
            padding-bottom: 56px !important;
            min-height: 75vh;
        }

        section.middle .pub-content {
            padding-top: 8px !important;
            padding-bottom: 24px !important;
        }

        footer {
            position: relative;
            z-index: 45;
        }

        @media (max-width: 768px) {
            .banner-middle.pub-hero-banner {
                padding: 78px 0 28px !important;
            }
            .banner-middle.pub-hero-banner h2 {
                font-size: 20px !important;
                margin-bottom: 6px !important;
            }
            .banner-middle.pub-hero-banner p {
                font-size: 13px !important;
                line-height: 1.5 !important;
            }
            .banner-middle.pub-hero-banner .pub-hero-label {
                margin-bottom: 8px !important;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── Daftar Kartu Horizontal ── --}}
    <div class="pub-grid" id="listContainer">
        @forelse($daftarUjiPublik as $item)
            @php
                $selesai = \Carbon\Carbon::parse($item->tgl_selesai)->endOfDay();
                $sisaHari = (int) now()->startOfDay()->diffInDays($selesai->copy()->startOfDay(), false);
                $isActivePeriod = $item->is_active && $sisaHari >= 0;
                $isUrgent = $isActivePeriod && $sisaHari <= 7;
                $isBerakhir = !$isActivePeriod;
                $jumlahMasukan = $item->regulasi->tanggapan->where('is_hidden', false)->count();
            @endphp
            <div class="pub-card {{ $isUrgent ? 'pub-card-urgent' : '' }} {{ $isBerakhir ? 'pub-card-berakhir' : '' }}"
                data-search="{{ strtolower($item->regulasi->judul . ' ' . $item->regulasi->jenis . ' ' . $item->regulasi->unit_kerja) }}">

                <div class="pub-card-main">
                    <div class="pub-card-meta">
                        <div class="pub-badges-row">
                            <span class="pub-tag-jenis">{{ $item->regulasi->jenis }}</span>
                            @if($item->regulasi->unit_kerja)
                                <span class="pub-tag-unit">🏛️ {{ $item->regulasi->unit_kerja }}</span>
                            @endif
                            @if($isActivePeriod)
                                <span class="pub-tag-sisa {{ $isUrgent ? 'urgent' : '' }}">
                                    {{ $isUrgent ? '⏳' : '🟢' }}
                                    {{ $sisaHari === 0 ? 'Hari terakhir' : ($isUrgent ? 'Hampir berakhir · ' . $sisaHari . ' hari lagi' : 'Dibuka · ' . $sisaHari . ' hari lagi') }}
                                </span>
                            @else
                                <span class="pub-tag-sisa ended">🔒 Ditutup · Periode Berakhir</span>
                            @endif
                            <span class="pub-masukan-count">
                                <span class="pub-icon">💬</span> {{ $jumlahMasukan }} Masukan Publik
                            </span>
                        </div>
                    </div>

                    {{-- Judul --}}
                    <div class="pub-card-title">
                        <a href="{{ route('partisipasi-publik.show', $item->id) }}" style="color:inherit; text-decoration:none;">
                            {{ $item->regulasi->judul }}
                        </a>
                    </div>

                    {{-- Abstrak --}}
                    @if($item->regulasi->abstrak)
                        @php $abstrakId = 'abstrak-' . $item->id; @endphp
                        <div class="pub-card-abstrak">
                            <p class="pub-abstrak-text" id="{{ $abstrakId }}">{{ $item->regulasi->abstrak }}</p>
                            @if(strlen($item->regulasi->abstrak) > 160)
                                <button type="button" class="pub-abstrak-toggle" onclick="toggleAbstrak(this, '{{ $abstrakId }}')">
                                    Baca selengkapnya
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Kolom Kanan: Periode & CTA --}}
                <div class="pub-card-aside">
                    <div class="pub-card-periode-box">
                        <span class="pub-periode-label">Periode Konsultasi Publik</span>
                        <div class="pub-card-periode">
                            <span>📅 {{ \Carbon\Carbon::parse($item->tgl_mulai)->isoFormat('D MMM Y') }}</span>
                            <span class="pub-periode-sep">s/d</span>
                            <span class="{{ $isUrgent ? 'text-urgent' : ($isBerakhir ? 'text-ended' : '') }}">{{ $selesai->isoFormat('D MMM Y') }}</span>
                        </div>
                    </div>

                    <div class="pub-card-cta-wrap">
                        @if($isBerakhir)
                            <a href="{{ route('partisipasi-publik.show', $item->id) }}" class="pub-card-btn pub-card-btn-ended">
                                Lihat Detail Rancangan ➤
                            </a>
                        @else
                            <a href="{{ route('partisipasi-publik.show', $item->id) }}" class="pub-card-btn">
                                Pelajari Draf & Berikan Masukan ➤
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="pub-empty">
                <span class="pub-empty-icon">📋</span>
                <p>Belum ada rancangan peraturan yang sesuai dengan kriteria pencarian saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- ── Pagination ── --}}
    @if($daftarUjiPublik->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 32px;">
            {{ $daftarUjiPublik->links('vendor.pagination.custom') }}
        </div>
    @endif

    <style>
        .pub-procedure-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
            border: 1px solid #dbe6f8;
            border-radius: 14px;
            padding: 22px 24px;
            margin-bottom: 28px;
            box-shadow: 0 2px 10px rgba(0, 32, 96, 0.04);
        }

        .pub-procedure-eyebrow {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #1d4ed8;
            display: block;
            margin-bottom: 4px;
        }

        .pub-procedure-title {
            font-size: 16.5px;
            font-weight: 700;
            color: #0d1b3e;
            margin: 0 0 16px;
        }

        .pub-procedure-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .pub-step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #ffffff;
            border: 1px solid #e6edf8;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .pub-step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #002060;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pub-step-body strong {
            display: block;
            font-size: 13.5px;
            color: #0d1b3e;
            margin-bottom: 4px;
        }

        .pub-step-body p {
            font-size: 12.5px;
            color: #5a6480;
            margin: 0;
            line-height: 1.5;
        }

        .pub-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 22px;
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid #e4eaf6;
        }

        .pub-count-pill {
            font-size: 12px;
            font-weight: 600;
            color: #003580;
            background: #eaf0ff;
            padding: 4px 11px;
            border-radius: 20px;
        }

        .pub-filter-controls {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pub-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 10px 38px 10px 14px;
            border: 1.5px solid #d8e0ee;
            border-radius: 8px;
            font-size: 13px;
            color: #1a1a2e;
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 15px 15px;
            cursor: pointer;
            outline: none;
        }

        .pub-filter-btn {
            padding: 10px 18px;
            border-radius: 8px;
            background: #002060;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .pub-reset-btn {
            font-size: 12.5px;
            font-weight: 600;
            color: #c0392b;
            text-decoration: none;
            padding: 6px 8px;
        }

        .pub-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 18px !important;
        }

        .pub-card {
            border-radius: 22px !important;
            padding: 24px 28px !important;
            flex-direction: row !important;
            align-items: stretch !important;
            justify-content: space-between !important;
            gap: 28px !important;
        }

        .pub-card-urgent {
            border-left: 4px solid #eab308 !important;
        }

        .pub-tag-sisa.urgent {
            color: #92400e !important;
            background: #fef9c3 !important;
            border-color: #fde047 !important;
        }

        .text-urgent {
            color: #b45309 !important;
            font-weight: 700;
        }

        .pub-tag-sisa.ended {
            color: #b91c1c !important;
            background: #fef2f2 !important;
            border-color: #fecaca !important;
        }

        .text-ended {
            color: #b91c1c !important;
            font-weight: 700;
        }

        .pub-card-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pub-card-main .pub-card-title {
            flex: none;
            font-size: 16.5px;
            line-height: 1.45;
        }

        .pub-card-aside {
            flex: 0 0 285px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 14px;
            border-left: 1px solid #e6edf8;
            padding-left: 24px;
        }

        .pub-card-periode-box {
            background: #f8fafc;
            border: 1px solid #e6edf8;
            border-radius: 14px;
            padding: 11px 14px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pub-periode-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .pub-card-aside .pub-card-periode {
            flex-wrap: wrap;
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .pub-card-cta-wrap {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pub-card-btn {
            border-radius: 12px !important;
            padding: 12px 14px !important;
            font-size: 12.5px !important;
            white-space: nowrap;
        }

        .pub-tag-unit {
            font-size: 11px;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 3px 10px;
            font-weight: 600;
        }

        .pub-tag-jenis {
            border-radius: 999px !important;
            padding: 4px 11px !important;
        }

        .pub-card-berakhir {
            background: #fafbfe;
            border-left: 4px solid #dc2626 !important;
        }

        .pub-card-btn-ended {
            background: #475569 !important;
            color: #ffffff !important;
        }

        .pub-card-btn-ended:hover {
            background: #334155 !important;
        }

        .pub-card-admin-link {
            display: block;
            text-align: center;
            padding: 8px 12px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1d4ed8 !important;
            border: 1px solid #bfdbfe;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            transition: background 0.15s;
        }

        .pub-card-admin-link:hover {
            background: #dbeafe;
        }

        .pub-card-abstrak {
            margin-top: 0;
        }

        .pub-abstrak-text {
            font-size: 13.5px;
            color: #5a6480;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .pub-abstrak-text.expanded {
            -webkit-line-clamp: unset;
            overflow: visible;
        }

        button.pub-abstrak-toggle {
            display: inline-flex;
            align-items: center;
            height: auto;
            min-height: 0;
            line-height: 1.4;
            background: #f1f5ff;
            border: 1px solid #d7e3fc;
            border-radius: 6px;
            padding: 5px 12px;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #003580;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        button.pub-abstrak-toggle:focus {
            background: #f1f5ff;
            border-color: #d7e3fc;
            color: #003580;
            outline: none;
        }

        button.pub-abstrak-toggle:hover,
        button.pub-abstrak-toggle:focus-visible {
            background: #003580;
            border-color: #003580;
            color: #ffffff;
            text-decoration: none;
            outline: none;
        }

        button.pub-abstrak-toggle:active {
            background: #002060;
            border-color: #002060;
            color: #ffffff;
        }

        @media (max-width: 1024px) {
            .pub-card-aside {
                flex: 0 0 235px;
                padding-left: 20px;
            }
        }

        @media (max-width: 768px) {
            .pub-procedure-steps {
                grid-template-columns: 1fr;
            }
            .pub-card {
                flex-direction: column !important;
                gap: 16px !important;
                padding: 20px !important;
                border-radius: 18px !important;
            }
            .pub-card-aside {
                flex: none;
                width: 100%;
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #e6edf8;
                padding-top: 14px;
            }
        }
    </style>

    <script>
        function syncPubHeroSpacing() {
            var hero = document.querySelector('.banner-middle.pub-hero-banner');
            var middle = document.querySelector('section.middle');
            if (hero && middle) {
                middle.style.setProperty('padding-top', (hero.offsetHeight + 14) + 'px', 'important');
            }
        }

        document.addEventListener('DOMContentLoaded', syncPubHeroSpacing);
        window.addEventListener('load', syncPubHeroSpacing);
        window.addEventListener('resize', syncPubHeroSpacing);

        function toggleAbstrak(btn, id) {
            var el = document.getElementById(id);
            var expanded = el.classList.toggle('expanded');
            btn.textContent = expanded ? 'Tutup ringkasan' : 'Baca selengkapnya';
        }

        (function () {
            var input = document.getElementById('searchInput');
            var emptyMsg = document.getElementById('searchEmpty');
            var grid = document.getElementById('listContainer');
            if (!input || !grid) return;

            input.addEventListener('input', function () {
                var q = this.value.toLowerCase().trim();
                var cards = grid.querySelectorAll('.pub-card[data-search]');
                if (cards.length === 0) return;
                var visible = 0;
                cards.forEach(function (card) {
                    var match = !q || card.getAttribute('data-search').includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) visible++;
                });
                emptyMsg.style.display = (visible === 0 && q) ? 'block' : 'none';
                grid.style.display = (visible === 0 && q) ? 'none' : '';
            });
        })();
    </script>

@endsection
