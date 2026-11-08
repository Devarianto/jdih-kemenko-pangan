# Dokumentasi API Publik JDIH Kemenko Pangan

Dokumentasi ini menjelaskan endpoint REST API publik untuk fitur Statistik Produk Hukum dan Klasifikasi Video. Seluruh endpoint dapat diakses secara publik dan mengembalikan respon dalam format standar JSON.

---

## 1. Endpoint Statistik Produk Hukum

### A. Ringkasan & Data Lengkap Statistik
Mengambil seluruh data agregasi statistik (ringkasan KPI, distribusi jenis peraturan, tren tahunan, dan opsi filter).

- **URL**: `/api/statistics/legal-products`
- **Method**: `GET`
- **Query Parameters**:
  | Parameter | Tipe | Wajib | Keterangan |
  |-----------|------|-------|------------|
  | `year` | integer | Tidak | Memfilter data berdasarkan tahun penetapan (contoh: `2025`). |
  | `rule_type_id` | integer | Tidak | Memfilter data berdasarkan ID jenis peraturan (contoh: `6` untuk Perpres). |

#### Contoh Request:
```bash
curl -X GET "http://localhost:8000/api/statistics/legal-products?year=2025" -H "Accept: application/json"
```

#### Contoh Respon (200 OK):
```json
{
  "status": "success",
  "message": "Statistik Produk Hukum berhasil dimuat",
  "data": {
    "filters": {
      "selected_year": 2025,
      "selected_rule_type_id": null,
      "available_years": [2026, 2025, 2024, 2023, 2022, 2021, 2019, 2015],
      "available_rule_types": [
        { "id": 1, "label": "Undang-Undang Dasar" },
        { "id": 3, "label": "Undang-Undang" },
        { "id": 5, "label": "Peraturan Pemerintah" },
        { "id": 6, "label": "Peraturan Presiden" },
        { "id": 7, "label": "Instruksi Presiden" },
        { "id": 10, "label": "Peraturan Menteri" },
        { "id": 11, "label": "Keputusan Menteri" },
        { "id": 14, "label": "Keputusan Presiden" }
      ]
    },
    "summary": {
      "total_documents": 28,
      "total_active_rule_types": 6,
      "top_year": {
        "year": 2025,
        "count": 28
      },
      "status_berlaku": {
        "count": 28,
        "percentage": 100
      },
      "status_tidak_berlaku": {
        "count": 0,
        "percentage": 0
      }
    },
    "by_type": [
      {
        "id": 6,
        "label": "Peraturan Presiden",
        "name": "Peraturan Presiden",
        "count": 9,
        "percentage": 32.1,
        "color": "#ff9999"
      },
      {
        "id": 7,
        "label": "Instruksi Presiden",
        "name": "Instruksi Presiden",
        "count": 6,
        "percentage": 21.4,
        "color": "#fbceb1"
      },
      {
        "id": 10,
        "label": "Peraturan Menteri",
        "name": "Peraturan Menteri",
        "count": 4,
        "percentage": 14.3,
        "color": "#87ceeb"
      },
      {
        "id": 11,
        "label": "Keputusan Menteri",
        "name": "Keputusan Menteri",
        "count": 3,
        "percentage": 10.7,
        "color": "#80daeb"
      },
      {
        "id": 14,
        "label": "Keputusan Presiden",
        "name": "Keputusan Presiden",
        "count": 3,
        "percentage": 10.7,
        "color": "#00ff7f"
      },
      {
        "id": 5,
        "label": "Peraturan Pemerintah",
        "name": "Peraturan Pemerintah",
        "count": 3,
        "percentage": 10.7,
        "color": "#ffa07a"
      }
    ],
    "by_year": [
      {
        "year": 2025,
        "total_count": 28,
        "berlaku_count": 28,
        "tidak_berlaku_count": 0
      }
    ]
  }
}
```

---

### B. Statistik Berdasarkan Jenis Peraturan
Mengambil daftar jenis peraturan beserta jumlah dokumen dan persentase kontribusinya.

- **URL**: `/api/statistics/legal-products/by-type`
- **Method**: `GET`
- **Query Parameters**:
  - `year`: (opsional) Filter berdasarkan tahun.
  - `rule_type_id`: (opsional) Filter berdasarkan jenis.

#### Contoh Request:
```bash
curl -X GET "http://localhost:8000/api/statistics/legal-products/by-type" -H "Accept: application/json"
```

#### Contoh Respon (200 OK):
```json
{
  "status": "success",
  "filter": {
    "year": null,
    "rule_type_id": null
  },
  "total_documents": 47,
  "data": [
    {
      "id": 6,
      "label": "Peraturan Presiden",
      "name": "Peraturan Presiden",
      "count": 13,
      "percentage": 27.7,
      "color": "#ff9999"
    },
    {
      "id": 10,
      "label": "Peraturan Menteri",
      "name": "Peraturan Menteri",
      "count": 10,
      "percentage": 21.3,
      "color": "#87ceeb"
    },
    {
      "id": 5,
      "label": "Peraturan Pemerintah",
      "name": "Peraturan Pemerintah",
      "count": 9,
      "percentage": 19.1,
      "color": "#ffa07a"
    },
    {
      "id": 7,
      "label": "Instruksi Presiden",
      "name": "Instruksi Presiden",
      "count": 8,
      "percentage": 17.0,
      "color": "#fbceb1"
    },
    {
      "id": 11,
      "label": "Keputusan Menteri",
      "name": "Keputusan Menteri",
      "count": 3,
      "percentage": 6.4,
      "color": "#80daeb"
    },
    {
      "id": 14,
      "label": "Keputusan Presiden",
      "name": "Keputusan Presiden",
      "count": 3,
      "percentage": 6.4,
      "color": "#00ff7f"
    },
    {
      "id": 3,
      "label": "Undang-Undang",
      "name": "Undang-Undang",
      "count": 1,
      "percentage": 2.1,
      "color": "#FF0000"
    }
  ]
}
```

---

### C. Statistik Berdasarkan Tahun
Mengambil tren tahunan dokumen peraturan, dipisahkan berdasarkan status Berlaku vs Tidak Berlaku.

- **URL**: `/api/statistics/legal-products/by-year`
- **Method**: `GET`
- **Query Parameters**:
  - `rule_type_id`: (opsional) Filter berdasarkan jenis regulasi.
  - `year`: (opsional) Filter tahun spesifik.

#### Contoh Request:
```bash
curl -X GET "http://localhost:8000/api/statistics/legal-products/by-year?rule_type_id=6" -H "Accept: application/json"
```

#### Contoh Respon (200 OK):
```json
{
  "status": "success",
  "filter": {
    "year": null,
    "rule_type_id": 6
  },
  "total_documents": 13,
  "data": [
    {
      "year": 2022,
      "total_count": 2,
      "berlaku_count": 0,
      "tidak_berlaku_count": 2
    },
    {
      "year": 2024,
      "total_count": 1,
      "berlaku_count": 1,
      "tidak_berlaku_count": 0
    },
    {
      "year": 2025,
      "total_count": 9,
      "berlaku_count": 9,
      "tidak_berlaku_count": 0
    },
    {
      "year": 2026,
      "total_count": 1,
      "berlaku_count": 1,
      "tidak_berlaku_count": 0
    }
  ]
}
```

---

## 2. Endpoint Klasifikasi Video

### A. Daftar Video & Filter Klasifikasi
Mengambil daftar video terpublikasi dengan metadata lengkap, URL embed normal YouTube, thumbnail, dan array klasifikasi relasional.

- **URL**: `/api/videos`
- **Method**: `GET`
- **Query Parameters**:
  | Parameter | Pilihan Nilai | Keterangan |
  |-----------|---------------|------------|
  | `category` | `gallery`, `galeri`, `accessibility`, `aksesibilitas` | Filter berdasarkan kategori klasifikasi video. Jika dikosongkan, menampilkan seluruh video aktif. |

#### Contoh Request (Kategori Aksesibilitas):
```bash
curl -X GET "http://localhost:8000/api/videos?category=accessibility" -H "Accept: application/json"
```

#### Contoh Respon (200 OK):
```json
{
  "status": "success",
  "category": "accessibility",
  "total": 1,
  "data": [
    {
      "id": 1,
      "title": "Sharing Session Penguatan Layanan Advokasi Hukum",
      "slug": "sharing-session-penguatan-layanan-advokasi-hukum",
      "description": "Video sharing session terkait penguatan fungsi advokasi dan kepatuhan hukum.",
      "video_url": "https://www.youtube.com/embed/oBR-jUrOZ68",
      "embed_url": "https://www.youtube.com/embed/oBR-jUrOZ68",
      "thumbnail_url": "http://localhost:8000/assets/source/assets/thumbs/images/gallery/cover_360_360_cover-video-sharing-session-2.png.webp",
      "date": "2025-11-02",
      "sort_id": 0,
      "classifications": [
        {
          "id": 1,
          "code": "galeri",
          "name": "Galeri"
        },
        {
          "id": 2,
          "code": "aksesibilitas",
          "name": "Aksesibilitas"
        }
      ],
      "created_at": "2025-11-03T14:33:50+07:00",
      "updated_at": "2025-12-09T16:27:02+07:00"
    }
  ]
}
```
