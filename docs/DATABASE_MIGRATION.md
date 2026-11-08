# Dokumentasi Migrasi Database

## 1. Ikhtisar Migrasi

Migrasi database dirancang secara non-destruktif (*additive and backward-compatible*):
- **Tidak ada tabel atau data existing yang dihapus**.
- Menambahkan 2 tabel baru untuk master klasifikasi dan relasi pivot.
- Menambahkan 2 kolom pendukung pada tabel galeri existing untuk urutan tampil dan deskripsi multibahasa.
- Mengaitkan video yang sudah ada di database ke kategori `galeri` secara otomatis agar kontinuitas konten tetap terjaga.

File migrasi yang dieksekusi:
`database/migrations/2026_10_26_000001_create_video_classifications_and_pivot_tables.php`

---

## 2. Struktur Tabel Baru

### A. Tabel `video_classifications`
Menyimpan daftar kategori klasifikasi video yang dapat ditambah sewaktu-waktu di masa depan.

```sql
CREATE TABLE `video_classifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_classifications_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

Data awal yang dimasukkan (*seeded*):
| ID | Code | Name | Description | Sort ID | Is Active |
|----|------|------|-------------|---------|-----------|
| 1 | `galeri` | Galeri | Video dokumentasi dan kegiatan umum JDIH | 1 | 1 |
| 2 | `aksesibilitas` | Aksesibilitas | Video panduan dan informasi ramah aksesibilitas/disabilitas | 2 | 1 |

### B. Tabel Pivot `gallery_video_classifications`
Menghubungkan record video di tabel `galleries` dengan kategori di `video_classifications` (Relasi Many-to-Many).

```sql
CREATE TABLE `gallery_video_classifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `classification_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gallery_video_class_unique` (`gallery_id`, `classification_id`),
  CONSTRAINT `gvc_gallery_fk` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gvc_classification_fk` FOREIGN KEY (`classification_id`) REFERENCES `video_classifications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. Perubahan Kolom Tabel Existing

### A. Tabel `galleries`
Menambahkan kolom `sort_id` untuk mengatur urutan prioritas tampilan video:
```sql
ALTER TABLE `galleries` ADD `sort_id` INT NOT NULL DEFAULT 0 AFTER `thumbnail`;
```

### B. Tabel `galleries_lang`
Menambahkan kolom `description` untuk menampung deskripsi/keterangan video dalam berbagai bahasa (Bahasa Indonesia `id` dan Bahasa Inggris `en`):
```sql
ALTER TABLE `galleries_lang` ADD `description` TEXT NULL AFTER `title`;
```

---

## 4. Migrasi Data Video Existing

Agar video existing tidak hilang dari halaman publik setelah migrasi berjalan:
1. Seluruh video existing (`galleries` dengan `type = 'video'`) secara otomatis dihubungkan ke kategori `galeri` (`classification_id = 1`).
2. Video pertama (ID 1, *"Sharing Session Penguatan Layanan Advokasi Hukum"*) dihubungkan ke **kedua kategori** (`galeri` dan `aksesibilitas`) untuk memverifikasi fitur multi-klasifikasi.

---

## 5. Prosedur Rollback

Jika di masa mendatang diperlukan rollback, migrasi telah dilengkapi method `down()` yang membersihkan relasi dan tabel secara aman tanpa merusak integritas tabel utama:

```php
public function down(): void
{
    Schema::dropIfExists('gallery_video_classifications');
    Schema::dropIfExists('video_classifications');

    if (Schema::hasColumn('galleries_lang', 'description')) {
        Schema::table('galleries_lang', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }

    if (Schema::hasColumn('galleries', 'sort_id')) {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('sort_id');
        });
    }
}
```
Perintah eksekusi rollback (jika dibutuhkan):
```bash
php artisan migrate:rollback --step=1
```
