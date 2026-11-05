# DOKUMENTASI IMPLEMENTASI PERATURAN TERJEMAHAN BAHASA INGGRIS
**Sistem JDIH & e-Regulasi Terintegrasi Kementerian Koordinator Bidang Pangan**

---

## 1. Latar Belakang & Tujuan
Untuk memenuhi keterbukaan informasi hukum tingkat internasional dan memudahkan mitra multinasional serta masyarakat global, fitur **Peraturan Terjemahan Bahasa Inggris** telah diintegrasikan langsung ke dalam modul **Peraturan Hukum** tanpa membuat modul terpisah.

---

## 2. Struktur Input & Field CMS (Admin Panel)

Pada halaman form Create dan Edit Peraturan Hukum (`/admin-panel/document-peraturan`), ditambahkan bagian collapsible opsional:
`Peraturan Terjemahan Bahasa Inggris (Optional)`.

### Field yang Tersedia:
| Field Name | Tipe Data | Deskripsi | Sifat |
|---|---|---|---|
| `has_translation` | Boolean (`0`/`1`) | Penanda ketersediaan versi terjemahan Inggris | Opsional (Otomatis aktif jika field terjemahan terisi) |
| `translation_title` | Text | Judul resmi peraturan dalam Bahasa Inggris | Opsional |
| `translation_no_peraturan`| String (255) | Nomor atau referensi versi Inggris (bila berbeda) | Opsional |
| `translation_intro` | LongText | Abstrak / deskripsi ringkas substansi peraturan dalam Bahasa Inggris | Opsional |
| `translation_pdf` | File (PDF) | Berkas dokumen PDF terjemahan resmi Bahasa Inggris | Opsional (Maks. 20MB) |
| `translation_attachment` | File | Berkas lampiran terjemahan (PDF, DOCX, XLSX, ZIP) | Opsional |

---

## 3. Relasi Database & Integritas Data

- **Master Document Reference:** Seluruh metadata primer (nomor peraturan, jenis peraturan, tema, instansi pemrakarsa, tahun, tanggal pengundangan, status keberlakuan) merujuk pada record dokumen asli di tabel `documents`.
- **Multi-language Synchronization:** Saat berkas dan teks bahasa Inggris disimpan, sistem secara otomatis mensinkronisasikan ke tabel `documents_lang` dengan `lang = 'en'`.
- **Zero Duplicate Entry:** Tidak ada duplikasi baris ID dokumen asli; versi Inggris tersimpan rapi sebagai atribut relasional langsung dari dokumen induk.

---

## 4. Tampilan Public Website (End-User Experience)

Pada halaman detail Peraturan Hukum (`/peraturan-menteri-...`):
1. **Dynamic Language Switcher:**
   - Jika dokumen memiliki terjemahan (`has_translation = 1` atau file PDF terjemahan tersedia), muncul toggle interaktif:
     - `Bahasa Indonesia` (Default aktif)
     - `English Version`
   - Jika dokumen **tidak** memiliki naskah terjemahan, toggle switcher **disembunyikan sepenuhnya** sehingga tidak ada tombol kosong/dead link.
2. **Saat Mode English Aktif:**
   - Judul berubah ke `translation_title`.
   - Ringkasan banner berubah ke `translation_intro`.
   - Tabel metadata menampilkan bahasa: *"English (Terjemahan Resmi)"*.
   - PDF viewer memuat `translation_pdf` via streaming (`route('document.stream', ['type' => 'translation_pdf', 'id' => $id])`).
   - Tombol unduh otomatis mengunduh berkas terjemahan Bahasa Inggris.

---

## 5. File & Komponen Terkait
- Migration: `database/migrations/2026_11_05_000001_add_translation_fields_to_documents_table.php`
- Admin Widget: `resources/views/admin/document/translation-widget.blade.php`
- Controller: `app/Http/Controllers/Admin/Document/DocumentPeraturanController.php`
- Helper Upload & Sync: `app/Helpers/Document.php`
- Public View: `resources/views/dynamic/pages/document-peraturan-detail.blade.php`
- Stream Controller: `app/Http/Controllers/Front/DownloadFileController.php`
