# Dokumentasi Fitur 1: Statistik Produk Hukum

## 1. Ringkasan Fitur
Modul Statistik Produk Hukum pada Portal Resmi JDIH Kementerian Koordinator Bidang Pangan dikembangkan untuk menyajikan data statistik regulasi yang akurat, dinamis, dan terpercaya bagi masyarakat luas serta pemangku kepentingan (*stakeholders*).

Fitur ini beroperasi secara penuh di atas database aktual JDIH Kemenko Pangan:
- **Zero Dummy Data**: Seluruh angka, persentase, dan tren dihitung langsung dari record dokumen di database.
- **Filter Publik Valid**: Hanya memperhitungkan dokumen berstatus aktif (`is_active = 1`) dengan kategori Peraturan (`master_document_id = 1`). Dokumen draft, unpublished, atau deleted secara ketat dikecualikan dari kalkulasi statistik publik.
- **Konsistensi Tahun**: Menggunakan tahun penetapan hukum dokumen (`year`), bukan tanggal input database (`created_at`).

---

## 2. Arsitektur & Logika Agregasi Backend

Logika statistik dipusatkan pada `App\Http\Controllers\Front\StatisticController::getStatisticsData($year, $ruleTypeId)` untuk memastikan konsistensi antara tampilan halaman web (`/statistik-produk-hukum`) dan endpoint API publik.

### A. Agregasi Berdasarkan Jenis Peraturan (`by_type`)
- Mengambil master data jenis peraturan aktif dari tabel `rule_types` (`is_active = 1`).
- Menghitung jumlah dokumen per `rule_type_id` dengan filter tahun (jika dipilih) menggunakan SQL aggregation (`GROUP BY rule_type_id`).
- Menghitung persentase terhadap total dokumen yang terpilih:
  $$\text{Persentase} = \left(\frac{\text{Jumlah Dokumen per Jenis}}{\text{Total Dokumen Terfilter}}\right) \times 100\%$$
- Hasil diurutkan secara menurun (*descending*) berdasarkan jumlah dokumen terbanyak.

### B. Agregasi Tren Tahunan (`by_year`)
- Mengambil distribusi tahun dari dokumen peraturan (`GROUP BY year ORDER BY year ASC`).
- Memisahkan status keberlakuan dokumen secara dinamis:
  - `status_berlaku = 1`: Dokumen Masih Berlaku
  - `status_berlaku = 0`: Dokumen Tidak Berlaku (Dicabut / Diubah)
- Mendukung filter `rule_type_id`: ketika pengguna memilih jenis peraturan tertentu (contoh: *Peraturan Presiden*), grafik tren tahunan hanya menampilkan sebaran dokumen untuk jenis peraturan tersebut.

### C. Ringkasan Eksekutif (*KPI Summary Cards*)
1. **Total Produk Hukum**: Total dokumen peraturan aktif yang memenuhi kriteria filter.
2. **Jenis Peraturan Aktif**: Jumlah kategori jenis regulasi yang memiliki setidaknya 1 dokumen.
3. **Tahun Terbanyak**: Tahun penetapan dengan jumlah produk hukum tertinggi beserta jumlahnya.
4. **Status Regulasi**: Komparasi jumlah dan persentase dokumen Berlaku vs Tidak Berlaku.

---

## 3. Komponen Antarmuka Pengguna (UI/UX)

Halaman `/statistik-produk-hukum` dibangun menggunakan Blade View:
`resources/views/dynamic/pages/about-statistik.blade.php`.

### A. Kartu Ringkasan (KPI Cards)
- Desain modern dengan gradient warna (Biru, Hijau Emerald, Kuning Amber, dan Putih Bordered).
- Dilengkapi ikon SVG tematik dan efek hover interaktif.
- Nilai angka terformat rapi (`number_format`).

### B. Dual Filter Terintegrasi
- **Dropdown Tahun**: Pilihan "Semua Tahun" dan daftar tahun aktual dari database (2026, 2025, 2024, 2023, 2022, 2021, 2019, 2015).
- **Dropdown Jenis Peraturan**: Pilihan "Semua Jenis Peraturan" dan daftar master data jenis peraturan.
- **Tombol Reset Filter**: Mengembalikan pilihan ke "Semua Tahun" dan "Semua Jenis Peraturan".
- **Sinkronisasi AJAX Tanpa Reload**: Perubahan filter memicu `fetch('/api/statistics/legal-products?...')`, memperbarui kartu ringkasan, tabel data, dan kedua grafik secara instan.
- **URL Synchronization**: Menggunakan `window.history.pushState` sehingga filter dapat di-bookmark atau dibagikan melalui link langsung (contoh: `/statistik-produk-hukum?year=2025&rule_type_id=6`).

### C. Tabel Statistik & Progress Bar
- Kolom:
  1. `No`
  2. `Jenis Peraturan` (disertai indikator warna jenis)
  3. `Jumlah Dokumen`
  4. `Persentase (%)` (disertai visual bar proporsional)
- Tombol **Unduh Tabel** sebagai gambar PNG beresolusi tinggi menggunakan `html2canvas`.

### D. Visualisasi Chart.js
1. **Grafik Distribusi Jenis Peraturan** (`#chartPeraturan`):
   - Vertical bar chart dengan *rounded corners* (`borderRadius: 6`).
   - Warna batang dinamis diambil dari master `chart_color` atau palet kontras tinggi.
   - Tooltip kustom menampilkan nama jenis, jumlah dokumen, dan persentase.
   - Tombol **Unduh Grafik** ke PNG.
2. **Grafik Tren Tahunan Produk Hukum** (`#statusChart`):
   - Grouped bar chart menampilkan komparasi status Berlaku (Biru) vs Tidak Berlaku (Merah).
   - Skala sumbu Y dinamis menyesuaikan data tertinggi (tidak lagi *hardcoded* 100).
   - Tombol **Unduh Grafik** ke PNG.

---

## 4. File-File yang Terlibat

| No | File Path | Keterangan Perubahan |
|----|-----------|----------------------|
| 1 | `app/Http/Controllers/Front/StatisticController.php` | Controller baru: mesin kalkulasi statistik dan endpoint API. |
| 2 | `app/Http/Controllers/Front/PageController.php` | Memperbarui method `getAboutStatistik` agar menggunakan agregasi dinamis. |
| 3 | `resources/views/dynamic/pages/about-statistik.blade.php` | Upgrade tampilan: KPI cards, dual filter, progress bar, Chart.js AJAX sync, dan PNG download. |
| 4 | `routes/web.php` | Mendaftarkan route `/statistik-produk-hukum` dan API endpoints `/api/statistics/*`. |
