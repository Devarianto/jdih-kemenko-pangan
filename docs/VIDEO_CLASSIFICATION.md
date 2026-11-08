# Dokumentasi Fitur 2: Klasifikasi Video untuk Galeri & Aksesibilitas

## 1. Ringkasan Fitur
Modul Klasifikasi Video dikembangkan untuk mengelola konten video pada JDIH Kementerian Koordinator Bidang Pangan secara fleksibel. Sistem ini memungkinkan:
1. **Multi-Klasifikasi**: Satu video dapat dikaitkan dengan lebih dari satu kategori klasifikasi secara bersamaan (contoh: **Galeri** dan **Aksesibilitas**) tanpa terjadi duplikasi data record.
2. **Halaman Galeri Terintegrasi (`/galeri`)**: Menampilkan foto dan video yang secara spesifik memiliki klasifikasi *Galeri*.
3. **Halaman Aksesibilitas Khusus (`/aksesibilitas`)**: Halaman *video-only* yang menyajikan konten video ramah disabilitas/aksesibilitas dengan pemutar popup responsif dan *empty state* profesional.
4. **Pengelolaan Fleksibel di Admin Panel**: Administrator dapat menambah, mengedit, memilih klasifikasi via checkbox, mengelola status publikasi, urutan tampil (`sort_id`), deskripsi singkat, thumbnail, dan URL video.

---

## 2. Arsitektur Database & Relasi Many-to-Many

Pola relasi Many-to-Many (*M:N*) dipilih karena paling sesuai dengan arsitektur existing Laravel & Cactuar Admin, memastikan integritas referensial dan mencegah duplikasi video.

```
+------------------------+          +-----------------------------------+          +-----------------------+
|       galleries        | 1      * |   gallery_video_classifications   | *      1 |  video_classifications |
+------------------------+----------+-----------------------------------+----------+-----------------------+
| id (PK)                |          | id (PK)                           |          | id (PK)               |
| type ('video'|'image') |          | gallery_id (FK -> galleries)      |          | code (varchar, unique)|
| iframe (video embed)   |          | classification_id (FK -> ...class)|          | name (varchar)        |
| thumbnail              |          | created_at, updated_at            |          | description           |
| sort_id (int)          |          | UNIQUE(gallery_id, class_id)      |          | is_active (tinyint)   |
| is_active              |          +-----------------------------------+          +-----------------------+
+------------------------+
```

### A. Tabel `video_classifications`
Master data kategori klasifikasi video:
- `id`: Primary key
- `code`: Kode unik slug (`galeri`, `aksesibilitas`)
- `name`: Nama kategori (`Galeri`, `Aksesibilitas`)
- `description`: Deskripsi peruntukan kategori
- `sort_id`: Urutan tampilan master data
- `is_active`: Status keaktifan kategori

### B. Tabel Pivot `gallery_video_classifications`
Tabel penghubung relasi many-to-many:
- `gallery_id`: Foreign key ke tabel `galleries(id)` dengan `ON DELETE CASCADE`.
- `classification_id`: Foreign key ke tabel `video_classifications(id)` dengan `ON DELETE CASCADE`.
- `UNIQUE KEY`: Mencegah duplikasi asosiasi antara video dan klasifikasi yang sama.

### C. Penambahan Kolom pada Tabel Existing
- `galleries.sort_id`: Integer untuk mengatur urutan prioritas tampil video.
- `galleries_lang.description`: Textarea multibahasa untuk deskripsi/keterangan singkat video.

---

## 3. Implementasi Model Eloquent

### A. Model `App\Models\VideoClassification`
Mendefinisikan relasi:
```php
public function galleries()
{
    return $this->belongsToMany(
        Gallery::class,
        'gallery_video_classifications',
        'classification_id',
        'gallery_id'
    )->withTimestamps();
}
```

### B. Model `App\Models\Gallery`
Menambahkan relasi dan helper:
```php
public function classifications()
{
    return $this->belongsToMany(
        VideoClassification::class,
        'gallery_video_classifications',
        'gallery_id',
        'classification_id'
    )->withTimestamps();
}

public function scopeClassifiedAs($query, $code)
{
    return $query->whereHas('classifications', function ($q) use ($code) {
        $q->where('code', $code);
    });
}

public function getEmbedUrlAttribute(): string
{
    return self::formatYoutubeEmbed($this->iframe);
}

public function getThumbnailUrlAttribute(): string
{
    if (empty($this->thumbnail)) return '';
    try {
        return \media::initial($this->thumbnail)->url ?? '';
    } catch (\Throwable $e) {
        return '';
    }
}
```

---

## 4. Normalisasi dan Sanitasi URL YouTube

Untuk kenyamanan administrator dan keamanan pemutaran video, sistem menyediakan parser otomatis `Gallery::formatYoutubeEmbed($url)`. Format URL berikut otomatis diubah menjadi format embed resmi YouTube:
1. Format Watch: `https://www.youtube.com/watch?v=VIDEO_ID` &rarr; `https://www.youtube.com/embed/VIDEO_ID`
2. Format Shortlink: `https://youtu.be/VIDEO_ID` &rarr; `https://www.youtube.com/embed/VIDEO_ID`
3. Format Shorts: `https://www.youtube.com/shorts/VIDEO_ID` &rarr; `https://www.youtube.com/embed/VIDEO_ID`
4. Format Embed: `https://www.youtube.com/embed/VIDEO_ID` &rarr; Tetap dipertahankan

Konversi ini dieksekusi secara otomatis pada hook `formCallbackBefore` di `GalleryController.php` sebelum data disimpan ke database.

---

## 5. Integrasi Admin Panel (`GalleryController.php`)

Pada menu **Informasi &rarr; Gallery** (`/admin-panel/information-gallery`):
1. **Listing Tabel**:
   - Kolom **Klasifikasi** menampilkan badge warna:
     - Badge Hijau: `Aksesibilitas`
     - Badge Biru: `Galeri`
     - Badge Abu-abu: `Foto` (untuk galeri bertipe gambar)
2. **Filter Listing**:
   - Dropdown filter di tabel admin untuk menyaring video berdasarkan: *Semua Klasifikasi*, *Galeri*, atau *Aksesibilitas*.
3. **Form Tambah / Edit Video**:
   - Tipe Konten: Pilihan `Foto` atau `Video`.
   - Field **Klasifikasi Video** menggunakan komponen `multicheck-table`:
     - `[x] Galeri`
     - `[x] Aksesibilitas`
     - Administrator dapat mencentang salah satu atau keduanya sekaligus.
   - Field **Deskripsi Video**: Textarea multibahasa (`id` dan `en`).
   - Field **Urutan Tampil** (`sort_id`): Input numerik untuk menyusun prioritas video.
   - **Tampilan Dinamis (JavaScript)**: Field *Klasifikasi Video* dan *URL Video* otomatis tersembunyi jika tipe konten yang dipilih adalah `Foto`, dan otomatis muncul ketika tipe konten diubah menjadi `Video`.

---

## 6. Logika Tampilan Publik (Frontend)

### A. Halaman Galeri (`/galeri`)
- Foto tetap ditampilkan seperti biasa.
- Video **hanya muncul** jika memiliki klasifikasi `galeri` (`whereHas('classifications', fn($q) => $q->where('code', 'galeri'))`).
- Video yang hanya diklasifikasikan sebagai *Aksesibilitas* tidak akan tampil di Galeri.

### B. Halaman Aksesibilitas (`/aksesibilitas`)
- **Video-Only**: Foto/gambar galeri biasa tidak ditampilkan.
- Hanya memuat video yang memiliki klasifikasi `aksesibilitas`.
- **Desain Kartu Video**:
  - Rasio thumbnail 16:9 responsif.
  - Tag badge hijau bertuliskan **Aksesibilitas**.
  - Tanggal publikasi rapi.
  - Judul video yang jelas dan mudah dibaca.
  - Potongan deskripsi singkat ramah aksesibilitas.
  - Tombol / ikon play YouTube dengan overlay gradient.
- **Pemutar Video Interaktif**:
  - Mengklik kartu video atau ikon play membuka modal responsif `#popup-video` dengan iframe YouTube resmi.
- **Fitur Filter & Pencarian**:
  - Input pencarian cepat: "Cari video aksesibilitas...".
  - Dropdown pengurutan: *Terbaru* / *Terlama*.
  - Indikator jumlah video tersedia.
- **Empty State**:
  - Jika belum ada video aksesibilitas yang dipublikasikan, sistem menampilkan ilustrasi dan pesan profesional:
    *"Belum ada video aksesibilitas yang tersedia. Konten video panduan dan ramah disabilitas sedang dipersiapkan..."*.

---

## 7. Pembuktian Kasus Multi-Klasifikasi

Skenario pengujian keterhubungan video:
- **Video ID 1**: *"Sharing Session Penguatan Layanan Advokasi Hukum"*
  - Klasifikasi: **Galeri** + **Aksesibilitas**
  - Hasil di `/galeri`: **TAMPIL**
  - Hasil di `/aksesibilitas`: **TAMPIL**
  - Hasil di Database: Tetap **1 record** di tabel `galleries`, dengan 2 relasi di tabel `gallery_video_classifications`.
- **Video ID 2**: *"Pembahasan Rancangan Peraturan Menteri Koordinator"*
  - Klasifikasi: **Galeri** saja
  - Hasil di `/galeri`: **TAMPIL**
  - Hasil di `/aksesibilitas`: **TIDAK TAMPIL**

---

## 8. File-File yang Terlibat

| No | File Path | Keterangan |
|----|-----------|------------|
| 1 | `database/migrations/2026_10_26_000001_create_video_classifications_and_pivot_tables.php` | Migrasi DDL pembuatan tabel dan seeder awal. |
| 2 | `app/Models/VideoClassification.php` | Model Eloquent master klasifikasi video. |
| 3 | `app/Models/Gallery.php` | Relasi `belongsToMany`, accessors `embed_url`, `thumbnail_url`, scopes. |
| 4 | `app/Http/Controllers/Admin/GalleryController.php` | Form fields, listing badges, multicheck-table, validasi embed YouTube. |
| 5 | `resources/views/admin/gallery/form-js.blade.php` | Script toggle visibilitas field klasifikasi video. |
| 6 | `app/Http/Controllers/Front/PageController.php` | Logika `getInformasiGaleri` dan `getAksesibilitas`. |
| 7 | `resources/views/dynamic/pages/informasi-aksesibilitas.blade.php` | Tampilan publik halaman video aksesibilitas. |
| 8 | `resources/views/dynamic/pages/informasi-galeri.blade.php` | Integrasi pemutar popup galeri. |
| 9 | `routes/web.php` | Pendaftaran route `/aksesibilitas` dan `/api/videos`. |
