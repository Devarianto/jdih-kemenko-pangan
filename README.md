# JDIH & e-Regulasi — Kementerian Koordinator Bidang Pangan RI

Repository resmi pengembangan terpadu **Jaringan Dokumentasi dan Informasi Hukum (JDIH)** dan sistem perancangan regulasi **e-Regulasi** Kementerian Koordinator Bidang Pangan Republik Indonesia.

---

## 🌟 Fitur Utama Sistem

1. **Portal Publik JDIH (`/`)**
   - Pencarian cerdas produk hukum (Peraturan, Monografi, Naskah Kerja Sama, Putusan, Kliping, Majalah).
   - Filter berdasarkan bentuk/jenis, tahun, nomor, dan status keberlakuan peraturan.
   - Fitur **Peraturan Terjemahan Bahasa Inggris** (Bilingual switcher ID/EN pada dokumen terkait).
   - Aksesibilitas (Widget ramah disabilitas / High Contrast / Text Resize).
   - Informasi hukum (Berita, Infografis, Galeri, Kamus Hukum).

2. **Sistem Perancangan e-Regulasi (`/dashboard`)**
   - Monitoring alur penyusunan peraturan perundang-undangan (PUU) secara digital.
   - Manajemen tahapan: Perencanaan, Penyusunan, Harmonisasi, Penetapan, Pengundangan.
   - Upload naskah akademik/urgensi, draf raperpres/rapermen, dan lampiran.
   - Log riwayat tahapan dan approval.

3. **Partisipasi Publik PUU (`/partisipasi-publik`)**
   - Kanal resmi keterbukaan bagi masyarakat untuk memberikan aspirasi, masukan, dan saran terhadap rancangan regulasi yang sedang dalam proses penyusunan.
   - Panel moderasi masukan publik pada dashboard admin.

4. **Multi-Role & Role Isolation (RBAC)**
   - **Super Admin (`super_admin`):** Akses menyeluruh ke CMS JDIH, e-Regulasi, publikasi, dan user management.
   - **Operator e-Regulasi (`admin_operator`):** Terisolasi penuh khusus untuk unit kerja penyusun regulasi. Login langsung masuk ke dashboard e-Regulasi tanpa akses ke modul CMS JDIH internal.
   - **User Publik (`masyarakat`):** Pengguna masyarakat untuk menyampaikan tanggapan partisipasi publik.

---

## 🛠️ Kebutuhan Sistem (Prerequisites)

- **PHP:** `>= 8.2` (dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `gd`, `zip`, `fileinfo`)
- **Web Server:** Nginx / Apache / Laravel Built-in Server
- **Database:** MariaDB `>= 10.4` atau MySQL `>= 8.0`
- **Composer:** `>= 2.2`
- **Node.js & NPM:** `>= 18.x` (opsional untuk re-compile SCSS/JS)

---

## 🚀 Panduan Setup untuk Kolaborator (Quick Start)

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer lokal:

### 1. Clone Repository
```bash
git clone https://github.com/Arkandrvesh/JDIH-Update.git
cd JDIH-Update
```

### 2. Install Dependencies Backend
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database Anda:
```env
APP_NAME="JDIH Kemenko Pangan"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pangan_jdihdb
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Setup Database
1. Buat database baru di MySQL/MariaDB dengan nama:
   ```sql
   CREATE DATABASE pangan_jdihdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Import file starter database yang sudah terintegrasi lengkap:
   ```bash
   mysql -u root -p pangan_jdihdb < database/sql/pangan_jdihdb_starter.sql
   ```
   *(Atau import file `database/sql/pangan_jdihdb_starter.sql` melalui phpMyAdmin / DBeaver).*

### 5. Setup Storage Link
```bash
php artisan storage:link
```

### 6. Jalankan Server Lokal
```bash
php artisan serve --port=8000
```
Aplikasi kini berjalan di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Akun Default untuk Pengujian Lokal

| Peran (Role) | Username / Email | Password | Hak Akses & Fitur |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin` / `superadmin@webadmin.com` | `password123` | Akses penuh CMS JDIH, e-Regulasi, User Management |
| **Operator e-Regulasi** | `operator.test@kemenkopangan.go.id` | `password123` | Khusus penyusunan PUU & Partisipasi Publik (Biro Hukum) |
| **Operator e-Regulasi** | `durraniazka.herbs@gmail.com` (user: `ibnu`) | `password123` | Khusus penyusunan PUU & Partisipasi Publik |

**Halaman Login:**
👉 `http://127.0.0.1:8000/admin-panel/guest/login`

---

## 📁 Struktur Folder Utama

```text
├── app/                  # Controller, Model, Middleware, Service
│   ├── Http/Controllers/
│   │   ├── Admin/        # Controller CMS JDIH & Bridge e-Regulasi
│   │   ├── ERegulasi/    # Controller modul e-Regulasi (Dashboard, PUU, Partisipasi)
│   │   └── Front/        # Controller publik JDIH
│   └── Models/           # Model Eloquent (Document, User, Regulasi, Partisipasi)
├── cadmin/               # Package internal Cactuar Admin CMS
├── config/               # Konfigurasi aplikasi & menu admin
├── database/             # Migrations, seeders, factories
│   └── sql/              # File SQL database starter terintegrasi
├── docs/                 # Dokumentasi teknis, audit, API, dan arsitektur
├── public/               # Web root (CSS, JS, Asset tema, logo)
├── resources/            # Blade templates (JDIH & e-Regulasi) & file Sass
├── routes/               # Definisi routing web (web.php)
└── storage/              # Cache runtime & upload lokal
```

---

## 📚 Indeks Dokumentasi Teknis

Dokumentasi detail tersimpan di dalam folder [`docs/`](docs/):
- [`docs/FULL_SYSTEM_AUDIT_REPORT.md`](docs/FULL_SYSTEM_AUDIT_REPORT.md) — Laporan audit sistem, crawling 300+ rute, dan mitigasi keamanan.
- [`docs/USER_ROLE_PERMISSION_MAPPING.md`](docs/USER_ROLE_PERMISSION_MAPPING.md) — Matriks peran pengguna (Super Admin vs Operator e-Regulasi).
- [`docs/TRANSLATED_REGULATION_IMPLEMENTATION.md`](docs/TRANSLATED_REGULATION_IMPLEMENTATION.md) — Panduan fitur bilingual peraturan hukum.
- [`docs/EREGULASI_INTEGRATION_REPORT.md`](docs/EREGULASI_INTEGRATION_REPORT.md) — Rangkuman arsitektur integrasi e-Regulasi ke JDIH.

---

## 🤝 Panduan Kolaborasi (Git Workflow)

1. **Selalu buat branch baru untuk fitur atau perbaikan:**
   ```bash
   git checkout -b feature/nama-fitur
   # atau
   git checkout -b fix/nama-bug
   ```
2. **Jangan pernah meng-commit file `.env` atau credential rahasia.**
3. **Pastikan database schema tetap sinkron dengan migrations atau update file starter SQL.**
4. **Push branch dan ajukan Pull Request (PR) ke branch `main`:**
   ```bash
   git push origin feature/nama-fitur
   ```

---
*Kementerian Koordinator Bidang Pangan Republik Indonesia — Biro Hukum dan Kerja Sama*
