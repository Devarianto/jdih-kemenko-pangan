@extends('cactuar::admin.layout-master')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col-md-7">
        <h1 class="h3 d-inline align-middle fw-bold text-dark">
            <i class="fas fa-chart-bar text-primary me-2"></i>Statistik Produk Hukum
        </h1>
        <p class="text-muted mb-0 small">
            Monitoring distribusi produk hukum secara terperinci berdasarkan jenis regulasi, tahun penerbitan, analisis matriks perbandingan, dan drilldown dokumen sumber.
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle shadow-sm" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-file-pdf me-1"></i> Ekspor Laporan PDF
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item py-2" href="#" onclick="exportPdf('all'); return false;">
                        <i class="fas fa-layer-group text-primary me-2"></i> Ekspor Seluruh Statistik (Lengkap)
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#" onclick="exportPdf('filter'); return false;">
                        <i class="fas fa-filter text-success me-2"></i> Ekspor Berdasarkan Filter Aktif
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#" onclick="exportPdf('year'); return false;">
                        <i class="fas fa-calendar-alt text-warning me-2"></i> Ekspor Menurut Tahun Terpilih
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="#" onclick="exportPdf('type'); return false;">
                        <i class="fas fa-balance-scale text-info me-2"></i> Ekspor Menurut Jenis Terpilih
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item py-2" href="#" onclick="exportPdf('documents'); return false;">
                        <i class="fas fa-list text-secondary me-2"></i> Ekspor Daftar Dokumen Hasil Filter
                    </a>
                </li>
            </ul>
        </div>
        <button type="button" class="btn btn-outline-secondary ms-2 shadow-sm" onclick="resetFilters()">
            <i class="fas fa-redo-alt me-1"></i> Reset
        </button>
    </div>
</div>

{{-- FILTER INTERAKTIF TERINTEGRASI --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <div class="row g-3 align-items-center">
            <div class="col-auto d-flex align-items-center text-primary fw-bold">
                <i class="fas fa-sliders-h me-2"></i> Filter:
            </div>
            {{-- Filter Tahun --}}
            <div class="col-md-3 col-sm-6">
                <label for="filter-year" class="form-label small fw-semibold text-muted mb-1">Tahun Penerbitan / Penetapan</label>
                <select id="filter-year" class="form-select form-select-sm">
                    <option value="all">Semua Tahun</option>
                    @foreach($stats['filters']['available_years'] as $yr)
                        <option value="{{ $yr }}" @selected($stats['filters']['selected_year'] == $yr)>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Filter Jenis Peraturan --}}
            <div class="col-md-3 col-sm-6">
                <label for="filter-rule-type" class="form-label small fw-semibold text-muted mb-1">Jenis Peraturan</label>
                <select id="filter-rule-type" class="form-select form-select-sm">
                    <option value="all">Semua Jenis Peraturan</option>
                    @foreach($stats['filters']['available_rule_types'] as $rt)
                        <option value="{{ $rt['id'] }}" @selected($stats['filters']['selected_rule_type_id'] == $rt['id'])>{{ $rt['label'] }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Filter Status Keberlakuan --}}
            <div class="col-md-3 col-sm-6">
                <label for="filter-status" class="form-label small fw-semibold text-muted mb-1">Status Keberlakuan</label>
                <select id="filter-status" class="form-select form-select-sm">
                    <option value="all">Semua Status (Berlaku & Tidak)</option>
                    <option value="1">Berlaku</option>
                    <option value="0">Tidak Berlaku</option>
                </select>
            </div>
            <div class="col-auto ms-auto align-self-end">
                <span id="filter-badge-indicator" class="badge bg-light text-dark border px-3 py-2 small">
                    <i class="fas fa-check-circle text-success me-1"></i> Data Real-Time Aktual
                </span>
            </div>
        </div>
    </div>
</div>

{{-- KPI SUMMARY CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 bg-primary text-white position-relative overflow-hidden">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-semibold small">Total Produk Hukum</span>
                        <h2 id="kpi-total" class="fw-bold my-1 text-white">{{ number_format($stats['summary']['total_documents']) }}</h2>
                        <span class="small text-white-50">Dokumen Regulasi Aktif</span>
                    </div>
                    <div class="opacity-25 me-1">
                        <i class="fas fa-file-contract fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 bg-success text-white position-relative overflow-hidden">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase fw-semibold small">Jenis Peraturan</span>
                        <h2 id="kpi-types" class="fw-bold my-1 text-white">{{ $stats['summary']['total_active_rule_types'] }}</h2>
                        <span class="small text-white-50">Kategori Regulasi Tersedia</span>
                    </div>
                    <div class="opacity-25 me-1">
                        <i class="fas fa-layer-group fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 bg-warning text-dark position-relative overflow-hidden">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-dark text-uppercase fw-semibold small opacity-75">Tahun Terbanyak</span>
                        <h2 id="kpi-top-year" class="fw-bold my-1 text-dark">{{ $stats['summary']['top_year']['year'] ?? '-' }}</h2>
                        <span id="kpi-top-year-count" class="small opacity-75">{{ $stats['summary']['top_year']['count'] ?? 0 }} Produk Ditetapkan</span>
                    </div>
                    <div class="opacity-25 me-1">
                        <i class="fas fa-calendar-check fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 bg-white border">
            <div class="card-body p-3">
                <span class="text-muted text-uppercase fw-semibold small d-block mb-1">Status Keberlakuan</span>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="text-center flex-fill">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small fw-bold" id="kpi-berlaku-badge">
                            {{ $stats['summary']['status_berlaku']['percentage'] }}%
                        </span>
                        <h4 id="kpi-berlaku-count" class="fw-bold text-dark mt-1 mb-0">{{ $stats['summary']['status_berlaku']['count'] }}</h4>
                        <small class="text-muted">Berlaku</small>
                    </div>
                    <div class="vr my-1"></div>
                    <div class="text-center flex-fill">
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small fw-bold" id="kpi-tidak-berlaku-badge">
                            {{ $stats['summary']['status_tidak_berlaku']['percentage'] }}%
                        </span>
                        <h4 id="kpi-tidak-berlaku-count" class="fw-bold text-dark mt-1 mb-0">{{ $stats['summary']['status_tidak_berlaku']['count'] }}</h4>
                        <small class="text-muted">Tdk Berlaku</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- GRAFIK VISUALISASI --}}
<div class="row g-4 mb-4">
    {{-- Chart 1: Distribusi Jenis Peraturan --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-chart-pie text-primary me-2"></i>Distribusi Jenis Peraturan
                </h5>
                <span class="badge bg-light text-muted border small"><i class="fas fa-mouse-pointer me-1"></i>Klik bar untuk drilldown</span>
            </div>
            <div class="card-body p-3">
                <div style="height: 320px; position: relative;">
                    <canvas id="chartByType"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart 2: Tren Tahunan Produk Hukum --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-chart-line text-success me-2"></i>Tren Tahunan (Status Keberlakuan)
                </h5>
                <span class="badge bg-light text-muted border small"><i class="fas fa-mouse-pointer me-1"></i>Klik bar tahun untuk drilldown</span>
            </div>
            <div class="card-body p-3">
                <div style="height: 320px; position: relative;">
                    <canvas id="chartByYear"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABEL MATRIKS PERBANDINGAN: JENIS PERATURAN X TAHUN --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="card-title mb-0 fw-bold text-dark">
                <i class="fas fa-table text-primary me-2"></i>Tabel Matriks Perbandingan Jenis Peraturan & Tahun
            </h5>
            <small class="text-muted">Klik pada angka sel mana pun untuk menampilkan daftar dokumen sumber di bawah secara instan.</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" id="toggleZeroRows" onchange="toggleZeroRows(this)">
                <label class="form-check-label small fw-semibold text-muted" for="toggleZeroRows">Sembunyikan baris kosong (0)</label>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" id="matrixTable">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th style="width: 40px;">No</th>
                        <th class="text-start" style="min-width: 220px;">Jenis Peraturan</th>
                        @foreach($matrix['years'] as $yr)
                            <th style="width: 65px;" class="cursor-pointer bg-light" onclick="filterByMatrixYear('{{ $yr }}')" title="Klik untuk filter tahun {{ $yr }}">
                                {{ $yr }}
                            </th>
                        @endforeach
                        <th style="width: 80px;" class="bg-primary-subtle text-primary fw-bold">Total</th>
                    </tr>
                </thead>
                <tbody id="matrixTableBody">
                    @php $no = 1; @endphp
                    @foreach($matrix['rows'] as $row)
                        <tr data-row-total="{{ $row['total'] }}" class="matrix-row {{ $row['total'] == 0 ? 'row-zero' : '' }}">
                            <td class="text-center text-muted small">{{ $no++ }}</td>
                            <td>
                                <span class="d-inline-block rounded-circle me-2" style="width: 9px; height: 9px; background-color: {{ $row['color'] }};"></span>
                                <span class="fw-semibold text-dark">{{ $row['label'] }}</span>
                            </td>
                            @foreach($matrix['years'] as $yr)
                                @php $c = $row['years'][$yr] ?? 0; @endphp
                                <td class="text-center">
                                    @if($c > 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary py-0 px-2 fw-bold text-nowrap matrix-cell-btn" 
                                                onclick="drilldownMatrix('{{ $row['id'] }}', '{{ $yr }}', '{{ e($row['label']) }}')"
                                                title="Tampilkan {{ $c }} dokumen {{ $row['label'] }} ({{ $yr }})">
                                            {{ $c }}
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-center bg-light">
                                @if($row['total'] > 0)
                                    <button type="button" 
                                            class="btn btn-sm btn-primary py-0 px-2 fw-bold text-nowrap" 
                                            onclick="drilldownMatrix('{{ $row['id'] }}', 'all', '{{ e($row['label']) }}')"
                                            title="Tampilkan seluruh {{ $row['total'] }} dokumen {{ $row['label'] }}">
                                        {{ $row['total'] }}
                                    </button>
                                @else
                                    <span class="text-muted fw-bold">0</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold text-center">
                        <td colspan="2" class="text-uppercase text-dark text-start ps-3">Total Keseluruhan</td>
                        @foreach($matrix['years'] as $yr)
                            @php $totYr = $matrix['col_totals'][$yr] ?? 0; @endphp
                            <td>
                                @if($totYr > 0)
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-dark py-0 px-2 fw-bold"
                                            onclick="drilldownMatrix('all', '{{ $yr }}', 'Semua Jenis')"
                                            title="Tampilkan seluruh dokumen tahun {{ $yr }}">
                                        {{ $totYr }}
                                    </button>
                                @else
                                    <span class="text-muted">0</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="bg-primary text-white fw-bold">
                            <button type="button" 
                                    class="btn btn-sm btn-light py-0 px-2 fw-bold text-primary"
                                    onclick="drilldownMatrix('all', 'all', 'Semua Jenis')"
                                    title="Tampilkan seluruh dokumen">
                                {{ $matrix['grand_total'] }}
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- DAFTAR DOKUMEN SUMBER STATISTIK (DRILLDOWN SECTION) --}}
<div class="card shadow-sm border-0 mb-4" id="drilldownSection">
    <div class="card-header bg-white py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <h5 class="card-title mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="fas fa-folder-open text-primary"></i>
                    Daftar Dokumen Sumber Statistik
                </h5>
                <span id="drilldownFilterContext" class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small">
                    Memuat seluruh dokumen produk hukum
                </span>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-inline-flex gap-2 w-100 justify-content-md-end">
                    {{-- Search Dokumen --}}
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="docSearchInput" class="form-control" placeholder="Cari judul / nomor peraturan..." onkeyup="debounceDocSearch()">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearDocSearch()"><i class="fas fa-times"></i></button>
                    </div>
                    {{-- Sort Dropdown --}}
                    <select id="docSortBy" class="form-select form-select-sm" style="max-width: 170px;" onchange="loadDocuments(1)">
                        <option value="tanggal_penetapan:desc">Tgl Penetapan (Terbaru)</option>
                        <option value="tanggal_penetapan:asc">Tgl Penetapan (Terlama)</option>
                        <option value="no_peraturan:asc">Nomor Peraturan (A-Z)</option>
                        <option value="no_peraturan:desc">Nomor Peraturan (Z-A)</option>
                        <option value="year:desc">Tahun (Terbaru)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="documentsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 45px;" class="text-center">No</th>
                        <th style="width: 110px;">No. Peraturan</th>
                        <th style="width: 170px;">Jenis Peraturan</th>
                        <th>Judul Dokumen Hukum</th>
                        <th style="width: 70px;" class="text-center">Tahun</th>
                        <th style="width: 120px;" class="text-center">Tgl Penetapan</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="documentsTableBody">
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            Memuat data dokumen...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="small text-muted" id="docPaginationInfo">
            Menampilkan 0 dari 0 dokumen
        </div>
        <div>
            <ul class="pagination pagination-sm mb-0" id="docPaginationLinks">
                {{-- Dynamic Pagination Buttons via JS --}}
            </ul>
        </div>
    </div>
</div>

{{-- MODAL DETAIL DOKUMEN --}}
<div class="modal fade" id="modalDocDetail" tabindex="-1" aria-labelledby="modalDocDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalDocDetailLabel">
                    <i class="fas fa-file-alt me-2"></i>Rincian Dokumen Hukum
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalDocDetailBody">
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <a href="#" id="modalBtnAdminEdit" class="btn btn-primary btn-sm" target="_blank">
                    <i class="fas fa-edit me-1"></i> Buka di Halaman Pengelolaan Dokumen
                </a>
                <a href="#" id="modalBtnPublicView" class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Publik
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@stack('assets')
@push('assets')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .cursor-pointer { cursor: pointer; }
    .matrix-cell-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 6px rgba(13, 110, 253, 0.25);
    }
    .row-zero { display: table-row; }
    .row-zero.hidden { display: none !important; }
    #drilldownSection {
        scroll-margin-top: 80px;
    }
    .pagination .page-link {
        color: #1e293b !important;
        font-weight: 600 !important;
        border-color: #cbd5e1 !important;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #ffffff !important;
    }
    .pagination .page-item.disabled .page-link {
        color: #94a3b8 !important;
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }
</style>
<script>
    let chartByTypeInstance = null;
    let chartByYearInstance = null;
    let currentStats = @json($stats);
    let currentMatrix = @json($matrix);
    let searchTimer = null;
    let activeDrilldownState = {
        year: 'all',
        rule_type_id: 'all',
        status_berlaku: 'all',
        q: '',
        sort_by: 'tanggal_penetapan',
        sort_dir: 'desc',
        page: 1,
        per_page: 10,
        context_label: 'Semua Produk Hukum'
    };

    document.addEventListener("DOMContentLoaded", function () {
        initChartByType(currentStats.by_type);
        initChartByYear(currentStats.by_year);
        bindFilterEvents();
        loadDocuments(1);
    });

    // 1. Chart Jenis Peraturan
    function initChartByType(byTypeData) {
        const ctx = document.getElementById('chartByType').getContext('2d');
        const activeData = byTypeData.filter(item => item.count > 0);
        const labels = activeData.map(item => item.label);
        const counts = activeData.map(item => item.count);
        const colors = activeData.map(item => item.color);
        const ids = activeData.map(item => item.id);

        if (chartByTypeInstance) chartByTypeInstance.destroy();

        chartByTypeInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['Tidak Ada Data'],
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: counts.length ? counts : [0],
                    backgroundColor: colors.length ? colors : ['#cbd5e1'],
                    borderRadius: 5,
                    ruleTypeIds: ids
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Jumlah: ${ctx.raw} dokumen (Klik untuk drilldown)`
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(val) {
                                const lbl = this.getLabelForValue(val);
                                return lbl.length > 20 ? lbl.substring(0, 18) + '...' : lbl;
                            },
                            font: { size: 10 }
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const idx = elements[0].index;
                        const ruleTypeId = activeData[idx].id;
                        const label = activeData[idx].label;
                        drilldownMatrix(ruleTypeId, document.getElementById('filter-year').value, label);
                    }
                }
            }
        });
    }

    // 2. Chart Tren Tahunan
    function initChartByYear(byYearData) {
        const ctx = document.getElementById('chartByYear').getContext('2d');
        const labels = byYearData.map(item => item.year);
        const berlaku = byYearData.map(item => item.berlaku_count);
        const tidakBerlaku = byYearData.map(item => item.tidak_berlaku_count);

        if (chartByYearInstance) chartByYearInstance.destroy();

        chartByYearInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['-'],
                datasets: [
                    {
                        label: 'Berlaku',
                        data: berlaku.length ? berlaku : [0],
                        backgroundColor: '#16a34a',
                        borderRadius: 4
                    },
                    {
                        label: 'Tidak Berlaku',
                        data: tidakBerlaku.length ? tidakBerlaku : [0],
                        backgroundColor: '#dc2626',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            afterLabel: () => 'Klik bar tahun untuk melihat dokumen'
                        }
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const idx = elements[0].index;
                        const yr = labels[idx];
                        drilldownMatrix(document.getElementById('filter-rule-type').value, yr, 'Tahun ' + yr);
                    }
                }
            }
        });
    }

    // Filter Change Handler
    function bindFilterEvents() {
        const filterYear = document.getElementById('filter-year');
        const filterType = document.getElementById('filter-rule-type');
        const filterStatus = document.getElementById('filter-status');

        function onFilterChange() {
            activeDrilldownState.year = filterYear.value;
            activeDrilldownState.rule_type_id = filterType.value;
            activeDrilldownState.status_berlaku = filterStatus.value;
            activeDrilldownState.page = 1;

            updateDrilldownLabel();
            reloadStatsAndMatrix();
            loadDocuments(1);
        }

        filterYear.addEventListener('change', onFilterChange);
        filterType.addEventListener('change', onFilterChange);
        filterStatus.addEventListener('change', onFilterChange);
    }

    function resetFilters() {
        document.getElementById('filter-year').value = 'all';
        document.getElementById('filter-rule-type').value = 'all';
        document.getElementById('filter-status').value = 'all';
        document.getElementById('docSearchInput').value = '';

        activeDrilldownState = {
            year: 'all',
            rule_type_id: 'all',
            status_berlaku: 'all',
            q: '',
            sort_by: 'tanggal_penetapan',
            sort_dir: 'desc',
            page: 1,
            per_page: 10,
            context_label: 'Semua Produk Hukum'
        };

        updateDrilldownLabel();
        reloadStatsAndMatrix();
        loadDocuments(1);
    }

    function reloadStatsAndMatrix() {
        const params = new URLSearchParams({
            year: activeDrilldownState.year,
            rule_type_id: activeDrilldownState.rule_type_id,
            status_berlaku: activeDrilldownState.status_berlaku,
        });

        fetch('{{ url(ADMIN . "/dashboard-statistik/data") }}?' + params.toString())
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    currentStats = res.stats;
                    currentMatrix = res.matrix;
                    updateKPICards(currentStats);
                    initChartByType(currentStats.by_type);
                    initChartByYear(currentStats.by_year);
                    renderMatrixTable(currentMatrix);
                }
            })
            .catch(err => console.error('Error reloading statistics:', err));
    }

    function updateKPICards(data) {
        document.getElementById('kpi-total').textContent = Number(data.summary.total_documents).toLocaleString();
        document.getElementById('kpi-types').textContent = data.summary.total_active_rule_types;
        document.getElementById('kpi-top-year').textContent = data.summary.top_year.year || '-';
        document.getElementById('kpi-top-year-count').textContent = (data.summary.top_year.count || 0) + ' Produk Ditetapkan';

        document.getElementById('kpi-berlaku-badge').textContent = data.summary.status_berlaku.percentage + '%';
        document.getElementById('kpi-berlaku-count').textContent = data.summary.status_berlaku.count;
        document.getElementById('kpi-tidak-berlaku-badge').textContent = data.summary.status_tidak_berlaku.percentage + '%';
        document.getElementById('kpi-tidak-berlaku-count').textContent = data.summary.status_tidak_berlaku.count;
    }

    function renderMatrixTable(matrix) {
        // Re-render the matrix dynamically
        const theadTr = document.querySelector('#matrixTable thead tr');
        let headerHtml = `<th style="width: 40px;">No</th><th class="text-start" style="min-width: 220px;">Jenis Peraturan</th>`;
        matrix.years.forEach(yr => {
            headerHtml += `<th style="width: 65px;" class="cursor-pointer bg-light" onclick="filterByMatrixYear('${yr}')" title="Klik untuk filter tahun ${yr}">${yr}</th>`;
        });
        headerHtml += `<th style="width: 80px;" class="bg-primary-subtle text-primary fw-bold">Total</th>`;
        theadTr.innerHTML = headerHtml;

        const tbody = document.getElementById('matrixTableBody');
        let bodyHtml = '';
        matrix.rows.forEach((row, idx) => {
            const isZero = row.total === 0;
            bodyHtml += `<tr data-row-total="${row.total}" class="matrix-row ${isZero ? 'row-zero' : ''}">
                <td class="text-center text-muted small">${idx + 1}</td>
                <td>
                    <span class="d-inline-block rounded-circle me-2" style="width: 9px; height: 9px; background-color: ${row.color};"></span>
                    <span class="fw-semibold text-dark">${row.label}</span>
                </td>`;

            matrix.years.forEach(yr => {
                const c = row.years[yr] || 0;
                if (c > 0) {
                    bodyHtml += `<td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 fw-bold text-nowrap matrix-cell-btn" 
                                onclick="drilldownMatrix('${row.id}', '${yr}', '${row.label.replace(/'/g, "\\'")}')"
                                title="Tampilkan ${c} dokumen ${row.label} (${yr})">${c}</button>
                    </td>`;
                } else {
                    bodyHtml += `<td class="text-center"><span class="text-muted small">-</span></td>`;
                }
            });

            bodyHtml += `<td class="text-center bg-light">
                ${row.total > 0 ? `<button type="button" class="btn btn-sm btn-primary py-0 px-2 fw-bold text-nowrap" onclick="drilldownMatrix('${row.id}', 'all', '${row.label.replace(/'/g, "\\'")}')">${row.total}</button>` : '<span class="text-muted fw-bold">0</span>'}
            </td></tr>`;
        });
        tbody.innerHTML = bodyHtml;

        // Apply toggleZeroRows setting if checked
        toggleZeroRows(document.getElementById('toggleZeroRows'));
    }

    function toggleZeroRows(checkbox) {
        const rows = document.querySelectorAll('.matrix-row.row-zero');
        rows.forEach(r => {
            if (checkbox.checked) {
                r.classList.add('hidden');
            } else {
                r.classList.remove('hidden');
            }
        });
    }

    function filterByMatrixYear(yr) {
        document.getElementById('filter-year').value = yr;
        activeDrilldownState.year = yr;
        drilldownMatrix(activeDrilldownState.rule_type_id, yr, 'Tahun ' + yr);
    }

    // MATRIX INTERACTIVE CLICK -> DRILLDOWN
    function drilldownMatrix(ruleTypeId, year, label) {
        activeDrilldownState.rule_type_id = ruleTypeId;
        activeDrilldownState.year = year;
        activeDrilldownState.page = 1;

        if (ruleTypeId !== 'all') {
            document.getElementById('filter-rule-type').value = ruleTypeId;
        }
        if (year !== 'all') {
            document.getElementById('filter-year').value = year;
        }

        let context = label || '';
        if (year !== 'all') context += ' — Tahun ' + year;
        activeDrilldownState.context_label = context;

        updateDrilldownLabel();
        loadDocuments(1);

        // Scroll to drilldown section smoothly
        const target = document.getElementById('drilldownSection');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function updateDrilldownLabel() {
        const yr = document.getElementById('filter-year').value;
        const rtSelect = document.getElementById('filter-rule-type');
        const rtText = rtSelect.options[rtSelect.selectedIndex].text;
        const stSelect = document.getElementById('filter-status');
        const stText = stSelect.value !== 'all' ? ` (${stSelect.options[stSelect.selectedIndex].text})` : '';

        let text = `${rtText} — ${yr === 'all' ? 'Semua Tahun' : 'Tahun ' + yr}${stText}`;
        document.getElementById('drilldownFilterContext').innerHTML = `<i class="fas fa-filter me-1"></i> Filter: <strong>${text}</strong>`;
    }

    // LOAD DOCUMENTS VIA AJAX
    function loadDocuments(page = 1, shouldScroll = false) {
        activeDrilldownState.page = page;
        const sortVal = document.getElementById('docSortBy').value.split(':');
        activeDrilldownState.sort_by = sortVal[0];
        activeDrilldownState.sort_dir = sortVal[1] || 'desc';
        activeDrilldownState.q = document.getElementById('docSearchInput').value.trim();

        const tbody = document.getElementById('documentsTableBody');
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">
            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
            Memuat daftar dokumen...
        </td></tr>`;

        const params = new URLSearchParams({
            year: activeDrilldownState.year,
            rule_type_id: activeDrilldownState.rule_type_id,
            status_berlaku: activeDrilldownState.status_berlaku,
            q: activeDrilldownState.q,
            sort_by: activeDrilldownState.sort_by,
            sort_dir: activeDrilldownState.sort_dir,
            page: activeDrilldownState.page,
            per_page: activeDrilldownState.per_page,
            is_admin: 1
        });

        fetch('{{ url(ADMIN . "/dashboard-statistik/documents") }}?' + params.toString())
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success' && res.data) {
                    renderDocumentsTable(res.data);
                    if (shouldScroll) {
                        const target = document.getElementById('drilldownSection');
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                }
            })
            .catch(err => {
                console.error('Error fetching documents:', err);
                tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-danger">Gagal memuat dokumen. Silakan coba lagi.</td></tr>`;
            });
    }

    function renderDocumentsTable(pageData) {
        const tbody = document.getElementById('documentsTableBody');
        const items = pageData.data || [];

        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x text-muted mb-2 d-block"></i>
                Tidak ada dokumen yang ditemukan untuk parameter ini.
            </td></tr>`;
            document.getElementById('docPaginationInfo').textContent = 'Menampilkan 0 dari 0 dokumen';
            document.getElementById('docPaginationLinks').innerHTML = '';
            return;
        }

        let html = '';
        const offset = (pageData.from || 1);
        items.forEach((item, index) => {
            const no = offset + index;
            const statusBadge = item.status_berlaku === 1
                ? `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Berlaku</span>`
                : `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Tdk Berlaku</span>`;

            html += `<tr>
                <td class="text-center text-muted small">${no}</td>
                <td class="fw-bold text-dark text-nowrap">${item.no_peraturan || '-'}</td>
                <td><span class="badge bg-light text-dark border">${item.rule_type_name}</span></td>
                <td>
                    <div class="fw-semibold text-dark mb-1" style="max-width: 480px; line-height: 1.35;">
                        ${escapeHtml(item.title)}
                    </div>
                </td>
                <td class="text-center fw-semibold">${item.year}</td>
                <td class="text-center small text-muted text-nowrap">${item.tanggal_penetapan_formatted || '-'}</td>
                <td class="text-center">${statusBadge}</td>
                <td class="text-center text-nowrap">
                    <button type="button" class="btn btn-sm btn-outline-info me-1" onclick="showDocDetail(${item.id})" title="Detail Singkat">
                        <i class="fas fa-eye"></i>
                    </button>
                    <a href="${item.admin_edit_url}" class="btn btn-sm btn-outline-primary me-1" target="_blank" title="Kelola di Admin">
                        <i class="fas fa-edit"></i>
                    </a>
                    ${item.pdf_url ? `<a href="${item.pdf_url}" class="btn btn-sm btn-outline-danger" target="_blank" title="Download PDF"><i class="fas fa-file-pdf"></i></a>` : ''}
                </td>
            </tr>`;
        });

        tbody.innerHTML = html;

        // Update Pagination Info
        document.getElementById('docPaginationInfo').textContent = 
            `Menampilkan ${pageData.from} - ${pageData.to} dari ${pageData.total} dokumen`;

        // Render Pagination Links
        renderPaginationLinks(pageData);
    }

    function renderPaginationLinks(pageData) {
        const container = document.getElementById('docPaginationLinks');
        const curr = pageData.current_page;
        const last = pageData.last_page;

        if (last <= 1) {
            container.innerHTML = '';
            return;
        }

        let html = '';
        // Previous
        html += `<li class="page-item ${curr === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadDocuments(${curr - 1}, true); return false;">&laquo;</a>
        </li>`;

        // Pages
        const start = Math.max(1, curr - 2);
        const end = Math.min(last, curr + 2);

        if (start > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="loadDocuments(1, true); return false;">1</a></li>`;
            if (start > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }

        for (let i = start; i <= end; i++) {
            html += `<li class="page-item ${i === curr ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadDocuments(${i}, true); return false;">${i}</a>
            </li>`;
        }

        if (end < last) {
            if (end < last - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            html += `<li class="page-item"><a class="page-link" href="#" onclick="loadDocuments(${last}, true); return false;">${last}</a></li>`;
        }

        // Next
        html += `<li class="page-item ${curr === last ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadDocuments(${curr + 1}, true); return false;">&raquo;</a>
        </li>`;

        container.innerHTML = html;
    }

    function debounceDocSearch() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            loadDocuments(1);
        }, 400);
    }

    function clearDocSearch() {
        document.getElementById('docSearchInput').value = '';
        loadDocuments(1);
    }

    // MODAL DETAIL DOKUMEN
    function showDocDetail(docId) {
        const modal = new bootstrap.Modal(document.getElementById('modalDocDetail'));
        const body = document.getElementById('modalDocDetailBody');
        body.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>`;
        modal.show();

        const params = new URLSearchParams({ id: docId, is_admin: 1 });
        fetch('{{ url(ADMIN . "/dashboard-statistik/documents") }}?q=' + docId + '&is_admin=1')
            .then(res => res.json())
            .then(res => {
                const doc = (res.data && res.data.data) ? res.data.data.find(d => d.id == docId) : null;
                if (!doc) {
                    body.innerHTML = `<div class="alert alert-warning">Dokumen tidak ditemukan.</div>`;
                    return;
                }

                document.getElementById('modalBtnAdminEdit').href = doc.admin_edit_url;
                if (doc.public_url) {
                    document.getElementById('modalBtnPublicView').href = doc.public_url;
                    document.getElementById('modalBtnPublicView').classList.remove('d-none');
                } else {
                    document.getElementById('modalBtnPublicView').classList.add('d-none');
                }

                body.innerHTML = `
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width: 180px;">Judul Dokumen</th>
                                    <td class="fw-bold text-dark">${escapeHtml(doc.title)}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nomor Peraturan</th>
                                    <td>${doc.no_peraturan || '-'}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis Peraturan</th>
                                    <td><span class="badge bg-light text-dark border">${doc.rule_type_name}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tahun</th>
                                    <td>${doc.year}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Penetapan</th>
                                    <td>${doc.tanggal_penetapan_formatted || '-'}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Pengundangan</th>
                                    <td>${doc.tanggal_pengundangan_formatted || '-'}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status Keberlakuan</th>
                                    <td>${doc.status_berlaku === 1 ? '<span class="badge bg-success">Berlaku</span>' : '<span class="badge bg-danger">Tidak Berlaku</span>'}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">File PDF Resmi</th>
                                    <td>
                                        ${doc.pdf_url ? `<a href="${doc.pdf_url}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf me-1"></i> Unduh File PDF</a>` : '<span class="text-muted">Tidak ada file</span>'}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `;
            })
            .catch(err => {
                body.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memuat rincian dokumen.</div>`;
            });
    }

    // EXPORT PDF HANDLER
    function exportPdf(mode = 'all') {
        const year = (mode === 'year' || mode === 'filter' || mode === 'documents') ? document.getElementById('filter-year').value : 'all';
        const ruleType = (mode === 'type' || mode === 'filter' || mode === 'documents') ? document.getElementById('filter-rule-type').value : 'all';
        const status = (mode === 'filter' || mode === 'documents') ? document.getElementById('filter-status').value : 'all';
        const q = (mode === 'documents') ? document.getElementById('docSearchInput').value.trim() : '';

        const params = new URLSearchParams({
            mode: mode,
            year: year,
            rule_type_id: ruleType,
            status_berlaku: status,
            q: q,
            is_admin: 1,
            download: 1
        });

        const url = '{{ url(ADMIN . "/dashboard-statistik/download") }}?' + params.toString();
        window.open(url, '_blank');
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
@endpush

