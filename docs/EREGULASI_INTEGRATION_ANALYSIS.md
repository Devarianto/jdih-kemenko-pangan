# ANALISIS KOMPATIBILITAS & ARSITEKTUR INTEGRASI E-REGULASI KE DALAM JDIH KEMENKO PANGAN

**Tanggal Pembaruan:** 3 November 2026  
**Repository Sumber (e-Regulasi):** `https://github.com/basharraihann/e-regulasi` (`..\temp_eregulasi`)  
**Repository Target (JDIH Kemenko Pangan):** `Source Code\jdih-kemenko-pangan`  

---

## 1. Perbandingan Arsitektur Kedua Sistem (Phase 1)

| Komponen | e-Regulasi (Source Repository) | JDIH Kemenko Pangan (Target) | Strategi & Implementasi Integrasi |
|---|---|---|---|
| **Programming Language** | PHP 8.2+ | PHP 8.2+ | Kompatibel penuh (Native Monolith). |
| **Framework** | Laravel 11.x | Laravel 11.x + Custom Package `Cactuar\Admin` (`cadmin/`) | Disatukan dalam satu aplikasi Laravel 11.x. |
| **Frontend Admin** | Blade + Custom CSS (`.stats-grid`, `.card`, `.btn`, `.form-card`) dengan sidebar terpisah | Blade (`cactuar::admin.layout-master`, `cactuar::admin.layout-nav`, Bootstrap 5 / AdminKit `nwcms`) | `resources/views/layouts/app.blade.php` direfaktor agar mewarisi sidebar resmi `cactuar::admin.layout-nav` & topbar `cactuar::admin.layout-top-menu` milik JDIH Admin Panel disertai sub-navigasi horizontal modul (`ereg-subnav-bar`). |
| **Frontend Publik** | Blade standalone (`resources/views/public.blade.php`) | Blade JDIH (`dynamic.layouts.layout`, `dynamic.component.menu`, `dynamic.component.footer`, Vite SCSS) | `resources/views/public.blade.php` direfaktor menggunakan Header Mega-Menu, Hero Banner, Footer, dan Widget Aksesibilitas resmi JDIH Kemenko Pangan. |
| **Database & ORM** | MySQL / MariaDB (Eloquent ORM) | MySQL / MariaDB (Eloquent ORM) | Menggunakan satu koneksi database terpadu (`regulasi`, `regulasi_tahapan`, `regulasi_proses`, `partisipasi_publik`, `tanggapan`). |
| **Authentication** | Session-based (`web` guard) | Session-based (`web` guard pada `/admin-panel`) | **Shared Session Single Sign-On (SSO)**: Login satu kali melalui `/admin-panel` langsung mengautentikasi seluruh fitur e-Regulasi tanpa login ulang. |
| **Authorization** | `RoleMiddleware` (`super_admin`, `admin_operator`) | `Cactuar\Admin\Models\User` (`privilege_id`, `allow()`, `isRoot`) + `role` | `App\Models\User` mewarisi `Cactuar\Admin\Models\User`; `RoleMiddleware` memverifikasi status aktif (`is_enable === 'Yes'`), menyinkronkan `privilege_id === null` menjadi `super_admin`, dan membagikan konteks menu Cactuar Admin. |
| **File Storage** | `Storage::disk('public')` (`regulasi/draft`, `regulasi/permohonan`, `regulasi/proses`) | `public/uploads` & `storage/app/public` (`public/storage`) | Menggunakan `Storage::disk('public')` dengan symlink/direktori `public/storage/regulasi/draft` dan kebijakan CSP `frame-src 'self'` agar pratinjau PDF berjalan lancar. |

---

## 2. Analisis Integrasi Login & Hak Akses (Phase 2)

1. **Penyebab Kegagalan Akses Sebelumnya & Perbaikannya:**
   - Pada `app/Http/Middleware/Authenticate.php`, method `authenticate($request, array $guards)` sebelumnya tidak menginisialisasi `$guards = [null]` ketika dipanggil oleh `middleware('auth')` tanpa parameter guard. Akibatnya perulangan `foreach ($guards as $guard)` dilewati dan selalu melempar `unauthenticated()` (redirect kembali ke `/admin-panel`).
   - **Solusi:** Menambahkan `if (empty($guards)) { $guards = [null]; }` pada `app/Http/Middleware/Authenticate.php` serta menyatukan pewarisan `App\Models\User extends \Cactuar\Admin\Models\User`.
2. **Pemetaan Role & Privilege:**
   - **Super Admin (`role = 'super_admin'` atau `privilege_id = null`):** Akses penuh ke Dashboard Eksekutif, Pengajuan Regulasi (dengan pilihan Unit Kerja Pemrakarsa), Persetujuan/Penolakan Uji Publik, Takedown Uji Publik, Moderasi & Tindak Lanjut Tanggapan Publik, Ekspor CSV, dan Manajemen Operator Unit Kerja.
   - **Admin/Operator Unit Kerja (`role = 'admin_operator'`):** Akses ke Dashboard Unit Kerja, Pengajuan Regulasi Unit Kerja, Dokumentasi Pembahasan, Permohonan Uji Publik, serta pemantauan dan telaah masukan Partisipasi Publik.

---

## 3. Analisis Integrasi Menu Admin Panel (Phase 3)

Pada `config/cadmin/menu.php`, di dalam grup menu **`Dokumen Pembentukan PUU`** (`puu-dokumen`), telah terintegrasi dua submenu yang terhubung langsung ke sistem e-Regulasi:
1. **`Pengajuan PUU` (`puu-pengajuan`):** Mengarah ke `App\Http\Controllers\Admin\Puu\PengajuanPuuController@getIndex` → `redirect()->route('dashboard')` (`/dashboard`).
2. **`Partisipasi Publik` (`puu-partisipasi-publik`):** Mengarah ke `App\Http\Controllers\Admin\Puu\PartisipasiPublikController@getIndex` → `redirect()->route('admin.partisipasi.index')` (`/admin/partisipasi-publik`).

---

## 4. Analisis Penyatuan Sistem Partisipasi Publik (Phase 5, 6, 7)

### Kondisi Sebelumnya (Terpisah):
- Website publik JDIH (`/partisipasi-publik`) sebelumnya membaca tabel `documents` (`Document::PARTISIPASI_PUBLIK`), sedangkan sistem e-Regulasi membaca tabel `partisipasi_publik`, `regulasi`, dan `tanggapan` pada URL terpisah (`/partisipasi-publik/konsultasi`).

### Arsitektur Terintegrasi (Single Source of Truth):
- Route utama website publik JDIH `GET /partisipasi-publik` (`route('partisipasi-publik')`) dan `PageController@getPartisipasiPublik` kini langsung memanggil `App\Http\Controllers\ERegulasi\PartisipasiPublikController@index`.
- Tabel `regulasi`, `partisipasi_publik`, dan `tanggapan` menjadi **satu-satunya sumber data (Single Source of Truth)** baik untuk halaman publik (`/partisipasi-publik` & `/partisipasi-publik/{id}`) maupun halaman Admin (`/admin/partisipasi-publik` & `/admin/partisipasi-publik/{id}`).
- Tabel `tanggapan` diperkaya melalui migrasi `2026_11_03_000001_add_moderation_fields_to_tanggapan_table.php` dengan kolom:
  - `status_tindak_lanjut` (`menunggu`, `ditelaah`, `diterima`, `ditolak`)
  - `tindak_lanjut` (Tanggapan resmi tim penyusun yang ditampilkan ke publik)
  - `catatan_internal` (Catatan rahasia verifikator internal yang hanya tampil di Admin Panel)
  - `reviewed_by` & `reviewed_at` (Audit trail verifikator)

