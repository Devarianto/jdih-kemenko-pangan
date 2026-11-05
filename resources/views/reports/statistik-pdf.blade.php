<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $reportTitle ?? 'Laporan Statistik Produk Hukum JDIH' }}</title>
    <style>
        @page {
            margin: 28px 32px 35px 32px;
            size: a4 landscape;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.35;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Resmi Pemerintah */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border-bottom: 3px double #0f172a;
            padding-bottom: 8px;
        }
        .kop-logo {
            width: 85px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            max-width: 80px;
            max-height: 80px;
        }
        .kop-content {
            text-align: center;
            vertical-align: middle;
            padding-left: 10px;
            padding-right: 40px;
        }
        .kop-instansi {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #0f172a;
            margin: 0 0 2px 0;
        }
        .kop-unit {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #1d4ed8;
            margin: 0 0 2px 0;
        }
        .kop-sub {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #334155;
            margin: 0 0 3px 0;
        }
        .kop-alamat {
            font-size: 8.5px;
            color: #64748b;
            margin: 0;
        }

        /* Judul Laporan */
        .report-header {
            text-align: center;
            margin: 12px 0 14px 0;
        }
        .report-title {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin: 0 0 4px 0;
        }
        .report-meta {
            font-size: 9px;
            color: #64748b;
            margin: 0;
        }

        /* Parameter Filter Box */
        .filter-info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }
        .filter-info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .filter-info-table td {
            padding: 2px 4px;
        }
        .filter-label {
            font-weight: 700;
            color: #475569;
            width: 130px;
        }
        .filter-val {
            color: #0f172a;
            font-weight: 600;
        }

        /* KPI Summary Grid */
        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 16px;
        }
        .kpi-cell {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            text-align: center;
            width: 25%;
        }
        .kpi-num {
            font-size: 18px;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 2px;
        }
        .kpi-title {
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.3px;
        }
        .kpi-desc {
            font-size: 8px;
            color: #94a3b8;
        }

        /* Section Title */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin: 14px 0 6px 0;
            border-left: 3px solid #2563eb;
            padding-left: 6px;
        }

        /* Data Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 8.5px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 4px 6px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
        }
        table.data-table td.center {
            text-align: center;
        }
        table.data-table td.right {
            text-align: right;
        }
        table.data-table tr.total-row {
            background-color: #e2e8f0;
            font-weight: 700;
        }
        table.data-table tr.odd {
            background-color: #f8fafc;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-berlaku {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }
        .badge-tidak-berlaku {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Page break utilities */
        .page-break {
            page-break-after: always;
        }
        tr {
            page-break-inside: avoid;
        }
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-footer-group;
        }

        .footer-note {
            font-size: 7.5px;
            color: #94a3b8;
            margin-top: 15px;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT PEMERINTAH RESMI --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @php
                    $logoPath = public_path('assets/source/images/logo-institusi/logo-kemenko-pangan-institusi.png');
                    $logoBase64 = '';
                    if (file_exists($logoPath)) {
                        $logoData = file_get_contents($logoPath);
                        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
                    }
                @endphp
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Kemenko Pangan">
                @else
                    <div style="font-weight: bold; font-size: 16px; color: #1e3a8a;">KEMENKO PANGAN</div>
                @endif
            </td>
            <td class="kop-content">
                <div class="kop-instansi">KEMENTERIAN KOORDINATOR BIDANG PANGAN</div>
                <div class="kop-unit">JARINGAN DOKUMENTASI DAN INFORMASI HUKUM (JDIH)</div>
                <div class="kop-sub">BIRO HUKUM DAN KERJA SAMA</div>
                <div class="kop-alamat">
                    Situs Resmi: https://jdih.kemenkopangan.go.id | Email: jdih@kemenkopangan.go.id<br>
                    Laman Administrasi Sistem Dokumentasi dan Informasi Hukum Nasional
                </div>
            </td>
        </tr>
    </table>

    {{-- JUDUL LAPORAN --}}
    <div class="report-header">
        <div class="report-title">{{ $reportTitle ?? 'LAPORAN STATISTIK DAN DISTRIBUSI PRODUK HUKUM' }}</div>
        <div class="report-meta">
            Dicetak pada: <strong>{{ $generatedAt ?? date('d F Y, H:i') . ' WIB' }}</strong> | Status Sistem: <strong>Aktif / Sinkronisasi Real-Time</strong>
        </div>
    </div>

    {{-- PARAMETER FILTER AKTIF --}}
    <div class="filter-info-box">
        <table class="filter-info-table">
            <tr>
                <td class="filter-label">Mode Ekspor:</td>
                <td class="filter-val">{{ $exportModeLabel ?? 'Seluruh Statistik & Dokumen' }}</td>
                <td class="filter-label">Filter Tahun:</td>
                <td class="filter-val">{{ $filterYearLabel ?? 'Semua Tahun' }}</td>
            </tr>
            <tr>
                <td class="filter-label">Filter Jenis:</td>
                <td class="filter-val">{{ $filterRuleTypeLabel ?? 'Semua Jenis Peraturan' }}</td>
                <td class="filter-label">Filter Status:</td>
                <td class="filter-val">{{ $filterStatusLabel ?? 'Semua Status (Berlaku & Tidak Berlaku)' }}</td>
            </tr>
        </table>
    </div>

    {{-- RINGKASAN EKSEKUTIF / KPI CARDS --}}
    @if(isset($stats['summary']))
    <table class="kpi-table">
        <tr>
            <td class="kpi-cell">
                <div class="kpi-num">{{ number_format($stats['summary']['total_documents'] ?? 0) }}</div>
                <div class="kpi-title">Total Dokumen</div>
                <div class="kpi-desc">Produk Hukum Sesuai Filter</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-num">{{ $stats['summary']['total_active_rule_types'] ?? 0 }}</div>
                <div class="kpi-title">Jenis Peraturan</div>
                <div class="kpi-desc">Kategori Regulasi Terdata</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-num" style="color: #16a34a;">
                    {{ number_format($stats['summary']['status_berlaku']['count'] ?? 0) }}
                    <span style="font-size: 10px; font-weight: normal; color: #64748b;">({{ $stats['summary']['status_berlaku']['percentage'] ?? 0 }}%)</span>
                </div>
                <div class="kpi-title">Status Berlaku</div>
                <div class="kpi-desc">Regulasi Masih Efektif</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-num" style="color: #dc2626;">
                    {{ number_format($stats['summary']['status_tidak_berlaku']['count'] ?? 0) }}
                    <span style="font-size: 10px; font-weight: normal; color: #64748b;">({{ $stats['summary']['status_tidak_berlaku']['percentage'] ?? 0 }}%)</span>
                </div>
                <div class="kpi-title">Tidak Berlaku</div>
                <div class="kpi-desc">Dicabut / Kadaluwarsa</div>
            </td>
        </tr>
    </table>
    @endif

    {{-- BAGIAN 1: TABEL MATRIKS PERBANDINGAN JENIS PERATURAN X TAHUN --}}
    @if(isset($matrix) && (!isset($hideMatrix) || !$hideMatrix))
    <div class="section-title">1. Matriks Distribusi Produk Hukum Berdasarkan Jenis Peraturan dan Tahun</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="text-align: left; width: 170px;">Jenis Peraturan</th>
                @foreach($matrix['years'] as $yr)
                    <th style="width: 35px;">{{ $yr }}</th>
                @endforeach
                <th style="width: 45px; background-color: #e2e8f0;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($matrix['rows'] as $row)
                <tr class="{{ $loop->odd ? 'odd' : '' }}">
                    <td class="center">{{ $no++ }}</td>
                    <td style="font-weight: 600;">{{ $row['label'] }}</td>
                    @foreach($matrix['years'] as $yr)
                        @php $val = $row['years'][$yr] ?? 0; @endphp
                        <td class="center" style="{{ $val > 0 ? 'font-weight: 700; color: #0f172a;' : 'color: #94a3b8;' }}">
                            {{ $val > 0 ? $val : '-' }}
                        </td>
                    @endforeach
                    <td class="center" style="font-weight: 800; background-color: #f1f5f9; color: #1e3a8a;">
                        {{ $row['total'] }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($matrix['years']) + 3 }}" class="center" style="padding: 12px; color: #94a3b8;">
                        Tidak ada data statistik ditemukan untuk parameter filter ini.
                    </td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="2" class="center" style="font-weight: 800; text-transform: uppercase;">Total Keseluruhan</td>
                @foreach($matrix['years'] as $yr)
                    <td class="center" style="font-weight: 800; color: #0f172a;">
                        {{ $matrix['col_totals'][$yr] ?? 0 }}
                    </td>
                @endforeach
                <td class="center" style="font-weight: 900; background-color: #cbd5e1; color: #0f172a; font-size: 9.5px;">
                    {{ $matrix['grand_total'] ?? 0 }}
                </td>
            </tr>
        </tbody>
    </table>
    @endif

    {{-- BAGIAN 2: STATISTIK PER JENIS & PERSENTASE --}}
    @if(isset($stats['by_type']) && count($stats['by_type']) > 0 && (!isset($hideByType) || !$hideByType))
    <div class="section-title">2. Distribusi & Persentase Jenis Peraturan</div>
    <table class="data-table" style="width: 70%;">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="text-align: left;">Jenis Peraturan</th>
                <th style="width: 65px;">Jumlah Dokumen</th>
                <th style="width: 65px;">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['by_type'] as $idx => $t)
            <tr class="{{ $loop->odd ? 'odd' : '' }}">
                <td class="center">{{ $idx + 1 }}</td>
                <td style="font-weight: 600;">{{ $t['label'] }}</td>
                <td class="center" style="font-weight: 700;">{{ $t['count'] }}</td>
                <td class="center">{{ $t['percentage'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- PAGE BREAK JIKA DILANJUTKAN DENGAN DAFTAR DOKUMEN --}}
    @if(isset($documents) && count($documents) > 0)
        <div class="page-break"></div>

        <div class="section-title" style="margin-top: 5px;">
            3. Rincian Dokumen Produk Hukum Sumber Statistik (Total: {{ count($documents) }} Dokumen)
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 22px;">No</th>
                    <th style="width: 85px;">Nomor Peraturan</th>
                    <th style="width: 100px;">Jenis Peraturan</th>
                    <th style="text-align: left;">Judul Dokumen Hukum</th>
                    <th style="width: 35px;">Tahun</th>
                    <th style="width: 75px;">Tgl Penetapan</th>
                    <th style="width: 65px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $docIdx => $d)
                <tr class="{{ $loop->odd ? 'odd' : '' }}">
                    <td class="center">{{ $docIdx + 1 }}</td>
                    <td class="center" style="font-weight: 700; color: #1e293b;">
                        {{ $d['no_peraturan'] ?: '-' }}
                    </td>
                    <td>{{ $d['rule_type_name'] ?? '-' }}</td>
                    <td style="font-weight: 500; line-height: 1.25;">
                        {{ $d['title'] }}
                    </td>
                    <td class="center">{{ $d['year'] }}</td>
                    <td class="center">{{ $d['tanggal_penetapan_formatted'] ?: '-' }}</td>
                    <td class="center">
                        @if($d['status_berlaku'] == 1)
                            <span class="badge badge-berlaku">Berlaku</span>
                        @else
                            <span class="badge badge-tidak-berlaku">Tdk Berlaku</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer-note">
        Dokumen ini diterbitkan secara otomatis melalui Sistem JDIH Kementerian Koordinator Bidang Pangan Republik Indonesia.<br>
        Seluruh data merupakan data aktual dan terotentikasi dari pangkalan data JDIH Kemenko Pangan.
    </div>

    {{-- Script Penomoran Halaman Otomatis Dompdf --}}
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT} | JDIH Kemenko Pangan - Laporan Statistik Resmi";
            $font = $fontMetrics->get_font("Helvetica", "italic");
            $size = 8;
            $color = array(0.4, 0.45, 0.5);
            $y = $pdf->get_height() - 22;
            $x = 32;
            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>
</body>
</html>
