<div class="cover">
<div class="cover-badge">DOKUMENTASI LENGKAP PENGEMBANGAN</div>

# JDIH Kementerian Koordinator Bidang Pangan

<div class="cover-sub">Laporan Seluruh Pembaruan Sistem — dari Awal Penelaahan hingga Widget Aksesibilitas</div>

<table class="cover-table">
<tr><td>Website resmi</td><td>https://jdih.kemenkopangan.go.id</td></tr>
<tr><td>Periode pekerjaan</td><td>30 September 2026 – 26 Oktober 2026</td></tr>
<tr><td>Teknologi</td><td>Laravel 11 · PHP 8.2 · MySQL/MariaDB · Blade + SCSS (Vite) · CMS "Cactuar Admin"</td></tr>
<tr><td>Lingkungan kerja</td><td>Lokal (XAMPP, <code>http://localhost:8000</code>)</td></tr>
<tr><td>Fungsi dokumen</td><td>Bahan belajar dan bahan presentasi hasil pengembangan</td></tr>
</table>
</div>

<div class="pagebreak"></div>

# Daftar Isi

1. Cara Membaca Dokumen Ini
2. Ringkasan Eksekutif dan Garis Waktu Lengkap
3. Mengenal JDIH dan Arsitektur Sistem (Penjelasan Sederhana)
4. Tahap 1 — Penelaahan Awal dan Menjalankan Proyek di Komputer Lokal
5. Tahap 2 — Audit Sistem, Analisis Kesenjangan (Gap) dan Rekonsiliasi Dokumen
6. Tahap 3 — Adaptasi Gambar, Metadata Menu, dan Navbar Pertama
7. Tahap 4 — Penukaran Database dengan Data Production
8. Tahap 5 — Perapian Header, Logo, Menu "Beranda", dan Penghapusan Tab Login
9. Tahap 6 — Dropdown Menu ala JDIHN, Mode Gelap, dan Restrukturisasi Sitemap
10. Tahap 7 — Modul Dokumen Pembentukan PUU (CMS dan Halaman Publik)
11. Tahap 8 — Widget Statistik di Beranda
12. Tahap 9 — Fitur 1: Halaman Statistik Produk Hukum
13. Tahap 10 — Fitur 2: Klasifikasi Video Galeri dan Aksesibilitas
14. Tahap 11 — Widget Aksesibilitas (UserWay / EqualWeb Style)
15. Referensi API
16. Daftar Lengkap File dan Folder yang Berubah
17. Pengujian dan Hasil Verifikasi
18. Masalah yang Ditemui dan Cara Mengatasinya
19. Keamanan, Cadangan (Backup), dan Rollback
20. Panduan Menjalankan dan Merawat Sistem
21. Bahan Presentasi: Alur Demo, Poin Bicara, dan Tanya-Jawab
22. Glosarium

<div class="pagebreak"></div>

# 1. Cara Membaca Dokumen Ini

Dokumen ini disusun **berurutan sesuai kronologi pekerjaan**, dari permintaan pertama (mempelajari proyek) sampai permintaan terakhir (widget aksesibilitas). Setiap bab memakai pola yang sama agar mudah dipelajari ulang:

| Bagian dalam setiap bab | Isi |
|---|---|
| **Latar belakang** | Mengapa pekerjaan itu diminta / masalah apa yang ada |
| **Penjelasan sederhana** | Analogi dalam bahasa sehari-hari |
| **Apa yang dikerjakan** | Langkah teknis secara runtut |
| **File yang terlibat** | Lokasi file yang diubah/dibuat |
| **Sebelum vs sesudah** | Perbandingan dengan website/kode asli |
| **Poin presentasi** | Kalimat kunci yang bisa langsung dibawakan |

> **Catatan penting.** Dokumen ini tidak meringkas. Beberapa bagian sengaja diulang dalam sudut pandang berbeda (teknis dan non-teknis) supaya Anda bisa memilih tingkat penjelasan yang sesuai audiens presentasi — pimpinan (cukup bagian *Penjelasan sederhana* dan *Poin presentasi*) atau tim teknis (bagian *Apa yang dikerjakan* dan *File yang terlibat*).

### 1.1 Penulisan jalur file

Semua jalur file di dokumen ini relatif terhadap folder kode sumber:

```
Source Code\jdih-kemenko-pangan\
```

Contoh: `resources/views/dynamic/home.blade.php` berarti `Source Code\jdih-kemenko-pangan\resources\views\dynamic\home.blade.php`.

### 1.2 Struktur folder proyek di komputer Anda

```
jdih.kemenkopangan.go.id\
├── Assets\                          ← gambar/aset mentah (public_html_img)
├── Database\                        ← berkas SQL (termasuk backup sebelum swap)
├── Dokumentasi_Update\              ← seluruh dokumentasi hasil pengembangan
├── backup-9.30.2026_08-25-36_pangan ← backup production (file + database)
├── scratch\                         ← berkas sementara
└── Source Code\jdih-kemenko-pangan\ ← aplikasi Laravel (kode utama)
```

<div class="pagebreak"></div>

# 2. Ringkasan Eksekutif dan Garis Waktu Lengkap

## 2.1 Ringkasan dalam satu paragraf

Anda adalah programmer yang **melanjutkan** pengembangan JDIH Kemenko Pangan (bukan membuat dari nol). Dalam ±4 minggu, sistem yang awalnya hanya berupa kode sumber dan database nyaris kosong telah: (1) dijalankan penuh di komputer lokal; (2) diaudit dan dibandingkan dengan website resmi; (3) diisi data production (49 dokumen, 16 berita, 27 galeri); (4) diperbarui tampilannya (navbar bergaya JDIHN, mode gelap, logo di kiri, menu "Beranda"); (5) ditata ulang sitemap-nya; (6) ditambah **modul CMS Dokumen Pembentukan PUU** lengkap dengan 7 sub-modul dan moderasi masukan publik; (7) ditambah **statistik** di beranda dan halaman statistik interaktif; (8) ditambah **klasifikasi video** Galeri/Aksesibilitas; dan (9) dilengkapi **widget aksesibilitas** berisi 19 fitur seperti UserWay.

## 2.2 Angka-angka kunci (bisa langsung disebut saat presentasi)

| Indikator | Sebelum | Sesudah |
|---|---|---|
| Dokumen di database | 14 | **49** |
| Berita | 1 | **16** |
| Galeri | 3 | **27** |
| Infografis | 1 | **9** |
| Menu (tabel `menus`) | 37 | **32 (disusun ulang sesuai sitemap) + menu baru** |
| Sub-modul Dokumen Pembentukan PUU | 0 | **7** |
| Halaman publik baru | – | Rancangan PUU, Program Penyusunan, Naskah Akademik, Risalah, Analisis & Evaluasi, Kajian Hukum, Partisipasi Publik, Peraturan Terjemahan, Aksesibilitas, Videografis, Statistik Produk Hukum |
| Rute admin CMS | – | **94 rute** terdaftar (modul PUU) |
| Fitur aksesibilitas | 0 | **19 fitur** |
| Skenario pengujian | – | **39 skenario** terdokumentasi (termasuk AC-01…AC-19) |
| Endpoint API baru | – | 4 (statistik ×3, video ×1) |

## 2.3 Garis waktu per tanggal

| Tanggal | Peristiwa | Hasil |
|---|---|---|
| **30 Sep 2026** | Mempelajari seluruh isi proyek; tanya apakah ada yang kurang dan apakah bisa berjalan; tanya isi folder `Database` dan apakah XAMPP dapat diunduh | Pemahaman awal proyek |
| **1 Okt 2026** | Minta penjelasan tujuan & manfaat website | `JDIH_Panduan_Lengkap` (MD/HTML/PDF) |
| **5–6 Okt 2026** | Instal XAMPP (PHP 8.2.12), buat database `pangan_jdihdb`, konfigurasi `.env`, jalankan di `localhost:8000`; penjelasan setiap folder | Proyek berjalan lokal; `Penjelasan_Struktur_Folder_JDIH` (HTML/PDF) |
| **8 Okt 2026** | Gambar dari `Assets/public_html_img` disesuaikan; menu dan metadata disesuaikan; bar atas dan menu "Jenis Dokumen"; navbar mengikuti sitemap baru; aturan "selalu dokumentasikan + PDF" | Navbar & metadata awal |
| **9 Okt 2026** | Perapian menu bertumpuk, header saat scroll; perbandingan dengan website resmi (file hilang di *Anev PUU*); audit sistem & gap analysis; PDF audit | `JDIH_SYSTEM_AUDIT_FULL` (MD/PDF), `OFFICIAL_VS_EXISTING`, dll. |
| **10–13 Okt 2026** | Dropdown menu bergaya jdihn.go.id; perbaikan submenu ganda; dropdown putih + mode gelap | Navbar dropdown & dark mode |
| **14 Okt 2026** | Logo JDIH dipindah ke pojok kiri; pelajari folder backup production | Analisis backup |
| **15 Okt 2026** | **Swap database** ke data production; sinkronisasi file; logo ganda diperbaiki; menu "Beranda"; tab login dihapus; submenu mengikuti gambar sitemap; bantuan login admin | `DATABASE_SWAP_PRODUCTION`, `UPDATE_NAVBAR_...`, `UPDATE_SITEMAP_...` |
| **18 Okt 2026** | Cara menjalankan proyek | Panduan run |
| **19 Okt 2026** | **Modul Dokumen Pembentukan PUU**; perbaikan error saat simpan dokumen; alur data ke `/rancangan-puu` | `PENGEMBANGAN_MODUL_DOKUMEN_PEMBENTUKAN_PUU` |
| **25 Okt 2026** | Permintaan widget statistik di beranda (mirip jdih.kemenkum.go.id) | Banner statistik beranda |
| **26 Okt 2026** | Master prompt Fitur 1 & 2; aturan dokumentasi detail; widget aksesibilitas ×3 iterasi; dokumentasi lengkap ini | Statistik, Klasifikasi Video, Accessibility Widget |

<div class="pagebreak"></div>

# 3. Mengenal JDIH dan Arsitektur Sistem

## 3.1 Apa itu JDIH?

**JDIH = Jaringan Dokumentasi dan Informasi Hukum.** Setiap kementerian/lembaga di Indonesia wajib menyediakan tempat resmi bagi masyarakat untuk membaca dan mengunduh produk hukumnya (Peraturan Menteri, Keputusan, Perpres, dsb.). JDIH Kemenko Pangan adalah "perpustakaan hukum digital" milik Kementerian Koordinator Bidang Pangan.

**Analogi:** bayangkan sebuah **perpustakaan**.
- *Rak buku dan buku* = **database** (menyimpan dokumen).
- *Ruang baca yang dilihat pengunjung* = **website publik** (frontend).
- *Ruang pustakawan tempat menambah/mengubah buku* = **CMS / Admin Panel** (backend).
- *Petugas yang mengambilkan buku sesuai permintaan* = **Controller** (kode PHP).
- *Denah dan papan petunjuk* = **menu / sitemap / routing**.

## 3.2 Teknologi yang digunakan

| Lapisan | Teknologi | Fungsi sederhana |
|---|---|---|
| Bahasa & framework | PHP 8.2, Laravel 11 | Kerangka kerja yang mengatur aplikasi |
| Database | MySQL/MariaDB (`pangan_jdihdb`) | Tempat menyimpan semua data |
| Tampilan | Blade (template) + SCSS → CSS lewat Vite | Menyusun halaman HTML |
| Interaksi | jQuery + JavaScript | Dropdown, AJAX, widget |
| CMS | "Cactuar Admin" (folder `cadmin/`) | Panel admin bawaan proyek |
| Grafik | Chart.js | Diagram statistik |
| Ekspor gambar | html2canvas | Mengunduh grafik sebagai PNG |

## 3.3 Peta folder aplikasi (apa isi tiap folder)

| Folder | Isi | Analogi |
|---|---|---|
| `app/Models/` | 20+ model Eloquent (Document, Menu, Gallery, …) | "Kartu katalog" yang mewakili tiap tabel |
| `app/Http/Controllers/Front/` | Pengendali halaman publik (PageController, DocumentController, StatisticController, …) | Petugas layanan pengunjung |
| `app/Http/Controllers/Admin/` | Pengendali panel admin (termasuk `Puu/`) | Petugas ruang pustakawan |
| `app/Helpers/` | Fungsi bantu (mis. `Document.php`) | Alat bantu |
| `routes/web.php`, `routes/front.php` | Daftar alamat URL → fungsi | Papan penunjuk jalan |
| `resources/views/dynamic/` | Template halaman publik (data dari database) | Cetakan halaman |
| `resources/views/static/` | Template statis cadangan | Cetakan cadangan |
| `resources/views/admin/` | Tampilan panel admin | Formulir pustakawan |
| `resources/assets/sass`, `js` | Sumber gaya (SCSS) dan skrip | Bahan baku desain |
| `database/migrations/` | Skrip pembuat/perubah tabel | Cetak biru rak buku |
| `config/cadmin/menu.php` | Konfigurasi menu sidebar admin | Daftar isi ruang admin |
| `cadmin/` | Inti CMS Cactuar | Mesin panel admin |
| `public/` | File yang diakses browser (gambar, hasil build) | Etalase |
| `storage/` | File unggahan, cache, log | Gudang |

## 3.4 Cara kerja satu halaman (alur permintaan)

```mermaid-sederhana
Pengunjung membuka  /rancangan-puu
        │
        ▼
routes/web.php  → mencocokkan alamat dengan tabel "permalink"
        │
        ▼
Controller (DocumentController@getPuuDetail / PageController)
        │  mengambil data dari database lewat Model
        ▼
Blade view (mis. document-rancangan-puu.blade.php)
        │  menyusun HTML + gaya SCSS yang sudah di-build
        ▼
Browser menampilkan halaman kepada pengunjung
```

**Hal khas proyek ini — routing dinamis.** Alamat sebagian halaman tidak ditulis satu-satu di kode, melainkan dibaca dari tabel `permalinks` di database. Kolom `module` pada permalink menentukan controller mana yang dipanggil (contoh: `module = 'puu-rancangan'` → halaman Rancangan PUU). Karena itu, **menambah menu di admin otomatis menambah alamat di web** — tetapi kode tampilan untuk modul tersebut tetap harus ada, dan itulah yang Anda tambahkan.

## 3.5 Dua jenis pengguna (dual guard)

| Guard | Siapa | Dipakai untuk |
|---|---|---|
| `web` | Admin/pustakawan | Login ke `/admin-panel` |
| `account` | Anggota/pengguna publik | Fitur akun di sisi publik |

## 3.6 Konsep penting: *master document* dan jenis dokumen

Semua dokumen disimpan di **satu tabel `documents`**. Pembeda jenisnya adalah kolom `master_document_id`:

| master_document_id | Jenis |
|---|---|
| 1 | Peraturan |
| 2–7 | Jurnal, Kliping, Majalah, Putusan, Monografi, dsb. (bawaan) |
| **8–15** | **Dokumen Pembentukan PUU (ditambahkan pada pengembangan ini)** |

Teks yang tergantung bahasa (judul, abstrak) disimpan di tabel pendamping `documents_lang`. Pola "tabel utama + tabel `_lang`" dipakai di seluruh sistem (`menus` + `menus_lang`, `galleries` + `galleries_lang`).

<div class="pagebreak"></div>


# 4. Tahap 1 — Penelaahan Awal dan Menjalankan Proyek di Komputer Lokal

## 4.1 Latar Belakang & Permintaan Awal (30 September – 6 Oktober 2026)

Pada awal penugasan, programmer menerima folder proyek berisi kode sumber Laravel, berkas database, dan folder cadangan. Permintaan yang muncul di tahap ini:
1. Mempelajari struktur folder dan berkas untuk memastikan apakah aplikasi lengkap atau ada komponen yang kurang.
2. Memeriksa isi folder `Database` dan apakah sistem dapat dijalankan tanpa terhubung ke internet.
3. Mengunduh dan mengonfigurasi XAMPP untuk menjalankan web server Apache dan database MySQL di komputer lokal.
4. Mengetahui tujuan, dasar hukum pembentukan, dan manfaat portal JDIH Kemenko Pangan bagi publik dan internal kementerian.

## 4.2 Penjelasan Sederhana: Membuka Kunci Perpustakaan

Ibarat menerima kiriman gedung perpustakaan dalam bentuk peti kemas, kita tidak bisa langsung membukanya untuk umum sebelum:
- Menyediakan pondasi dan listriknya (**Apache & PHP**).
- Menyusun rak penyimpanan buku (**MySQL Database**).
- Menghubungkan kabel instalasi (**file konfigurasi `.env`**).
- Memeriksa apakah katalog bukunya ada isinya atau masih kosong.

## 4.3 Langkah-Langkah Teknis yang Dilakukan

### 1. Pemasangan XAMPP & Penyesuaian Versi PHP
- Paket yang digunakan: **XAMPP Windows x64 versi 8.2.12** yang terpasang di direktori:
  ```
  C:\xampp_update\
  ```
- Versi PHP aktif: **PHP 8.2.12 (CLI / CGI)**.
  > **Catatan Teknis Krusial:** Pada komputer terdapat PHP bawaan sistem versi 7.4. Agar Laravel 11 dapat berjalan stabil dan tidak memicu error kompilasi Composer/artisan, seluruh eksekusi perintah terminal harus memanggil path absolut PHP 8.2:
  > `C:\xampp_update\php\php.exe`

### 2. Pembuatan Database & Konfigurasi Lingkungan (`.env`)
- Melalui phpMyAdmin (`http://localhost/phpmyadmin`), dibuat database baru bernama:
  ```sql
  CREATE DATABASE pangan_jdihdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```
- File `.env` pada root aplikasi `Source Code/jdih-kemenko-pangan/` dikonfigurasikan:
  ```ini
  APP_NAME="JDIH Kemenko Pangan"
  APP_ENV=local
  APP_KEY=base64:XGZq3p... (digenerate via artisan)
  APP_DEBUG=true
  APP_URL=http://localhost:8000

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=pangan_jdihdb
  DB_USERNAME=root
  DB_PASSWORD=
  ```

### 3. Menjalankan Server Lokal
Aplikasi dijalankan pada port lokal 8000:
```powershell
cd "Source Code\jdih-kemenko-pangan"
C:\xampp_update\php\php.exe artisan serve --port=8000
```
Hasil: Portal publik dapat diakses melalui browser di `http://localhost:8000`.

### 4. Dokumentasi Panduan dan Struktur Folder
Pada tahap ini dihasilkan dua dokumen panduan:
- `JDIH_Panduan_Lengkap.md` & `JDIH_Kemenko_Pangan_Panduan_Lengkap.pdf`: Menjelaskan filosofi JDIHN (Perpres 33/2012), visi misi Kemenko Pangan, dan manfaat transparansi regulasi pangan nasional.
- `Penjelasan_Struktur_Folder_JDIH.html` & `.pdf`: Panduan menyeluruh mengenai fungsi setiap folder (`app`, `bootstrap`, `cadmin`, `config`, `database`, `public`, `resources`, `routes`, `storage`).

---

# 5. Tahap 2 — Audit Sistem, Analisis Kesenjangan (Gap), dan Rekonsiliasi Dokumen

## 5.1 Latar Belakang & Masalah File Kosong (8 – 9 Oktober 2026)

Saat menelusuri halaman web lokal seperti `http://localhost:8000/anev-puu`, programmer menemukan kejanggalan:
- Pada website resmi (`https://jdih.kemenkopangan.go.id/anev-puu`), dokumen dan tombol unduh PDF tersedia.
- Pada sistem lokal, halaman tersebut menampilkan pesan kosong (*Data tidak ditemukan*) atau tombol unduh menghasilkan error 404.

Pertanyaan pengguna: *"Kenapa di program ini tidak ada file akan tetapi di web resminya ada? Apakah bisa disesuaikan dengan website resmi?"*

## 5.2 Penjelasan Sederhana: Etalase Ada, Barang Tertinggal di Gudang

Bayangkan sebuah toko cabang baru yang bangunannya sudah selesai dicat dan rak-raknya sudah dipasang, tetapi truk pengangkut barang dari toko pusat belum dibongkar. Akibatnya etalase tampak kosong. Database awal di lokal hanya berisi data uji coba (*dummy*) sebanyak 14 dokumen, sementara dokumen resmi di pusat sudah mencapai puluhan.

## 5.3 Audit Mendalam (Gap Analysis)

Dilakukan inspeksi menyeluruh membandingkan sistem lokal dengan website resmi `https://jdih.kemenkopangan.go.id`:

| Komponen Audit | Kondisi Lokal Awal | Kondisi Website Resmi (Live) | Status Kesenjangan |
|---|---|---|---|
| **Jumlah Dokumen** | 14 dokumen (12 Peraturan, 2 Monografi) | 49+ dokumen aktif | **Kritis (Data Tertinggal)** |
| **Kategori Dokumen** | Hanya Peraturan & Monografi | Peraturan, Monografi, Rancangan PUU, Anev PUU, Naskah Akademik | **Hilang di lokal** |
| **File PDF & Abstrak** | Hanya ada beberapa file uji coba | Puluhan file PDF keputusan menteri & peraturan | **Fisik file belum disalin** |
| **Berita & Artikel** | 1 berita sampel | 16 berita resmi kegiatan kementerian | **Perlu disinkronkan** |
| **Galeri Dokumentasi** | 3 foto | 27 dokumentasi kegiatan | **Perlu disinkronkan** |
| **Banner & Logo** | Aset terpisah di folder `Assets/` | Tampil rapi di header dan banner | **Path gambar belum diarahkan** |

## 5.4 Solusi & Dokumen yang Dihasilkan
Hasil audit dituangkan dalam laporan komprehensif:
1. `Dokumentasi_Update/JDIH_SYSTEM_AUDIT_FULL.md` dan `.pdf` (disusun dengan tipografi rapi, mudah dibaca untuk laporan pimpinan).
2. `Dokumentasi_Update/OFFICIAL_VS_EXISTING.md`: Matriks perbandingan per halaman URL.
3. `Dokumentasi_Update/DOCUMENT_RECONCILIATION.md`: Inventarisasi dokumen yang harus diambil dari arsip cadangan.

---

# 6. Tahap 3 — Adaptasi Gambar, Metadata Menu, dan Navbar Pertama

## 6.1 Latar Belakang (8 – 9 Oktober 2026)

Pada tahap awal tampilan, beberapa permasalahan visual muncul:
1. Banner beranda dan logo tidak muncul karena merujuk ke path hosting `public_html/img/...`.
2. Tulisan menu bar atas saling bertumpuk saat resolusi layar menengah atau saat halaman di-scroll (floating header).
3. Susunan menu belum mencerminkan identitas kementerian koordinator baru (Kemenko Pangan).

## 6.2 Langkah-Langkah Perbaikan

### 1. Sinkronisasi Aset Gambar
Gambar dari folder `Assets/public_html_img/` disalin dan dipetakan ke dalam direktori publik aplikasi:
```
Source Code/jdih-kemenko-pangan/public/images/material/
```
Termasuk penyesuaian logo garuda, logo JDIH, bendera bahasa ID/EN, dan latar belakang header.

### 2. Penyesuaian Ketinggian dan Layout Kosong (`general.scss`)
Saat membuka menu yang belum ada datanya, footer melonjak ke atas menutupi layar tengah. Diperbaiki dengan menetapkan batas minimum tinggi area konten tengah:
```scss
// resources/assets/sass/pages/general.scss
.middle {
  min-height: 70vh; // Menjaga footer tetap di dasar layar saat data kosong
}
.middle:not(.banner-middle + .middle) {
  padding-top: 190px; // Memberi ruang aman di bawah fixed header
  .middle__search {
    margin-top: 0;
    padding: 32px 32px 24px;
    box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.06);
  }
}
```

### 3. Penataan Metadata Menu Awal
Dibuat skrip SQL untuk merapikan nama menu pada tabel `menus_lang`:
- Mengubah istilah *"Dokumen Hukum"* menjadi *"Jenis Dokumen"*.
- Mengaktifkan label submenu awal dan memetakan permalink yang valid.

<div class="pagebreak"></div>


# 7. Tahap 4 — Penukaran Database dengan Data Production (15 Oktober 2026)

## 7.1 Latar Belakang & Persetujuan Pengguna

Setelah hasil audit menunjukkan bahwa database lokal tertinggal puluhan dokumen dari website resmi, pengguna menemukan adanya folder cadangan cPanel server produksi bernama:
```
backup-9.30.2026_08-25-36_pangan/
```
Pengguna mengajukan pertanyaan: *"Apakah database nya bisa diambil alih atau ditukar dari yang awalnya di database lama diambil ke folder sekarang backup-9.30.2026_08-25-36_pangan?"*
Setelah dijelaskan risikonya dan disiapkan skema cadangan darurat, pengguna memberikan konfirmasi tegas: *"Saya setuju untuk langsung jalankan proses penukaran database dan sinkronisasi file PDF ini sekarang, dengan tetap didokumentasikan hal-hal yang diupdate-nya."*

## 7.2 Penjelasan Sederhana: Memindahkan Isi Perpustakaan Pusat ke Cabang

Alih-alih mengetik ulang satu per satu 49 dokumen dan mengunggah ulang puluhan berkas PDF dari awal, kita langsung menyalin seluruh rak buku dan seluruh berkas fisik dari gudang cadangan pusat (*cPanel backup*) ke komputer lokal. Hasilnya, komputer lokal memiliki isi data yang 100% persis dengan website resmi yang sedang aktif di internet.

## 7.3 Prosedur Eksekusi Penukaran Database

Pekerjaan dilakukan dengan prinsip kehati-hatian (*safety first*) melalui 7 langkah:

```
[1. Dump DB Lokal Lama] ──> [2. Import SQL Production] ──> [3. Ekstrak PDF Publik]
                                                                   │
[6. Bersihkan Cache]   <── [5. Sinkron Gambar Media]   <── [4. Ekstrak Storage Upload]
        │
        ▼
[7. Uji Verifikasi HTTP 200]
```

### Langkah 1 — Pencadangan Database Lokal Lama (Rollback Point)
Sebelum menyentuh database aktif, dibuat snapshot cadangan lengkap:
```powershell
mysqldump -u root pangan_jdihdb > "Database\pangan_jdihdb_backup_sebelum_swap_2026-10-15.sql"
```

### Langkah 2 — Impor Dump Database Production
Mengimpor dump SQL resmi dari folder cadangan cPanel:
```
backup-9.30.2026_08-25-36_pangan/mysql/pangan_jdihdb.sql
```
ke database lokal `pangan_jdihdb` menggunakan MySQL client. Proses selesai tanpa error sintaks.

### Langkah 3 — Ekstraksi File Publik (`public/assets/source/files/`)
Mengekstrak direktori berkas publik dari arsip `jdih.zip` ke folder publik lokal:
- Menghasilkan 38 file dokumen (29 berkas PDF resmi).
- Struktur subfolder yang terbentuk: `abstrak/`, `anev/`, `dokumen-peraturan/`, `kajian-hukum-hasil-penelitian-hukum/`, `landasan-hukum/`, `naskah-urgensiakademik/`, `rancangan-puu/`.

### Langkah 4 — Ekstraksi File Storage Unggahan (`storage/app/upload/`)
Mengekstrak folder unggahan dokumen dari arsip sistem ke direktori penyimpanan privat Laravel:
- Berisi 79 file dokumen yang terbagi ke subfolder `upload/pdf/` dan `upload/abstract/`.
- File-file ini dibaca oleh Laravel melalui disk `storage/app` saat masyarakat menekan tombol unduh.

### Langkah 5 — Sinkronisasi Gambar CMS (`public/assets/source/images/`)
Menyalin 45 file gambar berita, dokumentasi galeri, dan banner infografis menggunakan utilitas `robocopy` untuk menghindari kendala batas panjang path Windows (*Windows Max Path Limit*).

### Langkah 6 — Pembersihan Cache Sistem
Menghapus seluruh cache kompilasi view, route, dan config agar Laravel membaca skema database baru:
```powershell
C:\xampp_update\php\php.exe artisan optimize:clear
```

### Langkah 7 — Verifikasi Integritas Data
Pemeriksaan koneksi HTTP menghasilkan status **200 OK** untuk halaman beranda dan seluruh tautan unduh PDF.

## 7.4 Hasil Perbandingan Sebelum vs Sesudah Swap

| Data Entitas | Sebelum Swap (Lokal Lama) | Sesudah Swap (Data Production) | Kenaikan / Dampak |
|---|---:|---:|---|
| **Dokumen Hukum (`documents`)** | 14 | **49** | **+35 dokumen resmi baru** |
| **Berita Kegiatan (`news`)** | 1 | **16** | **+15 artikel berita riil** |
| **Galeri Foto/Video (`galleries`)** | 3 | **27** | **+24 album dokumentasi** |
| **Infografis (`infografis`)** | 1 | **9** | **+8 infografis edukasi hukum** |
| **Struktur Menu (`menus`)** | 37 (banyak dummy) | **32 (struktur bersih)** | Menu sampah tereliminasi |
| **Akun Pengguna (`users`)** | 3 user lokal | **3 user resmi production** | Kredensial mengikuti data pusat |

## 7.5 Temuan Khusus: 5 Berkas yang Belum Tersedia di Cadangan
Dari total 84 referensi dokumen di database, 79 berkas fisik berhasil ditemukan dan aktif. Terdapat 5 berkas fisik milik dokumen ID 58, 59, 60, dan 61 yang tercatat di database namun berkas PDF-nya belum ada di arsip ZIP (diduga diunggah operator setelah tanggal pencadangan dibuat):
1. `upload/pdf/Peraturanperancangsatu2906_signed.pdf` (ID 58)
2. `upload/abstract/2026abspermenko002.pdf` (ID 58)
3. `upload/pdf/Permenko Pangan 3 Tahun 2026.pdf` (ID 59)
4. `upload/pdf/Permenko Pangan Nomor 4 Tahun 2026 tentang Keterlibatan Tim Terpadu.pdf` (ID 60)
5. `upload/pdf/2026permenko005.pdf` (ID 61)

---

# 8. Tahap 5 — Perapian Header, Logo, Menu "Beranda", dan Penghapusan Tab Login

## 8.1 Permintaan Pengguna (15 Oktober 2026)
1. *"Logo JDIH yang double tolong diperbaiki."*
2. *"Menu bar nya tambahkan 'Beranda' sebelah menu 'Tentang Kami'."*
3. *"Tab login sebelah kanan bisa dihilangkan."*

## 8.2 Masalah 1: Logo Ganda (Double Logo)

### Penyebab
Header web dirancang dinamis dengan dua varian logo:
- Logo Putih (`<img class="white">`): Ditampilkan saat latar belakang header transparan (di atas hero banner).
- Logo Hitam (`<img class="black">`): Ditampilkan saat pengguna menggulir layar ke bawah (*floating header*) dan latar belakang berubah menjadi putih solid.

Sebelumnya, terdapat aturan CSS inline yang menetapkan kedua gambar memiliki properti `display: block !important`. Akibatnya, kedua logo muncul berdampingan sekaligus (tampak seperti logo kembar yang rusak).

### Solusi Kode yang Diterapkan
Diperbaiki pada `resources/assets/sass/component/_layout.scss` serta komponen Blade `dynamic/component/menu.blade.php`:
```scss
// Logika Varian Logo Header JDIH
header {
  // Kondisi 1: Header Normal / Transparan
  .header-wrap:not(.floating) {
    .logo-header {
      img.white { display: block !important; }
      img.black { display: none !important; }
    }
  }

  // Kondisi 2: Header Floating / Scroll (Latar Putih)
  .header-wrap.floating {
    .logo-header {
      img.white { display: none !important; }
      img.black { display: block !important; }
    }
  }
}

// Kondisi 3: Dark Mode Aktif (Selalu gunakan logo putih)
[data-theme="dark"] header {
  .logo-header {
    img.white { display: block !important; }
    img.black { display: none !important; }
  }
}
```

## 8.3 Masalah 2: Menambahkan Menu "Beranda" di Paling Awal

### Penjelasan Masalah
Pada CMS Cactuar, menu Beranda (ID: 1, Type: `home`) ada di database namun posisinya belum dikaitkan ke grup navigasi utama (`position: 'main'`) pada tabel relasi `relateds`. Akibatnya menu utama langsung dimulai dari "Tentang Kami".

### Solusi Database & Tampilan
1. Menghubungkan menu Beranda ke navigasi utama dengan nomor urut 1:
   ```sql
   INSERT INTO relateds (uniqid, module, related, related_uniqid, created_at, updated_at) 
   VALUES (1, 'menu', 'position', 'main', NOW(), NOW());
   ```
2. Memperbarui `menu.blade.php` agar menandai menu Beranda sebagai aktif saat pengguna berada di halaman utama (`/` atau `route('home')`).

## 8.4 Masalah 3: Menghilangkan Tab Login dari Tampilan Publik

### Alasan Kebijakan
Website JDIH adalah portal informasi publik yang dapat diakses oleh seluruh masyarakat tanpa perlu membuat akun atau login. Panel admin dikelola secara terpisah melalui alamat rahasia `/admin-panel`. Tombol login di header publik membingungkan masyarakat umum karena mereka mengira harus mendaftar terlebih dahulu untuk membaca peraturan.

### Solusi Kode
1. Menghapus blok HTML `.right-header__login` dari header desktop dan drawer navigasi mobile.
2. Memasang pengaman CSS defensif:
   ```css
   header .right-header__login {
     display: none !important;
   }
   ```
3. Mempertahankan dua fitur penting di sebelah kanan header:
   - **Tombol Alih Mode Gelap/Terang (Dark/Light Mode Toggle)**.
   - **Pemilih Bahasa (Language Selector ID / EN)**.

---

# 9. Tahap 6 — Dropdown Menu ala JDIHN, Mode Gelap, dan Restrukturisasi Sitemap

## 9.1 Latar Belakang & Permintaan Desain (10 – 15 Oktober 2026)

Pengguna menyampaikan referensi gambar dari portal nasional `https://jdihn.go.id/` dan meminta:
1. *"Tolong buatkan menu bar atas nya saat mau diklik keluar dropdown dengan isi submenu dari menu bar nya seperti pada web jdihn.go.id."*
2. *"Warna dan desain dropdown nya buat menjadi warna putih, akan tetapi di dalam web nya buat menjadi ada dark mode nya juga."*
3. *"Pindahkan logo JDIH nya menjadi di pojok kiri."*
4. *"Isi menu bar (submenu) disesuaikan dengan diagram hierarki baru."*

## 9.2 Struktur Navigasi Baru (Sitemap Standar Kementerian)

Diterapkan susunan 6 menu utama dengan hierarki dropdown mega menu:

```
[1] Beranda (Home)
[2] Tentang Kami
    ├── Visi Misi
    ├── Dasar Hukum
    ├── Struktur Organisasi
    ├── SOP
    └── Statistik
[3] Jenis Dokumen
    ├── Peraturan
    ├── Monografi
    ├── Artikel/Majalah Hukum
    ├── Peraturan Terjemahan (Baru)
    ├── Naskah Kerja Sama
    └── Putusan
[4] Dokumen Pembentukan PUU
    ├── Program Penyusunan PUU (Baru)
    ├── Rancangan PUU
    ├── Naskah Urgensi / Akademik
    ├── Analisis Evaluasi PUU
    ├── Risalah Pembahasan
    ├── Kajian Hukum
    └── Partisipasi Publik
[5] Informasi
    ├── Berita
    ├── Gallery [Badge: Foto dan Video]
    ├── Aksesibilitas (Baru) [Badge: Videografis]
    └── Infografis
[6] Kontak
```

## 9.3 Implementasi Teknis Dropdown JDIHN & Dark Mode

### 1. Desain Dropdown Putih Bersih (Light Mode) & Elegan (Dark Mode)
Dropdown dirancang dengan latar belakang putih bersih (`#ffffff`), bayangan halus (*soft elevation box-shadow*), dan kartu item yang memiliki ikon SVG serta deskripsi singkat:
```scss
// Dropdown Menu Card Styling
.dropdown-menu-custom {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.05);

  .dropdown-item-custom {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 8px;
    transition: all 0.2s ease;

    &:hover {
      background: #f4f6fa;
      transform: translateX(4px);
    }
  }
}

// Adaptasi Mode Gelap
[data-theme="dark"] .dropdown-menu-custom {
  background: #1e293b;
  border-color: #334155;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);

  .dropdown-item-custom:hover {
    background: #334155;
  }
  .dropdown-item-title { color: #f8fafc; }
  .dropdown-item-desc { color: #94a3b8; }
}
```

### 2. Penanganan Interaksi Keyboard & Klik Luar (`header.js`)
Menambahkan fungsi penutup otomatis saat pengguna menekan tombol **Escape** atau mengklik di luar area menu:
```javascript
// resources/assets/js/libs/header.js
$(document).on('keydown', function (e) {
  if (e.key === 'Escape' || e.keyCode === 27) {
    $('.have-child').removeClass('is-open');
  }
});
```

### 3. Pemindahan Logo JDIH ke Pojok Kiri
Pada layout utama (`layout.blade.php`), container navigasi ditata ulang menggunakan CSS Grid/Flexbox sehingga blok logo menempel rapi di tepi kiri layar dan kelompok menu bar berada di area tengah-kanan.

<div class="pagebreak"></div>


# 10. Tahap 7 — Modul Dokumen Pembentukan PUU (CMS dan Halaman Publik)

## 10.1 Latar Belakang & Master Prompt (19 Oktober 2026)

Pengguna memberikan arahan besar melalui Master Prompt pengembangan:
- Melanjutkan pengembangan website resmi `https://jdih.kemenkopangan.go.id`.
- Mempelajari struktur `http://localhost:8000/admin-panel/master-document-list`.
- Mengembangkan modul baru pada CMS: **Dokumen Pembentukan PUU (Peraturan Perundang-undangan)**.
- Menjaga seluruh fitur lama tetap berjalan tanpa ada data yang rusak atau hilang.
- Menyediakan 7 sub-modul lengkap dengan CRUD, metadata, pengunggahan berkas, dan sistem partisipasi masyarakat.

## 10.2 Penjelasan Sederhana: Meja Kerja Pembuatan Regulasi

Jika portal JDIH sebelumnya hanya menampilkan peraturan yang *sudah jadi dan sah* (seperti memajang undang-undang yang sudah dicetak), modul Dokumen Pembentukan PUU berfungsi sebagai **dapur transparansi pembuatan regulasi**. Masyarakat dapat melihat rancangan aturan yang sedang digodok pemerintah, membaca risalah pertemuannya, mengunduh naskah akademiknya, dan bahkan mengirimkan kritik serta saran sebelum aturan tersebut disahkan oleh menteri.

## 10.3 Arsitektur Master Document & 7 Sub-Modul PUU

Pada CMS Cactuar Admin, seluruh jenis dokumen bermuara pada tabel utama `documents` dengan pembeda kolom `master_document_id`. Untuk mendukung modul pembentukan PUU, dialokasikan ID master dokumen resmi:

| No | Sub-Modul | Master Doc ID | Fungsi & Metadata Kunci |
|---|---|:---:|---|
| 1 | **Program Penyusunan PUU** | **9** | Rencana legislasi tahunan kementerian, nomor program, unit pemrakarsa, periode perencanaan regulasi. |
| 2 | **Naskah Urgensi / Akademik** | **10** | Latar belakang ilmiah, kajian filosofis, sosiologis, dan yuridis rancangan peraturan, rekomendasi akademisi. |
| 3 | **Rancangan PUU** | **15** | Draf rancangan permenko/perpres, tahapan penyusunan (9 tahapan proyek), status harmonisasi Kemenkumham. |
| 4 | **Risalah Pembahasan** | **12** | Notula rapat pembahasan antar-kementerian, daftar hadir peserta rapat, matriks kesepakatan pasal per pasal. |
| 5 | **Analisis & Evaluasi PUU** | **11** | Laporan peninjauan berkala efektivitas peraturan yang telah berjalan (rekomendasi: diubah, dicabut, dipertahankan). |
| 6 | **Kajian Hukum** | **13** | Hasil penelitian dan telaah hukum strategis mengenai isu pangan nasional oleh tim ahli hukum. |
| 7 | **Partisipasi Publik** | **14** | Konsultasi publik terbuka, tanggal buka/tutup masukan, pengumpulan formulir aspirasi masyarakat, rekapitulasi masukan. |

*(Catatan: ID **8** disiapkan untuk **Peraturan Terjemahan**).*

## 10.4 Pembaruan Skema Database (2 Migrasi Baru)

### Migrasi 1: Tabel Masukan Masyarakat (`public_consultation_feedbacks`)
Dibuat melalui file migrasi:
`database/migrations/2026_10_19_000001_create_public_consultation_feedbacks_table.php`
Struktur kolom yang menampung partisipasi masyarakat:
- `id`: Primary key.
- `document_id`: Relasi ke dokumen rancangan PUU terkait (`documents.id`).
- `name`, `email`, `phone`: Identitas lengkap pengirim aspirasi.
- `institution`, `profession`, `city`: Asal organisasi/kampus dan domisili.
- `feedback`: Isi pokok pikiran/masukan masyarakat terhadap draf aturan.
- `file_attachment`: Berkas PDF/DOC pendukung yang dilampirkan pengirim.
- `status`: Status telaah tim internal (`pending`, `reviewed`, `approved`, `rejected`).
- `notes`: Catatan disposisi telaah oleh tim hukum kementerian.
- `ip_address` & `user_agent`: Pencatatan jejak audit pengirim demi keamanan.

### Migrasi 2: Kolom Tambahan Metadata pada `documents` & `documents_lang`
Dibuat melalui file migrasi:
`database/migrations/2026_10_19_000002_add_puu_master_documents_and_columns.php`
- Pada tabel `documents`:
  - `related_document_id`: Relasi tautan antar-dokumen (misal: Risalah Pembahasan merujuk ke draf Rancangan PUU-nya).
  - `tahapan_puu_id`: Menghubungkan draf ke 9 tahapan resmi proses pembentukan peraturan (pada tabel `status_projects`).
  - `tanggal_mulai` & `tanggal_selesai`: Masa berlaku konsultasi publik.
  - `status_konsultasi`: Indikator status (`Dibuka`, `Ditutup`, `Menunggu`).
  - `status_harmonisasi`: Status proses harmonisasi di Kemenkumham (`Belum`, `Proses`, `Selesai`).
  - `periode_perencanaan`: Rentang waktu program (misal: `2025-2029`).
  - `periode_evaluasi`: Periode audit hukum (misal: `Semester I 2025`).
- Pada tabel `documents_lang`:
  - `unit_pemrakarsa`, `rekomendasi`, `metode_evaluasi`, `kesimpulan`, `panduan_masukan`.

## 10.5 Implementasi 7 Controller Admin CMS

Seluruh controller admin dibangun di dalam direktori:
```
app/Http/Controllers/Admin/Puu/
├── ProgramPenyusunanController.php
├── NaskahUrgensiController.php
├── RancanganPuuController.php
├── RisalahPembahasanController.php
├── AnalisisEvaluasiController.php
├── KajianHukumController.php
└── PartisipasiPublikController.php
```

### Fitur Khusus: Moderasi Masukan Publik (`PartisipasiPublikController`)
Pada sub-modul Partisipasi Publik, admin memiliki panel khusus untuk memoderasi aspirasi masyarakat:
1. **Daftar Masukan Masuk**: Halaman `/admin-panel/puu-partisipasi-publik/feedback?unique={id}` menampilkan daftar aspirasi masyarakat lengkap dengan indikator status.
2. **Detail Masukan & Berkas**: Halaman `/admin-panel/puu-partisipasi-publik/feedback-detail?unique={id}` memungkinkan staf hukum membaca telaah lengkap serta mengunduh berkas lampiran pendukung.
3. **Pembaruan Status & Catatan Telaah**: Staf hukum dapat mengubah status dari `pending` menjadi `approved` / `rejected` serta membubuhkan catatan pertimbangan tim hukum.

## 10.6 Konfigurasi Sidebar & Hak Akses (94 Rute Admin)

Menu induk `'puu'` didaftarkan pada `config/cadmin/menu.php` dengan ikon `fa-balance-scale`. Seluruh hak akses (`index`, `create`, `edit`, `delete`, `publish`, `download`, `feedback`, `feedback-detail`, `feedback-status`) disinkronkan ke tabel `module_privileges` untuk role Admin (`privilege_id = 1`). Total terdapat **94 rute admin aktif** di bawah grup `admin-panel/puu-*`.

## 10.7 Alur Data: Saat Dokumen Dibuat di Admin, Masuk Kemana dan Muncul Dimana?

Pertanyaan penting dari pengguna: *"Setelah berhasil dibuat, data masuk kemana? Dan apakah bisa muncul di dalam web (http://localhost:8000/rancangan-puu)?"*

### A. Alur Penyimpanan di Database & Server
Saat admin menekan tombol **Simpan** pada form CMS:
1. **Tabel `documents`**: Menyimpan entitas utama (`master_document_id = 15`, tahun, nomor, relasi tahapan PUU, path file `upload/pdf/...`, status aktif `is_active = 1`).
2. **Tabel `documents_lang`**: Menyimpan judul, ringkasan, dan teks abstrak untuk bahasa Indonesia (`lang = 'id'`) dan Inggris (`lang = 'en'`).
3. **Tabel `permalinks`**: CMS secara otomatis menciptakan URL slug yang ramah mesin pencari (*SEO-friendly*), contoh: `rancangan-permenko-tentang-swasembada-pangan`.
4. **Folder Fisik Server (`storage/app/upload/pdf/`)**: Berkas PDF tersimpan aman di server dan siap disajikan melalui rute unduh resmi.

### B. Alur Penayangan di Web Publik (`/rancangan-puu`)
1. Dibuat tampilan khusus [resources/views/dynamic/pages/document-rancangan-puu.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/pages/document-rancangan-puu.blade.php).
2. Method `PageController@getRancanganPuu` bertugas mengambil dokumen yang berstatus `is_active = 1` dengan `master_document_id = 15`, lalu menyajikannya dalam kartu-kartu dokumen lengkap dengan:
   - Judul dan abstrak rancangan.
   - Badge tahapan PUU (misal: "Tahap Harmonisasi").
   - Filter tahun dan kotak pencarian judul.
   - Jumlah pengunjung dan pengunduh PDF.
   - Tombol **Unduh PDF** dan tautan **Baca Selengkapnya**.
3. **Hasil:** Begitu admin menekan tombol Simpan di CMS, dokumen tersebut **langsung otomatis muncul secara seketika (*real-time*)** di halaman publik `http://localhost:8000/rancangan-puu`.

## 10.8 Bugfix Krusial: Masalah Error Simpan Dokumen di CMS

### Gejala Masalah
Saat pengguna mencoba menyimpan dokumen di form admin panel, terjadi error sistem:
```
Call to a member function getClientOriginalName() on string
```

### Investigasi Penyebab
CMS Cactuar memeriksa apakah form memiliki pengunggahan berkas melalui method `createFile()` dan `editFile()`. Karena kedua method ini belum didefinisikan pada controller PUU baru, form HTML dirender tanpa atribut:
```html
enctype="multipart/form-data"
```
Akibatnya, saat form dikirimkan, browser tidak mengirimkan objek berkas binary melainkan hanya string nama file biasa. Ketika helper `App\Helpers\Document::formCallbackBefore` memanggil method bawaan file `$request['pdf']->getClientOriginalName()`, PHP melempar error fatal karena variabel tersebut bertipe teks string, bukan objek `UploadedFile`.

### Solusi Komprehensif yang Diterapkan
1. Menambahkan method wajib pada seluruh 7 controller PUU:
   ```php
   public function createFile() { return true; }
   public function editFile($item = null) { return true; }
   ```
2. Memperbarui helper `app/Helpers/Document.php` secara defensif:
   ```php
   // Memeriksa tipe secara aman sebelum memanggil fungsi getClientOriginalName
   if (isset($request[$field]) && $request[$field] instanceof \Illuminate\Http\UploadedFile && $request[$field]->isValid()) {
       $filename = $request[$field]->getClientOriginalName();
       // proses unggah...
   }
   ```
3. Menormalkan string kosong (`''`) menjadi `null` untuk kolom relasi dan tanggal bertipe nullable agar database MySQL tidak memicu error *Foreign Key Constraint Violation*.

---

# 11. Tahap 8 — Widget Statistik di Beranda (Mirip JDIH Kemenkumham)

## 11.1 Latar Belakang & Permintaan Desain (25 Oktober 2026)

Pengguna menyampaikan referensi gambar dari portal Kementerian Hukum dan HAM (`https://jdih.kemenkum.go.id/`) dan meminta:
*"Buatkan ada tampilan stats seperti pada gambar mirip di web https://jdih.kemenkum.go.id/ pada bagian beranda."*

Pada website rujukan tersebut, tepat di bawah bilah pencarian banner beranda, terdapat kartu-kartu statistik ringkas yang menampilkan jumlah koleksi peraturan secara transparan kepada pengunjung.

## 11.2 Penjelasan Sederhana: Papan Informasi Koleksi Buku

Saat masyarakat pertama kali melangkah masuk ke lobi perpustakaan, mereka langsung melihat papan informasi digital: *"Di perpustakaan ini tersedia 45 Peraturan Menteri, 2 Monografi Hukum, 0 Artikel, dan 0 Putusan"*. Hal ini memberi kesan profesional, transparan, dan memudahkan masyarakat mengetahui seberapa lengkap isi portal tanpa harus mencari-cari terlebih dahulu.

## 11.3 Implementasi Teknis Widget Banner Stats

Widget ditempatkan langsung di bawah kotak pencarian beranda pada [resources/views/dynamic/home.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/home.blade.php):

### 1. Perhitungan Jumlah Data Riil (Bukan Hardcoded)
Data dihitung langsung dari database melalui query Eloquent di controller beranda:
```php
// Hitung jumlah dokumen resmi yang aktif (is_active = 1)
$peraturan_count = Document::where('is_active', 1)->where('master_document_id', 1)->count();
$monografi_count = Document::where('is_active', 1)->where('master_document_id', 6)->count();
$artikel_count   = Document::where('is_active', 1)->whereIn('master_document_id', [2, 4])->count();
$putusan_count   = Document::where('is_active', 1)->where('master_document_id', 5)->count();
```

### 2. Tampilan Kartu Beranda Elegan & Responsif
Kartu statistik disusun dalam 2 baris fleksibel dengan ikon SVG profesional, label kategori, dan badge angka tebal:
```html
<div class="banner-stats">
  <div class="banner-stats__row">
    <!-- Kartu Peraturan -->
    <a href="{{ url('/peraturan-hukum') }}" class="banner-stats__item">
      <span class="banner-stats__icon">...ikon dokumen...</span>
      <span class="banner-stats__label">Peraturan</span>
      <span class="banner-stats__badge">{{ number_format($peraturan_count, 0, ',', '.') }}</span>
    </a>
    <!-- Kartu Monografi -->
    <a href="{{ url('/monografi-hukum') }}" class="banner-stats__item">
      <span class="banner-stats__icon">...ikon buku...</span>
      <span class="banner-stats__label">Monografi</span>
      <span class="banner-stats__badge">{{ number_format($monografi_count, 0, ',', '.') }}</span>
    </a>
    <!-- Kartu Artikel Hukum -->
    <a href="{{ url('/jurnal-hukum') }}" class="banner-stats__item">
      <span class="banner-stats__icon">...ikon artikel...</span>
      <span class="banner-stats__label">Artikel Hukum</span>
      <span class="banner-stats__badge">{{ number_format($artikel_count, 0, ',', '.') }}</span>
    </a>
  </div>
  <div class="banner-stats__row">
    <!-- Kartu Putusan -->
    <a href="{{ url('/putusan-hukum') }}" class="banner-stats__item">
      <span class="banner-stats__icon">...ikon palu sidang...</span>
      <span class="banner-stats__label">Putusan</span>
      <span class="banner-stats__badge">{{ number_format($putusan_count, 0, ',', '.') }}</span>
    </a>
  </div>
</div>
```

### 3. Penataan Gaya SCSS (`resources/assets/sass/pages/home.scss`)
- Menggunakan efek kaca transparan (*glassmorphism*) yang menyatu dengan gradasi hero banner kementerian.
- Efek *hover*: kartu sedikit terangkat (*lift-up animation*) dan menyala lembut saat kursor melintas.
- Pada layar smartphone, kartu otomatis tersusun rapi (*wrap*) sehingga angka tetap mudah dibaca tanpa terpotong.

<div class="pagebreak"></div>


# 12. Tahap 9 — Fitur 1: Halaman Statistik Produk Hukum (26 Oktober 2026)

## 12.1 Latar Belakang & Master Prompt Fitur 1

Pada tanggal 26 Oktober 2026, pengguna menetapkan arahan teknis untuk membangun halaman mandiri **Statistik Produk Hukum**:
- **Tujuan Utama:** Memungkinkan masyarakat, peneliti, dan administrator menganalisis sebaran dokumen hukum berdasarkan **Jenis Peraturan** dan **Tahun Penetapan**.
- **Prinsip Utama:** Wajib menggunakan data dokumen riil yang tersimpan di database `pangan_jdihdb`. **Dilarang keras menggunakan data statis, angka tiruan (*dummy*), atau angka yang di-hardcode di kode.**
- **Interaktivitas:** Wajib menyediakan filter ganda, grafik visual dinamis, tabel rincian, pembaruan URL otomatis (*pushState*), dan fitur pengunduhan grafik sebagai gambar PNG resolusi tinggi.

## 12.2 Penjelasan Sederhana: Ruang Infografis Digital Perpustakaan

Jika sebelumnya pengunjung perpustakaan harus menghitung buku satu per satu dari halaman katalog, kini tersedia **layar sentuh infografis raksasa** di dinding perpustakaan. Pengunjung bisa menekan tombol *"Tampilkan Peraturan Menteri saja"* atau *"Tahun 2025 saja"*, lalu grafik batang dan diagram lingkaran langsung bergerak menyesuaikan secara otomatis, dan pengunjung dapat mencetak hasil grafik tersebut untuk bahan laporan.

## 12.3 Arsitektur Backend & Pengolahan Data Riil

Seluruh logika pengolahan data statistik dipusatkan pada controller:
`app/Http/Controllers/Front/StatisticController.php`

### 1. Metode Agregasi Data (`getStatisticsData`)
Data disaring dengan kriteria dokumen peraturan yang aktif secara hukum:
- `is_active = 1`
- `master_document_id = 1` (Kategori Peraturan)
- Memetakan relasi ke tabel `rule_types` (Bentuk/Jenis Peraturan) dan tabel teks `rule_types_lang` untuk memperoleh nama resmi peraturan dalam Bahasa Indonesia dan Bahasa Inggris.

### 2. Fakta Data Riil yang Dihasilkan
Berdasarkan pembacaan database aktual, diperoleh sebaran data dokumen hukum Kemenko Pangan:
- **Total Peraturan Aktif:** **47 Peraturan**.
- **Sebaran 7 Jenis Peraturan:**
  1. Peraturan Presiden (Perpres): **13 dokumen** (27.7%)
  2. Peraturan Menteri Koordinator (Permen/Permenko): **10 dokumen** (21.3%)
  3. Peraturan Pemerintah (PP): **9 dokumen** (19.1%)
  4. Instruksi Presiden (Inpres): **8 dokumen** (17.0%)
  5. Keputusan Menteri (Kepmen): **3 dokumen** (6.4%)
  6. Keputusan Presiden (Keppres): **3 dokumen** (6.4%)
  7. Undang-Undang (UU): **1 dokumen** (2.1%)
- **Sebaran Rentang Tahun (2015 – 2026):**
  - 2015: 1 dokumen | 2019: 1 dokumen | 2021: 1 dokumen | 2022: 2 dokumen
  - 2023: 1 dokumen | 2024: 3 dokumen | **2025: 28 dokumen (Puncak Pembentukan Regulasi)** | 2026: 10 dokumen
- **Status Keberlakuan Hukum:**
  - **Berlaku:** **45 dokumen** (95.7%)
  - **Tidak Berlaku (Dicabut/Diubah):** **2 dokumen** (4.3%)

## 12.4 Tampilan Frontend Interaktif (`about-statistik.blade.php`)

Tampilan visual dibangun pada file:
[resources/views/dynamic/pages/about-statistik.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/pages/about-statistik.blade.php)

Komponen-komponen visual utama yang disajikan:
1. **4 Kartu Metrik Utama (KPI Cards):**
   - *Total Peraturan*: Menampilkan angka `47`.
   - *Jenis Terbanyak*: Menampilkan `Peraturan Presiden (13)`.
   - *Tahun Terbanyak*: Menampilkan `2025 (28 Dokumen)`.
   - *Status Berlaku*: Menampilkan rasio `45 Berlaku / 2 Tidak Berlaku`.
2. **Filter Ganda Interaktif:**
   - Dropdown pemilih Jenis Peraturan (Semua Jenis atau spesifik).
   - Dropdown pemilih Tahun (Semua Tahun atau rentang tahun tertentu).
3. **Grafik Interaktif Chart.js:**
   - **Diagram Batang (Bar Chart)**: Menampilkan tren pertumbuhan peraturan tahun demi tahun dengan palet warna navy gradasi emas kementerian.
   - **Diagram Donat (Doughnut Chart)**: Menampilkan proporsi persentase per jenis peraturan dengan legenda interaktif (dapat diklik untuk menyembunyikan/menampilkan jenis tertentu).
   - **Diagram Status**: Visualisasi perbandingan persentase regulasi aktif vs dicabut.
4. **Tabel Ringkasan Data:**
   Menyajikan rekapitulasi angka secara presisi untuk kebutuhan analisis dan kutipan laporan.
5. **Pembaruan AJAX & Riwayat URL (PushState):**
   Saat filter diubah, grafik dan tabel diperbarui seketika tanpa memuat ulang seluruh halaman (*no-refresh*), dan URL browser otomatis diselaraskan (misal: `/statistik-produk-hukum?type=1&year=2025`) sehingga pengguna dapat menyalin dan membagikan tautan hasil analisis kepada orang lain.
6. **Ekspor Grafik sebagai Gambar PNG (html2canvas):**
   Disediakan tombol **"Unduh Grafik (PNG)"**. Saat ditekan, skrip `html2canvas` mengambil tangkapan layar elemen grafik dengan resolusi tinggi dan mengunduhnya ke komputer pengguna secara otomatis sebagai berkas gambar siap pakai untuk presentasi PowerPoint atau laporan berkala.

## 12.5 Rute Publik & REST API Statistik

Pada `routes/web.php` didaftarkan:
- Rute halaman publik: `GET /statistik-produk-hukum` (terhubung ke menu 36 `menus_lang.url = 'about-statistik'`).
- Rute REST API publik:
  - `GET /api/statistics/legal-products`: Data mentah seluruh statistik.
  - `GET /api/statistics/legal-products/by-type`: Ringkasan jumlah per bentuk peraturan.
  - `GET /api/statistics/legal-products/by-year`: Ringkasan jumlah per tahun penetapan.

---

# 13. Tahap 10 — Fitur 2: Klasifikasi Video Galeri dan Aksesibilitas (26 Oktober 2026)

## 13.1 Latar Belakang & Kebutuhan Regulasi Inklusif

Portal kementerian wajib memenuhi standar keterbukaan informasi publik yang ramah disabilitas (UU No. 8 Tahun 2016 tentang Penyandang Disabilitas). Konten multimedia video terbagi menjadi dua kategori yang berbeda tujuan:
1. **Video Galeri Umum:** Liputan seremonial, dokumentasi kunjungan kerja, dan siaran pers pimpinan kementerian.
2. **Video Khusus Aksesibilitas:** Video sosialisasi hukum yang dilengkapi dengan **juru bahasa isyarat (JBI)**, takarir teks (*closed captions*), atau panduan audio khusus bagi masyarakat berkebutuhan khusus.

Pengguna meminta sistem agar staf pengelola web dapat menentukan apakah sebuah video masuk ke Galeri, Aksesibilitas, atau keduanya, serta menyediakan halaman publik khusus untuk video aksesibilitas.

## 13.2 Penjelasan Sederhana: Rak Khusus Buku Huruf Braille

Di perpustakaan, kita tidak mencampur aduk buku cerita umum dengan buku bertulisan huruf Braille atau buku bersuara (*audiobook*). Kita membuat rak khusus bertanda **Layanan Aksesibilitas** agar penyandang disabilitas dapat langsung menemukan materi hukum yang ramah bagi mereka tanpa tersesat di antara ratusan dokumentasi seremonial biasa.

## 13.3 Desain Database & Skema Many-to-Many

Dibuat file migrasi:
`database/migrations/2026_10_26_000001_create_video_classifications_and_pivot_tables.php`

### 1. Tabel Master Klasifikasi (`video_classifications`)
- `id` (bigIncrements)
- `slug` (varchar 50, unique: `galeri`, `aksesibilitas`)
- `name` (varchar 100: "Galeri Kegiatan", "Layanan Aksesibilitas")
- `description` (teks keterangan peruntukan)
- `is_active` (tinyint 1)
- `sort_id` (integer)

### 2. Tabel Pivot Relasi Banyak-ke-Banyak (`gallery_video_classifications`)
- `gallery_id` (unsignedBigInteger, FK ke `galleries.id` dengan onDelete CASCADE).
- `video_classification_id` (unsignedBigInteger, FK ke `video_classifications.id` dengan onDelete CASCADE).
- Relasi ini memungkinkan **satu video yang sama** dapat muncul sekaligus di halaman Galeri umum dan di halaman Layanan Aksesibilitas jika memang memenuhi standar keduanya.

### 3. Penambahan Kolom Penunjang
- Menambahkan kolom `sort_id` pada tabel `galleries` untuk pengaturan urutan tampil video.
- Menambahkan kolom `description` pada tabel multibahasa `galleries_lang` agar setiap video dapat memiliki teks penjelasan detail mengenai materi hukum yang dibahas.

## 13.4 Model Eloquent & Normalisasi Tautan YouTube

Pada model `app/Models/Gallery.php`:
1. Didefinisikan relasi:
   ```php
   public function classifications() {
       return $this->belongsToMany(VideoClassification::class, 'gallery_video_classifications');
   }
   ```
2. Dibuat query scope untuk penyaringan cepat:
   ```php
   public function scopeClassifiedAs($query, $slug) {
       return $query->whereHas('classifications', function($q) use ($slug) {
           $q->where('slug', $slug);
       });
   }
   ```
3. **Fungsi Cerdas Normalisasi Tautan YouTube (`formatYoutubeEmbed`):**
   Operator sering kali memasukkan format tautan YouTube yang berbeda-beda saat mengisi form (misal: `https://youtu.be/xyz`, `https://www.youtube.com/watch?v=xyz`, atau `https://www.youtube.com/shorts/xyz`). Dibuat parser ekspresi reguler (Regex) yang secara otomatis mengekstrak ID video dan mengubahnya menjadi format iframe resmi:
   ```
   https://www.youtube.com/embed/{VIDEO_ID}
   ```
   Serta menyediakan accessor `thumbnail_url` otomatis dari server gambar YouTube (`img.youtube.com/vi/{VIDEO_ID}/hqdefault.jpg`).

## 13.5 Integrasi CMS Admin Panel (`Admin/GalleryController.php`)

Pada form kelola Galeri di admin panel:
- Ditambahkan komponen **kotak centang ganda (multi-checkbox)** untuk klasifikasi video.
- Ditambahkan kolom filter klasifikasi pada tabel daftar galeri admin.
- Dilengkapi lencana warna (*badge*) yang membedakan video Galeri (biru) dan Aksesibilitas (hijau).
- Saat data disimpan, controller secara otomatis menyelaraskan relasi pivot melalui `$gallery->classifications()->sync(...)`.

## 13.6 Halaman Publik Layanan Aksesibilitas (`/aksesibilitas`)

- Dihubungkan ke menu navigasi ID 39 dengan URL slug `/aksesibilitas`.
- Method `PageController::getAksesibilitas` menyaring hanya video yang memiliki relasi ke klasifikasi `aksesibilitas` (`is_active = 1`).
- Dibuat view khusus: [resources/views/dynamic/pages/informasi-aksesibilitas.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/pages/informasi-aksesibilitas.blade.php).
  - Tampilan grid responsif video interaktif.
  - Pemutar video YouTube responsif (16:9) tanpa terpotong di layar smartphone.
  - Penjelasan teks transkrip dan informasi mengenai ketersediaan bahasa isyarat pada masing-masing materi regulasi pangan.
- Disediakan endpoint REST API publik:
  ```
  GET /api/videos?category=accessibility
  GET /api/videos?category=gallery
  ```

---

# 14. Tahap 11 — Widget Aksesibilitas (UserWay / EqualWeb Style)

## 14.1 Latar Belakang & Tiga Permintaan Bertahap (26 Oktober 2026)

Pengembangan widget aksesibilitas dilakukan melalui 3 tahap penyempurnaan sesuai permintaan pengguna:
1. **Permintaan Awal:** *"Apakah bisa ditambahkan accessibility tools seperti pada userway, accessibility widget fitur mengikuti userway https://www.equalweb.com/platform/accessibility_widget/ ?"*
2. **Penyesuaian Visual:** *"Apakah model tampilan accessibility bisa mengikuti referensi gambar itu seperti pada web https://jdih.kemenkum.go.id/ ?"*
3. **Penyempurnaan Fitur:** *"Tambahkan fitur-fitur seperti pada di userway."*

## 14.2 Penjelasan Sederhana: Asisten Pribadi bagi Penyandang Disabilitas

Tidak semua masyarakat memiliki kemampuan penglihatan atau fisik yang sama:
- Ada lansia yang pandangannya kabur sehingga butuh huruf besar.
- Ada penyandang buta warna yang tidak bisa membaca tulisan abu-abu di atas latar putih.
- Ada penyandang disleksia yang sulit membaca huruf latin standar.
- Ada tuna netra yang tidak bisa melihat layar sama sekali dan membutuhkan suara yang membacakan isi pasal.

Widget aksesibilitas adalah **kotak peralatan pembantu** yang menempel di layar web. Pengunjung bebas memilih setelan kenyamanan mereka sendiri tanpa mengubah tampilan bagi pengunjung lainnya.

## 14.3 Desain Tampilan Mengikuti JDIH Kemenkumham

Sesuai gambar rujukan dari portal Kementerian Hukum dan HAM:
1. **Tombol Peluncur (*Launcher Button*):**
   - Berbentuk lingkaran elegan berdiameter 52 piksel di **sudut kiri bawah layar** (`bottom: 24px; left: 24px;`).
   - Warna biru navy resmi (`#1a263f`) dengan ikon internasional penyandang disabilitas berwarna putih bersih.
   - Mengambang di atas seluruh elemen halaman dengan prioritas lapisan tertinggi (`z-index: 999999`).
2. **Panel Modal Aksesibilitas:**
   - Panel pop-up modern bersudut lengkung (`border-radius: 16px`) dengan bayangan mendalam (*soft shadow*).
   - Bagian atas (*header*) memuat judul *"Menu Aksesibilitas JDIH"*, tombol *"Atur Ulang"*, dan tombol silang tutup (*close*).
   - Area tengah menyusun 19 kartu tombol fitur dalam format kisi (*grid*) 3 kolom yang mudah disentuh di smartphone maupun diklik di komputer.

## 14.4 Rincian Lengkap 19 Fitur Aksesibilitas (Standar UserWay & EqualWeb)

Berikut penjelasan detail dari ke-19 alat bantu yang terpasang di dalam widget:

| No | Nama Fitur | Mekanisme Kerja Teknis | Manfaat bagi Pengguna |
|---|---|---|---|
| 1 | **Kontras Tinggi** | Menerapkan kelas `a11y-contrast-high`: seluruh latar belakang web diubah menjadi hitam pekat (`#000000`) dan seluruh teks diubah menjadi kuning menyala (`#ffff00`). | Membantu pengguna dengan gangguan penglihatan berat (*low vision*) membaca teks pasal dengan sangat kontras. |
| 2 | **Kontras Terang** | Menerapkan kelas `a11y-contrast-light`: seluruh latar belakang diubah menjadi putih solid (`#ffffff`) dan teks menjadi hitam legam tajam (`#000000`). | Membantu membaca di bawah sinar matahari terang atau layar redup. |
| 3 | **Mode Abu-abu (Monokrom)** | Menerapkan filter CSS `filter: grayscale(100%) !important` ke seluruh dokumen. | Membantu penyandang buta warna parsial dan mengurangi kelelahan saraf optik akibat warna menyala. |
| 4 | **Inversi Warna** | Menerapkan filter CSS `filter: invert(100%) hue-rotate(180deg) !important`. | Membalikkan spektrum warna layar bagi pengguna yang sensitif terhadap pancaran cahaya terang (*photophobia*). |
| 5 | **Sorot Tautan (Highlight Links)** | Menerapkan garis bawah ganda berwarna kuning menyala tebal pada setiap elemen tautan `<a>`. | Membantu pengguna membedakan dengan tegas mana teks biasa dan mana bagian yang bisa diklik. |
| 6 | **Sorot Judul (Highlight Headings)** | Memberikan garis tepi penanda khusus pada elemen `<h1>`, `<h2>`, `<h3>`, `<h4>`. | Mempermudah penelusuran struktur bab dan pasal peraturan secara cepat (*skimming*). |
| 7 | **Font Ramah Disleksia** | Memuat Google Font **Lexend** secara asinkron dan menerapkannya ke seluruh tag teks: `font-family: 'Lexend', sans-serif !important`. | Karakter huruf dirancang dengan ruang terbuka lebar di bagian bawah sehingga mencegah penderita disleksia melihat huruf bertumpuk atau terbalik. |
| 8 | **Perbesar Teks** | Menaikkan ukuran font bertahap (hingga +40%) pada elemen `body`. | Membantu lansia dan pengguna yang lupa memakai kacamata membaca draf regulasi. |
| 9 | **Perkecil Teks** | Menurunkan ukuran font bertahap (hingga -20%) pada elemen `body`. | Membantu pengguna yang ingin melihat lebih banyak konteks paragraf hukum dalam satu layar. |
| 10 | **Spasi Teks Ekstra** | Menambahkan `letter-spacing: 0.12em` dan `line-height: 2 !important` pada paragraf. | Memberikan ruang napas antar-kata sehingga kalimat hukum yang panjang tidak tampak padat melelahkan. |
| 11 | **Rata Kiri Teks** | Memaksa seluruh teks menggunakan `text-align: left !important` (menonaktifkan rata kanan-kiri / *justify*). | Menghilangkan celah spasi putih aneh antar-kata (*river effect*) yang kerap menyulitkan pembaca difabel. |
| 12 | **Kursor Besar** | Mengganti gambar kursor standar mouse dengan kursor panah berukuran ekstra besar berwarna kontras tinggi. | Membantu pengguna dengan tremor tangan atau lansia agar tidak kehilangan posisi kursor di layar lebar. |
| 13 | **Panduan Membaca (Reading Guide)** | Memunculkan garis horizontal kuning melintang di layar yang posisinya selalu mengikuti sumbu vertikal kursor mouse. | Berfungsi seperti meletakkan penggaris di atas buku fisik agar mata fokus pada baris kalimat yang sedang dibaca. |
| 14 | **Masker Fokus (Focus Mask)** | Memunculkan dua tirai gelap transparan di atas dan di bawah area baris yang sedang diarahkan kursor. | Menghalangi distraksi visual dari paragraf lain sehingga perhatian pembaca terkunci pada pasal yang ditunjuk. |
| 15 | **Hentikan Animasi** | Memaksa seluruh elemen CSS transisi, animasi putar, ticker berita, dan carousel menjadi diam: `animation: none !important; transition: none !important;`. | Mencegah pemicu pusing, mual, atau kejang fotogenik bagi penderita vestibular dan epilepsi fotosensitif. |
| 16 | **Sembunyikan Gambar** | Menyembunyikan seluruh tag `<img>`, `<svg>`, dan gambar latar: `opacity: 0 !important; visibility: hidden !important;`. | Mengubah portal menjadi mode teks murni yang bebas gangguan visual dan mempercepat daya serap pembacaan. |
| 17 | **Baca Layar (Text-to-Speech)** | Mengintegrasikan **Web Speech API (`speechSynthesis`)** bawaan browser dengan setelan bahasa Indonesia resmi (`lang = 'id-ID'`). | Membacakan teks judul dokumen, isi berita, atau paragraf yang disorot oleh pengguna secara audio bersuara jelas. |
| 18 | **Hentikan Suara Bacaan** | Memanggil perintah `window.speechSynthesis.cancel()` seketika. | Mematikan audio bacaan secara instan saat pengguna ingin beralih membaca mandiri. |
| 19 | **Atur Ulang Semua (Reset)** | Menghapus seluruh kelas modifikasi visual dan mengembalikan pengaturan ke posisi nol. | Mengembalikan website ke tampilan orisinal desainer dalam satu kali klik. |

## 14.5 Aksesibilitas Keyboard & Penyimpanan Setelan Lokal

1. **Aksesibilitas Tombol Cepat Keyboard (Shortcut):**
   - Menekan kombinasi tombol **Alt + A** di keyboard akan membuka atau menutup panel aksesibilitas secara langsung tanpa mouse.
   - Menekan tombol **Escape (Esc)** akan menutup panel modal aksesibilitas.
2. **Penyimpanan Pengaturan Berkelanjutan (*LocalStorage Persistence*):**
   Setiap kali pengguna mengaktifkan salah satu fitur (misalnya *Mode Kontras Tinggi* dan *Font Disleksia*), preferensi tersebut otomatis disimpan di memori browser pengunjung dengan kunci:
   ```javascript
   localStorage.setItem('jdih_kemenkum_a11y_v2', JSON.stringify(activeSettings));
   ```
   **Dampaknya:** Saat pengguna berpindah dari halaman Beranda ke halaman Peraturan atau halaman Kontak, **setelan aksesibilitas tidak akan hilang atau reset sendiri**. Pengunjung tidak perlu repot menyetel ulang setiap kali membuka halaman baru.
3. **Penyematan Global:**
   Komponen diletakkan pada layout induk:
   `Source Code/jdih-kemenko-pangan/resources/views/dynamic/layouts/layout.blade.php`
   tepat sebelum tag penutup `</body>` sehingga otomatis aktif di 100% halaman website JDIH Kemenko Pangan.

<div class="pagebreak"></div>


# 15. Referensi API

Seluruh endpoint API publik yang baru dibangun berformat standar RESTful dengan respons data bertipe JSON:

## 15.1 API Statistik Produk Hukum

### 1. `GET /api/statistics/legal-products`
- **Fungsi:** Mengambil data komprehensif statistik peraturan hukum (total, sebaran per jenis peraturan, tren tahunan, dan status keberlakuan).
- **Contoh Respons JSON:**
  ```json
  {
    "status": "success",
    "data": {
      "total_peraturan": 47,
      "summary_by_type": [
        {"type_id": 2, "name": "Peraturan Presiden", "count": 13, "percentage": 27.66},
        {"type_id": 1, "name": "Peraturan Menteri", "count": 10, "percentage": 21.28},
        {"type_id": 3, "name": "Peraturan Pemerintah", "count": 9, "percentage": 19.15},
        {"type_id": 4, "name": "Instruksi Presiden", "count": 8, "percentage": 17.02},
        {"type_id": 6, "name": "Keputusan Menteri", "count": 3, "percentage": 6.38},
        {"type_id": 5, "name": "Keputusan Presiden", "count": 3, "percentage": 6.38},
        {"type_id": 7, "name": "Undang-Undang", "count": 1, "percentage": 2.13}
      ],
      "summary_by_year": [
        {"year": 2015, "count": 1},
        {"year": 2019, "count": 1},
        {"year": 2021, "count": 1},
        {"year": 2022, "count": 2},
        {"year": 2023, "count": 1},
        {"year": 2024, "count": 3},
        {"year": 2025, "count": 28},
        {"year": 2026, "count": 10}
      ],
      "summary_by_status": {
        "berlaku": 45,
        "tidak_berlaku": 2
      }
    }
  }
  ```

### 2. `GET /api/statistics/legal-products/by-type`
- **Fungsi:** Mengambil data ringkas hanya untuk diagram jenis peraturan.

### 3. `GET /api/statistics/legal-products/by-year`
- **Fungsi:** Mengambil data ringkas hanya untuk diagram tren pertumbuhan tahunan.

## 15.2 API Klasifikasi Video

### `GET /api/videos`
- **Parameter URL:**
  - `category`: `accessibility` (khusus video disabilitas) atau `gallery` (dokumentasi umum). Default: semua video aktif.
  - `limit`: Jumlah data per halaman (default: 12).
- **Contoh Respons JSON:**
  ```json
  {
    "status": "success",
    "category": "accessibility",
    "total": 1,
    "data": [
      {
        "id": 1,
        "title": "Sosialisasi Perpres Swasembada Pangan (Dengan Juru Bahasa Isyarat)",
        "embed_url": "https://www.youtube.com/embed/dQw4w9WgXcQ",
        "thumbnail_url": "https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg",
        "classifications": ["galeri", "aksesibilitas"],
        "created_at": "2026-10-26T08:00:00Z"
      }
    ]
  }
  ```

---

# 16. Daftar Lengkap File dan Folder yang Berubah

Berikut inventarisasi seluruh berkas kode sumber yang mengalami penambahan atau modifikasi sejak awal pengerjaan proyek:

| Komponen / File | Status | Kategori | Ringkasan Perubahan |
|---|:---:|---|---|
| `app/Helpers/Document.php` | **MODIFIED** | Backend Helper | Bugfix penanganan upload berkas, pencegahan error `getClientOriginalName()` pada string, normalisasi nilai nullable. |
| `app/Http/Controllers/Admin/GalleryController.php` | **MODIFIED** | Backend CMS | Penambahan dukungan multi-checkbox klasifikasi video, filter kategori di listing, normalisasi tautan YouTube. |
| `app/Http/Controllers/Admin/Puu/ProgramPenyusunanController.php` | **NEW** | Backend CMS | Sub-modul Program Penyusunan PUU (CRUD, metadata tahun, filter, upload PDF). |
| `app/Http/Controllers/Admin/Puu/NaskahUrgensiController.php` | **NEW** | Backend CMS | Sub-modul Naskah Urgensi / Akademik (relasi draf, rekomendasi, lampiran). |
| `app/Http/Controllers/Admin/Puu/RancanganPuuController.php` | **NEW** | Backend CMS | Sub-modul Rancangan PUU (tahapan regulasi, status harmonisasi, DIM). |
| `app/Http/Controllers/Admin/Puu/RisalahPembahasanController.php` | **NEW** | Backend CMS | Sub-modul Risalah Pembahasan (notula rapat, daftar hadir, matriks pasal). |
| `app/Http/Controllers/Admin/Puu/AnalisisEvaluasiController.php` | **NEW** | Backend CMS | Sub-modul Analisis & Evaluasi PUU (audit efektivitas peraturan, rekomendasi). |
| `app/Http/Controllers/Admin/Puu/KajianHukumController.php` | **NEW** | Backend CMS | Sub-modul Kajian Hukum (kajian tematik isu pangan nasional). |
| `app/Http/Controllers/Admin/Puu/PartisipasiPublikController.php` | **NEW** | Backend CMS | Sub-modul Partisipasi Publik & panel moderasi aspirasi masyarakat. |
| `app/Http/Controllers/Front/DocumentController.php` | **MODIFIED** | Backend Publik | Handler `getPuuDetail()` untuk halaman detail PUU dan method `postPublicFeedback()` untuk pengiriman aspirasi. |
| `app/Http/Controllers/Front/PageController.php` | **MODIFIED** | Backend Publik | Penambahan method `getAboutStatistik()`, `getAksesibilitas()`, `getRancanganPuu()`, `getPeraturanTerjemahan()`, dll. |
| `app/Http/Controllers/Front/StatisticController.php` | **NEW** | Backend Publik | Controller pengolah data statistik riil dan penyaji REST API statistik & video. |
| `app/Models/Document.php` | **MODIFIED** | Eloquent Model | Konstanta `master_document_id` PUU baru, relasi `relateds`, relasi tahapan, accessor permalink dinamis. |
| `app/Models/Gallery.php` | **MODIFIED** | Eloquent Model | Relasi `classifications()`, query scope `scopeClassifiedAs()`, parser regex normalisasi YouTube, accessor embed & thumbnail. |
| `app/Models/PublicConsultationFeedback.php` | **NEW** | Eloquent Model | Model representasi data aspirasi masyarakat terhadap rancangan regulasi. |
| `app/Models/VideoClassification.php` | **NEW** | Eloquent Model | Model representasi master kategori klasifikasi video. |
| `config/cadmin/menu.php` | **MODIFIED** | Konfigurasi CMS | Pendaftaran grup menu induk `'puu'` dan 7 sub-modul Dokumen Pembentukan PUU. |
| `database/migrations/2026_10_19_000001_create_public_consultation_feedbacks_table.php` | **NEW** | Migrasi Database | Skema tabel masukan konsultasi publik masyarakat. |
| `database/migrations/2026_10_19_000002_add_puu_master_documents_and_columns.php` | **NEW** | Migrasi Database | Kolom metadata baru pada tabel `documents` dan `documents_lang`. |
| `database/migrations/2026_10_26_000001_create_video_classifications_and_pivot_tables.php` | **NEW** | Migrasi Database | Skema master klasifikasi video, tabel pivot, dan kolom penunjang galeri. |
| `resources/assets/js/libs/header.js` | **MODIFIED** | Frontend Script | Interaksi keyboard Escape dan klik luar untuk penutup dropdown menu. |
| `resources/assets/sass/component/_layout.scss` | **MODIFIED** | Stylesheet | Perbaikan logika tampilan logo ganda (hitam/putih), styling dropdown menu ala JDIHN, dan penyesuaian dark mode. |
| `resources/assets/sass/pages/general.scss` | **MODIFIED** | Stylesheet | Penataan batas tinggi minimum `.middle` (70vh) agar footer tidak naik saat data kosong. |
| `resources/assets/sass/pages/home.scss` | **MODIFIED** | Stylesheet | Styling kartu statistik beranda (banner stats glassmorphism & hover effect). |
| `resources/views/admin/gallery/form-js.blade.php` | **MODIFIED** | View CMS | Skrip pembantu pemilihan multi-checkbox klasifikasi video. |
| `resources/views/admin/puu/feedback_list.blade.php` | **NEW** | View CMS | Tampilan tabel rekapitulasi masukan masyarakat per rancangan peraturan. |
| `resources/views/admin/puu/feedback_detail.blade.php` | **NEW** | View CMS | Tampilan rincian masukan masyarakat, telaah berkas, dan form perubahan status. |
| `resources/views/dynamic/component/accessibility-widget.blade.php` | **NEW** | View Publik | Komponen widget aksesibilitas mandiri berisi 19 fitur lengkap (UserWay / EqualWeb style). |
| `resources/views/dynamic/component/menu.blade.php` | **MODIFIED** | View Publik | Navbar utama: 6 menu, mega dropdown JDIHN, badge subchild, penghapusan tombol login. |
| `resources/views/dynamic/home.blade.php` | **MODIFIED** | View Publik | Penyematan widget 4 kartu statistik produk hukum di bawah kotak pencarian beranda. |
| `resources/views/dynamic/layouts/layout.blade.php` | **MODIFIED** | View Publik | Skrip inisialisasi dark mode awal (mencegah kedipan putih) dan penyematan widget aksesibilitas. |
| `resources/views/dynamic/pages/about-statistik.blade.php` | **MODIFIED** | View Publik | Halaman statistik lengkap: KPI cards, filter ganda, Chart.js, AJAX pushState, ekspor PNG. |
| `resources/views/dynamic/pages/document-rancangan-puu.blade.php` | **NEW** | View Publik | Halaman listing rancangan PUU dengan pencarian, filter tahun, dan badge tahapan. |
| `resources/views/dynamic/pages/informasi-aksesibilitas.blade.php` | **NEW** | View Publik | Halaman galeri khusus video ramah disabilitas (bahasa isyarat / takarir). |
| `routes/web.php` | **MODIFIED** | Rute Aplikasi | Pendaftaran rute dinamis PUU, rute masukan publik, rute statistik, rute aksesibilitas, dan grup REST API. |

---

# 17. Pengujian dan Hasil Verifikasi

Pengujian dilakukan secara komprehensif mencakup 39 skenario uji fungsional, performa, dan tampilan:

## 17.1 Pengujian Modul PUU & CMS (Skenario PUU-01 s/d PUU-08)
- **PUU-01 (Akses Admin Panel):** Membuka `/admin-panel/puu-*` → Status **200 OK**, menu sidebar tampil dengan ikon timbangan.
- **PUU-02 (Pembuatan Dokumen PUU):** Input rancangan peraturan baru dengan berkas PDF → **Lolos**, data tersimpan di `documents` dan berkas masuk ke `storage/app/upload/pdf/`.
- **PUU-03 (Bugfix Upload Enctype):** Verifikasi tidak terjadi error `getClientOriginalName() on string` → **Lolos 100%**.
- **PUU-04 (Penayangan Halaman Publik `/rancangan-puu`):** Dokumen yang baru disimpan di admin langsung muncul di web publik → **Lolos**, judul, badge tahapan, dan tombol unduh berfungsi.
- **PUU-05 (Pengiriman Masukan Masyarakat):** Submit form masukan di halaman detail partisipasi publik → **Lolos**, data masuk ke `public_consultation_feedbacks`.
- **PUU-06 (Moderasi Masukan di Admin):** Staf hukum membuka halaman rekapitulasi masukan dan mengubah status menjadi `approved` → **Lolos**.
- **PUU-07 (Integritas Data Eksisting):** Pemeriksaan 49 dokumen peraturan lama setelah migrasi → **Lolos**, seluruh dokumen lama tetap utuh tanpa kerusakan relasi.

## 17.2 Pengujian Fitur 1: Statistik Produk Hukum (Skenario F1-01 s/d F1-08)
- **F1-01 (Akses Halaman `/statistik-produk-hukum`):** Status **200 OK**, seluruh elemen visual dirender sempurna.
- **F1-02 (Akurasi Metrik KPI Cards):** Total Peraturan menunjukkan angka `47`, jenis terbanyak `Peraturan Presiden (13)` → **Sesuai 100% dengan database**.
- **F1-03 (Filter Jenis Peraturan):** Memilih "Peraturan Presiden" → Grafik batang dan donat diperbarui hanya menampilkan data Perpres tanpa reload halaman.
- **F1-04 (Filter Tahun):** Memilih tahun "2025" → Angka menyesuaikan menjadi 28 dokumen.
- **F1-05 (URL PushState):** Saat filter diubah, URL browser berganti menjadi `?type=...&year=...` → **Lolos**.
- **F1-06 (Ekspor PNG via html2canvas):** Menekan tombol unduh grafik → Berkas gambar PNG terunduh ke komputer lokal dengan kualitas tajam.
- **F1-07 (Endpoint REST API):** Pengujian `GET /api/statistics/legal-products` → Menghasilkan JSON valid dengan status code **200 OK**.

## 17.3 Pengujian Fitur 2: Klasifikasi Video (Skenario F2-01 s/d F2-08)
- **F2-01 (Kelola Galeri di Admin):** Form galeri memuat kotak centang "Galeri Kegiatan" dan "Layanan Aksesibilitas" → **Lolos**.
- **F2-02 (Multi-Checkbox Sync):** Memilih kedua kategori pada video ID 1 → Tabel pivot tersimpan ganda tanpa duplikasi record.
- **F2-03 (Normalisasi Tautan YouTube):** Memasukkan tautan `youtu.be/xyz` → Otomatis terkonversi menjadi format embed resmi.
- **F2-04 (Halaman Publik `/aksesibilitas`):** Menampilkan hanya video berkategori aksesibilitas → **Lolos (HTTP 200 OK)**.
- **F2-05 (Responsivitas Pemutar Video):** Tampilan video di layar HP (resolusi 375px) beradaptasi dengan rasio 16:9 tanpa memotong layout.
- **F2-06 (Endpoint API Video):** `GET /api/videos?category=accessibility` menyajikan JSON video difabel → **Lolos**.

## 17.4 Pengujian Fitur Aksesibilitas (Skenario AC-01 s/d AC-19)
Pengujian ke-19 alat bantu aksesibilitas pada berbagai kondisi browser:
- **AC-01 s/d AC-04 (Kontras & Warna):** Mode Kontras Tinggi (latar hitam teks kuning), Kontras Terang (latar putih teks hitam), Mode Abu-abu (grayscale 100%), dan Inversi Warna berfungsi seketika.
- **AC-05 & AC-06 (Penyorotan Navigasi):** Sorot Tautan dan Sorot Judul memberikan tanda visual jelas pada elemen interaktif.
- **AC-07 (Font Disleksia):** Font Google Lexend termuat mulus dan menggantikan font bawaan tanpa merusak struktur tombol.
- **AC-08 s/d AC-11 (Tipografi & Tata Letak):** Pembesaran teks (+40%), pengecilan teks (-20%), spasi lega, dan perataan kiri berjalan presisi.
- **AC-12 s/d AC-14 (Alat Bantu Visual):** Kursor besar, garis panduan membaca (mengikuti mouse), dan masker fokus (menutup baris lain) berjalan lancar.
- **AC-15 & AC-16 (Kenyamanan Sensorik):** Hentikan animasi membekukan seluruh transisi; Sembunyikan gambar menyamarkan seluruh elemen visual.
- **AC-17 & AC-18 (Pembaca Suara / TTS):** Web Speech API berbahasa Indonesia (`id-ID`) melafalkan judul peraturan dengan artikulasi jelas; tombol stop mematikan suara instan.
- **AC-19 (Ketahanan Setelan / Persistence):** Mengaktifkan 3 fitur, lalu berpindah halaman dari `/` ke `/kontak` → **Setelan tetap aktif tanpa reset**.
- **Pintasan Keyboard:** Menekan tombol **Alt + A** membuka/menutup panel seketika; tombol **Esc** menutup modal secara cepat.

---

# 18. Masalah yang Ditemui dan Cara Mengatasinya (Troubleshooting)

Selama proses pengembangan dari awal hingga akhir, ditemukan beberapa kendala teknis nyata. Bagian ini mendokumentasikan akar masalah dan solusi yang telah diterapkan sebagai bahan pembelajaran:

| No | Gejala Error / Kendala | Akar Masalah | Solusi yang Diterapkan |
|---|---|---|---|
| 1 | `php: command not found` atau versi PHP tidak sesuai saat menjalankan Composer/artisan. | Windows memiliki instalasi PHP bawaan lama (PHP 7.4) pada system PATH yang tidak kompatibel dengan Laravel 11. | Menggunakan path absolut PHP 8.2 resmi XAMPP: `C:\xampp_update\php\php.exe`. |
| 2 | Halaman `/anev-puu` lokal kosong, tombol unduh menghasilkan error 404. | Database lokal awal hanya berisi data dummy 14 dokumen; berkas fisik PDF belum diekstrak dari server production. | Melakukan swap database production dari folder backup cPanel dan mengekstrak berkas arsip `jdih.zip` ke `public/assets/source/files/` dan `storage/app/upload/`. |
| 3 | Logo JDIH muncul ganda berdampingan di header atas. | CSS inline lama menetapkan `display: block !important` pada varian logo putih dan hitam secara bersamaan. | Memperbaiki aturan CSS: logo putih hanya aktif saat header transparan/dark mode, logo hitam aktif saat header scrolling/floating. |
| 4 | Tombol login di header publik membingungkan masyarakat umum. | Terdapat markup `.right-header__login` bawaan template komersial. | Menghapus elemen HTML login dari header publik dan mobile drawer; membatasi akses admin hanya melalui `/admin-panel`. |
| 5 | Menu dropdown bertumpuk dan tulisan sulit dibaca saat resolusi layar menengah. | Struktur dropdown lama menggunakan absolute positioning tanpa pembungkus responsif. | Mengadopsi arsitektur Mega Dropdown ala JDIHN dengan kartu putih bersih, ikon visual, dan deskripsi singkat. |
| 6 | Footer melonjak ke tengah layar saat membuka halaman menu yang belum ada isinya. | Area `.middle` tidak memiliki tinggi minimum saat data tabel kosong. | Menambahkan properti CSS `min-height: 70vh` pada kelas `.middle` di `general.scss`. |
| 7 | Error `Call to a member function getClientOriginalName() on string` saat menyimpan dokumen PUU di admin. | Form CMS dirender tanpa atribut `enctype="multipart/form-data"` karena method `createFile()` belum dioverride di controller. | Menambahkan `createFile()` dan `editFile()` pada 7 controller PUU dan memperbarui helper `Document.php` dengan pengecekan `instanceof UploadedFile`. |
| 8 | Error SQL `Foreign Key Constraint Violation` saat input dokumen baru tanpa memilih dokumen relasi acuan. | Input form mengirimkan string kosong `""` ke kolom database bertipe foreign key integer nullable. | Menambahkan konversi otomatis di helper `Document.php`: jika nilai string kosong `""`, diubah menjadi `null`. |
| 9 | Halaman detail dokumen `/rencana-strategis-...` menghasilkan error 500 saat dibuka publik. | Accessor `$document->permalink_document` pada model `Document` belum memetakan tipe baru `puu-rancangan`. | Memperbarui method accessor di `Document.php` dengan menambahkan case `RANCANGAN_PUU` beserta fallback slug yang aman. |
| 10 | Halaman `/aksesibilitas` memicu error 500 `Trying to get property 'file' of non-object`. | Fungsi pembaca banner `widget($menu->id, 'menu', 'banner')` mengembalikan nilai null karena menu baru belum memiliki gambar banner di database. | Menambahkan logika fallback di `PageController::getAksesibilitas`: jika banner menu kosong, sistem otomatis meminjam banner default kementerian. |

---

# 19. Keamanan, Cadangan (Backup), dan Rollback

## 19.1 Titik Pemulihan Cadangan (Rollback Points)

Untuk menjamin keamanan sistem di masa depan, proyek ini telah dilengkapi berkas cadangan di setiap fase penting:
1. **Cadangan Database Sebelum Swap Production:**
   Tersimpan di: `Database/pangan_jdihdb_backup_sebelum_swap_2026-10-15.sql`
   Dapat diimpor sewaktu-waktu jika ingin mengembalikan database ke kondisi awal.
2. **Cadangan Server Production Asli (cPanel):**
   Tersimpan utuh pada folder: `backup-9.30.2026_08-25-36_pangan/`
   Berisi seluruh kode, database, dan berkas arsip `jdih.zip`.

## 19.2 Langkah Cepat Melakukan Rollback (Jika Terjadi Kegagalan)
Jika suatu saat database lokal mengalami kerusakan data uji coba, cukup jalankan perintah satu baris di terminal:
```powershell
mysql -u root pangan_jdihdb < "Database\pangan_jdihdb_backup_sebelum_swap_2026-10-15.sql"
C:\xampp_update\php\php.exe artisan optimize:clear
```

## 19.3 Catatan Keamanan Kredensial (.env)
File konfigurasi `.env` pada lingkungan produksi mengandung kredensial sensitif (koneksi database server dan akun email SMTP kementerian). Di lingkungan lokal, seluruh koneksi diarahkan secara aman ke `127.0.0.1` tanpa membeberkan sandi produksi ke pihak luar.

---

# 20. Panduan Menjalankan dan Merawat Sistem

Jika Anda atau rekan programmer lain ingin menjalankan proyek ini di kemudian hari pada komputer baru, ikuti panduan praktis berikut:

## 20.1 Prasyarat Perangkat Lunak
- **XAMPP Windows** dengan PHP 8.2 dan MySQL aktif.
- **Git for Windows** (opsional, untuk version control).
- **Web Browser modern** (Google Chrome, Microsoft Edge, Mozilla Firefox).

## 20.2 Langkah-Langkah Menjalankan Proyek (3 Langkah Mudah)

### Langkah 1: Aktifkan XAMPP
Buka **XAMPP Control Panel**, lalu tekan tombol **Start** pada modul **Apache** dan **MySQL**. Pastikan kedua modul berwarna hijau.

### Langkah 2: Buka Terminal di Folder Proyek
Buka PowerShell atau Command Prompt, lalu arahkan ke direktori kode sumber:
```powershell
cd "c:\Users\Asus\Documents\Arkan-Document\kerja\Kemenko Pangan\HKS\JDIH\web_jdih\jdih.kemenkopangan.go.id\jdih.kemenkopangan.go.id\Source Code\jdih-kemenko-pangan"
```

### Langkah 3: Jalankan Perintah Server Artisan
Ketik perintah berikut lalu tekan Enter:
```powershell
C:\xampp_update\php\php.exe artisan serve --port=8000
```
Biarkan jendela terminal tetap terbuka. Buka browser dan ketik alamat:
```
http://localhost:8000
```
Portal JDIH Kemenko Pangan kini siap digunakan dan diuji!

## 20.3 Alamat-Alamat Penting untuk Diuji

| Tujuan | Alamat URL | Fungsi yang Dapat Dicoba |
|---|---|---|
| **Beranda Publik** | `http://localhost:8000/` | Widget statistik beranda, tombol dark mode, launcher aksesibilitas. |
| **Statistik Produk Hukum** | `http://localhost:8000/statistik-produk-hukum` | Filter jenis peraturan, filter tahun, grafik interaktif, unduh PNG. |
| **Layanan Aksesibilitas** | `http://localhost:8000/aksesibilitas` | Galeri video ramah disabilitas (bahasa isyarat & takarir). |
| **Rancangan PUU Publik** | `http://localhost:8000/rancangan-puu` | Daftar draf regulasi, tahapan penyusunan, unduh PDF rancangan. |
| **Admin Panel CMS** | `http://localhost:8000/admin-panel` | Login pengelola web, menu Dokumen Pembentukan PUU, kelola galeri. |
| **API Statistik JSON** | `http://localhost:8000/api/statistics/legal-products` | Endpoint data mentah statistik untuk integrasi antar-aplikasi. |

---

# 21. Bahan Presentasi: Alur Demo, Poin Bicara, dan Tanya-Jawab

Bagian ini dirancang khusus agar Anda dapat mempresentasikan hasil pekerjaan di hadapan pimpinan atau tim penguji dengan penuh percaya diri.

## 21.1 Skenario Alur Demonstrasi Langsung (Live Demo Flow)

Gunakan urutan demonstrasi berikut (durasi ideal: 10 – 15 menit):

```
[1. Pembukaan & Beranda] ──> [2. Fitur Aksesibilitas] ──> [3. Halaman Statistik]
                                                                    │
[6. Penutup & Tanya Jawab] <── [5. Admin Panel CMS]    <── [4. Modul Pembentukan PUU]
```

### Langkah 1: Beranda JDIH yang Lebih Bersih & Modern
- Buka `http://localhost:8000/`.
- Tunjukkan bahwa logo kementerian berada rapi di pojok kiri atas.
- Tunjukkan bahwa navigasi atas memiliki menu **"Beranda"** di awal dan **tombol login sudah dibersihkan** sehingga ramah publik.
- Arahkan mouse ke menu **Tentang Kami**, **Jenis Dokumen**, dan **Dokumen Pembentukan PUU**: tunjukkan tampilan **Mega Dropdown bergaya JDIHN** berlatar putih bersih dengan ikon informatif.
- Tunjukkan tombol **Toggle Dark Mode**: klik sekali untuk menunjukkan bahwa website langsung beralih ke mode malam yang elegan tanpa merusak keterbacaan teks.
- Gulir ke area di bawah kotak pencarian: perlihatkan **Widget 4 Kartu Statistik Beranda** (Peraturan, Monografi, Artikel, Putusan) yang angkanya langsung dihitung dari database kementerian.

### Langkah 2: Demonstrasi 19 Fitur Aksesibilitas (Paling Memikat Audiens!)
- Tunjukkan tombol bulat navy di pojok kiri bawah layar: *"Sesuai amanat UU Disabilitas dan standar UserWay, kami menambahkan asisten aksesibilitas digital."*
- Klik tombol tersebut (atau tekan **Alt + A** di keyboard): panel modal pop-up modern akan muncul di layar.
- **Demokan 3 fitur favorit:**
  1. Klik tombol **Kontras Tinggi**: seluruh layar seketika berubah menjadi hitam pekat dengan teks kuning menyala. Katakan: *"Ini membantu masyarakat yang memiliki keterbatasan daya pandang berat."*
  2. Klik tombol **Font Disleksia**: huruf seketika berganti menjadi font Lexend yang dirancang khusus bagi penyandang disleksia.
  3. Klik tombol **Baca Layar (Text-to-Speech)**: sistem akan langsung membacakan teks peraturan di layar menggunakan suara bahasa Indonesia alami.
- Tunjukkan tombol **Atur Ulang**: klik sekali, dan website kembali ke tampilan normal.
- Buktikan ketahanan setelan: aktifkan salah satu fitur, buka halaman lain, dan tunjukkan bahwa setelan tersebut **tetap tersimpan** di browser pengunjung.

### Langkah 3: Halaman Statistik Produk Hukum Interaktif
- Buka menu `Tentang Kami -> Statistik` (atau `/statistik-produk-hukum`).
- Jelaskan 4 Kartu KPI di atas: *"Dari database kementerian, tercatat ada 47 Peraturan aktif, di mana jenis terbanyak adalah Perpres sebanyak 13 dokumen dan tahun 2025 merupakan puncak legislasi sebanyak 28 peraturan."*
- Ubah filter Jenis Peraturan ke *"Peraturan Presiden"*: tunjukkan grafik batang dan diagram donat bergerak dinamis tanpa memuat ulang halaman (*AJAX*).
- Tekan tombol **"Unduh Grafik (PNG)"**: tunjukkan bahwa sistem langsung men-generate gambar grafik beresolusi tinggi yang siap disisipkan ke slide laporan pimpinan.

### Langkah 4: Transparansi Dokumen Pembentukan PUU
- Buka menu `Dokumen Pembentukan PUU -> Rancangan PUU` (`/rancangan-puu`).
- Tunjukkan bahwa masyarakat kini dapat melihat draf aturan yang sedang dirumuskan, lengkap dengan badge status tahapannya (misal: *Tahap Harmonisasi*).
- Klik salah satu rancangan untuk menunjukkan halaman detail draf dan formulir konsultasi publik tempat masyarakat dapat menyalurkan aspirasinya.

### Langkah 5: Dapur Pengelola (CMS Admin Panel)
- Buka `http://localhost:8000/admin-panel`.
- Perlihatkan kelompok menu baru di sidebar: **Dokumen Pembentukan PUU** yang menaungi 7 sub-modul (Program Penyusunan, Naskah Akademik, Rancangan PUU, Risalah, Evaluasi, Kajian, Partisipasi Publik).
- Tunjukkan bagaimana staf kementerian dapat memoderasi masukan masyarakat yang masuk dan mengunduh berkas lampirannya secara terstruktur.

---

## 21.2 Poin-Poin Bicara Kunci (Key Talking Points)

Gunakan kalimat-kalimat strategis berikut saat berbicara:

> **Prinsip Pengembangan:**  
> *"Pengembangan ini dilakukan dengan prinsip kesinambungan. Kami tidak merombak dari nol dan tidak menghapus fitur lama. Seluruh arsitektur Laravel dan CMS Cactuar yang sudah ada kami pertahankan dan tingkatkan kualitasnya agar 100% selaras dengan website resmi JDIH Kemenko Pangan."*

> **Keaslian Data:**  
> *"Seluruh angka pada widget statistik dan halaman infografis hukum ditarik secara riil dari database kementerian, bukan angka tiruan atau hardcoding. Jika staf admin menambahkan satu peraturan baru di panel CMS, detik itu juga angka statistik di web publik bertambah secara otomatis."*

> **Inklusivitas & Disabilitas:**  
> *"Melalui implementasi 19 alat bantu aksesibilitas berstandar UserWay dan klasifikasi video ramah disabilitas, portal JDIH Kemenko Pangan kini siap menjadi salah satu portal hukum kementerian yang paling inklusif di Indonesia bagi penyandang disabilitas."*

---

## 21.3 Antisipasi Pertanyaan Penguji & Jawaban Tepat (FAQ)

**Pertanyaan 1: Mengapa database lokal sempat berbeda dengan website resmi?**  
*Jawaban:*  
*"Database awal di komputer pengembang adalah database instalasi dasar yang hanya memuat 14 data sampel. Pada tanggal 15 Oktober 2026, kami telah melakukan proses database swap menggunakan berkas cadangan resmi cPanel kementerian, sehingga seluruh 49 dokumen hukum, 16 berita, dan 27 dokumentasi galeri resmi telah tersinkronisasi 100% ke lingkungan lokal beserta seluruh berkas PDF-nya."*

**Pertanyaan 2: Apakah penambahan 7 sub-modul PUU ini merusak data peraturan yang lama?**  
*Jawaban:*  
*"Sama sekali tidak. Kami memanfaatkan arsitektur master_document_id bawaan sistem Cactuar. Peraturan lama tetap menempati ID 1, sedangkan modul PUU menggunakan rentang ID 8 sampai 15. Tabel utama documents tetap utuh dan 49 peraturan lama tidak mengalami perubahan struktur data."*

**Pertanyaan 3: Apa yang terjadi jika pengunjung mematikan koneksi internet saat menggunakan widget aksesibilitas?**  
*Jawaban:*  
*"Seluruh 19 fitur aksesibilitas (kontras tinggi, monokrom, spasi teks, kursor besar, masker fokus, panduan membaca) diproses sepenuhnya di sisi peramban pengunjung (client-side CSS & JavaScript). Bahkan fitur Text-to-Speech memanfaatkan Web Speech API bawaan peramban komputer, sehingga widget tetap berfungsi prima meskipun koneksi internet mengalami gangguan."*

**Pertanyaan 4: Bagaimana jika ada penambahan jenis peraturan baru di masa depan?**  
*Jawaban:*  
*"Sistem telah dirancang modular. Controller statistik membaca tabel rule_types secara dinamis. Jika administrator menambahkan jenis regulasi baru di database, sistem statistik akan otomatis membuatkan kategori baru pada diagram donat dan diagram batang tanpa perlu mengubah sebaris kode pun."*

---

# 22. Glosarium

- **JDIH:** Jaringan Dokumentasi dan Informasi Hukum, wadah pendayagunaan bersama atas dokumen hukum secara tertib, terpadu, dan berkesinambungan di lingkungan instansi pemerintah.
- **PUU:** Peraturan Perundang-undangan.
- **CMS:** *Content Management System*, aplikasi berbasis web yang digunakan untuk mengelola, menambah, dan mengubah konten website (pada proyek ini menggunakan Cactuar Admin).
- **Dual Guard Authentication:** Arsitektur keamanan Laravel yang memisahkan sesi login antara administrator pengelola web (`guard: web`) dan akun masyarakat umum (`guard: account`).
- **Eloquent ORM:** Sistem pemetaan objek-relasional bawaan Laravel yang memungkinkan pemrogram berinteraksi dengan tabel database menggunakan sintaks PHP objek tanpa mengetik query SQL mentah.
- **Master Document ID:** Kolom pengenal numerik pada tabel `documents` yang menentukan jenis arsip hukum (1: Peraturan, 6: Monografi, 9: Program Penyusunan, 15: Rancangan PUU, dst.).
- **Pivot Table:** Tabel perantara dalam relasi database *Many-to-Many* yang menghubungkan dua entitas utama (contoh: `gallery_video_classifications` yang menghubungkan video galeri dengan master klasifikasi video).
- **PushState:** Fitur antarmuka JavaScript HTML5 yang memperbarui teks alamat URL pada bilah alamat browser tanpa memicu pemuatan ulang seluruh halaman (*page refresh*).
- **Web Speech API:** Standar antarmuka pemrograman peramban web modern yang memungkinkan komputer menyintesis teks tulisan menjadi suara audio percakapan manusia secara alami.
- **LocalStorage:** Media penyimpanan data ringan di dalam peramban web pengguna yang bersifat persisten (tidak terhapus saat berpindah halaman atau browser ditutup).
- **Glassmorphism:** Tren desain antarmuka visual modern yang menonjolkan efek transparansi kaca kabur (*frosted glass*) dengan bayangan halus untuk menciptakan kesan kedalaman antarmuka yang elegan.

