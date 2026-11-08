# MAPPING ROLE & HAK AKSES PENGGUNA
**Sistem Terintegrasi JDIH & e-Regulasi Kemenko Pangan**

---

## 1. Matriks Kategori Pengguna

| Kategori User | Role Kode | Ruang Lingkup Akses | Redirect Setelah Login | Akses Admin Panel JDIH | Akses e-Regulasi | Akses Web Publik |
|---|---|---|---|---|---|---|
| **Super Admin** | `super_admin` | Seluruh Modul JDIH & e-Regulasi | Admin Panel / e-Regulasi | ✅ Penuh | ✅ Penuh | ✅ Penuh |
| **Operator e-Regulasi (Mas Ibnu)** | `admin_operator` / `operator_eregulasi` | Khusus Penyusunan & Pengajuan Regulasi | Langsung ke `/dashboard` e-Regulasi | ❌ Dibatasi (Blokir ke `/dashboard`) | ✅ Penuh (Sesuai Unit) | ✅ Penuh |
| **User JDIH Portal** | `account` / `user_jdih` | Pengajuan Usulan Peraturan & Aspirasi | Dashboard Usulan Masyarakat | ❌ Tidak Ada | ❌ Dibatasi | ✅ Penuh |
| **Masyarakat Umum** | `masyarakat` / Guest | Melihat Regulasi & Partisipasi Publik | Halaman Publik | ❌ Tidak Ada | Form Tanggapan Saja | ✅ Penuh |

---

## 2. Alur Pengamanan Khusus Operator e-Regulasi (Mas Ibnu)

### Akun Mas Ibnu:
- **Email:** `durraniazka.herbs@gmail.com`
- **Username:** `ibnu`
- **Role:** `admin_operator` (Operator e-Regulasi)
- **Unit Kerja:** Biro Hukum dan Kerja Sama

### Proteksi Backend:
1. **Login Redirect:**
   Saat login di `/admin-panel/guest/login` atau portal, sistem memeriksa role pengguna. Jika bertipe `admin_operator`, pengguna **langsung diarahkan ke `/dashboard`** e-Regulasi.
2. **Direct Link Protection:**
   Middleware `cadmin/src/Http/Middleware/Admin.php` memeriksa apakah pengguna ber-role `admin_operator`. Jika mencoba mengetik URL seperti `/admin-panel/document-peraturan` atau `/admin-panel/setting`, sistem otomatis mencegat dan me-redirect pengguna kembali ke `/dashboard`.
3. **UI / Sidebar Isolation:**
   Pada template `resources/views/layouts/app.blade.php`, sidebar navigasi JDIH (`cactuar::admin.layout-nav`) disembunyikan untuk operator e-Regulasi, sehingga tampilan bersih dan fokus pada operasional e-Regulasi saja.

