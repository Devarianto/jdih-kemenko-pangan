# Dokumentasi Fitur: Accessibility Widget (Full UserWay Suite & Model JDIH Kemenkumham)
**Portal**: JDIH Kementerian Koordinator Bidang Pangan Republik Indonesia  
**Referensi Visual**: Model Kartu Popup Elegan [https://jdih.kemenkum.go.id/](https://jdih.kemenkum.go.id/)  
**Spesifikasi Fungsional**: Rangkaian Lengkap Alat Aksesibilitas [UserWay Accessibility Toolkit](https://userway.org/)  
**Standar Kepatuhan**: WCAG 2.1 (Level AA), PermenpanRB No. 59/2020, Perpres No. 95/2018 (SPBE)  
**Tipe Implementasi**: Native In-House Component (Zero External Dependency, Zero Subscriptions)  

---

## 1. Ikhtisar & Arsitektur

Fitur Widget Aksesibilitas pada JDIH Kementerian Koordinator Bidang Pangan memadukan **dua keunggulan utama**:
1. **Model Visual JDIH Kemenkumham**: Desain popup melayang di atas tombol launcher bulat biru navy di pojok kiri bawah (`bottom: 24px; left: 24px;`), header elegan bertuliskan *"Aksesibilitas"* dengan tombol tutup **✕**, dan list item vertikal ber-scroll halus dilengkapi panah navigator.
2. **Kekayaan Fitur UserWay**: Mengintegrasikan seluruh fungsi alat bantu disabilitas yang umum dijumpai pada UserWay (18 fitur operasional + 1 tombol atur ulang).

---

## 2. Matriks 19 Fitur Aksesibilitas UserWay

| No | Nama Fitur | Ikon | Kategori | Penjelasan Efek Fungsional |
|:---:|:---|:---:|:---|:---|
| 1 | **Kontras tinggi** | ◐ | Warna & Kontras | Mengubah latar menjadi hitam pekat (`#0b0f19`), teks putih (`#f8fafc`), dan link biru kontras (`#93c5fd`). |
| 2 | **Kontras terang** | ☀️ | Warna & Kontras | Mengubah latar menjadi putih bersih (`#ffffff`) dengan teks hitam pekat (`#000000`). |
| 3 | **Mode abu-abu** | 🎨 | Warna & Kontras | Menghapus seluruh spektrum warna menjadi monokrom (grayscale 100%) bagi pengguna buta warna. |
| 4 | **Inversi warna** | 🔄 | Warna & Kontras | Membalikkan spektrum warna (*invert colors*) untuk kenyamanan mata sensitif terhadap cahaya. |
| 5 | **Sorot tautan** | 🔗 | Navigasi & Fokus | Memberikan latar kuning cerah (`#fef08a`), teks cokelat tua, dan outline putus-putus pada seluruh link `<a>`. |
| 6 | **Sorot judul** | 📑 | Navigasi & Fokus | Menyorot elemen judul (`<h1>` s.d. `<h6>`) dengan border biru dan padding kontras tinggi. |
| 7 | **Font mudah dibaca** | Aa | Tipografi | Mengubah seluruh font situs menjadi font Google **Lexend** yang dirancang khusus untuk penderita disleksia. |
| 8 | **Perbesar teks** | A+ | Tipografi | Meningkatkan ukuran teks bertahap (+12%, +24%, +36%, +48%) secara proporsional. |
| 9 | **Perkecil teks** | A- | Tipografi | Mengurangi ukuran teks kembali ke normal atau skala minimal (-10%). |
| 10 | **Spasi teks** | ↔️ | Tipografi | Memperlebar spasi baris (*line-height: 1.85*) dan jarak antar huruf (*letter-spacing: 0.08em*). |
| 11 | **Rata kiri teks** | 📄 | Tipografi | Mengubah perataan teks menjadi rata kiri (*align-left*) untuk mencegah efek *river of whitespace*. |
| 12 | **Kursor besar** | 🖱️ | Navigasi & Motorik | Mengganti kursor pointer menjadi kursor panah berukuran besar 44px dengan kontras tinggi. |
| 13 | **Panduan membaca** | 📏 | Alat Baca | Garis penunjuk horisontal transparan berwarna kuning emas (*reading ruler*) yang bergerak mengikuti kursor mouse. |
| 14 | **Masker fokus baca** | 🔦 | Alat Baca | Menggelapkan area atas dan bawah layar dengan tirai transparan, menyisakan celah baca fokus selebar 110px. |
| 15 | **Hentikan animasi** | ⏸️ | Gerakan & Sensitif | Mematikan durasi seluruh transisi, animasi slider, keyframes CSS, dan scroll halus bagi pengguna epilepsi/vestibular. |
| 16 | **Sembunyikan gambar** | 🖼️ | Konten | Menurunkan opasitas gambar hingga 5% dengan efek blur untuk fokus penuh pada dokumen teks regulasi. |
| 17 | **Baca layar** | 🔊 | Suara & Audio | Membaca teks yang diklik atau diblok dalam Bahasa Indonesia resmi via Web Speech API browser (`id-ID`). |
| 18 | **Hentikan bacaan** | ⏹ | Suara & Audio | Menghentikan audio pembaca layar seketika. |
| 19 | **Atur ulang** | ↺ | Kontrol Sistem | Mengembalikan seluruh modifikasi CSS dan preferensi ke kondisi awal dalam 1 klik (*reset all*). |

---

## 3. Interaktivitas & Aksesibilitas Keyboard

- **Pintasan Keyboard Global**: Tekan <kbd>Alt + A</kbd> di halaman mana pun untuk membuka/menutup kartu aksesibilitas secara instan.
- **Tutup Cepat**: Tekan tombol <kbd>Esc</kbd>, klik tombol **✕**, atau klik di luar area popup untuk menutup kartu secara otomatis.
- **Status Bar Suara**: Saat mode baca layar aktif, muncul bilah mengambang bertuliskan *"🔊 Sedang membacakan..."* dengan tombol *"Hentikan"*.
- **Penyimpanan State Otomatis**: Semua pengaturan tersimpan aman di `localStorage` browser sehingga tetap aktif saat pengguna berpindah halaman di seluruh portal JDIH.

---

## 4. File Implementasi

| Berkas | Lokasi | Peran |
|:---|:---|:---|
| `accessibility-widget.blade.php` | [accessibility-widget.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/component/accessibility-widget.blade.php) | Komponen UI, style CSS terisolasi, overlay reading guide/mask, dan controller JS native. |
| `layout.blade.php` | [layout.blade.php](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Source%20Code/jdih-kemenko-pangan/resources/views/dynamic/layouts/layout.blade.php#L112-L115) | Penyematan komponen secara global pada seluruh layout portal publik. |
| `DOKUMENTASI_ACCESSIBILITY_TOOLS_USERWAY_EQUALWEB.html` | [DOKUMENTASI_ACCESSIBILITY_TOOLS_USERWAY_EQUALWEB.html](file:///c:/Users/Asus/Documents/Arkan-Document/kerja/Kemenko%20Pangan/HKS/JDIH/web_jdih/jdih.kemenkopangan.go.id/jdih.kemenkopangan.go.id/Dokumentasi_Update/DOKUMENTASI_ACCESSIBILITY_TOOLS_USERWAY_EQUALWEB.html) | Dokumen resmi format HTML eksekutif yang memuat preview mockup dan tabel pengujian. |

---

## 5. Hasil Pengujian Verifikasi (100% Pass)
Seluruh 19 fitur telah diverifikasi pada lingkungan server aktif (`http://localhost:8000/`) dan lulus uji tanpa galat teknis.
