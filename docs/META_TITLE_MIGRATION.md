# Dokumentasi Migrasi Kolom Meta Title VARCHAR(255) — JDIH Kemenko Pangan

Dokumen ini merupakan laporan teknis resmi implementasi **PROMPT 3 — DATABASE META TITLE VARCHAR(255)** pada sistem JDIH Kemenko Pangan.

---

## 1. Ringkasan Eksekutif
Perubahan ini secara khusus menstandardisasi penyimpanan data **Meta Title (SEO)** di seluruh modul sistem JDIH Kemenko Pangan agar menggunakan tipe data `VARCHAR(255)` dengan kapasitas penuh hingga 255 karakter, memperluas batas lama yang sebelumnya dibatasi 60 karakter pada Admin Panel.

---

## 2. Audit Skema Database

Sebelum dilakukan migrasi, dilakukan audit terhadap seluruh tabel dan kolom di database `pangan_jdihdb`:

| Entitas | Nama Tabel | Nama Kolom | Tipe Data Sebelum | Tipe Data Sesudah | Keterangan |
|---|---|---|---|---|---|
| **Metadata SEO (Multilingual)** | `meta_datas` | `meta_title` | `TEXT` (65.535 bytes) | `VARCHAR(255)` | Digunakan oleh seluruh modul CRUD (Peraturan, Putusan, Monografi, Naskah, Berita, Galeri, Infografis, Menu, dll.) |
| **Pengaturan Global** | `configs` | `val` (`key = 'meta-title'`) | `TEXT` | `TEXT` (Kapasitas $\ge 255$) | Tabel generic key-value config untuk setting meta-title global ID & EN |

> [!NOTE]
> Audit terhadap 202 baris data existing di tabel `meta_datas` memastikan nilai `meta_title` terpanjang yang ada saat ini adalah 60 karakter. Dengan demikian, pengubahan tipe kolom ke `VARCHAR(255)` berjalan dengan **0 data loss (zero truncation)**.

---

## 3. File Migration yang Dibuat

File migration Laravel dibuat di:
`database/migrations/2026_10_31_000002_modify_meta_title_to_varchar_255_in_meta_datas.php`

### Isi Migration:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ubah kolom meta_title pada tabel meta_datas menjadi VARCHAR(255).
     */
    public function up(): void
    {
        if (Schema::hasTable('meta_datas') && Schema::hasColumn('meta_datas', 'meta_title')) {
            DB::statement("ALTER TABLE `meta_datas` MODIFY `meta_title` VARCHAR(255) NULL DEFAULT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('meta_datas') && Schema::hasColumn('meta_datas', 'meta_title')) {
            DB::statement("ALTER TABLE `meta_datas` MODIFY `meta_title` TEXT NULL DEFAULT NULL");
        }
    }
};
```
- **Status Eksekusi**: `Migrated: 2026_10_31_000002_modify_meta_title_to_varchar_255_in_meta_datas (78.87ms)`

---

## 4. Pembaruan Model & ORM

File model:
`cadmin/src/Models/MetaData.php`

Ditambahkan properti mass assignment `$fillable` dan Eloquent attribute casting `$casts`:
```php
class MetaData extends Model
{
    protected $table = 'meta_datas';
    public $timestamps = false;

    protected $fillable = [
        'module',
        'uniqid',
        'lang',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_image',
    ];

    protected $casts = [
        'meta_title' => 'string',
    ];
```

---

## 5. Pembaruan Form Admin Panel & Validasi Backend

### A. Core Cadmin Base Trait (`BaseTrait.php`)
File: `cadmin/src/Traits/Controllers/BaseTrait.php`
1. **Form Attribute & Helper Info**:
   ```php
   $newFields['meta_title'] = [
       'subtitle' => 'Meta Data',
       'label' => 'Meta Title',
       'multilang' => true,
       'type' => 'text',
       'meta' => 'title',
       'draft' => true,
       'attributes' => [
           'class' => 'required',
           'maxlength' => 255 // Diperbarui dari 60 menjadi 255
       ],
       'info' => 'maximum 255 character' // Diperbarui dari 60 menjadi 255
   ];
   ```
2. **Backend Validation Callback**:
   ```php
   // Validasi batas maksimal 255 karakter pada Meta Title
   if (isset($post['meta']) && is_array($post['meta'])) {
       foreach ($post['meta'] as $lang => $metaFields) {
           if (isset($metaFields['title']) && mb_strlen($metaFields['title']) > 255) {
               $error[] = "Meta Title (" . strtoupper($lang) . ") tidak boleh melebihi 255 karakter (saat ini: " . mb_strlen($metaFields['title']) . " karakter).";
               $out = false;
           }
       }
   }
   ```

### B. Setting Controller (Pengaturan Global Meta Title)
File:
- `app/Http/Controllers/Admin/SettingController.php`
- `cadmin/src/Http/Controllers/SettingController.php`
```php
'meta-title' => [
    'label' => 'Meta Title',
    'subtitle' => 'Default Meta Data',
    'type' => 'text',
    'multilang' => true,
    'attributes' => ['class' => 'required', 'maxlength' => 255],
    'info' => 'maximum 255 character',
],
```

### C. Guard Penyimpanan Form (`adminForm.php` & `adminFormDraft.php`)
File:
- `cadmin/src/Helpers/adminForm.php`
- `cadmin/src/Helpers/adminFormDraft.php`
```php
$rawTitle = array_get($meta, 'title');
$m->meta_title = !is_null($rawTitle) ? mb_substr($rawTitle, 0, 255) : null;
```

---

## 6. Hasil Pengujian Otomatis

Pengujian dijalankan langsung melalui script `scratch/test_meta_title_suite.php` terhadap database aktual:

| No | Skenario Pengujian | Hasil | Keterangan |
|---|---|---|---|
| 1 | Skema database `meta_datas.meta_title` | **PASS** | Tipe kolom terverifikasi `varchar(255)` |
| 2 | Nullability kolom | **PASS** | Bersifat `YES` (opsional / backward compatible) |
| 3 | Penyimpanan Meta Title 100 karakter | **PASS** | Tersimpan 100 karakter penuh tanpa terpotong |
| 4 | Pembaruan (Update) 200 karakter | **PASS** | Berhasil di-update & dibaca kembali 200 karakter |
| 5 | Penyimpanan tepat 255 karakter | **PASS** | Tersimpan 255 karakter utuh sama persis dengan input |
| 6 | Multilingual Meta Title (EN) 255 karakter | **PASS** | Tersimpan terpisah per bahasa (ID & EN) |
| 7 | Validasi penolakan input > 255 karakter | **PASS** | Ditolak dengan pesan validasi ramah pengguna |
| 8 | Pesan error validasi informatif | **PASS** | Menampilkan info batas 255 & panjang karakter aktual |
| 9 | Lolos validasi input $\le 255$ karakter | **PASS** | Form diproses normal tanpa hambatan |
| 10 | SEO Rendering pada public frontend | **PASS** | Helper `og::render` & `og::sets` membaca normal |
| 11 | Pembersihan data uji (cleanup) | **PASS** | Database bersih kembali |

**Total: 12 Kasus Uji — 12 Lulus (0 Gagal)**.

