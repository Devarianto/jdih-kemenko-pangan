@php
    $resDoc = isset($res) && $res ? $res : null;
    $hasTrans = $resDoc && ($resDoc->has_translation || !empty($resDoc->translation_title) || !empty($resDoc->translation_pdf));
    $transTitle = old('translation_title', $resDoc ? $resDoc->translation_title : '');
    $transNo = old('translation_no_peraturan', $resDoc ? $resDoc->translation_no_peraturan : '');
    $transIntro = old('translation_intro', $resDoc ? $resDoc->translation_intro : '');
    $transPdf = $resDoc ? $resDoc->translation_pdf : null;
    $transAttachment = $resDoc ? $resDoc->translation_attachment : null;
@endphp

<div class="card card-outline card-info shadow-sm mt-4 mb-4" id="section-translation-en" style="border: 1px solid #17a2b8; border-radius: 6px;">
    <div class="card-header bg-light d-flex justify-content-between align-items-center" style="cursor: pointer; padding: 12px 18px;" data-toggle="collapse" data-target="#collapseTranslationBox" aria-expanded="{{ $hasTrans ? 'true' : 'false' }}">
        <div class="d-flex align-items-center">
            <span class="badge badge-info p-2 mr-3" style="font-size: 13px; background-color: #0c8599;">
                <i class="fa fa-language fa-lg"></i> EN
            </span>
            <div>
                <h5 class="mb-0 text-dark font-weight-bold" style="font-size: 15px;">
                    Peraturan Terjemahan Bahasa Inggris (Optional)
                </h5>
                <small class="text-muted">
                    Sediakan versi terjemahan resmi dalam Bahasa Inggris tanpa menduplikasi data peraturan asli.
                </small>
            </div>
        </div>
        <div>
            @if($hasTrans)
                <span class="badge badge-success px-2 py-1 mr-2" style="font-size: 12px;">
                    <i class="fa fa-check-circle"></i> Terjemahan Aktif
                </span>
            @else
                <span class="badge badge-secondary px-2 py-1 mr-2" style="font-size: 12px;">
                    Opsional
                </span>
            @endif
            <button type="button" class="btn btn-sm btn-outline-info" style="border-radius: 20px;">
                <i class="fa fa-chevron-down" id="iconTranslationToggle"></i> Buka / Tutup Form
            </button>
        </div>
    </div>

    <div id="collapseTranslationBox" class="collapse {{ $hasTrans ? 'show' : '' }}" style="background-color: #fafbfc; border-top: 1px solid #dee2e6;">
        <div class="card-body p-4">
            <div class="alert alert-info py-2 px-3 mb-4" style="font-size: 13px; border-left: 4px solid #117a8b;">
                <i class="fa fa-info-circle mr-1"></i>
                Bagian ini bersifat <strong>opsional</strong>. Jika peraturan belum memiliki naskah terjemahan Bahasa Inggris, Anda dapat melewati bagian ini. Data peraturan asli tetap tersimpan dengan utuh.
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
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
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
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
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
                        Status Ketersediaan Terjemahan
                    </label>
                    <div class="custom-control custom-switch mt-2">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="has_translation_switch" 
                            name="has_translation" 
                            value="1" 
                            {{ $hasTrans ? 'checked' : '' }}
                        >
                        <label class="custom-control-label font-weight-normal" for="has_translation_switch" style="font-size: 13px; cursor: pointer;">
                            Tampilkan opsi Bahasa Inggris pada halaman detail website publik
                        </label>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
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
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
                        File Dokumen PDF Terjemahan (English PDF)
                    </label>
                    <div class="custom-file">
                        <input 
                            type="file" 
                            name="translation_pdf" 
                            id="translation_pdf" 
                            class="custom-file-input" 
                            accept=".pdf"
                            onchange="updateFileName(this, 'label_translation_pdf')"
                        >
                        <label class="custom-file-label" id="label_translation_pdf" for="translation_pdf" style="font-size: 13px;">
                            Pilih file PDF Terjemahan...
                        </label>
                    </div>
                    <small class="form-text text-muted">Unggah dokumen terjemahan resmi dalam format PDF (Maks. 20 MB).</small>

                    @if($transPdf)
                        <div class="alert alert-secondary mt-2 p-2 d-flex align-items-center justify-content-between" style="font-size: 12px;">
                            <div>
                                <i class="fa fa-file-pdf-o text-danger mr-1 fa-lg"></i>
                                <a href="{{ asset($transPdf) }}" target="_blank" class="text-primary font-weight-bold">
                                    {{ basename($transPdf) }}
                                </a>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="delete_translation_pdf" value="1" id="del_trans_pdf">
                                <label class="form-check-label text-danger font-weight-bold" for="del_trans_pdf" style="cursor: pointer;">
                                    <i class="fa fa-trash"></i> Hapus File
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold text-dark" style="font-size: 13px;">
                        File Lampiran Terjemahan (Optional Attachment)
                    </label>
                    <div class="custom-file">
                        <input 
                            type="file" 
                            name="translation_attachment" 
                            id="translation_attachment" 
                            class="custom-file-input" 
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                            onchange="updateFileName(this, 'label_translation_attachment')"
                        >
                        <label class="custom-file-label" id="label_translation_attachment" for="translation_attachment" style="font-size: 13px;">
                            Pilih file lampiran terjemahan...
                        </label>
                    </div>
                    <small class="form-text text-muted">Format: PDF, DOC, XLS, ZIP jika terdapat lampiran berbahasa Inggris.</small>

                    @if($transAttachment)
                        <div class="alert alert-secondary mt-2 p-2 d-flex align-items-center justify-content-between" style="font-size: 12px;">
                            <div>
                                <i class="fa fa-paperclip text-info mr-1 fa-lg"></i>
                                <a href="{{ asset($transAttachment) }}" target="_blank" class="text-primary font-weight-bold">
                                    {{ basename($transAttachment) }}
                                </a>
                            </div>
                            <div class="form-check form-check-inline mb-0">
                                <input class="form-check-input" type="checkbox" name="delete_translation_attachment" value="1" id="del_trans_att">
                                <label class="form-check-label text-danger font-weight-bold" for="del_trans_att" style="cursor: pointer;">
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
    function updateFileName(input, labelId) {
        var fileName = input.files[0] ? input.files[0].name : 'Pilih file...';
        var label = document.getElementById(labelId);
        if (label) {
            label.innerText = fileName;
        }
        var switchEl = document.getElementById('has_translation_switch');
        if (switchEl && input.files[0]) {
            switchEl.checked = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var titleInput = document.getElementById('translation_title');
        var switchEl = document.getElementById('has_translation_switch');
        if (titleInput && switchEl) {
            titleInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    switchEl.checked = true;
                }
            });
        }
    });
</script>

