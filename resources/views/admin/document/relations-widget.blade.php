@php
    $resId = isset($res) && $res ? $res->id : null;
    $initialRegulations = [];
    $initialCrossDocs = [];

    if (old('regulations_relations')) {
        $rawOldReg = old('regulations_relations');
        $initialRegulations = is_array($rawOldReg) ? $rawOldReg : (json_decode($rawOldReg, true) ?: []);
    } elseif ($resId) {
        $existingRelations = \App\Models\DocumentRelation::with(['relatedDocument.master_document', 'relatedDocument.rule_type'])
            ->where('source_document_id', $resId)
            ->get();

        foreach ($existingRelations as $rel) {
            if ($rel->is_external) {
                $itemData = [
                    'is_external' => true,
                    'related_document_id' => null,
                    'external_url' => $rel->external_url,
                    'relationship_type' => $rel->relationship_type,
                    'relation_label' => $rel->type_label,
                    'title' => $rel->external_title,
                    'no_peraturan' => $rel->external_number ?? '-',
                    'year' => $rel->external_year ?? '-',
                    'category_label' => $rel->external_category ?? 'Dokumen Luar',
                    'type_label' => $rel->external_category ?? 'Peraturan Luar',
                    'note' => $rel->note ?? '',
                    'colors' => $rel->type_colors,
                ];
            } else {
                $doc = $rel->relatedDocument;
                if (!$doc) continue;
                $itemData = [
                    'is_external' => false,
                    'related_document_id' => $doc->id,
                    'relationship_type' => $rel->relationship_type,
                    'relation_label' => $rel->type_label,
                    'title' => $doc->translated('title') ?: $doc->title,
                    'no_peraturan' => $doc->no_peraturan ?? $doc->nomor_perjanjian ?? $doc->no_putusan ?? '-',
                    'year' => $doc->date ? date('Y', strtotime($doc->date)) : '-',
                    'category_label' => optional($doc->master_document)->label ?? 'Dokumen',
                    'type_label' => optional($doc->rule_type)->label ?? (optional($doc->master_document)->label ?? 'Peraturan'),
                    'note' => $rel->note ?? '',
                    'colors' => $rel->type_colors,
                ];
            }

            if ($rel->category === 'dokumen_terkait') {
                $initialCrossDocs[] = $itemData;
            } else {
                $initialRegulations[] = $itemData;
            }
        }
    }

    if (old('cross_documents_relations')) {
        $rawOldDoc = old('cross_documents_relations');
        $initialCrossDocs = is_array($rawOldDoc) ? $rawOldDoc : (json_decode($rawOldDoc, true) ?: []);
    }
@endphp

<div class="jdih-relations-container" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin:20px 0; font-family: inherit;">
    <style>
        .jdih-rel-badge { display:inline-block; padding:3px 10px; border-radius:12px; font-size:12px; font-weight:600; border:1px solid transparent; white-space:nowrap; }
        .jdih-search-results { position:absolute; z-index:9999; background:#fff; border:1px solid #cbd5e1; border-radius:6px; max-height:240px; overflow-y:auto; width:100%; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); margin-top:2px; display:none; }
        .jdih-search-item { padding:8px 12px; border-bottom:1px solid #f1f5f9; cursor:pointer; font-size:13px; }
        .jdih-search-item:hover { background:#f0fdf4; color:#166534; }
        .jdih-rel-table { width:100%; border-collapse:collapse; margin-top:12px; background:#fff; border-radius:6px; overflow:hidden; border:1px solid #e2e8f0; }
        .jdih-rel-table th { background:#f1f5f9; padding:10px 12px; font-size:12px; font-weight:700; color:#475569; text-align:left; border-bottom:1px solid #e2e8f0; }
        .jdih-rel-table td { padding:10px 12px; font-size:13px; color:#1e293b; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
        .jdih-rel-btn-del { color:#dc2626; background:none; border:none; cursor:pointer; font-size:15px; padding:4px 8px; border-radius:4px; }
        .jdih-rel-btn-del:hover { background:#fee2e2; }
        .jdih-ext-badge { display:inline-block; padding:2px 7px; border-radius:10px; font-size:11px; font-weight:700; background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; margin-left:6px; vertical-align:middle; }
        .jdih-ext-link { color:#2563eb; font-size:12px; text-decoration:none; display:inline-block; margin-top:2px; word-break:break-all; }
        .jdih-ext-link:hover { text-decoration:underline; color:#1d4ed8; }
        .jdih-mode-btn { font-size:12px; font-weight:600; padding:6px 14px; border-radius:6px; cursor:pointer; border:1px solid #cbd5e1; background:#fff; color:#475569; transition:all 0.15s; }
        .jdih-mode-btn.active { background:#2563eb; color:#fff; border-color:#1d4ed8; }
        .jdih-mode-btn-green.active { background:#059669; color:#fff; border-color:#047857; }
    </style>

    <!-- Hidden inputs for form submit -->
    <input type="hidden" name="regulations_relations" id="regulations_relations_input" value="{{ json_encode($initialRegulations) }}">
    <input type="hidden" name="cross_documents_relations" id="cross_documents_relations_input" value="{{ json_encode($initialCrossDocs) }}">

    <!-- ==================== BAGIAN 1: PERATURAN TERKAIT ==================== -->
    <div style="margin-bottom:35px;">
        <div style="display:flex; align-items:center; margin-bottom:14px; border-bottom:2px solid #2563eb; padding-bottom:8px;">
            <i class="fa fa-link" style="color:#2563eb; font-size:18px; margin-right:10px;"></i>
            <h3 style="margin:0; font-size:17px; font-weight:700; color:#1e3a8a;">Peraturan Terkait</h3>
            <span style="margin-left:auto; font-size:12px; color:#64748b;">Hubungan antar-peraturan perundang-undangan</span>
        </div>

        <!-- Mode Selector -->
        <div style="display:flex; gap:8px; margin-bottom:12px;">
            <button type="button" class="jdih-mode-btn active" id="btn_mode_reg_internal">
                <i class="fa fa-database"></i> Dari Database Internal JDIH
            </button>
            <button type="button" class="jdih-mode-btn" id="btn_mode_reg_external">
                <i class="fa fa-globe"></i> Tarik dari Link Luar (Eksternal)
            </button>
        </div>

        <!-- Mode 1: Search Internal Regulation -->
        <div id="panel_reg_internal">
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-5" style="position:relative;">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Cari Peraturan Internal (Judul / Nomor / Tahun)</label>
                    <div style="position:relative;">
                        <input type="text" id="input_search_reg" class="form-control" placeholder="Ketik kata kunci judul, nomor, atau tahun..." autocomplete="off">
                        <span id="loading_reg" style="position:absolute; right:10px; top:8px; display:none;"><i class="fa fa-spinner fa-spin text-muted"></i></span>
                    </div>
                    <div id="results_reg" class="jdih-search-results"></div>
                    <input type="hidden" id="selected_reg_id">
                    <input type="hidden" id="selected_reg_title">
                    <input type="hidden" id="selected_reg_number">
                    <input type="hidden" id="selected_reg_year">
                    <input type="hidden" id="selected_reg_type">
                </div>

                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Jenis Hubungan</label>
                    <select id="select_reg_type" class="form-control">
                        <option value="mengubah">Mengubah</option>
                        <option value="diubah_oleh">Diubah Oleh</option>
                        <option value="mencabut">Mencabut</option>
                        <option value="dicabut_oleh">Dicabut Oleh</option>
                        <option value="melaksanakan">Melaksanakan</option>
                        <option value="dilaksanakan_oleh">Dilaksanakan Oleh</option>
                        <option value="menetapkan">Menetapkan</option>
                        <option value="ditetapkan_oleh">Ditetapkan Oleh</option>
                        <option value="dasar_hukum">Dasar Hukum</option>
                        <option value="menjadi_dasar_hukum">Menjadi Dasar Hukum</option>
                        <option value="terkait" selected>Terkait Lainnya</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Catatan (Opsional)</label>
                    <input type="text" id="input_reg_note" class="form-control" placeholder="Ket. pasal / hal...">
                </div>

                <div class="col-md-2" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_add_reg" class="btn btn-primary" style="width:100%; font-weight:600; background:#2563eb; border-color:#1d4ed8;">
                        <i class="fa fa-plus"></i> Tambahkan
                    </button>
                </div>
            </div>

            <div id="selected_reg_info" style="display:none; padding:10px 14px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:6px; margin-bottom:12px; font-size:13px; color:#1e40af; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <div style="flex:1; min-width:240px;">
                    <i class="fa fa-check-circle" style="color:#2563eb;"></i> <strong>Peraturan Terpilih:</strong> <span id="selected_reg_text" style="font-weight:600;"></span>
                </div>
                <div>
                    <button type="button" id="btn_quick_add_reg" class="btn btn-sm btn-primary" style="font-weight:600; background:#2563eb; border-color:#1d4ed8; padding:5px 14px;">
                        <i class="fa fa-plus-circle"></i> Tambahkan ke Tabel Relasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Mode 2: Fetch / Pull from External Link -->
        <div id="panel_reg_external" style="display:none; background:#eff6ff; border:1px solid #bfdbfe; border-radius:6px; padding:15px; margin-bottom:15px;">
            <div style="font-size:13px; font-weight:700; color:#1e40af; margin-bottom:8px;">
                <i class="fa fa-globe"></i> Tarik Peraturan dari Link Luar (Contoh: JDIH Bapanas, JDIHN, JDIH BPK, dll.)
            </div>
            
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-9">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Link / URL Peraturan Luar</label>
                    <input type="url" id="input_ext_url_reg" class="form-control" placeholder="Tempel URL lengkap, contoh: https://jdih.badanpangan.go.id/doc/2152dce1-6a21-403c-b198-04f420d524ef">
                </div>
                <div class="col-md-3" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_fetch_ext_reg" class="btn btn-info" style="width:100%; font-weight:600; background:#0284c7; border-color:#0369a1; color:#fff;">
                        <i class="fa fa-bolt"></i> Tarik Data Link
                    </button>
                </div>
            </div>

            <div id="status_ext_reg" style="display:none; font-size:12px; padding:6px 10px; border-radius:4px; margin-bottom:10px;"></div>

            <!-- Form after fetch / manual input -->
            <div class="row" style="margin-bottom:8px;">
                <div class="col-md-6">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Judul Peraturan</label>
                    <input type="text" id="input_ext_title_reg" class="form-control" placeholder="Judul peraturan luar (otomatis terisi atau ketik manual)...">
                </div>
                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Nomor</label>
                    <input type="text" id="input_ext_no_reg" class="form-control" placeholder="Nomor...">
                </div>
                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Tahun</label>
                    <input type="text" id="input_ext_year_reg" class="form-control" placeholder="Tahun...">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Jenis Hubungan</label>
                    <select id="select_ext_reg_type" class="form-control">
                        <option value="mengubah">Mengubah</option>
                        <option value="diubah_oleh">Diubah Oleh</option>
                        <option value="mencabut">Mencabut</option>
                        <option value="dicabut_oleh">Dicabut Oleh</option>
                        <option value="melaksanakan">Melaksanakan</option>
                        <option value="dilaksanakan_oleh">Dilaksanakan Oleh</option>
                        <option value="menetapkan">Menetapkan</option>
                        <option value="ditetapkan_oleh">Ditetapkan Oleh</option>
                        <option value="dasar_hukum">Dasar Hukum</option>
                        <option value="menjadi_dasar_hukum">Menjadi Dasar Hukum</option>
                        <option value="terkait" selected>Terkait Lainnya</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label style="font-size:12px; font-weight:600; color:#1e3a8a; margin-bottom:4px; display:block;">Catatan (Opsional)</label>
                    <input type="text" id="input_ext_note_reg" class="form-control" placeholder="Ket. pasal / hal...">
                </div>
                <div class="col-md-3" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_add_ext_reg" class="btn btn-primary" style="width:100%; font-weight:600; background:#1d4ed8; border-color:#1e40af;">
                        <i class="fa fa-plus"></i> Tambahkan Link Luar
                    </button>
                </div>
            </div>
        </div>

        <table class="jdih-rel-table">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Judul Peraturan</th>
                    <th style="width:110px;">Nomor</th>
                    <th style="width:80px;">Tahun</th>
                    <th style="width:160px;">Jenis Hubungan</th>
                    <th>Catatan</th>
                    <th style="width:60px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody_reg">
                <!-- Data populated dynamically -->
            </tbody>
        </table>
        <div id="empty_reg_msg" style="text-align:center; padding:15px; color:#94a3b8; font-size:13px; border:1px dashed #cbd5e1; border-radius:0 0 6px 6px; border-top:none;">
            Belum ada peraturan terkait yang ditambahkan.
        </div>
    </div>

    <!-- ==================== BAGIAN 2: DOKUMEN TERKAIT (LINTAS KATEGORI) ==================== -->
    <div>
        <div style="display:flex; align-items:center; margin-bottom:14px; border-bottom:2px solid #059669; padding-bottom:8px;">
            <i class="fa fa-folder-open" style="color:#059669; font-size:18px; margin-right:10px;"></i>
            <h3 style="margin:0; font-size:17px; font-weight:700; color:#065f46;">Dokumen Terkait (Lintas Kategori)</h3>
            <span style="margin-left:auto; font-size:12px; color:#64748b;">Hubungan dengan Monografi, Naskah Kerja Sama, Putusan, PUU, atau Link Luar</span>
        </div>

        <!-- Mode Selector -->
        <div style="display:flex; gap:8px; margin-bottom:12px;">
            <button type="button" class="jdih-mode-btn jdih-mode-btn-green active" id="btn_mode_doc_internal">
                <i class="fa fa-database"></i> Dari Database Internal JDIH
            </button>
            <button type="button" class="jdih-mode-btn jdih-mode-btn-green" id="btn_mode_doc_external">
                <i class="fa fa-globe"></i> Tarik dari Link Luar (Eksternal)
            </button>
        </div>

        <!-- Mode 1: Search Internal Cross-Docs -->
        <div id="panel_doc_internal">
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-5" style="position:relative;">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Cari Dokumen Internal (Judul / Nomor)</label>
                    <div style="position:relative;">
                        <input type="text" id="input_search_doc" class="form-control" placeholder="Ketik kata kunci monografi, naskah kerja sama, putusan, rancangan..." autocomplete="off">
                        <span id="loading_doc" style="position:absolute; right:10px; top:8px; display:none;"><i class="fa fa-spinner fa-spin text-muted"></i></span>
                    </div>
                    <div id="results_doc" class="jdih-search-results"></div>
                    <input type="hidden" id="selected_doc_id">
                    <input type="hidden" id="selected_doc_title">
                    <input type="hidden" id="selected_doc_number">
                    <input type="hidden" id="selected_doc_year">
                    <input type="hidden" id="selected_doc_category">
                </div>

                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Jenis Hubungan</label>
                    <select id="select_doc_type" class="form-control">
                        <option value="dasar_hukum">Menjadi Dasar Hukum</option>
                        <option value="melaksanakan">Melaksanakan</option>
                        <option value="terkait" selected>Terkait</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label style="font-size:12px; font-weight:600; color:#334155; margin-bottom:4px; display:block;">Catatan (Opsional)</label>
                    <input type="text" id="input_doc_note" class="form-control" placeholder="Keterangan relasi...">
                </div>

                <div class="col-md-2" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_add_doc" class="btn btn-success" style="width:100%; font-weight:600; background:#059669; border-color:#047857;">
                        <i class="fa fa-plus"></i> Tambahkan
                    </button>
                </div>
            </div>

            <div id="selected_doc_info" style="display:none; padding:10px 14px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:6px; margin-bottom:12px; font-size:13px; color:#065f46; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <div style="flex:1; min-width:240px;">
                    <i class="fa fa-check-circle" style="color:#059669;"></i> <strong>Dokumen Terpilih:</strong> <span id="selected_doc_text" style="font-weight:600;"></span>
                </div>
                <div>
                    <button type="button" id="btn_quick_add_doc" class="btn btn-sm btn-success" style="font-weight:600; background:#059669; border-color:#047857; padding:5px 14px;">
                        <i class="fa fa-plus-circle"></i> Tambahkan ke Tabel Relasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Mode 2: Fetch / Pull External Document Link -->
        <div id="panel_doc_external" style="display:none; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:6px; padding:15px; margin-bottom:15px;">
            <div style="font-size:13px; font-weight:700; color:#065f46; margin-bottom:8px;">
                <i class="fa fa-globe"></i> Tarik Dokumen dari Link Luar (Rancangan PUU, Naskah Urgensi, Risalah, Dokumen PDF eksternal)
            </div>

            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-9">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Link / URL Dokumen Luar</label>
                    <input type="url" id="input_ext_url_doc" class="form-control" placeholder="Tempel URL lengkap dokumen/PDF...">
                </div>
                <div class="col-md-3" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_fetch_ext_doc" class="btn btn-success" style="width:100%; font-weight:600; background:#059669; border-color:#047857; color:#fff;">
                        <i class="fa fa-bolt"></i> Tarik Data Link
                    </button>
                </div>
            </div>

            <div id="status_ext_doc" style="display:none; font-size:12px; padding:6px 10px; border-radius:4px; margin-bottom:10px;"></div>

            <!-- Form after fetch / manual input -->
            <div class="row" style="margin-bottom:8px;">
                <div class="col-md-6">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Judul Dokumen</label>
                    <input type="text" id="input_ext_title_doc" class="form-control" placeholder="Judul dokumen luar...">
                </div>
                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Kategori Dokumen</label>
                    <input type="text" id="input_ext_cat_doc" class="form-control" placeholder="Contoh: Rancangan PUU / Naskah Urgensi / Monografi">
                </div>
                <div class="col-md-3">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Nomor (Opsional)</label>
                    <input type="text" id="input_ext_no_doc" class="form-control" placeholder="Nomor...">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Jenis Hubungan</label>
                    <select id="select_ext_doc_type" class="form-control">
                        <option value="dasar_hukum">Menjadi Dasar Hukum</option>
                        <option value="melaksanakan">Melaksanakan</option>
                        <option value="terkait" selected>Terkait</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label style="font-size:12px; font-weight:600; color:#065f46; margin-bottom:4px; display:block;">Catatan (Opsional)</label>
                    <input type="text" id="input_ext_note_doc" class="form-control" placeholder="Keterangan relasi...">
                </div>
                <div class="col-md-3" style="display:flex; align-items:flex-end;">
                    <button type="button" id="btn_add_ext_doc" class="btn btn-success" style="width:100%; font-weight:600; background:#047857; border-color:#065f46;">
                        <i class="fa fa-plus"></i> Tambahkan Link Luar
                    </button>
                </div>
            </div>
        </div>

        <table class="jdih-rel-table">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Judul Dokumen</th>
                    <th style="width:160px;">Kategori Dokumen</th>
                    <th style="width:110px;">Nomor</th>
                    <th style="width:80px;">Tahun</th>
                    <th style="width:160px;">Jenis Hubungan</th>
                    <th style="width:60px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody_doc">
                <!-- Data populated dynamically -->
            </tbody>
        </table>
        <div id="empty_doc_msg" style="text-align:center; padding:15px; color:#94a3b8; font-size:13px; border:1px dashed #cbd5e1; border-radius:0 0 6px 6px; border-top:none;">
            Belum ada dokumen terkait lintas kategori yang ditambahkan.
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentDocId = {{ $resId ? $resId : 'null' }};
    const searchApiUrl = "{{ route('api.admin.documents.search-related') }}";
    const fetchMetaApiUrl = "{{ route('api.admin.documents.fetch-external-meta') }}";

    const typeLabels = {
        'mengubah': 'Mengubah',
        'diubah_oleh': 'Diubah Oleh',
        'mencabut': 'Mencabut',
        'dicabut_oleh': 'Dicabut Oleh',
        'melaksanakan': 'Melaksanakan',
        'dilaksanakan_oleh': 'Dilaksanakan Oleh',
        'menetapkan': 'Menetapkan',
        'ditetapkan_oleh': 'Ditetapkan Oleh',
        'dasar_hukum': 'Dasar Hukum',
        'menjadi_dasar_hukum': 'Menjadi Dasar Hukum',
        'terkait': 'Terkait Lainnya'
    };

    const typeColors = {
        'mengubah': { bg: '#eff6ff', text: '#1d4ed8', border: '#bfdbfe' },
        'diubah_oleh': { bg: '#ecfeff', text: '#0e7490', border: '#a5f3fc' },
        'mencabut': { bg: '#fef2f2', text: '#b91c1c', border: '#fecaca' },
        'dicabut_oleh': { bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        'melaksanakan': { bg: '#f0fdf4', text: '#15803d', border: '#bbf7d0' },
        'dilaksanakan_oleh': { bg: '#f0fdfa', text: '#0f766e', border: '#99f6e4' },
        'menetapkan': { bg: '#faf5ff', text: '#7e22ce', border: '#e9d5ff' },
        'ditetapkan_oleh': { bg: '#eef2ff', text: '#4338ca', border: '#c7d2fe' },
        'dasar_hukum': { bg: '#fffbeb', text: '#b45309', border: '#fde68a' },
        'menjadi_dasar_hukum': { bg: '#fefce8', text: '#a16207', border: '#fef08a' },
        'terkait': { bg: '#f8fafc', text: '#475569', border: '#e2e8f0' }
    };

    let regulationsList = [];
    let crossDocsList = [];

    try {
        const rawReg = document.getElementById('regulations_relations_input').value;
        if (rawReg) regulationsList = JSON.parse(rawReg);
    } catch(e) { regulationsList = []; }

    try {
        const rawDoc = document.getElementById('cross_documents_relations_input').value;
        if (rawDoc) crossDocsList = JSON.parse(rawDoc);
    } catch(e) { crossDocsList = []; }

    function updateInputs() {
        document.getElementById('regulations_relations_input').value = JSON.stringify(regulationsList);
        document.getElementById('cross_documents_relations_input').value = JSON.stringify(crossDocsList);
    }

    // ----------------------------------------------------
    // TAB MODE SWITCHERS
    // ----------------------------------------------------
    const btnModeRegInt = document.getElementById('btn_mode_reg_internal');
    const btnModeRegExt = document.getElementById('btn_mode_reg_external');
    const panelRegInt = document.getElementById('panel_reg_internal');
    const panelRegExt = document.getElementById('panel_reg_external');

    btnModeRegInt.addEventListener('click', function() {
        btnModeRegInt.classList.add('active');
        btnModeRegExt.classList.remove('active');
        panelRegInt.style.display = 'block';
        panelRegExt.style.display = 'none';
    });

    btnModeRegExt.addEventListener('click', function() {
        btnModeRegExt.classList.add('active');
        btnModeRegInt.classList.remove('active');
        panelRegExt.style.display = 'block';
        panelRegInt.style.display = 'none';
    });

    const btnModeDocInt = document.getElementById('btn_mode_doc_internal');
    const btnModeDocExt = document.getElementById('btn_mode_doc_external');
    const panelDocInt = document.getElementById('panel_doc_internal');
    const panelDocExt = document.getElementById('panel_doc_external');

    btnModeDocInt.addEventListener('click', function() {
        btnModeDocInt.classList.add('active');
        btnModeDocExt.classList.remove('active');
        panelDocInt.style.display = 'block';
        panelDocExt.style.display = 'none';
    });

    btnModeDocExt.addEventListener('click', function() {
        btnModeDocExt.classList.add('active');
        btnModeDocInt.classList.remove('active');
        panelDocExt.style.display = 'block';
        panelDocInt.style.display = 'none';
    });

    // ----------------------------------------------------
    // TABLE RENDERING
    // ----------------------------------------------------
    function renderRegulationsTable() {
        const tbody = document.getElementById('tbody_reg');
        const emptyMsg = document.getElementById('empty_reg_msg');
        tbody.innerHTML = '';

        if (regulationsList.length === 0) {
            emptyMsg.style.display = 'block';
            return;
        }
        emptyMsg.style.display = 'none';

        regulationsList.forEach((item, idx) => {
            const col = typeColors[item.relationship_type] || typeColors['terkait'];
            const label = typeLabels[item.relationship_type] || item.relationship_type;
            const isExt = !!item.is_external;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${idx + 1}</strong></td>
                <td>
                    <div style="font-weight:600; color:#1e293b;">
                        ${item.title}
                        ${isExt ? '<span class="jdih-ext-badge"><i class="fa fa-globe"></i> Eksternal</span>' : ''}
                    </div>
                    ${isExt && item.external_url ? `<a href="${item.external_url}" target="_blank" class="jdih-ext-link"><i class="fa fa-external-link"></i> ${item.external_url}</a>` : `<small style="color:#64748b;">${item.type_label || 'Peraturan'}</small>`}
                </td>
                <td>${item.no_peraturan || '-'}</td>
                <td>${item.year || '-'}</td>
                <td>
                    <span class="jdih-rel-badge" style="background:${col.bg}; color:${col.text}; border-color:${col.border};">
                        ${label}
                    </span>
                </td>
                <td><small style="color:#475569;">${item.note || '-'}</small></td>
                <td style="text-align:center;">
                    <button type="button" class="jdih-rel-btn-del" data-idx="${idx}" title="Hapus hubungan">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        tbody.querySelectorAll('.jdih-rel-btn-del').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-idx'));
                regulationsList.splice(idx, 1);
                updateInputs();
                renderRegulationsTable();
            });
        });
    }

    function renderCrossDocsTable() {
        const tbody = document.getElementById('tbody_doc');
        const emptyMsg = document.getElementById('empty_doc_msg');
        tbody.innerHTML = '';

        if (crossDocsList.length === 0) {
            emptyMsg.style.display = 'block';
            return;
        }
        emptyMsg.style.display = 'none';

        crossDocsList.forEach((item, idx) => {
            const col = typeColors[item.relationship_type] || typeColors['terkait'];
            const label = typeLabels[item.relationship_type] || item.relationship_type;
            const isExt = !!item.is_external;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${idx + 1}</strong></td>
                <td>
                    <div style="font-weight:600; color:#1e293b;">
                        ${item.title}
                        ${isExt ? '<span class="jdih-ext-badge"><i class="fa fa-globe"></i> Eksternal</span>' : ''}
                    </div>
                    ${isExt && item.external_url ? `<a href="${item.external_url}" target="_blank" class="jdih-ext-link"><i class="fa fa-external-link"></i> ${item.external_url}</a>` : `<small style="color:#64748b;">${item.note || ''}</small>`}
                </td>
                <td><span style="display:inline-block; padding:2px 8px; border-radius:4px; background:#f1f5f9; font-size:12px; font-weight:600;">${item.category_label || 'Dokumen'}</span></td>
                <td>${item.no_peraturan || '-'}</td>
                <td>${item.year || '-'}</td>
                <td>
                    <span class="jdih-rel-badge" style="background:${col.bg}; color:${col.text}; border-color:${col.border};">
                        ${label}
                    </span>
                </td>
                <td style="text-align:center;">
                    <button type="button" class="jdih-rel-btn-del" data-idx="${idx}" title="Hapus hubungan">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        tbody.querySelectorAll('.jdih-rel-btn-del').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-idx'));
                crossDocsList.splice(idx, 1);
                updateInputs();
                renderCrossDocsTable();
            });
        });
    }

    // ----------------------------------------------------
    // INTERNAL AUTOCOMPLETE
    // ----------------------------------------------------
    function setupAutocomplete(inputId, resultsId, loadingId, category, onSelect) {
        const input = document.getElementById(inputId);
        const results = document.getElementById(resultsId);
        const loading = document.getElementById(loadingId);
        let debounceTimer;

        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            if (q.length < 2) {
                results.style.display = 'none';
                return;
            }

            loading.style.display = 'inline-block';
            debounceTimer = setTimeout(() => {
                fetch(`${searchApiUrl}?q=${encodeURIComponent(q)}&category=${category}&exclude_id=${currentDocId || ''}`)
                    .then(r => r.json())
                    .then(data => {
                        loading.style.display = 'none';
                        results.innerHTML = '';
                        if (!data || data.length === 0) {
                            results.innerHTML = '<div style="padding:10px; color:#94a3b8; font-size:12px; text-align:center;">Tidak ada dokumen ditemukan.</div>';
                            results.style.display = 'block';
                            return;
                        }

                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'jdih-search-item';
                            div.innerHTML = `
                                <div style="font-weight:600; color:#1e293b;">${item.title}</div>
                                <small style="color:#64748b;">${item.type_label} | No: ${item.no_peraturan} | Tahun: ${item.year}</small>
                            `;
                            div.addEventListener('click', () => {
                                onSelect(item);
                                results.style.display = 'none';
                                input.value = '';
                            });
                            results.appendChild(div);
                        });
                        results.style.display = 'block';
                    })
                    .catch(() => {
                        loading.style.display = 'none';
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.style.display = 'none';
            }
        });
    }

    // Internal Peraturan Autocomplete
    setupAutocomplete('input_search_reg', 'results_reg', 'loading_reg', 'peraturan', function(item) {
        document.getElementById('selected_reg_id').value = item.id;
        document.getElementById('selected_reg_title').value = item.title;
        document.getElementById('selected_reg_number').value = item.no_peraturan;
        document.getElementById('selected_reg_year').value = item.year;
        document.getElementById('selected_reg_type').value = item.type_label;

        document.getElementById('selected_reg_text').innerText = `${item.title} (No: ${item.no_peraturan}, ${item.year})`;
        document.getElementById('selected_reg_info').style.display = 'flex';
    });

    const btnQuickAddReg = document.getElementById('btn_quick_add_reg');
    if (btnQuickAddReg) {
        btnQuickAddReg.addEventListener('click', function() {
            document.getElementById('btn_add_reg').click();
        });
    }

    document.getElementById('btn_add_reg').addEventListener('click', function() {
        const id = parseInt(document.getElementById('selected_reg_id').value);
        if (!id) {
            alert('Silakan cari dan pilih dokumen peraturan terlebih dahulu.');
            return;
        }

        const type = document.getElementById('select_reg_type').value;
        const note = document.getElementById('input_reg_note').value.trim();

        const exists = regulationsList.some(r => r.related_document_id === id && r.relationship_type === type);
        if (exists) {
            alert('Peraturan ini dengan jenis hubungan tersebut sudah ditambahkan.');
            return;
        }

        regulationsList.push({
            is_external: false,
            related_document_id: id,
            relationship_type: type,
            title: document.getElementById('selected_reg_title').value,
            no_peraturan: document.getElementById('selected_reg_number').value,
            year: document.getElementById('selected_reg_year').value,
            type_label: document.getElementById('selected_reg_type').value,
            note: note
        });

        document.getElementById('selected_reg_id').value = '';
        document.getElementById('selected_reg_info').style.display = 'none';
        document.getElementById('input_reg_note').value = '';

        updateInputs();
        renderRegulationsTable();
    });

    // Internal Cross-Docs Autocomplete
    setupAutocomplete('input_search_doc', 'results_doc', 'loading_doc', 'dokumen', function(item) {
        document.getElementById('selected_doc_id').value = item.id;
        document.getElementById('selected_doc_title').value = item.title;
        document.getElementById('selected_doc_number').value = item.no_peraturan;
        document.getElementById('selected_doc_year').value = item.year;
        document.getElementById('selected_doc_category').value = item.category_label;

        document.getElementById('selected_doc_text').innerText = `[${item.category_label}] ${item.title} (${item.year})`;
        document.getElementById('selected_doc_info').style.display = 'flex';
    });

    const btnQuickAddDoc = document.getElementById('btn_quick_add_doc');
    if (btnQuickAddDoc) {
        btnQuickAddDoc.addEventListener('click', function() {
            document.getElementById('btn_add_doc').click();
        });
    }

    document.getElementById('btn_add_doc').addEventListener('click', function() {
        const id = parseInt(document.getElementById('selected_doc_id').value);
        if (!id) {
            alert('Silakan cari dan pilih dokumen lintas kategori terlebih dahulu.');
            return;
        }

        const type = document.getElementById('select_doc_type').value;
        const note = document.getElementById('input_doc_note').value.trim();

        const exists = crossDocsList.some(r => r.related_document_id === id && r.relationship_type === type);
        if (exists) {
            alert('Dokumen ini dengan jenis hubungan tersebut sudah ditambahkan.');
            return;
        }

        crossDocsList.push({
            is_external: false,
            related_document_id: id,
            relationship_type: type,
            title: document.getElementById('selected_doc_title').value,
            category_label: document.getElementById('selected_doc_category').value,
            no_peraturan: document.getElementById('selected_doc_number').value,
            year: document.getElementById('selected_doc_year').value,
            note: note
        });

        document.getElementById('selected_doc_id').value = '';
        document.getElementById('selected_doc_info').style.display = 'none';
        document.getElementById('input_doc_note').value = '';

        updateInputs();
        renderCrossDocsTable();
    });

    // ----------------------------------------------------
    // EXTERNAL LINK FETCHER: PERATURAN
    // ----------------------------------------------------
    const btnFetchExtReg = document.getElementById('btn_fetch_ext_reg');
    const inputExtUrlReg = document.getElementById('input_ext_url_reg');
    const statusExtReg = document.getElementById('status_ext_reg');

    btnFetchExtReg.addEventListener('click', function() {
        const url = inputExtUrlReg.value.trim();
        if (!url) {
            alert('Silakan masukkan link URL terlebih dahulu.');
            return;
        }

        btnFetchExtReg.disabled = true;
        btnFetchExtReg.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menarik...';
        statusExtReg.style.display = 'block';
        statusExtReg.style.background = '#e0f2fe';
        statusExtReg.style.color = '#0369a1';
        statusExtReg.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sedang menghubungi server & menarik metadata dokumen...';

        fetch(`${fetchMetaApiUrl}?url=${encodeURIComponent(url)}`)
            .then(r => r.json())
            .then(res => {
                btnFetchExtReg.disabled = false;
                btnFetchExtReg.innerHTML = '<i class="fa fa-bolt"></i> Tarik Data Link';

                if (res.status === 'success') {
                    statusExtReg.style.background = '#dcfce7';
                    statusExtReg.style.color = '#15803d';
                    statusExtReg.innerHTML = '<i class="fa fa-check-circle"></i> Berhasil menarik data dari link!';

                    if (res.data.title) document.getElementById('input_ext_title_reg').value = res.data.title;
                    if (res.data.number) document.getElementById('input_ext_no_reg').value = res.data.number;
                    if (res.data.year) document.getElementById('input_ext_year_reg').value = res.data.year;
                } else {
                    statusExtReg.style.background = '#fef3c7';
                    statusExtReg.style.color = '#b45309';
                    statusExtReg.innerHTML = `<i class="fa fa-info-circle"></i> ${res.message || 'Lengkapi judul secara manual.'}`;
                }
            })
            .catch(err => {
                btnFetchExtReg.disabled = false;
                btnFetchExtReg.innerHTML = '<i class="fa fa-bolt"></i> Tarik Data Link';
                statusExtReg.style.background = '#fee2e2';
                statusExtReg.style.color = '#b91c1c';
                statusExtReg.innerHTML = '<i class="fa fa-exclamation-triangle"></i> Gagal terhubung ke link luar. Anda tetap dapat memasukkan judul secara manual.';
            });
    });

    document.getElementById('btn_add_ext_reg').addEventListener('click', function() {
        const url = inputExtUrlReg.value.trim();
        const title = document.getElementById('input_ext_title_reg').value.trim();
        const no = document.getElementById('input_ext_no_reg').value.trim();
        const year = document.getElementById('input_ext_year_reg').value.trim();
        const type = document.getElementById('select_ext_reg_type').value;
        const note = document.getElementById('input_ext_note_reg').value.trim();

        if (!url) {
            alert('URL peraturan luar tidak boleh kosong.');
            return;
        }
        if (!title) {
            alert('Judul peraturan luar tidak boleh kosong.');
            return;
        }

        // Check duplicate
        const exists = regulationsList.some(r => r.is_external && r.external_url === url && r.relationship_type === type);
        if (exists) {
            alert('Peraturan luar dari link ini dengan jenis hubungan tersebut sudah ditambahkan.');
            return;
        }

        regulationsList.push({
            is_external: true,
            related_document_id: null,
            external_url: url,
            title: title,
            no_peraturan: no || '-',
            year: year || '-',
            type_label: 'Peraturan Luar',
            relationship_type: type,
            note: note
        });

        // Reset external inputs
        inputExtUrlReg.value = '';
        document.getElementById('input_ext_title_reg').value = '';
        document.getElementById('input_ext_no_reg').value = '';
        document.getElementById('input_ext_year_reg').value = '';
        document.getElementById('input_ext_note_reg').value = '';
        statusExtReg.style.display = 'none';

        updateInputs();
        renderRegulationsTable();
    });

    // ----------------------------------------------------
    // EXTERNAL LINK FETCHER: DOKUMEN TERKAIT
    // ----------------------------------------------------
    const btnFetchExtDoc = document.getElementById('btn_fetch_ext_doc');
    const inputExtUrlDoc = document.getElementById('input_ext_url_doc');
    const statusExtDoc = document.getElementById('status_ext_doc');

    btnFetchExtDoc.addEventListener('click', function() {
        const url = inputExtUrlDoc.value.trim();
        if (!url) {
            alert('Silakan masukkan link URL terlebih dahulu.');
            return;
        }

        btnFetchExtDoc.disabled = true;
        btnFetchExtDoc.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menarik...';
        statusExtDoc.style.display = 'block';
        statusExtDoc.style.background = '#e0f2fe';
        statusExtDoc.style.color = '#0369a1';
        statusExtDoc.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sedang menghubungi server & menarik metadata dokumen...';

        fetch(`${fetchMetaApiUrl}?url=${encodeURIComponent(url)}`)
            .then(r => r.json())
            .then(res => {
                btnFetchExtDoc.disabled = false;
                btnFetchExtDoc.innerHTML = '<i class="fa fa-bolt"></i> Tarik Data Link';

                if (res.status === 'success') {
                    statusExtDoc.style.background = '#dcfce7';
                    statusExtDoc.style.color = '#15803d';
                    statusExtDoc.innerHTML = '<i class="fa fa-check-circle"></i> Berhasil menarik data dari link!';

                    if (res.data.title) document.getElementById('input_ext_title_doc').value = res.data.title;
                    if (res.data.number) document.getElementById('input_ext_no_doc').value = res.data.number;
                    if (res.data.type) document.getElementById('input_ext_cat_doc').value = res.data.type;
                } else {
                    statusExtDoc.style.background = '#fef3c7';
                    statusExtDoc.style.color = '#b45309';
                    statusExtDoc.innerHTML = `<i class="fa fa-info-circle"></i> ${res.message || 'Lengkapi judul secara manual.'}`;
                }
            })
            .catch(err => {
                btnFetchExtDoc.disabled = false;
                btnFetchExtDoc.innerHTML = '<i class="fa fa-bolt"></i> Tarik Data Link';
                statusExtDoc.style.background = '#fee2e2';
                statusExtDoc.style.color = '#b91c1c';
                statusExtDoc.innerHTML = '<i class="fa fa-exclamation-triangle"></i> Gagal terhubung ke link luar. Anda tetap dapat memasukkan judul secara manual.';
            });
    });

    document.getElementById('btn_add_ext_doc').addEventListener('click', function() {
        const url = inputExtUrlDoc.value.trim();
        const title = document.getElementById('input_ext_title_doc').value.trim();
        const cat = document.getElementById('input_ext_cat_doc').value.trim();
        const no = document.getElementById('input_ext_no_doc').value.trim();
        const type = document.getElementById('select_ext_doc_type').value;
        const note = document.getElementById('input_ext_note_doc').value.trim();

        if (!url) {
            alert('URL dokumen luar tidak boleh kosong.');
            return;
        }
        if (!title) {
            alert('Judul dokumen luar tidak boleh kosong.');
            return;
        }

        const exists = crossDocsList.some(r => r.is_external && r.external_url === url && r.relationship_type === type);
        if (exists) {
            alert('Dokumen luar dari link ini dengan jenis hubungan tersebut sudah ditambahkan.');
            return;
        }

        crossDocsList.push({
            is_external: true,
            related_document_id: null,
            external_url: url,
            title: title,
            category_label: cat || 'Dokumen Luar',
            no_peraturan: no || '-',
            year: '-',
            relationship_type: type,
            note: note
        });

        inputExtUrlDoc.value = '';
        document.getElementById('input_ext_title_doc').value = '';
        document.getElementById('input_ext_cat_doc').value = '';
        document.getElementById('input_ext_no_doc').value = '';
        document.getElementById('input_ext_note_doc').value = '';
        statusExtDoc.style.display = 'none';

        updateInputs();
        renderCrossDocsTable();
    });

    // Initial render
    renderRegulationsTable();
    renderCrossDocsTable();
});
</script>
