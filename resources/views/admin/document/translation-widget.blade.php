@php
    $resDoc = isset($res) && $res ? $res : null;
    $hasTrans = session()->hasOldInput()
        ? (bool) old('has_translation')
        : ($resDoc ? (bool) $resDoc->has_translation : false);
    $transTitle = old('translation_title', $resDoc ? $resDoc->translation_title : '');
    $transNo = old('translation_no_peraturan', $resDoc ? $resDoc->translation_no_peraturan : '');
    $transIntro = old('translation_intro', $resDoc ? $resDoc->translation_intro : '');
    $transPdf = $resDoc ? $resDoc->translation_pdf : null;
    $transAttachment = $resDoc ? $resDoc->translation_attachment : null;
    $hasAnyTransContent = $hasTrans || !empty($transTitle) || !empty($transNo) || !empty($transIntro) || !empty($transPdf) || !empty($transAttachment);
@endphp

<div class="card card-outline card-info shadow-sm mt-4 mb-4" id="section-translation-en" style="border: 1px solid #17a2b8; border-radius: 6px;">
    <div
        class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap"
        id="headerTranslationToggle"
        role="button"
        tabindex="0"
        aria-expanded="{{ $hasAnyTransContent ? 'true' : 'false' }}"
        aria-controls="collapseTranslationBox"
        style="cursor: pointer; padding: 12px 18px; gap: 10px;"
    >
        <div class="d-flex align-items-center" style="gap: 12px;">
            <span class="badge p-2 text-white" style="font-size: 13px; background-color: #0c8599; border-radius: 4px;">
                <i class="fa fa-language fa-lg"></i> EN
            </span>
            <div>
                <h5 class="mb-0 text-dark fw-bold" style="font-size: 15px;">
                    Peraturan Terjemahan Bahasa Inggris (Optional)
                </h5>
                <small class="text-muted">
                    Sediakan versi terjemahan resmi dalam Bahasa Inggris tanpa menduplikasi data peraturan asli.
                </small>
            </div>
        </div>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <span
                id="badgeTranslationStatus"
                class="badge px-2 py-1 text-white {{ $hasTrans ? 'bg-success' : 'bg-secondary' }}"
                style="font-size: 12px;"
            >
                @if($hasTrans)
                    <i class="fa fa-check-circle"></i> Terjemahan Aktif
                @else
                    Opsional (Nonaktif)
                @endif
            </span>
            <button
                type="button"
                id="btnTranslationToggle"
                class="btn btn-sm btn-outline-info"
                style="border-radius: 20px;"
                aria-expanded="{{ $hasAnyTransContent ? 'true' : 'false' }}"
                aria-controls="collapseTranslationBox"
            >
                <i class="fa {{ $hasAnyTransContent ? 'fa-chevron-up' : 'fa-chevron-down' }}" id="iconTranslationToggle"></i> Buka / Tutup Form
            </button>
        </div>
    </div>

    <div
        id="collapseTranslationBox"
        style="display: {{ $hasAnyTransContent ? 'block' : 'none' }}; background-color: #fafbfc; border-top: 1px solid #dee2e6;"
    >
        <div class="card-body p-4">
            <div class="alert alert-info py-2 px-3 mb-4" style="font-size: 13px; border-left: 4px solid #117a8b; display: block;">
                <i class="fa fa-info-circle me-1"></i>
                Bagian ini bersifat <strong>opsional</strong>. Jika peraturan belum memiliki naskah terjemahan Bahasa Inggris, Anda dapat melewati bagian ini. Data peraturan asli tetap tersimpan dengan utuh.
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="fw-bold text-dark mb-1" for="translation_title" style="font-size: 13px;">
                        Judul Peraturan Bahasa Inggris (English Title)
                    </label>
                    <textarea
                        name="translation_title"
                        id="translation_title"
                        class="form-control"
                        rows="2"
                        placeholder="Contoh: Regulation of the Coordinating Minister for Food Affairs Number 1 of 2025 concerning..."
                        style="resize: vertical; font-size: 13px;"
                    >{{ $transTitle }}</textarea>
                    <small class="form-text text-muted">Judul resmi peraturan hukum dalam Bahasa Inggris.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold text-dark mb-1" for="translation_no_peraturan" style="font-size: 13px;">
                        Nomor Peraturan (English Version / Reference Number)
                    </label>
                    <input
                        type="text"
                        name="translation_no_peraturan"
                        id="translation_no_peraturan"
                        class="form-control"
                        value="{{ $transNo }}"
                        placeholder="Contoh: No. 1 Year 2025 (Opsional jika sama)"
                        style="font-size: 13px;"
                    >
                    <small class="form-text text-muted">Kosongkan jika menggunakan format nomor peraturan asli.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold text-dark mb-1" for="has_translation_switch" style="font-size: 13px;">
                        Status Ketersediaan Terjemahan
                    </label>
                    <input type="hidden" name="has_translation" value="0">
                    <div class="form-check form-switch mt-2">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            role="switch"
                            id="has_translation_switch"
                            name="has_translation"
                            value="1"
                            style="cursor: pointer;"
                            {{ $hasTrans ? 'checked' : '' }}
                        >
                        <label class="form-check-label fw-normal" for="has_translation_switch" style="font-size: 13px; cursor: pointer;">
                            Tampilkan opsi Bahasa Inggris pada halaman detail website publik
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-bold text-dark mb-1" for="translation_intro" style="font-size: 13px;">
                        Deskripsi Singkat / Abstrak Bahasa Inggris (Abstract / Description in English)
                    </label>
                    <textarea
                        name="translation_intro"
                        id="translation_intro"
                        class="form-control"
                        rows="3"
                        placeholder="Provide an English summary or abstract of this regulation..."
                        style="resize: vertical; font-size: 13px;"
                    >{{ $transIntro }}</textarea>
                    <small class="form-text text-muted">Ringkasan substansi peraturan dalam Bahasa Inggris.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold text-dark mb-1" for="translation_pdf" style="font-size: 13px;">
                        File Dokumen PDF Terjemahan (English PDF)
                    </label>
                    <input
                        type="file"
                        name="translation_pdf"
                        id="translation_pdf"
                        class="form-control"
                        accept=".pdf"
                        onchange="updateFileName(this, 'label_translation_pdf')"
                        style="font-size: 13px;"
                    >
                    <small class="form-text text-muted" id="label_translation_pdf">Unggah dokumen terjemahan resmi dalam format PDF (Maks. 20 MB).</small>

                    @if($transPdf)
                        <div class="alert alert-secondary mt-2 p-2 d-flex align-items-center justify-content-between" style="font-size: 12px;">
                            <div>
                                <i class="fa fa-file-pdf-o text-danger me-1 fa-lg"></i>
                                <a href="{{ asset($transPdf) }}" target="_blank" class="text-primary fw-bold">
                                    {{ basename($transPdf) }}
                                </a>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="delete_translation_pdf" value="1" id="del_trans_pdf">
                                <label class="form-check-label text-danger fw-bold" for="del_trans_pdf" style="cursor: pointer;">
                                    <i class="fa fa-trash"></i> Hapus File
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold text-dark mb-1" for="translation_attachment" style="font-size: 13px;">
                        File Lampiran Terjemahan (Optional Attachment)
                    </label>
                    <input
                        type="file"
                        name="translation_attachment"
                        id="translation_attachment"
                        class="form-control"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                        onchange="updateFileName(this, 'label_translation_attachment')"
                        style="font-size: 13px;"
                    >
                    <small class="form-text text-muted" id="label_translation_attachment">Format: PDF, DOC, XLS, ZIP jika terdapat lampiran berbahasa Inggris.</small>

                    @if($transAttachment)
                        <div class="alert alert-secondary mt-2 p-2 d-flex align-items-center justify-content-between" style="font-size: 12px;">
                            <div>
                                <i class="fa fa-paperclip text-info me-1 fa-lg"></i>
                                <a href="{{ asset($transAttachment) }}" target="_blank" class="text-primary fw-bold">
                                    {{ basename($transAttachment) }}
                                </a>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="delete_translation_attachment" value="1" id="del_trans_att">
                                <label class="form-check-label text-danger fw-bold" for="del_trans_att" style="cursor: pointer;">
                                    <i class="fa fa-trash"></i> Hapus Lampiran
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var manualSwitchToggled = false;

        function syncStatusBadge(checked) {
            var badge = document.getElementById('badgeTranslationStatus');
            if (!badge) return;
            if (checked) {
                badge.classList.remove('bg-secondary');
                badge.classList.add('bg-success');
                badge.innerHTML = '<i class="fa fa-check-circle"></i> Terjemahan Aktif';
            } else {
                badge.classList.remove('bg-success');
                badge.classList.add('bg-secondary');
                badge.textContent = 'Opsional (Nonaktif)';
            }
        }

        window.updateFileName = function(input, labelId) {
            var label = document.getElementById(labelId);
            if (label && input.files && input.files[0]) {
                label.textContent = 'File dipilih: ' + input.files[0].name;
            }
            var switchEl = document.getElementById('has_translation_switch');
            if (switchEl && input.files && input.files[0] && !manualSwitchToggled) {
                switchEl.checked = true;
                syncStatusBadge(true);
            }
        };

        function toggleTranslationBox(forceState) {
            var box = document.getElementById('collapseTranslationBox');
            var icon = document.getElementById('iconTranslationToggle');
            var header = document.getElementById('headerTranslationToggle');
            var btn = document.getElementById('btnTranslationToggle');
            if (!box) return;

            var isCurrentlyOpen = window.getComputedStyle(box).display !== 'none';
            var shouldOpen = typeof forceState === 'boolean' ? forceState : !isCurrentlyOpen;

            box.style.display = shouldOpen ? 'block' : 'none';
            if (icon) {
                icon.classList.toggle('fa-chevron-up', shouldOpen);
                icon.classList.toggle('fa-chevron-down', !shouldOpen);
            }
            if (header) header.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            if (btn) btn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
        }

        function initTranslationWidget() {
            var header = document.getElementById('headerTranslationToggle');
            var btn = document.getElementById('btnTranslationToggle');
            var titleInput = document.getElementById('translation_title');
            var switchEl = document.getElementById('has_translation_switch');

            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleTranslationBox();
                });
            }

            if (header) {
                header.addEventListener('click', function(e) {
                    if (e.target && e.target.closest('#btnTranslationToggle')) return;
                    toggleTranslationBox();
                });
                header.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleTranslationBox();
                    }
                });
            }

            if (switchEl) {
                switchEl.addEventListener('change', function() {
                    manualSwitchToggled = true;
                    syncStatusBadge(this.checked);
                });
                syncStatusBadge(switchEl.checked);
            }

            if (titleInput && switchEl) {
                var initialTitleEmpty = titleInput.value.trim().length === 0;
                titleInput.addEventListener('input', function() {
                    if (initialTitleEmpty && !manualSwitchToggled && this.value.trim().length > 0) {
                        switchEl.checked = true;
                        syncStatusBadge(true);
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTranslationWidget);
        } else {
            initTranslationWidget();
        }
    })();
</script>

