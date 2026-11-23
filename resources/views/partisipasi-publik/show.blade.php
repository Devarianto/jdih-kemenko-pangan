@extends('public')

@section('hero-title', $ujiPublik->regulasi->judul)
@section('hero-desc', 'Detail rancangan peraturan perundang-undangan dan dokumen draf naskah Kementerian Koordinator Bidang Pangan.')

@push('head')
    <style>
        .banner-middle.pub-hero-banner {
            height: auto !important;
            min-height: 0 !important;
            padding: 96px 0 32px !important;
        }
        .banner-middle.pub-hero-banner .wave {
            display: none !important;
        }
        .banner-middle.pub-hero-banner .pub-hero-text {
            max-width: 880px;
        }
        .banner-middle.pub-hero-banner h2 {
            font-size: 24px !important;
            line-height: 1.38 !important;
            margin-bottom: 10px !important;
            letter-spacing: -0.01em;
        }
        .banner-middle.pub-hero-banner p {
            font-size: 14px !important;
            line-height: 1.6 !important;
        }
        section.middle {
            padding: 28px 0 56px !important;
        }
        section.middle .pub-content {
            padding-top: 4px !important;
        }
        @media (max-width: 768px) {
            .banner-middle.pub-hero-banner {
                padding: 82px 0 26px !important;
            }
            .banner-middle.pub-hero-banner h2 {
                font-size: 19px !important;
            }
        }
    </style>
@endpush

@section('content')

    @php
        $selesaiDate = \Carbon\Carbon::parse($ujiPublik->tgl_selesai)->endOfDay();
        $sisaHari = (int) now()->startOfDay()->diffInDays($selesaiDate->copy()->startOfDay(), false);
        $isPeriodOpen = $ujiPublik->is_active && $sisaHari >= 0;
        $isUrgent = $isPeriodOpen && $sisaHari <= 7;
    @endphp

    <style>
        .pp-wrap {
            max-width: 980px;
            margin: 0 auto;
        }

        .pp-top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .pp-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #003580;
            font-size: 13.5px;
            text-decoration: none;
            font-weight: 700;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #d8e0ee;
            transition: all 0.15s;
        }

        .pp-back-link:hover {
            background: #eaf0ff;
        }

        .pp-admin-manage-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #002060;
            color: #ffffff !important;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
        }

        [data-theme="dark"] section.middle {
            background-color: #0b1120 !important;
        }
        [data-theme="dark"] .pp-back-link {
            background: #111c2d !important;
            border-color: #334155 !important;
            color: #93c5fd !important;
        }
        [data-theme="dark"] .pp-card {
            background: #111c2d !important;
            border-color: #243247 !important;
            color: #e2e8f0 !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35) !important;
        }
        [data-theme="dark"] .pp-info-box,
        [data-theme="dark"] .pp-abstrak-box {
            background: #0f172a !important;
            border-color: #243247 !important;
        }
        [data-theme="dark"] .pp-info-label,
        [data-theme="dark"] .pp-form-desc {
            color: #94a3b8 !important;
        }
        [data-theme="dark"] .pp-info-val,
        [data-theme="dark"] .pp-section-head,
        [data-theme="dark"] .pp-form-title,
        [data-theme="dark"] .pp-abstrak-label,
        [data-theme="dark"] .pp-abstrak-body,
        [data-theme="dark"] .pp-form-group label {
            color: #f1f5f9 !important;
        }
        [data-theme="dark"] .pp-form-group input,
        [data-theme="dark"] .pp-form-group select,
        [data-theme="dark"] .pp-form-group textarea {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        [data-theme="dark"] .pp-berakhir-notice {
            background: rgba(220, 38, 38, 0.16) !important;
            border-color: rgba(248, 113, 113, 0.35) !important;
            color: #fecaca !important;
        }
        [data-theme="dark"] .pp-empty-draft {
            background: #0f172a !important;
            color: #94a3b8 !important;
            border: 1px solid #243247 !important;
        }

        .pp-card {
            background: #fff;
            border-radius: 20px;
            padding: 28px 30px;
            margin-bottom: 22px;
            border: 1px solid #e4eaf6;
            box-shadow: 0 2px 12px rgba(0, 32, 96, .05);
        }

        .pp-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .pp-info-box {
            background: #f8faff;
            border: 1px solid #e6edf8;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .pp-info-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .pp-info-val {
            font-size: 14px;
            font-weight: 700;
            color: #0d1b3e;
            line-height: 1.45;
        }

        .pp-abstrak-box {
            background: #f8faff;
            border: 1px solid #e2eaf8;
            border-left: 4px solid #003580;
            border-radius: 12px;
            padding: 18px 22px;
            margin-bottom: 22px;
        }

        .pp-abstrak-label {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #003580;
            margin-bottom: 8px;
        }

        .pp-abstrak-body {
            font-size: 14.5px;
            color: #334155;
            line-height: 1.75;
            margin: 0;
            text-align: justify;
        }

        .pp-section-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #0d1b3e;
            border-bottom: 2px solid #003580;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .pp-doc-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pp-doc-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            border-radius: 8px;
            background: #003580;
            color: #ffffff !important;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none !important;
            transition: background .15s;
        }

        .pp-doc-link:hover {
            background: #002060;
        }

        .pp-doc-link-outline {
            background: #eaf0ff;
            color: #003580 !important;
            border: 1px solid #c9d8f5;
        }

        .pp-doc-link-outline:hover {
            background: #dde6ff;
        }

        .pp-pdf-preview-wrap {
            border: 1px solid #e4eaf6;
            border-radius: 10px;
            overflow: hidden;
            background: #f4f6fb;
            width: 100%;
        }

        .pp-pdf-preview {
            width: 100%;
            height: 75vh;
            max-height: 700px;
            border: none;
            display: block;
        }

        .pp-form-title {
            font-size: 17px;
            font-weight: 700;
            color: #0d1b3e;
            margin-bottom: 6px;
        }

        .pp-form-desc {
            font-size: 13.5px;
            color: #5a6480;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eef1f8;
        }

        .pp-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .pp-form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3a55;
            margin-bottom: 6px;
        }

        .pp-form-group label .req {
            color: #c0392b;
        }

        .pp-form-group input,
        .pp-form-group select,
        .pp-form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d8dfef;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
            color: #1a1a2e;
            background: #fff;
            transition: border-color .15s;
        }

        .pp-form-group input:focus,
        .pp-form-group select:focus,
        .pp-form-group textarea:focus {
            border-color: #003580;
            box-shadow: 0 0 0 3px rgba(0, 53, 128, .08);
        }

        .pp-submit-btn {
            background: #003580;
            color: #fff;
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }

        .pp-submit-btn:hover {
            background: #002060;
        }

        .pp-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .pp-badge-masyarakat {
            background: #eaf0ff;
            color: #003580;
        }

        .pp-badge-instansi {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .pp-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .pp-status-menunggu { background: #f1f5f9; color: #475569; }
        .pp-status-ditelaah { background: #eff6ff; color: #1d4ed8; }
        .pp-status-diterima { background: #f0fdf4; color: #15803d; }
        .pp-status-ditolak { background: #fef2f2; color: #b91c1c; }

        .pp-tanggapan-item {
            padding: 18px;
            border: 1px solid #edf1f9;
            border-radius: 12px;
            margin-bottom: 14px;
            background: #fcfdff;
        }

        .pp-tanggapan-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .pp-tanggapan-name {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            font-weight: 700;
            font-size: 14px;
            color: #0d1b3e;
        }

        .pp-tanggapan-time {
            font-size: 12px;
            color: #94a3b8;
        }

        .pp-tanggapan-meta {
            font-size: 12.5px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .pp-tanggapan-body {
            font-size: 13.5px;
            color: #334155;
            line-height: 1.65;
            white-space: pre-line;
        }

        .pp-tindak-lanjut-box {
            margin-top: 12px;
            padding: 12px 14px;
            background: #f0f7ff;
            border-left: 3px solid #003580;
            border-radius: 6px;
            font-size: 12.5px;
            color: #1e293b;
        }

        .pp-tindak-lanjut-box strong {
            display: block;
            color: #003580;
            margin-bottom: 3px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .pp-berakhir-notice {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff8f1;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 13.5px;
            color: #9a3412;
            margin-top: 16px;
        }

        @media (max-width: 640px) {
            .pp-info-grid {
                grid-template-columns: 1fr;
            }
            .pp-form-row {
                grid-template-columns: 1fr;
            }
            .pp-card {
                padding: 20px;
                border-radius: 16px;
            }
            .pp-abstrak-box {
                padding: 15px 16px;
            }
            .pp-abstrak-body {
                text-align: left;
                font-size: 14px;
            }
        }
    </style>

    <div class="pp-wrap">

        {{-- TOP BAR --}}
        <div class="pp-top-nav">
            <a href="{{ route('partisipasi-publik') }}" class="pp-back-link">
                ← Kembali ke Daftar Partisipasi Publik
            </a>
        </div>

        {{-- VALIDATION ERRORS --}}
        @if($errors->any())
            <div class="pub-alert pub-alert-danger" style="flex-direction: column; align-items: flex-start;">
                <strong>Mohon periksa kembali isian formulir Anda:</strong>
                <ul style="margin: 6px 0 0 18px; padding: 0;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- INFO REGULASI & PERIODE --}}
        <div class="pp-card">
            <div class="pp-info-grid">
                <div class="pp-info-box">
                    <div class="pp-info-label">Jenis Regulasi</div>
                    <div class="pp-info-val">{{ $ujiPublik->regulasi->jenis }}</div>
                </div>
                <div class="pp-info-box">
                    <div class="pp-info-label">Unit Kerja Pemrakarsa</div>
                    <div class="pp-info-val">{{ $ujiPublik->regulasi->unit_kerja ?? 'Kemenko Pangan' }}</div>
                </div>
                <div class="pp-info-box">
                    <div class="pp-info-label">Periode Konsultasi Publik</div>
                    <div class="pp-info-val">
                        {{ \Carbon\Carbon::parse($ujiPublik->tgl_mulai)->isoFormat('D MMM Y') }} &ndash;
                        {{ \Carbon\Carbon::parse($ujiPublik->tgl_selesai)->isoFormat('D MMM Y') }}
                    </div>
                </div>
                <div class="pp-info-box">
                    <div class="pp-info-label">Status Partisipasi</div>
                    <div class="pp-info-val">
                        @if($isPeriodOpen)
                            @if($isUrgent)
                                <span style="display:inline-block; background:#fef9c3; color:#92400e; border:1px solid #fde047; padding:3px 10px; border-radius:999px; font-size:12.5px;">
                                    ⏳ {{ $sisaHari === 0 ? 'Hari terakhir' : 'Hampir berakhir · ' . $sisaHari . ' hari lagi' }}
                                </span>
                            @else
                                <span style="display:inline-block; background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; padding:3px 10px; border-radius:999px; font-size:12.5px;">
                                    🟢 Dibuka ({{ $sisaHari }} hari lagi)
                                </span>
                            @endif
                        @else
                            <span style="display:inline-block; background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:3px 10px; border-radius:999px; font-size:12.5px;">
                                🔒 Ditutup (Periode Berakhir)
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$isPeriodOpen)
                <div class="pp-berakhir-notice" style="border-radius: 12px; line-height: 1.6; background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    <span>🔒</span>
                    <span>Periode konsultasi publik untuk rancangan ini telah <strong>ditutup</strong>. Penyampaian masukan baru sudah tidak tersedia, namun Anda tetap dapat mempelajari detail serta mengunduh dokumen rancangan peraturan di bawah ini.</span>
                </div>
            @endif
        </div>

        {{-- DOKUMEN RANCANGAN PERATURAN --}}
        <div class="pp-card">
            @php
                $hasDraft = !empty($ujiPublik->regulasi->file_draft);
                $draftUrl = $hasDraft ? Storage::url($ujiPublik->regulasi->file_draft) : null;
                $isPdfDraft = $hasDraft && strtolower(pathinfo($ujiPublik->regulasi->file_draft, PATHINFO_EXTENSION)) === 'pdf';
            @endphp
            <div class="pp-section-head">
                <span>📄 Naskah & Abstrak Rancangan Peraturan</span>
                @if($hasDraft)
                    <div class="pp-doc-actions">
                        <a href="{{ $draftUrl }}" target="_blank" rel="noopener" class="pp-doc-link pp-doc-link-outline">
                            ↗ Buka di Tab Baru
                        </a>
                        <a href="{{ $draftUrl }}" download class="pp-doc-link">
                            ⬇ Unduh Draf Rancangan (PDF)
                        </a>
                    </div>
                @endif
            </div>

            @if($ujiPublik->regulasi->abstrak)
                <div class="pp-abstrak-box">
                    <div class="pp-abstrak-label">Ringkasan / Abstrak Rancangan</div>
                    <p class="pp-abstrak-body">{{ $ujiPublik->regulasi->abstrak }}</p>
                </div>
            @endif

            @if($isPdfDraft)
                <div class="pp-pdf-preview-wrap">
                    <iframe src="{{ $draftUrl }}#zoom=page-width" class="pp-pdf-preview"
                        title="Pratinjau Dokumen Rancangan Peraturan"></iframe>
                </div>
            @elseif($hasDraft)
                <div class="pp-empty-draft" style="padding: 16px; background: #f8faff; border-radius: 10px; border: 1px solid #e4eaf6;">
                    <a href="{{ $draftUrl }}" download class="pp-doc-link">
                        ⬇ Unduh Dokumen Rancangan
                    </a>
                </div>
            @else
                <div class="pp-empty-draft" style="padding: 20px; text-align: center; color: #64748b; background: #f8fafc; border-radius: 10px;">
                    Dokumen pratinjau draf sedang dipersiapkan oleh unit pemrakarsa.
                </div>
            @endif
        </div>

        {{-- FORM TANGGAPAN PUBLIK --}}
        @if($isPeriodOpen)
            <div class="pp-card" id="form-partisipasi">
                <div class="pp-form-title">✍️ Formulir Penyampaian Masukan / Aspirasi Publik</div>
                <div class="pp-form-desc">
                    Sampaikan saran, masukan, atau tanggapan konstruktif Anda terhadap rancangan
                    <strong>{{ $ujiPublik->regulasi->judul }}</strong>. Identitas kontak (email dan nomor telepon) dijaga kerahasiaannya dan hanya dapat diakses oleh tim verifikator internal.
                </div>

                <form action="{{ route('tanggapan.store', $ujiPublik->regulasi_id) }}" method="POST">
                    @csrf

                    <div class="pp-form-row">
                        <div class="pp-form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama" required placeholder="Masukkan nama lengkap Anda" value="{{ old('nama') }}">
                        </div>
                        <div class="pp-form-group">
                            <label>Alamat Email <span style="font-weight:400; color:#94a3b8;">(Tidak ditampilkan ke publik)</span></label>
                            <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="pp-form-row">
                        <div class="pp-form-group">
                            <label>Kategori Pengirim <span class="req">*</span></label>
                            <select name="instansi" id="instansiSelect" required onchange="ppHandleInstansiChange()">
                                <option value="masyarakat" {{ old('instansi') === 'masyarakat' ? 'selected' : '' }}>Masyarakat Umum</option>
                                <option value="pemerintahan_akademisi" {{ old('instansi') === 'pemerintahan_akademisi' ? 'selected' : '' }}>Kementerian/Lembaga/Akademisi/Asosiasi</option>
                            </select>
                        </div>
                        <div class="pp-form-group" id="ppSlotSecondary"></div>
                    </div>

                    <div class="pp-form-row" id="ppRowExtraTelp" style="display:none;">
                        <div class="pp-form-group"></div>
                    </div>

                    {{-- Dynamic fields moved by JS --}}
                    <div id="ppFieldTelp" style="display:none;">
                        <label>Nomor Telepon / WhatsApp <span style="font-weight:400; color:#94a3b8;">(Tidak ditampilkan ke publik)</span></label>
                        <input type="tel" name="nomor_telepon" id="ppInputTelp" placeholder="08xxxxxxxxxx"
                            value="{{ old('nomor_telepon') }}">
                    </div>
                    <div id="ppFieldNamaInstansi" style="display:none;">
                        <label>Nama Instansi / Lembaga / Universitas <span class="req">*</span></label>
                        <input type="text" name="nama_instansi" id="ppInputNamaInstansi" placeholder="Nama K/L/D/Universitas/Asosiasi"
                            value="{{ old('nama_instansi') }}">
                    </div>

                    <div class="pp-form-group" style="margin-bottom: 20px;">
                        <label>Isi Tanggapan / Masukan / Substansi Pasal <span class="req">*</span></label>
                        <textarea name="isi_tanggapan" required rows="5"
                            placeholder="Tuliskan tanggapan, saran penyempurnaan pasal, atau masukan Anda secara jelas...">{{ old('isi_tanggapan') }}</textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="pp-submit-btn">Kirim Tanggapan Publik ➤</button>
                    </div>
                </form>
            </div>
        @endif

    </div>

    <script>
        function ppHandleInstansiChange() {
            var selectEl = document.getElementById('instansiSelect');
            if (!selectEl) return;
            var val = selectEl.value;
            var slotSecondary = document.getElementById('ppSlotSecondary');
            var rowExtraTelp = document.getElementById('ppRowExtraTelp');
            var telpField = document.getElementById('ppFieldTelp');
            var namaInstansiField = document.getElementById('ppFieldNamaInstansi');
            var inputNamaInstansi = document.getElementById('ppInputNamaInstansi');

            if (val === 'pemerintahan_akademisi') {
                slotSecondary.innerHTML = '';
                slotSecondary.appendChild(namaInstansiField);
                namaInstansiField.style.display = 'block';
                inputNamaInstansi.required = true;

                rowExtraTelp.style.display = 'grid';
                var telpSlot = rowExtraTelp.querySelector('.pp-form-group');
                telpSlot.innerHTML = '';
                telpSlot.appendChild(telpField);
                telpField.style.display = 'block';
            } else {
                slotSecondary.innerHTML = '';
                slotSecondary.appendChild(telpField);
                telpField.style.display = 'block';

                rowExtraTelp.style.display = 'none';
                namaInstansiField.style.display = 'none';
                inputNamaInstansi.required = false;
                inputNamaInstansi.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', ppHandleInstansiChange);
    </script>

@endsection
