@extends('public')

@section('hero-title', 'Partisipasi Publik Rancangan Peraturan')
@section('hero-desc', 'Daftar rancangan peraturan perundang-undangan Kementerian Koordinator Bidang Pangan yang dibuka untuk konsultasi publik. Silakan pelajari draf naskah dan sampaikan masukan Anda.')

@section('content')

    {{-- ── Alur & Prosedur Partisipasi Publik ── --}}
    <div class="pub-procedure-card">
        <div class="pub-procedure-header">
            <div>
                <span class="pub-procedure-eyebrow">Tata Cara Penyampaian Masukan</span>
                <h3 class="pub-procedure-title">Bagaimana Berpartisipasi dalam Penyusunan Regulasi?</h3>
            </div>
        </div>
        <div class="pub-procedure-steps">
            <div class="pub-step-item">
                <div class="pub-step-num">1</div>
                <div class="pub-step-body">
                    <strong>Pilih Rancangan Regulasi</strong>
                    <p>Pilih rancangan peraturan yang sedang dalam masa konsultasi publik aktif pada daftar di bawah.</p>
                </div>
            </div>
            <div class="pub-step-item">
                <div class="pub-step-num">2</div>
                <div class="pub-step-body">
                    <strong>Pelajari Draf & Abstrak</strong>
                    <p>Baca ringkasan materi muatan dan pratinjau dokumen PDF rancangan peraturan secara langsung.</p>
                </div>
            </div>
            <div class="pub-step-item">
                <div class="pub-step-num">3</div>
                <div class="pub-step-body">
                    <strong>Kirim Tanggapan / Aspirasi</strong>
                    <p>Isi formulir tanggapan sebagai Masyarakat Umum atau Perwakilan Instansi/Akademisi untuk ditelaah tim penyusun.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Header & Filter Bar ── --}}
    <form method="GET" action="{{ route('partisipasi-publik') }}" class="pub-filter-bar">
        <div class="pub-section-title" style="margin-bottom: 0;">
            <span>🗁 Daftar Rancangan Peraturan</span>
            <span class="pub-count-pill">
                {{ $daftarUjiPublik->total() }} Rancangan
            </span>
        </div>

        <div class="pub-filter-controls">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau abstrak..." class="pub-search" id="searchInput">

            <select name="status" class="pub-select" onchange="this.form.submit()">
                <option value="">Semua Status Periode</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Sedang Dibuka (Aktif)</option>
                <option value="berakhir" {{ request('status') === 'berakhir' ? 'selected' : '' }}>Telah Berakhir</option>
            </select>

            <select name="jenis" class="pub-select" onchange="this.form.submit()">
                <option value="">Semua Jenis Peraturan</option>
                <option value="Peraturan Menteri Koordinator" {{ request('jenis') === 'Peraturan Menteri Koordinator' ? 'selected' : '' }}>Peraturan Menteri Koordinator</option>
                <option value="Peraturan Presiden" {{ request('jenis') === 'Peraturan Presiden' ? 'selected' : '' }}>Peraturan Presiden</option>
                <option value="Keputusan Menteri Koordinator" {{ request('jenis') === 'Keputusan Menteri Koordinator' ? 'selected' : '' }}>Keputusan Menteri Koordinator</option>
                <option value="Instruksi Menteri Koordinator" {{ request('jenis') === 'Instruksi Menteri Koordinator' ? 'selected' : '' }}>Instruksi Menteri Koordinator</option>
            </select>

            <button type="submit" class="pub-filter-btn">Filter</button>

            @if(request('search') || request('status') || request('jenis'))
                <a href="{{ route('partisipasi-publik') }}" class="pub-reset-btn">✕ Reset</a>
            @endif
        </div>
    </form>

    {{-- ── Pesan pencarian instan kosong ── --}}
    <div id="searchEmpty" style="display:none;">
        <div class="pub-empty">
            <span class="pub-empty-icon">🔍</span>
            <p>Tidak ada rancangan peraturan yang cocok dengan kata kunci pencarian Anda.</p>
        </div>
    </div>

    {{-- ── Grid card ── --}}
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

                <div class="pub-card-meta">
                    <div class="pub-tag-jenis-row" style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px; flex-wrap:wrap;">
                        <span class="pub-tag-jenis">{{ $item->regulasi->jenis }}</span>
                        @if($item->regulasi->unit_kerja)
                            <span class="pub-tag-unit">🏛️ {{ $item->regulasi->unit_kerja }}</span>
                        @endif
                    </div>
                    <div class="pub-badges-row">
                        @if($isActivePeriod)
                            <span class="pub-tag-sisa {{ $isUrgent ? 'urgent' : '' }}">
                                {{ $isUrgent ? '⚠' : '🟢' }}
                                {{ $sisaHari === 0 ? 'Hari terakhir' : 'Dibuka · ' . $sisaHari . ' hari lagi' }}
                            </span>
                        @else
                            <span class="pub-tag-sisa"
                                style="color:#64748b; background:#f1f5f9; border-color:#cbd5e1;">Periode Berakhir</span>
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
                        @if(strlen($item->regulasi->abstrak) > 130)
                            <button type="button" class="pub-abstrak-toggle" onclick="toggleAbstrak(this, '{{ $abstrakId }}')">
                                Baca selengkapnya
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Periode --}}
                <div class="pub-card-periode">
                    <span>📅 {{ \Carbon\Carbon::parse($item->tgl_mulai)->isoFormat('D MMM Y') }}</span>
                    <span class="pub-periode-sep">s/d</span>
                    <span class="{{ $isUrgent ? 'text-urgent' : '' }}">{{ $selesai->isoFormat('D MMM Y') }}</span>
                </div>

                {{-- CTA --}}
                <div style="margin-top: auto; display: flex; flex-direction: column; gap: 8px;">
                    @if($isBerakhir)
                        <a href="{{ route('partisipasi-publik.show', $item->id) }}" class="pub-card-btn pub-card-btn-ended">
                            Lihat Draf & Tanggapan Publik ➤
                        </a>
                    @else
                        <a href="{{ route('partisipasi-publik.show', $item->id) }}" class="pub-card-btn">
                            Pelajari Draf & Berikan Masukan ➤
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="pub-empty" style="grid-column: 1/-1;">
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
            padding: 10px 14px;
            border: 1.5px solid #d8e0ee;
            border-radius: 8px;
            font-size: 13px;
            color: #1a1a2e;
            background: #ffffff;
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

        .pub-tag-unit {
            font-size: 11px;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 3px 8px;
            font-weight: 600;
        }

        .pub-card-berakhir {
            background: #fafbfe;
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
            margin-top: -2px;
        }

        .pub-abstrak-text {
            font-size: 13px;
            color: #5a6480;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .pub-abstrak-text.expanded {
            -webkit-line-clamp: unset;
            overflow: visible;
        }

        .pub-abstrak-toggle {
            background: none;
            border: none;
            padding: 0;
            margin-top: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #003580;
            cursor: pointer;
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .pub-procedure-steps {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
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
