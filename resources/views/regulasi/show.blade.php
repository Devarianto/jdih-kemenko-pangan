@extends('layouts.app')

@section('page-title', 'Detail Regulasi')

@section('content')

    @php
        $isSuperAdmin = auth()->user()->role === 'super_admin';
        $bisaKelola = $isSuperAdmin
            || strcasecmp(trim((string) $regulasi->unit_kerja), trim((string) auth()->user()->unit_kerja)) === 0;

        $stages = [
            'pengajuan' => ['label' => 'Pengajuan', 'icon' => '📋'],
            'pembahasan' => ['label' => 'Pembahasan', 'icon' => '💬'],
            'uji_publik' => ['label' => 'Partisipasi Publik', 'icon' => '🌐'],
            'pasca_partisipasi' => ['label' => 'Pasca Partisipasi Publik', 'icon' => '📝'],
            'harmonisasi' => ['label' => 'Harmonisasi', 'icon' => '🔗'],
            'penetapan' => ['label' => 'Penetapan', 'icon' => '✅'],
        ];

        $defaultOpen = $regulasi->current_stage ?? 'pengajuan';

        // Pasca partisipasi hanya bisa diisi setelah operator KLIK "Lanjut ke Pasca Partisipasi Publik"
        // (bukan otomatis begitu masuk uji_publik). Kalau sudah lewat ke harmonisasi/penetapan,
        // anggap pasca sudah pernah dimulai (untuk data lama / regulasi yang sudah lanjut).
        $pascaSudahDimulai = (bool) ($regulasi->pasca_partisipasi_dimulai ?? false);
        $sudahLewatUjiPublik = in_array($regulasi->current_stage, ['harmonisasi', 'penetapan']);
        $pascaBisaDiisi = $pascaSudahDimulai || $sudahLewatUjiPublik;

        // Super Admin selalu dapat menambah/mengedit/menghapus proses di semua tahap,
        // sedangkan operator hanya saat masih di uji_publik setelah klik "Lanjut ke Pasca Partisipasi Publik".
        $prosceBisaKelola = $bisaKelola && ($isSuperAdmin || ($regulasi->current_stage === 'uji_publik' && $pascaSudahDimulai));
        $pembahasanBisaKelola = $bisaKelola && ($isSuperAdmin || in_array($regulasi->current_stage, ['pengajuan', 'pembahasan']));
    @endphp

    <style>
        :root {
            --navy: #003580;
            --navy-deep: #0d1b3e;
            --ink: #1a1a2e;
            --muted: #8a93a6;
            --line: #e8edf6;
            --bg-soft: #f4f6fb;
            --accent-bg: #eaf0ff;
        }

        * {
            box-sizing: border-box;
        }

        .detail-wrap {
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            padding-inline: 4px;
        }

        /* ───────────────────────── TOAST NOTIFICATIONS ───────────────────────── */
        .toast-stack {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 380px;
            width: calc(100% - 40px);
        }

        .toast {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 32, 96, .16);
            border: 1px solid var(--line);
            border-left: 4px solid var(--navy);
            animation: toast-in .25s cubic-bezier(.2, .8, .3, 1) both;
            font-size: 13.5px;
        }

        .toast.success {
            border-left-color: #2e7d32;
        }

        .toast.error {
            border-left-color: #c0392b;
        }

        .toast.info {
            border-left-color: var(--navy);
        }

        .toast-icon {
            font-size: 18px;
            line-height: 1;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .toast-body {
            flex: 1;
            min-width: 0;
        }

        .toast-title {
            font-weight: 700;
            color: var(--navy-deep);
            margin-bottom: 2px;
        }

        .toast-msg {
            color: #4a5578;
            line-height: 1.45;
            word-break: break-word;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 15px;
            cursor: pointer;
            line-height: 1;
            padding: 2px;
            flex-shrink: 0;
        }

        .toast-close:hover {
            color: var(--navy-deep);
        }

        .toast.hide {
            animation: toast-out .2s ease forwards;
        }

        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateX(24px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes toast-out {
            from {
                opacity: 1;
                transform: translateX(0);
                max-height: 200px;
                margin-bottom: 10px;
            }

            to {
                opacity: 0;
                transform: translateX(24px);
                max-height: 0;
                margin-bottom: 0;
                padding-top: 0;
                padding-bottom: 0;
            }
        }

        @media (max-width: 560px) {
            .toast-stack {
                top: 12px;
                right: 12px;
                left: 12px;
                max-width: none;
                width: auto;
            }
        }

        /* ───────────────────────── HEADER ───────────────────────── */
        .reg-header {
            background: #fff;
            border-radius: 14px;
            padding: 24px 28px;
            border: 1px solid var(--line);
            box-shadow: 0 2px 8px rgba(0, 32, 96, .06);
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .reg-header-title {
            font-size: 19px;
            font-weight: 700;
            color: var(--navy-deep);
            line-height: 1.4;
            word-break: break-word;
        }

        .reg-header-meta {
            font-size: 13px;
            color: var(--muted);
            margin-top: 5px;
        }

        .reg-back {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            background: #f0f4ff;
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #d0dbf5;
            transition: background .15s;
            white-space: nowrap;
        }

        .reg-back:hover {
            background: #dde6ff;
        }

        .alert-info-custom {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            background: var(--accent-bg);
            color: var(--navy);
            border: 1px solid #c9d8f5;
        }

        /* ───────────────────────── TIMELINE ───────────────────────── */
        .timeline-wrap {
            background: #fff;
            border-radius: 14px;
            padding: 28px 32px 20px;
            border: 1px solid var(--line);
            box-shadow: 0 2px 8px rgba(0, 32, 96, .06);
            margin-bottom: 28px;
            overflow-x: auto;
        }

        .timeline-title {
            font-size: 13px;
            font-weight: 700;
            color: #8a93a6;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 24px;
        }

        .timeline-row {
            display: flex;
            align-items: flex-start;
            position: relative;
            min-width: 560px;
        }

        .timeline-row::before {
            content: '';
            position: absolute;
            top: 22px;
            left: calc(10% + 24px);
            right: calc(10% + 24px);
            height: 2px;
            background: #e0e7f4;
            z-index: 0;
        }

        .tl-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            position: relative;
            z-index: 1;
            transition: transform .15s;
            padding: 0 4px;
        }

        .tl-step:hover {
            transform: translateY(-2px);
        }

        .tl-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            border: 3px solid #e0e7f4;
            background: var(--bg-soft);
            color: #b0bbcc;
            transition: all .2s;
            flex-shrink: 0;
        }

        .tl-step.done .tl-circle {
            background: var(--accent-bg);
            color: var(--navy);
            border-color: var(--navy);
        }

        .tl-step.active .tl-circle {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
            box-shadow: 0 0 0 5px rgba(0, 53, 128, .15);
        }

        .tl-step.selected .tl-circle {
            box-shadow: 0 0 0 5px rgba(0, 53, 128, .25);
            transform: scale(1.1);
        }

        .tl-step.locked .tl-circle {
            background: var(--bg-soft);
            color: #b0bbcc;
            border-color: #e0e7f4;
        }

        .tl-label {
            margin-top: 10px;
            text-align: center;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--muted);
            transition: color .2s;
        }

        .tl-step.done .tl-label,
        .tl-step.active .tl-label {
            color: var(--navy);
        }

        .tl-step.active .tl-label,
        .tl-step.selected .tl-label {
            color: var(--navy-deep);
            font-weight: 700;
        }

        .tl-step.locked .tl-label {
            color: #b0bbcc;
        }

        .tl-date {
            font-size: 11px;
            color: #b0bbcc;
            margin-top: 3px;
            text-align: center;
        }

        .tl-step.done .tl-date,
        .tl-step.active .tl-date {
            color: #4a7abf;
        }

        /* ───────────────────────── STAGE PANEL ───────────────────────── */
        .stage-panel {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--line);
            box-shadow: 0 2px 8px rgba(0, 32, 96, .06);
            overflow: hidden;
        }

        .tab-pane {
            display: none;
            padding: 28px 28px 24px;
            animation: fadeIn .2s ease;
        }

        .tab-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pane-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f3fa;
            flex-wrap: wrap;
        }

        .pane-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--accent-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .pane-icon.inactive {
            background: var(--bg-soft);
        }

        .pane-head-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy-deep);
        }

        .pane-head-sub {
            font-size: 12.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #f6f8fc;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            width: 200px;
            flex-shrink: 0;
            color: var(--muted);
            font-weight: 500;
        }

        .info-val {
            color: var(--ink);
            font-weight: 500;
            flex: 1;
            min-width: 0;
            word-break: break-word;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            background: var(--accent-bg);
            color: var(--navy);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #c9d8f5;
            transition: background .15s;
        }

        .file-link:hover {
            background: #dde6ff;
        }

        .table-scroll {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 16px;
        }

        .proc-table {
            width: 100%;
            min-width: 560px;
            border-collapse: collapse;
            font-size: 13.5px;
            margin-bottom: 0;
        }

        .proc-table th {
            text-align: left;
            padding: 9px 10px;
            font-size: 11.5px;
            color: var(--muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            border-bottom: 2px solid #f0f3fa;
            white-space: nowrap;
        }

        .proc-table td {
            padding: 11px 10px;
            color: #2d3a55;
            border-bottom: 1px solid #f6f8fc;
        }

        .proc-table tr:last-child td {
            border-bottom: none;
        }

        .proc-table tbody tr:hover {
            background: #f9fbff;
        }

        .stage-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 13px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .stage-status.active {
            background: var(--accent-bg);
            color: var(--navy);
        }

        .stage-status.done {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .stage-status.pending {
            background: var(--bg-soft);
            color: var(--muted);
        }

        .stage-status.locked {
            background: var(--bg-soft);
            color: #b0bbcc;
        }

        .add-proc-grid {
            display: grid;
            grid-template-columns: 2fr 2fr 1.2fr;
            gap: 8px;
            align-items: end;
            margin-bottom: 8px;
        }

        .add-proc-grid input[type="file"] {
            background: #f8faff;
            border: 1.5px dashed #c9d8f5;
            border-radius: 8px;
            cursor: pointer;
        }

        .add-proc-grid input[type="file"]:hover {
            border-color: var(--navy);
            background: #f0f4ff;
        }

        .empty-state {
            text-align: center;
            padding: 32px 16px;
            color: #b0bbcc;
        }

        .empty-state-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 13.5px;
        }

        .field-error {
            color: #c0392b;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Kolom tanggal di tabel proses: tampilkan hint hover */
        .proc-table td[onclick] {
            text-decoration: underline dotted #a0aec0;
            user-select: none;
        }

        .proc-table td[onclick]:hover {
            color: var(--navy-deep);
            text-decoration: underline;
        }

        /* ═══════════════════════ RESPONSIVE ═══════════════════════ */
        @media (max-width: 900px) {
            .detail-wrap {
                padding-inline: 0;
            }
        }

        @media (max-width: 700px) {
            .add-proc-grid {
                grid-template-columns: 1fr;
            }

            .reg-header {
                padding: 18px 18px;
                gap: 10px;
            }

            .reg-header-title {
                font-size: 17px;
            }

            .reg-back {
                padding: 7px 13px;
                font-size: 12.5px;
            }

            .timeline-wrap {
                padding: 20px 16px 16px;
            }

            .tab-pane {
                padding: 20px 16px 18px;
            }

            .info-row {
                flex-direction: column;
                gap: 2px;
                padding: 10px 0;
            }

            .info-key {
                width: 100%;
                font-size: 12px;
            }

            .pane-head {
                gap: 10px;
            }

            .pane-head-title {
                font-size: 15px;
            }

            .stage-status {
                margin-left: 0 !important;
                order: 3;
                width: 100%;
                justify-content: center;
                margin-top: 4px;
            }
        }

        @media (max-width: 480px) {
            .reg-header {
                flex-direction: column;
                align-items: stretch;
            }

            .reg-back {
                justify-content: center;
            }

            .tl-label {
                font-size: 11px;
            }

            .tl-circle {
                width: 38px;
                height: 38px;
                font-size: 13px;
            }

            .pane-icon {
                width: 34px;
                height: 34px;
                font-size: 15px;
            }

            .toast-title {
                font-size: 13px;
            }

            .toast-msg {
                font-size: 12.5px;
            }
        }

        /* Buttons & forms stack nicely on small screens */
        @media (max-width: 700px) {
            .btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            div[style*="display: flex"][style*="gap"] form,
            div[style*="display:flex"][style*="gap"] form {
                width: 100%;
            }
        }

        /* ───────────────────────── CUSTOM CONFIRM MODAL ───────────────────────── */
        .confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 62, .45);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            opacity: 0;
            pointer-events: none;
            transition: opacity .18s ease;
            padding: 16px;
        }

        .confirm-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .confirm-modal {
            background: #fff;
            border-radius: 16px;
            padding: 28px 26px 22px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0, 32, 96, .25);
            transform: translateY(10px) scale(.97);
            opacity: 0;
            transition: transform .2s cubic-bezier(.2, .8, .3, 1), opacity .2s ease;
            text-align: center;
        }

        .confirm-overlay.show .confirm-modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .confirm-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--accent-bg);
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .confirm-icon.danger {
            background: #fdecea;
            color: #c0392b;
        }

        .confirm-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy-deep);
            margin-bottom: 6px;
        }

        .confirm-message {
            font-size: 13.5px;
            color: #5a6480;
            line-height: 1.55;
            margin-bottom: 22px;
        }

        .confirm-actions {
            display: flex;
            gap: 10px;
        }

        .confirm-actions .btn {
            flex: 1;
            font-size: 13.5px;
            padding: 10px 14px;
            justify-content: center;
        }

        .confirm-btn-cancel {
            border: 1px solid #d8dfef;
            color: #5a6480;
            background: #fff;
        }

        .confirm-btn-cancel:hover {
            background: #f4f6fb;
        }

        .confirm-btn-ok {
            border: 1px solid var(--navy);
            background: var(--navy);
            color: #fff;
        }

        .confirm-btn-ok:hover {
            background: #002a66;
        }

        .confirm-btn-ok.danger {
            border-color: #c0392b;
            background: #c0392b;
        }

        .confirm-btn-ok.danger:hover {
            background: #a5301f;
        }

        @media (max-width: 480px) {
            .confirm-modal {
                padding: 24px 20px 18px;
            }

            .confirm-actions {
                flex-direction: column-reverse;
            }
        }
    </style>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- TOAST NOTIFICATIONS (session flash & errors) --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="toast-stack" id="toast-stack">
        @if(session('success'))
            <div class="toast success">
                <div class="toast-body">
                            <div class="toast-title">Berhasil</div>
                            <div class="toast-msg">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="toast-close" onclick="dismissToast(this)">✕</button>
                    </div>
        @endif

            @if(session('error'))
                <div class="toast error">
                    <div class="toast-body">
                        <div class="toast-title">Gagal</div>
                        <div class="toast-msg">{{ session('error') }}</div>
                    </div>
                    <button type="button" class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif

            @if(session('info'))
                <div class="toast info">
                    <div class="toast-body">
                        <div class="toast-title">Informasi</div>
                        <div class="toast-msg">{{ session('info') }}</div>
                    </div>
                    <button type="button" class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="toast error">
                    <div class="toast-body">
                                    <div class="toast-title">Periksa kembali isian Anda</div>
                                    <div class="toast-msg">{{ $errors->first() }}</div>
                                </div>
                                <button type="button" class="toast-close" onclick="dismissToast(this)">✕</button>
                            </div>
            @endif
                </div>

                {{-- ═══════════════════════════════════════════ --}}
                {{-- CUSTOM CONFIRM MODAL (pengganti confirm() bawaan browser) --}}
                {{-- ═══════════════════════════════════════════ --}}
                <div class="confirm-overlay" id="confirm-overlay">
                    <div class="confirm-modal">
                        <div class="confirm-icon" id="confirm-icon">❓</div>
                        <div class="confirm-title" id="confirm-title">Konfirmasi</div>
                        <div class="confirm-message" id="confirm-message"></div>
                        <div class="confirm-actions">
                            <button type="button" class="btn confirm-btn-cancel" id="confirm-cancel-btn">Batal</button>
                            <button type="button" class="btn confirm-btn-ok" id="confirm-ok-btn">Ya, Lanjutkan</button>
                        </div>
                    </div>
                </div>

                <div class="detail-wrap">

                    @if(!$bisaKelola)
                        <div class="alert-info-custom">
                            ℹ️ Ini regulasi milik unit kerja lain. Anda hanya bisa melihat, tidak bisa mengubah.
                        </div>
                    @endif

                    {{-- HEADER --}}
                    <div class="reg-header">
                        <div>
                            <div class="reg-header-title">{{ $regulasi->judul }}</div>
                            <div class="reg-header-meta">{{ $regulasi->jenis }} &middot; {{ $regulasi->unit_kerja }}</div>
                        </div>
                        <a href="{{ route('regulasi.index') }}" class="reg-back">← Kembali</a>
                    </div>

                    {{-- TIMELINE --}}
                    <div class="timeline-wrap">
                        <div class="timeline-title">Timeline Penyusunan</div>
                        <div class="timeline-row">
                            @php $i = 1; @endphp
                            @foreach($stages as $key => $info)
                                @php
                                    $isActive = $regulasi->isStageActive($key);
                                    $isCompleted = $regulasi->isStageCompleted($key);

                                    $pascaSudahDimulaiTl = (bool) ($regulasi->pasca_partisipasi_dimulai ?? false);
                                    $sudahHarmonisasiTl = in_array($regulasi->current_stage, ['harmonisasi', 'penetapan']);

                                    if ($key === 'uji_publik') {
                                        // Tandai done jika operator sudah klik "Lanjut ke Pasca Partisipasi"
                                        if ($pascaSudahDimulaiTl && $regulasi->current_stage === 'uji_publik') {
                                            $isCompleted = true;
                                            $isActive = false;
                                        }
                                    }

                                    if ($key === 'pasca_partisipasi') {
                                        // Done begitu sudah lewat ke harmonisasi/penetapan — tidak peduli
                                        // ada/tidaknya proses pasca yang diisi, karena operator sudah resmi
                                        // melewati tahap ini lewat tombol "Lanjut ke Harmonisasi".
                                        $isCompleted = $sudahHarmonisasiTl;
                                        // Active: di uji_publik DAN operator sudah klik lanjut ke pasca
                                        $isActive = !$sudahHarmonisasiTl
                                            && $regulasi->current_stage === 'uji_publik'
                                            && $pascaSudahDimulaiTl;
                                    }

                                    // Pasca partisipasi dikunci HANYA jika belum diklik "Lanjut ke Pasca Partisipasi"
                                    // saat masih di uji_publik. Begitu sudah harmonisasi/penetapan, tahap ini
                                    // dianggap selesai (done), bukan locked.
                                    $isLocked = ($key === 'pasca_partisipasi')
                                        && !$pascaSudahDimulaiTl
                                        && $regulasi->current_stage === 'uji_publik';

                                    $showUjiPublikDate = !in_array($regulasi->current_stage, ['pengajuan', 'pembahasan']);
                                    $showPascaDate = $pascaSudahDimulaiTl || $sudahHarmonisasiTl;

                                    $tgl = match ($key) {
                                        'pengajuan' => $regulasi->tgl_usulan?->format('d M Y'),
                                        'pembahasan' => $regulasi->proses->where('is_after_uji_publik', false)->first()?->tanggal?->format('d M Y'),
                                        'uji_publik' => $showUjiPublikDate ? ($regulasi->partisipasiPublik?->tgl_mulai?->format('d M Y') ?? null) : null,
                                        'pasca_partisipasi' => $showPascaDate ? ($regulasi->proses->where('is_after_uji_publik', true)->first()?->tanggal?->format('d M Y') ?? null) : null,
                                        'harmonisasi' => $regulasi->tgl_mulai_harmonisasi?->format('d M Y') ?? null,
                                        'penetapan' => $regulasi->tgl_mulai_penetapan?->format('d M Y') ?? null,
                                        default => null,
                                    };

                                    $stepClass = $isCompleted ? 'done' : ($isActive ? 'active' : ($isLocked ? 'locked' : ''));
                                @endphp
                                <div class="tl-step {{ $stepClass }}" id="tl-{{ $key }}" onclick="selectTab('{{ $key }}')">
                                    <div class="tl-circle">
                                        @if($isCompleted) ✓
                                        @else {{ $i }}
                                        @endif
                                    </div>
                                    <div class="tl-label">{{ $info['label'] }}</div>
                                    <div class="tl-date">{{ $tgl ?? '-' }}</div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>

                    {{-- STAGE PANEL --}}
                    <div class="stage-panel">

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 1: PENGAJUAN                          --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-pengajuan">
                            @php
                                $active = $regulasi->isStageActive('pengajuan');
                                $done = $regulasi->isStageCompleted('pengajuan');
                            @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$active && !$done) ? 'inactive' : '' }}">🧾</div>
                                <div>
                                    <div class="pane-head-title">Pengajuan Regulasi</div>
                                    <div class="pane-head-sub">Informasi dasar dan dokumen permohonan</div>
                                </div>
                                @if($done)  <span class="stage-status done"   style="margin-left:auto;">✓ Selesai</span>
                                @elseif($active) <span class="stage-status active" style="margin-left:auto;">● Aktif</span>
                                @endif
                            </div>

                            <div class="info-row">
                                <div class="info-key">Jenis Peraturan</div>
                                <div class="info-val">{{ $regulasi->jenis }}</div>
                            </div>
                            @if($regulasi->abstrak)
                                <div class="info-row">
                                    <div class="info-key">Abstrak</div>
                                    <div class="info-val" style="line-height:1.6;">{{ $regulasi->abstrak }}</div>
                                </div>
                            @endif
                            <div class="info-row">
                                <div class="info-key">Tanggal Usulan</div>
                                <div class="info-val">{{ $regulasi->tgl_usulan->format('d F Y') }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-key">Diajukan Oleh</div>
                                <div class="info-val">{{ $regulasi->pemohon->name ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-key">Dokumen Permohonan</div>
                                <div class="info-val">
                                    @if($regulasi->file_permohonan)
                                        <a href="{{ Storage::url($regulasi->file_permohonan) }}" target="_blank" class="file-link">📄 Lihat / Unduh</a>
                                    @else
                                        <span style="color:#ccc;">Tidak ada</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-key">Draft Awal</div>
                                <div class="info-val">
                                    @if($regulasi->file_draft)
                                        <a href="{{ Storage::url($regulasi->file_draft) }}" target="_blank" class="file-link">📄 Lihat / Unduh</a>
                                    @else
                                        <span style="color:#ccc;">Tidak ada</span>
                                    @endif
                                </div>
                            </div>

                            @if(($isSuperAdmin || in_array($regulasi->current_stage, ['pengajuan', 'pembahasan'])) && $bisaKelola)
                                <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0f3fa; display: flex; gap: 10px; flex-wrap: wrap;">
                                    <a href="{{ route('regulasi.edit', $regulasi) }}" class="btn"
                                        style="font-size: 13px; border: 1px solid #003580; color: #003580;">✏ Edit Data Rancangan</a>
                                    @if($regulasi->current_stage === 'pengajuan')
                                        <form action="{{ route('regulasi.mulai-pembahasan', $regulasi) }}" method="POST"
                                            onsubmit="return confirmAction(event, this, 'Mulai tahap pembahasan untuk regulasi ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="font-size: 13px;">➤ Mulai Pembahasan</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 2: PEMBAHASAN                         --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-pembahasan">
                            @php
                                $active = $regulasi->isStageActive('pembahasan');
                                $done = $regulasi->isStageCompleted('pembahasan');
                            @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$active && !$done) ? 'inactive' : '' }}">💬</div>
                                <div>
                                    <div class="pane-head-title">Pembahasan</div>
                                    <div class="pane-head-sub">Riwayat proses pembahasan regulasi</div>
                                </div>
                                @if($done)        <span class="stage-status done"    style="margin-left:auto;">✓ Selesai</span>
                                @elseif($active)  <span class="stage-status active"  style="margin-left:auto;">● Aktif</span>
                                @else             <span class="stage-status pending"  style="margin-left:auto;">— Belum Dimulai</span>
                                @endif
                            </div>

                            @php $prosePembahasan = $regulasi->proses->where('is_after_uji_publik', false); @endphp

                            @if($prosePembahasan->isEmpty())
                                <div class="empty-state">
                                    <p>Belum ada proses pembahasan tercatat.</p>
                                </div>
                            @else
                                <div class="table-scroll">
                                <table class="proc-table">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Proses</th>
                                            <th>Tanggal</th>
                                            <th>Dokumen</th>
                                            @if($pembahasanBisaKelola)
                                                <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prosePembahasan as $p)
                                            <tr id="row-proses-{{ $p->id }}">
                                                <td>{{ $p->judul }}</td>
                                                <td>{{ $p->proses }}</td>
                                                <td style="cursor:pointer;color:#003580;" onclick="toggleEditProses({{ $p->id }})" title="Klik untuk edit">{{ $p->tanggal->format('d M Y') }}</td>
                                                <td>
                                                    @if(!empty($p->file_dokumen))
                                                        @foreach((array) $p->file_dokumen as $idx => $file)
                                                            <a href="{{ Storage::url($file) }}" target="_blank" class="file-link"
                                                                style="margin-bottom:4px;display:inline-flex;">📄 Dok {{ $idx + 1 }}</a>
                                                        @endforeach
                                                    @else
                                                        <span style="color:#ccc;font-size:12px;">—</span>
                                                    @endif
                                                </td>
                                                @if($pembahasanBisaKelola)
                                                    <td style="white-space:nowrap;">
                                                        <button type="button" onclick="toggleEditProses({{ $p->id }})" class="btn"
                                                            style="font-size:12px;padding:5px 10px;border:1px solid #003580;color:#003580;">✏ Edit</button>
                                                        <form action="{{ route('regulasi.proses.destroy', [$regulasi, $p]) }}" method="POST"
                                                            style="display:inline;" onsubmit="return confirmAction(event, this, 'Hapus proses ini? Tindakan ini tidak bisa dibatalkan.', true)">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" style="font-size:12px;padding:5px 10px;">Hapus</button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                            @if($pembahasanBisaKelola)
                                                <tr id="edit-proses-{{ $p->id }}" style="display:none;background:#f8faff;">
                                                    <td colspan="5" style="padding:16px;">
                                                        <form action="{{ route('regulasi.proses.update', [$regulasi, $p]) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf @method('PUT')
                                                            <div style="display:grid;grid-template-columns:2fr 2fr 1.2fr;gap:10px;margin-bottom:10px;">
                                                                <div><label class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="{{ $p->judul }}" required></div>
                                                                <div><label class="form-label">Proses</label><input type="text" name="proses" class="form-control" value="{{ $p->proses }}" required></div>
                                                                <div><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ $p->tanggal->format('Y-m-d') }}" required></div>
                                                            </div>
                                                            <div style="margin-bottom:10px;">
                                                                <label class="form-label">Ganti Dokumen <span style="color:#b0bbcc;font-weight:400;">(opsional · maks 10MB per file)</span></label>
                                                                <input type="file" name="file_dokumen[]" multiple class="form-control"
                                                                    id="dok-edit-pembahasan-{{ $p->id }}"
                                                                    onchange="checkMultiFileSize(this, 'warn-edit-pembahasan-{{ $p->id }}')"
                                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png" style="padding:7px 12px;font-size:13px;">
                                                                <small id="warn-edit-pembahasan-{{ $p->id }}" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                                            </div>
                                                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                                                <button type="submit" class="btn btn-primary" style="font-size:13px;">💾 Simpan</button>
                                                                <button type="button" onclick="toggleEditProses({{ $p->id }})" class="btn"
                                                                    style="font-size:13px;border:1px solid #ccc;color:#666;">Batal</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            @endif

                            @if($pembahasanBisaKelola)
                                <div style="margin-top:20px;padding-top:18px;border-top:1px solid #f0f3fa;">
                                    <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">
                                        Tambah Proses/Notulensi/Risalah Rapat
                                    </p>
                                    @if($errors->hasAny(['judul', 'proses', 'tanggal', 'file_dokumen', 'file_dokumen.*']) && in_array($regulasi->current_stage, ['pengajuan', 'pembahasan']))
                                        <div class="alert alert-danger" style="font-size:13px;margin-bottom:12px;border-radius:8px;">
                                            <strong>Gagal menyimpan:</strong> {{ $errors->first() }}
                                        </div>
                                    @endif
                                    <form action="{{ route('regulasi.proses.store', $regulasi) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="add-proc-grid">
                                            <div class="form-group" style="margin:0;"><label class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required></div>
                                            <div class="form-group" style="margin:0;"><label class="form-label">Proses</label><input type="text" name="proses" class="form-control" value="{{ old('proses') }}" placeholder="Contoh: Rapat Internal" required></div>
                                            <div class="form-group" style="margin:0;"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required></div>
                                            <div class="form-group" style="margin:0;grid-column:1/-1;">
                                                <label class="form-label">Dokumen Pendukung <span style="color:#b0bbcc;font-weight:400;">(opsional · bisa lebih dari 1 · PDF/Word/Excel/PPT/Gambar · maks 10MB per file)</span></label>
                                                <input type="file" name="file_dokumen[]" multiple class="form-control"
                                                    id="dok-tambah-pembahasan"
                                                    onchange="checkMultiFileSize(this, 'warn-tambah-pembahasan')"
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png" style="padding:7px 12px;font-size:13px;">
                                                <small id="warn-tambah-pembahasan" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                style="padding:10px 16px;font-size:13px;white-space:nowrap;grid-column:1/-1;width:fit-content;">+ Tambah</button>
                                        </div>
                                    </form>
                                </div>

                                @if($regulasi->current_stage === 'pembahasan')
                                <div style="margin-top:18px;padding-top:16px;border-top:1px solid #f0f3fa;">
                                    @if($regulasi->uji_publik_status === 'requested')
                                        {{-- Sudah request, tampilkan info menunggu --}}
                                        <div class="alert" style="background:#fff8e1;color:#e65100;border:1px solid #ffe0b2;font-size:13px;border-radius:8px;padding:12px 16px;margin-bottom:0;">
                                            @if($regulasi->partisipasiPublik)
                                                <div style="margin-top:6px;font-weight:600;">
                                                    Periode diusulkan: {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_mulai)->isoFormat('D MMM Y') }}
                                                    — {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_selesai)->isoFormat('D MMM Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($prosePembahasan->isEmpty())
                                        {{-- Belum ada proses, tampilkan panduan --}}
                                        <div style="padding:14px 16px;background:#f8faff;border-radius:10px;border:1px solid #e8edf6;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                                            <p style="font-size:13px;color:#8a93a6;margin:0;">
                                                Tambahkan minimal <strong>1 proses pembahasan</strong> di atas sebelum bisa mengajukan request Partisipasi Publik.
                                            </p>
                                            @if($isSuperAdmin)
                                                <form action="{{ route('regulasi.uji-publik.request', $regulasi) }}" method="POST"
                                                    onsubmit="return confirmAction(event, this, 'Lewati tahap Pembahasan (Tidak Ada Pembahasan) dan lanjut ke tahap Partisipasi Publik?')">
                                                    @csrf
                                                    <input type="hidden" name="skip_pembahasan" value="1">
                                                    <button type="submit" class="btn btn-primary" style="font-size:13px;white-space:nowrap;">
                                                        ➤ Tidak Ada Pembahasan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        {{-- Ada proses, tampilkan form request --}}
                                        @if($regulasi->uji_publik_status === 'rejected')
                                            <div class="alert alert-danger" style="font-size:13px;margin-bottom:14px;">✕ Request Partisipasi Publik sebelumnya ditolak. Anda bisa mengajukan ulang dengan periode tanggal baru.</div>
                                        @endif

                                        <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">
                                            Usulkan Periode Partisipasi Publik
                                        </p>
                                        @if($errors->hasAny(['tgl_mulai_uji_publik', 'tgl_selesai_uji_publik']))
                                            <div class="alert alert-danger" style="font-size:13px;margin-bottom:12px;border-radius:8px;">
                                                <strong>Gagal menyimpan:</strong> {{ $errors->first('tgl_mulai_uji_publik') ?: $errors->first('tgl_selesai_uji_publik') }}
                                            </div>
                                        @endif
                                        <form action="{{ route('regulasi.uji-publik.request', $regulasi) }}" method="POST">
                                            @csrf
                                            <div class="add-proc-grid" style="grid-template-columns:1fr 1fr auto;">
                                                <div class="form-group" style="margin:0;">
                                                    <label class="form-label">Tanggal Mulai *</label>
                                                    <input type="date" name="tgl_mulai_uji_publik" class="form-control"
                                                        value="{{ old('tgl_mulai_uji_publik', $regulasi->partisipasiPublik?->tgl_mulai?->format('Y-m-d')) }}" required>
                                                </div>
                                                <div class="form-group" style="margin:0;">
                                                    <label class="form-label">Tanggal Selesai *</label>
                                                    <input type="date" name="tgl_selesai_uji_publik" class="form-control"
                                                        value="{{ old('tgl_selesai_uji_publik', $regulasi->partisipasiPublik?->tgl_selesai?->format('Y-m-d')) }}" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary"
                                                    style="padding:10px 16px;font-size:13px;white-space:nowrap;align-self:end;">
                                                    ➤ {{ $regulasi->uji_publik_status === 'rejected' ? 'Request Ulang' : 'Request Partisipasi Publik' }}
                                                </button>
                                            </div>
                                            <small style="color:#888;font-size:12px;">Periode ini akan otomatis aktif begitu Super Admin menyetujui request.</small>
                                        </form>
                                    @endif
                                </div>
                                @elseif($isSuperAdmin && $regulasi->current_stage === 'pengajuan')
                                <div style="margin-top:18px;padding-top:16px;border-top:1px solid #f0f3fa;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                                    <span style="font-size:13px;color:#8a93a6;">
                                        Super Admin dapat melewati tahap Pembahasan dan langsung masuk ke tahap <strong>Partisipasi Publik</strong>.
                                    </span>
                                    <form action="{{ route('regulasi.uji-publik.request', $regulasi) }}" method="POST"
                                        onsubmit="return confirmAction(event, this, 'Lewati tahap Pembahasan (Tidak Ada Pembahasan) dan lanjut ke tahap Partisipasi Publik?')">
                                        @csrf
                                        <input type="hidden" name="skip_pembahasan" value="1">
                                        <button type="submit" class="btn btn-primary" style="font-size:13px;white-space:nowrap;">
                                            ➤ Tidak Ada Pembahasan
                                        </button>
                                    </form>
                                </div>
                                @endif
                            @endif
                        </div>

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 3: PARTISIPASI PUBLIK                 --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-uji_publik">
                            @php
                                $active = $regulasi->isStageActive('uji_publik');
                                $done = $regulasi->isStageCompleted('uji_publik');
                            @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$active && !$done) ? 'inactive' : '' }}">🌐</div>
                                <div>
                                    <div class="pane-head-title">Partisipasi Publik</div>
                                    <div class="pane-head-sub">Proses konsultasi dan masukan publik</div>
                                </div>
                                @if($done)       <span class="stage-status done"    style="margin-left:auto;">✓ Selesai</span>
                                @elseif($active) <span class="stage-status active"  style="margin-left:auto;">● Aktif</span>
                                @else            <span class="stage-status pending"  style="margin-left:auto;">— Belum Dimulai</span>
                                @endif
                            </div>

                            @if($regulasi->current_stage === 'pembahasan' && $regulasi->uji_publik_status === 'requested')
                                {{-- Super admin approval --}}
                                <p style="font-size:14px;margin-bottom:16px;color:#555;">Operator
                                    <strong>{{ $regulasi->pemohon->name ?? '' }}</strong> mengajukan request untuk maju ke tahap Partisipasi Publik.</p>
                                @if(auth()->user()->role === 'super_admin')
                                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                        <form action="{{ route('regulasi.uji-publik.approve', $regulasi) }}" method="POST">
                                            @csrf<button type="submit" class="btn btn-primary" style="font-size:13px;">✓ Setujui</button>
                                        </form>
                                        <form action="{{ route('regulasi.uji-publik.reject', $regulasi) }}" method="POST">
                                            @csrf<button type="submit" class="btn btn-danger" style="font-size:13px;">✕ Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <p style="color:#999;font-size:13px;">Menunggu persetujuan Super Admin.</p>
                                @endif

                            @elseif($regulasi->current_stage === 'uji_publik')
                                {{-- Info periode --}}
                                <div style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:#f0f4ff;border-radius:10px;border:1px solid #c9d8f5;margin-bottom:20px;flex-wrap:wrap;">
                                    <span style="font-size:22px;">🌐</span>
                                    <div>
                                        <p style="font-size:14px;color:#003580;margin:0;font-weight:600;">Regulasi sedang berada di tahap Partisipasi Publik.</p>
                                        @if($regulasi->partisipasiPublik)
                                            <p style="font-size:12.5px;color:#5066a3;margin:4px 0 0;">
                                                Periode:
                                                {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_mulai)->isoFormat('D MMM Y') }}
                                                — {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_selesai)->isoFormat('D MMM Y') }}
                                                <span style="color:#888;">(otomatis lanjut ke Harmonisasi setelah tanggal selesai)</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Komentar Publik --}}
                                {{-- $komentarPublik dikirim dari controller --}}
                                <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">
                                    Komentar Publik
                                    @if($komentarPublik->isNotEmpty())
                                        <span style="background:#eaf0ff;color:#003580;border-radius:20px;padding:2px 10px;font-size:12px;margin-left:6px;font-weight:700;">
                                            {{ $komentarPublik->count() }}
                                        </span>
                                    @endif
                                </p>

                                @if($komentarPublik->isEmpty())
                                    <div class="empty-state" style="padding:20px 16px;">
                                        <p>Belum ada komentar dari publik.</p>
                                    </div>
                                @else
                                    <div class="table-scroll">
                                    <table class="proc-table" style="margin-bottom:20px;">
                                        <thead>
                                            <tr>
                                                <th style="width:180px;">Nama</th>
                                                <th>Komentar</th>
                                                <th style="width:120px;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($komentarPublik as $k)
                                                <tr>
                                                    <td>{{ $k->nama_pengirim ?: ($k->user?->name ?? 'Anonim') }}</td>
                                                    <td>{{ $k->isi_tanggapan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d M Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                @endif

                                {{-- Aksi --}}
                                @if($bisaKelola)
                                    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;padding-top:16px;border-top:1px solid #f0f3fa;">
                                        <a href="{{ route('admin.partisipasi.show', $regulasi->id) }}" class="btn btn-primary" style="font-size:13px;">🗂 Kelola Partisipasi Publik</a>

                                        @unless($regulasi->pasca_partisipasi_dimulai)
                                            <form action="{{ route('regulasi.lanjut-pasca-partisipasi', $regulasi) }}" method="POST"
                                                onsubmit="return confirmAction(event, this, 'Lanjutkan ke tahap Pasca Partisipasi Publik?')">
                                                @csrf
                                                <button type="submit" class="btn" style="font-size:13px;border:1px solid #003580;color:#003580;">
                                                    ➤ Lanjut ke Pasca Partisipasi Publik
                                                </button>
                                            </form>
                                        @endunless
                                    </div>
                                @endif

                            @elseif($regulasi->isStageCompleted('uji_publik'))
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:14px 16px;background:#f0f4ff;border-radius:10px;border:1px solid #c9d8f5;flex-wrap:wrap;">
                                    <div>
                                        <p style="font-size:14px;color:#003580;margin:0;font-weight:600;">Tahap Partisipasi Publik telah selesai.</p>
                                        @if($regulasi->partisipasiPublik)
                                            <p style="font-size:12.5px;color:#5066a3;margin:4px 0 0;">
                                                Periode:
                                                {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_mulai)->isoFormat('D MMM Y') }}
                                                — {{ \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_selesai)->isoFormat('D MMM Y') }}
                                                @if($regulasi->partisipasiPublik->is_active && \Carbon\Carbon::parse($regulasi->partisipasiPublik->tgl_selesai)->endOfDay()->gte(now()))
                                                    <span style="display:inline-block;margin-left:6px;background:#dcfce7;color:#166534;padding:1px 8px;border-radius:999px;font-size:11px;font-weight:700;">Aktif di Publik</span>
                                                @else
                                                    <span style="display:inline-block;margin-left:6px;background:#e2e8f0;color:#475569;padding:1px 8px;border-radius:999px;font-size:11px;font-weight:700;">Ditutup</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                    @if($isSuperAdmin)
                                        <a href="{{ route('admin.partisipasi.show', $regulasi->id) }}" class="btn btn-primary" style="font-size:12.5px;padding:8px 14px;">🗂 Kelola Masukan</a>
                                    @endif
                                </div>

                                {{-- Tetap tampilkan komentar meski sudah selesai --}}
                                {{-- $komentarPublik dikirim dari controller --}}
                                @if($komentarPublik->isNotEmpty())
                                    <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin:20px 0 12px;">
                                        Komentar Publik
                                        <span style="background:#eaf0ff;color:#003580;border-radius:20px;padding:2px 10px;font-size:12px;margin-left:6px;">{{ $komentarPublik->count() }}</span>
                                    </p>
                                    <div class="table-scroll">
                                    <table class="proc-table">
                                        <thead>
                                            <tr>
                                                <th style="width:180px;">Nama</th>
                                                <th>Komentar</th>
                                                <th style="width:120px;">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($komentarPublik as $k)
                                                <tr>
                                                    <td>{{ $k->nama_pengirim ?: ($k->user?->name ?? 'Anonim') }}</td>
                                                    <td>{{ $k->isi_tanggapan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d M Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                @endif

                            @else
                                <div class="empty-state">
                                    <p>Tahap ini belum dimulai. Selesaikan Pembahasan dan ajukan request terlebih dahulu.</p>
                                </div>
                            @endif

                            {{-- Form Ubah Periode Partisipasi Publik (Khusus Super Admin) --}}
                            @if($isSuperAdmin && !($regulasi->current_stage === 'pembahasan' && $regulasi->uji_publik_status === 'requested'))
                                <div style="margin-top:18px;padding:18px 20px;background:#f8faff;border:1px solid #d8e4f8;border-radius:12px;">
                                    <p style="font-size:12.5px;font-weight:700;color:#003580;text-transform:uppercase;letter-spacing:.06em;margin:0 0 10px;">
                                        🗓️ Ubah Tanggal Periode Partisipasi Publik (Super Admin)
                                    </p>
                                    <form action="{{ route('regulasi.uji-publik.update-periode', $regulasi) }}" method="POST">
                                        @csrf
                                        <div class="add-proc-grid" style="grid-template-columns:1fr 1fr auto;gap:12px;">
                                            <div class="form-group" style="margin:0;">
                                                <label class="form-label">Tanggal Mulai *</label>
                                                <input type="date" name="tgl_mulai" class="form-control"
                                                    value="{{ old('tgl_mulai', $regulasi->partisipasiPublik?->tgl_mulai?->format('Y-m-d')) }}" required>
                                            </div>
                                            <div class="form-group" style="margin:0;">
                                                <label class="form-label">Tanggal Selesai *</label>
                                                <input type="date" name="tgl_selesai" class="form-control"
                                                    value="{{ old('tgl_selesai', $regulasi->partisipasiPublik?->tgl_selesai?->format('Y-m-d')) }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                style="padding:10px 18px;font-size:13px;white-space:nowrap;align-self:end;">
                                                💾 Simpan Periode
                                            </button>
                                        </div>
                                        <small style="display:block;color:#64748b;font-size:12px;margin-top:8px;">
                                            Super Admin dapat memajukan atau memundurkan tanggal periode secara bebas. Tanggal selesai di masa lalu otomatis menutup status di halaman publik, sedangkan tanggal di masa depan membuka kembali partisipasi publik.
                                        </small>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 4: PASCA PARTISIPASI PUBLIK           --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-pasca_partisipasi">
                            @php $prosePasca = $regulasi->proses->where('is_after_uji_publik', true); @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$pascaBisaDiisi && $prosePasca->isEmpty()) ? 'inactive' : '' }}">📝</div>
                                <div>
                                    <div class="pane-head-title">Pasca Partisipasi Publik</div>
                                    <div class="pane-head-sub">Pembahasan lanjutan setelah periode partisipasi publik selesai</div>
                                </div>
                                @if(!$pascaBisaDiisi)
                                    <span class="stage-status locked"  style="margin-left:auto;">🔒 Terkunci</span>
                                @elseif(in_array($regulasi->current_stage, ['harmonisasi', 'penetapan']))
                                    <span class="stage-status done"    style="margin-left:auto;">✓ Selesai</span>
                                @elseif($prosePasca->isNotEmpty())
                                    <span class="stage-status active"  style="margin-left:auto;">● Aktif</span>
                                @else
                                    <span class="stage-status pending" style="margin-left:auto;">— Belum Ada Catatan</span>
                                @endif
                            </div>

                            @if(!$pascaBisaDiisi)
                                <div class="empty-state">
                                    @if($regulasi->current_stage === 'uji_publik')
                                        <p>Tahap ini masih terkunci. Klik tombol "Lanjut ke Pasca Partisipasi Publik" di tab Partisipasi Publik untuk membukanya.</p>
                                    @else
                                        <p>Tahap ini baru bisa diisi setelah Partisipasi Publik dimulai.</p>
                                    @endif
                                </div>
                            @else
                                {{-- Tabel proses pasca --}}
                                @if($prosePasca->isEmpty())
                                    <div class="empty-state">
                                        <p>Belum ada proses pasca partisipasi publik tercatat.</p>
                                    </div>
                                @else
                                    <div class="table-scroll">
                                    <table class="proc-table">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Proses</th>
                                                <th>Tanggal</th>
                                                <th>Dokumen</th>
                                                {{-- Kolom aksi hanya muncul jika masih di uji_publik --}}
                                                @if($prosceBisaKelola)
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prosePasca as $p)
                                                <tr id="row-proses-pasca-{{ $p->id }}">
                                                    <td>{{ $p->judul }}</td>
                                                    <td>{{ $p->proses }}</td>
                                                    <td style="cursor:pointer;color:#003580;" onclick="toggleEditProses({{ $p->id }})" title="Klik untuk edit">{{ $p->tanggal->format('d M Y') }}</td>
                                                    <td>
                                                        @if(!empty($p->file_dokumen))
                                                            @foreach((array) $p->file_dokumen as $idx => $file)
                                                                <a href="{{ Storage::url($file) }}" target="_blank" class="file-link"
                                                                    style="margin-bottom:4px;display:inline-flex;">📄 Dok {{ $idx + 1 }}</a>
                                                            @endforeach
                                                        @else
                                                            <span style="color:#ccc;font-size:12px;">—</span>
                                                        @endif
                                                    </td>
                                                    @if($prosceBisaKelola)
                                                        <td style="white-space:nowrap;">
                                                            <button type="button" onclick="toggleEditProses({{ $p->id }})" class="btn"
                                                                style="font-size:12px;padding:5px 10px;border:1px solid #003580;color:#003580;">✏ Edit</button>
                                                            <form action="{{ route('regulasi.proses.destroy', [$regulasi, $p]) }}" method="POST"
                                                                style="display:inline;" onsubmit="return confirmAction(event, this, 'Hapus proses ini? Tindakan ini tidak bisa dibatalkan.', true)">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" style="font-size:12px;padding:5px 10px;">Hapus</button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                                @if($prosceBisaKelola)
                                                    <tr id="edit-proses-{{ $p->id }}" style="display:none;background:#f8faff;">
                                                        <td colspan="5" style="padding:16px;">
                                                            <form action="{{ route('regulasi.proses.update', [$regulasi, $p]) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf @method('PUT')
                                                                <div style="display:grid;grid-template-columns:2fr 2fr 1.2fr;gap:10px;margin-bottom:10px;">
                                                                    <div><label class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="{{ $p->judul }}" required></div>
                                                                    <div><label class="form-label">Proses</label><input type="text" name="proses" class="form-control" value="{{ $p->proses }}" required></div>
                                                                    <div><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ $p->tanggal->format('Y-m-d') }}" required></div>
                                                                </div>
                                                                <div style="margin-bottom:10px;">
                                                                    <label class="form-label">Ganti Dokumen <span style="color:#b0bbcc;font-weight:400;">(opsional · maks 10MB per file)</span></label>
                                                                    <input type="file" name="file_dokumen[]" multiple class="form-control"
                                                                        id="dok-edit-pasca-{{ $p->id }}"
                                                                        onchange="checkMultiFileSize(this, 'warn-edit-pasca-{{ $p->id }}')"
                                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png" style="padding:7px 12px;font-size:13px;">
                                                                    <small id="warn-edit-pasca-{{ $p->id }}" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                                                </div>
                                                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                                                    <button type="submit" class="btn btn-primary" style="font-size:13px;">💾 Simpan</button>
                                                                    <button type="button" onclick="toggleEditProses({{ $p->id }})" class="btn"
                                                                        style="font-size:13px;border:1px solid #ccc;color:#666;">Batal</button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                @endif

                                {{-- Form tambah: hanya saat uji_publik --}}
                                @if($prosceBisaKelola)
                                    <div style="margin-top:20px;padding-top:18px;border-top:1px solid #f0f3fa;">
                                        <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">
                                            Tambah Proses Pasca Partisipasi
                                        </p>
                                        @if($errors->hasAny(['judul', 'proses', 'tanggal', 'file_dokumen', 'file_dokumen.*']) && $regulasi->current_stage === 'uji_publik')
                                            <div class="alert alert-danger" style="font-size:13px;margin-bottom:12px;border-radius:8px;">
                                                <strong>Gagal menyimpan:</strong> {{ $errors->first() }}
                                            </div>
                                        @endif
                                        <form action="{{ route('regulasi.proses.store', $regulasi) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="force_pasca" value="1">
                                            <div class="add-proc-grid">
                                                <div class="form-group" style="margin:0;"><label class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required></div>
                                                <div class="form-group" style="margin:0;"><label class="form-label">Proses</label><input type="text" name="proses" class="form-control" value="{{ old('proses') }}" placeholder="Contoh: Rapat Internal" required></div>
                                                <div class="form-group" style="margin:0;"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required></div>
                                                <div class="form-group" style="margin:0;grid-column:1/-1;">
                                                    <label class="form-label">Dokumen Pendukung <span style="color:#b0bbcc;font-weight:400;">(opsional · bisa lebih dari 1 · PDF/Word/Excel/PPT/Gambar · maks 10MB per file)</span></label>
                                                    <input type="file" name="file_dokumen[]" multiple class="form-control"
                                                        id="dok-tambah-pasca"
                                                        onchange="checkMultiFileSize(this, 'warn-tambah-pasca')"
                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png" style="padding:7px 12px;font-size:13px;">
                                                    <small id="warn-tambah-pasca" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                                </div>
                                                <button type="submit" class="btn btn-primary"
                                                    style="padding:10px 16px;font-size:13px;white-space:nowrap;grid-column:1/-1;width:fit-content;">+ Tambah</button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Tombol lanjut ke Harmonisasi --}}
                                    @if($regulasi->current_stage === 'uji_publik')
                                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f0f3fa;">
                                        <form action="{{ route('regulasi.mulai-harmonisasi', $regulasi) }}" method="POST"
                                            onsubmit="return confirmAction(event, this, 'Lanjutkan ke tahap Harmonisasi? Pastikan semua proses pasca partisipasi sudah lengkap.')">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="font-size:13px;">
                                                ➤ Lanjut ke Harmonisasi
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                @elseif(in_array($regulasi->current_stage, ['harmonisasi', 'penetapan']))
                                    {{-- Pesan kunci untuk harmonisasi/penetapan --}}
                                    <div style="margin-top:16px;padding:12px 16px;background:#f4f6fb;border-radius:10px;border:1px solid #e0e7f4;">
                                        <p style="font-size:13px;color:#8a93a6;margin:0;">Proses pasca partisipasi sudah terkunci karena regulasi telah memasuki tahap Harmonisasi.</p>
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 5: HARMONISASI                        --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-harmonisasi">
                            @php
                                $active = $regulasi->isStageActive('harmonisasi');
                                $done = $regulasi->isStageCompleted('harmonisasi');
                            @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$active && !$done) ? 'inactive' : '' }}">🔗</div>
                                <div>
                                    <div class="pane-head-title">Harmonisasi</div>
                                    <div class="pane-head-sub">Sinkronisasi dengan regulasi lain yang berlaku</div>
                                </div>
                                @if($done)       <span class="stage-status done"   style="margin-left:auto;">✓ Selesai</span>
                                @elseif($active) <span class="stage-status active" style="margin-left:auto;">● Aktif</span>
                                @else            <span class="stage-status pending" style="margin-left:auto;">— Belum Dimulai</span>
                                @endif
                            </div>

                            @if(($isSuperAdmin || in_array($regulasi->current_stage, ['uji_publik', 'harmonisasi'])) && $bisaKelola)
                                <form action="{{ route('regulasi.harmonisasi.update', $regulasi) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Mulai Harmonisasi *</label>
                                        <input type="date" name="tgl_mulai_harmonisasi" class="form-control"
                                            value="{{ $regulasi->tgl_mulai_harmonisasi?->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Selesai Harmonisasi</label>
                                        <input type="date" name="tgl_selesai_harmonisasi" class="form-control"
                                            value="{{ $regulasi->tgl_selesai_harmonisasi?->format('Y-m-d') }}">
                                    </div>

                                    <div style="margin-top:20px;padding-top:16px;border-top:1px solid #f0f3fa;margin-bottom:16px;">
                                        <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:14px;">
                                            Dokumen Harmonisasi
                                        </p>
                                        @foreach([
                                                'harmon_surat_permohonan' => 'Surat Permohonan Harmonisasi',
                                                'harmon_naskah_urgensi' => 'Naskah Urgensi',
                                                'harmon_draft_rancangan' => 'Draft Rancangan',
                                            ] as $field => $label)
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                {{ $label }}
                                                                @if(!$regulasi->$field)
                                                                    <span style="color:#c0392b;font-weight:700;">*</span>
                                                                @endif
                                                            </label>
                                                            @if($regulasi->$field)
                                                                <div style="margin-bottom:8px;">
                                                                    <a href="{{ Storage::url($regulasi->$field) }}" target="_blank" class="file-link">📄 File saat ini</a>
                                                                </div>
                                                            @endif
                                                            <input type="file" name="{{ $field }}" class="form-control"
                                                                id="file-{{ $field }}"
                                                                onchange="checkSingleFileSize(this, 'warn-{{ $field }}')"
                                                                accept=".pdf,.doc,.docx"
                                                                style="padding:7px 12px;font-size:13px;"
                                                                {{ !$regulasi->$field ? 'required' : '' }}>
                                                            <small style="color:#888;font-size:12px;">PDF / Word · maks 10MB</small>
                                                            <small id="warn-{{ $field }}" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                                            @error($field)
                                                                <div class="field-error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="font-size:13px;">💾 Simpan</button>
                                </form>

                            @elseif($regulasi->current_stage === 'harmonisasi' || $regulasi->isStageCompleted('harmonisasi'))
                                <div class="info-row">
                                    <div class="info-key">Tanggal Mulai</div>
                                    <div class="info-val">{{ $regulasi->tgl_mulai_harmonisasi?->format('d F Y') ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-key">Tanggal Selesai</div>
                                    <div class="info-val">{{ $regulasi->tgl_selesai_harmonisasi?->format('d F Y') ?? '-' }}</div>
                                </div>
                                @foreach([
                                        'harmon_surat_permohonan' => 'Surat Permohonan',
                                        'harmon_naskah_urgensi' => 'Naskah Urgensi',
                                        'harmon_draft_rancangan' => 'Draft Rancangan',
                                    ] as $col => $lbl)
                                                <div class="info-row">
                                                    <div class="info-key">{{ $lbl }}</div>
                                                    <div class="info-val">
                                                        @if($regulasi->$col)
                                                            <a href="{{ Storage::url($regulasi->$col) }}" target="_blank" class="file-link">📄 Unduh</a>
                                                        @else
                                                            <span style="color:#ccc;">—</span>
                                                        @endif
                                                    </div>
                                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <p>Tahap ini belum dimulai.</p>
                                </div>
                            @endif
                        </div>

                        {{-- ═══════════════════════════════════════════ --}}
                        {{-- PANE 6: PENETAPAN                          --}}
                        {{-- ═══════════════════════════════════════════ --}}
                        <div class="tab-pane" id="pane-penetapan">
                            @php
                                $active = $regulasi->isStageActive('penetapan');
                                $done = $regulasi->isStageCompleted('penetapan');
                            @endphp
                            <div class="pane-head">
                                <div class="pane-icon {{ (!$active && !$done) ? 'inactive' : '' }}">✔</div>
                                <div>
                                    <div class="pane-head-title">Penetapan</div>
                                    <div class="pane-head-sub">Pengesahan dan penetapan regulasi</div>
                                </div>
                                @if($done)       <span class="stage-status done"   style="margin-left:auto;">✓ Selesai</span>
                                @elseif($active) <span class="stage-status active" style="margin-left:auto;">● Aktif</span>
                                @else            <span class="stage-status pending" style="margin-left:auto;">— Belum Dimulai</span>
                                @endif
                            </div>

                            @if(($isSuperAdmin || in_array($regulasi->current_stage, ['harmonisasi', 'penetapan'])) && $bisaKelola)
                                <form action="{{ route('regulasi.penetapan.update', $regulasi) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Mulai Penetapan *</label>
                                        <input type="date" name="tgl_mulai_penetapan" class="form-control"
                                            value="{{ $regulasi->tgl_mulai_penetapan?->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Selesai (Ditetapkan)</label>
                                        <input type="date" name="tgl_selesai_penetapan" class="form-control"
                                            value="{{ $regulasi->tgl_selesai_penetapan?->format('Y-m-d') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Catatan</label>
                                        <textarea name="catatan_penetapan" class="form-control" rows="3">{{ $regulasi->catatan_penetapan }}</textarea>
                                    </div>

                                    <div style="margin-top:20px;padding-top:16px;border-top:1px solid #f0f3fa;margin-bottom:16px;">
                                        <p style="font-size:12.5px;font-weight:700;color:#8a93a6;text-transform:uppercase;letter-spacing:.06em;margin-bottom:14px;">
                                            Dokumen Penetapan
                                        </p>
                                        @foreach([
                                                'tapan_surat_permohonan' => 'Surat Permohonan Penetapan',
                                                'tapan_surat_selesai_harmon' => 'Surat Selesai Harmonisasi',
                                                'tapan_ba_harmon' => 'Berita Acara Harmonisasi',
                                                'tapan_softcopy_harmon' => 'Soft Copy Hasil Harmonisasi',
                                                'tapan_draft_akhir' => 'Draft Akhir',
                                            ] as $field => $label)
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                {{ $label }}
                                                                @if(!$regulasi->$field)
                                                                    <span style="color:#c0392b;font-weight:700;">*</span>
                                                                @endif
                                                            </label>
                                                            @if($regulasi->$field)
                                                                <div style="margin-bottom:8px;">
                                                                    <a href="{{ Storage::url($regulasi->$field) }}" target="_blank" class="file-link">📄 File saat ini</a>
                                                                </div>
                                                            @endif
                                                            <input type="file" name="{{ $field }}" class="form-control"
                                                                id="file-{{ $field }}"
                                                                onchange="checkSingleFileSize(this, 'warn-{{ $field }}')"
                                                                accept=".pdf,.doc,.docx"
                                                                style="padding:7px 12px;font-size:13px;"
                                                                {{ !$regulasi->$field ? 'required' : '' }}>
                                                            <small style="color:#888;font-size:12px;">PDF / Word · maks 10MB</small>
                                                            <small id="warn-{{ $field }}" style="display:block;color:#c0392b;font-size:12px;margin-top:4px;"></small>
                                                            @error($field)
                                                                <div class="field-error">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="font-size:13px;">💾 Simpan</button>
                                </form>

                            @elseif($regulasi->current_stage === 'penetapan' || $regulasi->isStageCompleted('penetapan'))
                                <div class="info-row">
                                    <div class="info-key">Tanggal Mulai</div>
                                    <div class="info-val">{{ $regulasi->tgl_mulai_penetapan?->format('d F Y') ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-key">Tanggal Selesai</div>
                                    <div class="info-val">{{ $regulasi->tgl_selesai_penetapan?->format('d F Y') ?? '-' }}</div>
                                </div>
                                @if($regulasi->catatan_penetapan)
                                    <div class="info-row">
                                        <div class="info-key">Catatan</div>
                                        <div class="info-val">{{ $regulasi->catatan_penetapan }}</div>
                                    </div>
                                @endif
                                @foreach([
                                        'tapan_surat_permohonan' => 'Surat Permohonan',
                                        'tapan_surat_selesai_harmon' => 'Surat Selesai Harmon',
                                        'tapan_ba_harmon' => 'BA Harmonisasi',
                                        'tapan_softcopy_harmon' => 'Soft Copy Harmon',
                                        'tapan_draft_akhir' => 'Draft Akhir',
                                    ] as $col => $lbl)
                                                <div class="info-row">
                                                    <div class="info-key">{{ $lbl }}</div>
                                                    <div class="info-val">
                                                        @if($regulasi->$col)
                                                            <a href="{{ Storage::url($regulasi->$col) }}" target="_blank" class="file-link">📄 Unduh</a>
                                                        @else
                                                            <span style="color:#ccc;">—</span>
                                                        @endif
                                                    </div>
                                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <p>Tahap ini belum dimulai.</p>
                                </div>
                            @endif
                        </div>

                    </div>{{-- end .stage-panel --}}
                </div>

                <script>
                    const stages = ['pengajuan', 'pembahasan', 'uji_publik', 'pasca_partisipasi', 'harmonisasi', 'penetapan'];
                    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10 MB

                    function formatMb(bytes) {
                        return (bytes / (1024 * 1024)).toFixed(2);
                    }

                    // Peringatan langsung untuk input file tunggal (Harmonisasi)
                    function checkSingleFileSize(input, warnId) {
                        const warnEl = document.getElementById(warnId);
                        if (!warnEl) return;
                        const file = input.files[0];
                        if (!file) {
                            warnEl.textContent = '';
                            return;
                        }
                        if (file.size > MAX_FILE_SIZE) {
                            warnEl.textContent = `⚠ ${file.name} (${formatMb(file.size)} MB) melebihi batas maksimal 10 MB`;
                            input.value = ''; // reset supaya tidak ikut ter-submit
                        } else {
                            warnEl.textContent = '';
                        }
                    }

                    // Peringatan langsung untuk input file multiple (Pembahasan & Pasca Partisipasi)
                    function checkMultiFileSize(input, warnId) {
                        const warnEl = document.getElementById(warnId);
                        if (!warnEl) return;
                        const files = Array.from(input.files || []);
                        if (files.length === 0) {
                            warnEl.textContent = '';
                            return;
                        }
                        const oversized = files.filter(f => f.size > MAX_FILE_SIZE);
                        if (oversized.length > 0) {
                            const daftar = oversized.map(f => `${f.name} (${formatMb(f.size)} MB)`).join(', ');
                            warnEl.textContent = `⚠ File berikut melebihi batas maksimal 10 MB, silakan pilih ulang: ${daftar}`;
                            input.value = ''; // reset semua file yang dipilih
                        } else {
                            warnEl.textContent = '';
                        }
                    }

                    function selectTab(stage) {
                        stages.forEach(s => {
                            const pane = document.getElementById('pane-' + s);
                            const tl   = document.getElementById('tl-' + s);
                            if (pane) pane.classList.remove('active');
                            if (tl)   tl.classList.remove('selected');
                        });
                        const pane = document.getElementById('pane-' + stage);
                        const tl   = document.getElementById('tl-' + stage);
                        if (pane) pane.classList.add('active');
                        if (tl)   tl.classList.add('selected');
                    }

                    function toggleEditProses(id) {
                        const row = document.getElementById('edit-proses-' + id);
                        if (row) row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
                    }

                    function dismissToast(btn) {
                        const toast = btn.closest('.toast');
                        if (!toast) return;
                        toast.classList.add('hide');
                        setTimeout(() => toast.remove(), 220);
                    }

                    /* ── Custom confirm modal (pengganti confirm() bawaan browser) ── */
                    const confirmOverlay  = document.getElementById('confirm-overlay');
                    const confirmIconEl   = document.getElementById('confirm-icon');
                    const confirmTitleEl  = document.getElementById('confirm-title');
                    const confirmMsgEl    = document.getElementById('confirm-message');
                    const confirmOkBtn    = document.getElementById('confirm-ok-btn');
                    const confirmCancelBtn = document.getElementById('confirm-cancel-btn');

                    function closeConfirmModal() {
                        confirmOverlay.classList.remove('show');
                    }

                    function confirmAction(event, form, message, isDanger) {
                        // Jika form ini sudah dikonfirmasi (dipanggil ulang lewat requestSubmit), izinkan lolos.
                        if (form.dataset.confirmed === 'true') {
                            delete form.dataset.confirmed;
                            return true;
                        }

                        event.preventDefault();

                        confirmMsgEl.textContent = message;
                        confirmTitleEl.textContent = isDanger ? 'Konfirmasi Hapus' : 'Konfirmasi';
                        confirmIconEl.textContent = isDanger ? '🗑️' : '❓';
                        confirmIconEl.classList.toggle('danger', !!isDanger);
                        confirmOkBtn.classList.toggle('danger', !!isDanger);
                        confirmOkBtn.textContent = isDanger ? 'Ya, Hapus' : 'Ya, Lanjutkan';

                        confirmOverlay.classList.add('show');

                        const onOk = function () {
                            cleanup();
                            form.dataset.confirmed = 'true';
                            if (form.requestSubmit) form.requestSubmit();
                            else form.submit();
                        };
                        const onCancel = function () {
                            cleanup();
                            // Jaga-jaga: pastikan tombol submit form ini tetap aktif setelah dibatalkan.
                            const btn = form.querySelector('button[type="submit"]');
                            if (btn) {
                                btn.disabled      = false;
                                btn.style.opacity = '';
                                btn.style.cursor  = '';
                            }
                        };
                        const onOverlayClick = function (e) {
                            if (e.target === confirmOverlay) onCancel();
                        };
                        const onKeydown = function (e) {
                            if (e.key === 'Escape') onCancel();
                        };

                        function cleanup() {
                            closeConfirmModal();
                            confirmOkBtn.removeEventListener('click', onOk);
                            confirmCancelBtn.removeEventListener('click', onCancel);
                            confirmOverlay.removeEventListener('click', onOverlayClick);
                            document.removeEventListener('keydown', onKeydown);
                        }

                        confirmOkBtn.addEventListener('click', onOk);
                        confirmCancelBtn.addEventListener('click', onCancel);
                        confirmOverlay.addEventListener('click', onOverlayClick);
                        document.addEventListener('keydown', onKeydown);

                        return false;
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                        const hash         = window.location.hash.replace('#tahap-', '');
                        const defaultStage = hash && stages.includes(hash) ? hash : '{{ $defaultOpen }}';
                        selectTab(defaultStage);

                        document.querySelectorAll('form').forEach(function (form) {
                            form.addEventListener('submit', function (e) {
                                // Jika event ini baru "dicegat" oleh dialog konfirmasi (belum benar-benar
                                // dikirim), jangan disable tombolnya dulu. Kalau tetap didisable di sini,
                                // begitu user klik "Batal" pada dialog, tombol akan tetap ke-disable
                                // selamanya sampai halaman di-refresh, padahal form belum jadi terkirim.
                                if (e.defaultPrevented) return;

                                const btn = form.querySelector('button[type="submit"]');
                                if (btn) {
                                    btn.disabled      = true;
                                    btn.style.opacity = '0.6';
                                    btn.style.cursor  = 'not-allowed';
                                }
                            });
                        });

                        // Auto-isi Tanggal Selesai (+14 hari) saat Tanggal Mulai diubah, tetap bisa diedit manual
                        function addDaysIso(dateStr, days) {
                            const parts = (dateStr || '').split('-').map(Number);
                            if (parts.length !== 3 || parts.some(isNaN)) return '';
                            const dt = new Date(Date.UTC(parts[0], parts[1] - 1, parts[2] + days));
                            return dt.toISOString().slice(0, 10);
                        }

                        function bindAutoPeriod14(startSelector, endSelector) {
                            document.querySelectorAll(startSelector).forEach(function (startInput) {
                                const form = startInput.closest('form');
                                const endInput = form ? form.querySelector(endSelector) : null;
                                if (!endInput) return;

                                if (startInput.value) {
                                    endInput.min = startInput.value;
                                    if (!endInput.value) {
                                        endInput.value = addDaysIso(startInput.value, 14);
                                    }
                                }

                                const syncEnd = function () {
                                    if (!startInput.value) return;
                                    endInput.min = startInput.value;
                                    const nextEnd = addDaysIso(startInput.value, 14);
                                    if (nextEnd) {
                                        endInput.value = nextEnd;
                                    }
                                };

                                startInput.addEventListener('change', syncEnd);
                            });
                        }

                        bindAutoPeriod14('input[name="tgl_mulai_uji_publik"]', 'input[name="tgl_selesai_uji_publik"]');
                        bindAutoPeriod14('input[name="tgl_mulai"]', 'input[name="tgl_selesai"]');

                        // Auto-dismiss toast notifications after a few seconds
                        document.querySelectorAll('#toast-stack .toast').forEach(function (toast, idx) {
                            setTimeout(function () {
                                toast.classList.add('hide');
                                setTimeout(() => toast.remove(), 220);
                            }, 6000 + idx * 300);
                        });
                    });
                </script>

@endsection