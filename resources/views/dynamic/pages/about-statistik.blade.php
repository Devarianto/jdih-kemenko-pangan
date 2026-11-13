@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  
  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'content') as $content)
      <div class="middle__title">
        <h4>{{ $content->translated('title') }}</h4>
        <p>{{ $content->translated('description') }}</p>
      </div>
      @endforeach

      {{-- KPI SUMMARY CARDS --}}
      <div class="stat-summary-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin: 30px 0 40px;">
        {{-- Card 1: Total Dokumen --}}
        <div class="stat-card" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18); position: relative; overflow: hidden;">
          <div style="position: absolute; right: -10px; bottom: -10px; opacity: 0.15;">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="currentColor">
              <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
            </svg>
          </div>
          <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; font-weight: 500;">Total Produk Hukum</span>
          <div id="stat-kpi-total" style="font-size: 38px; font-weight: 700; margin: 8px 0 4px; line-height: 1;">
            {{ number_format($stats['summary']['total_documents']) }}
          </div>
          <small style="opacity: 0.85; font-size: 12px;">Dokumen Terpublikasi</small>
        </div>

        {{-- Card 2: Jenis Peraturan --}}
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.18); position: relative; overflow: hidden;">
          <div style="position: absolute; right: -10px; bottom: -10px; opacity: 0.15;">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="currentColor">
              <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z"/>
            </svg>
          </div>
          <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; font-weight: 500;">Jenis Peraturan Aktif</span>
          <div id="stat-kpi-types" style="font-size: 38px; font-weight: 700; margin: 8px 0 4px; line-height: 1;">
            {{ $stats['summary']['total_active_rule_types'] }}
          </div>
          <small style="opacity: 0.85; font-size: 12px;">Kategori Regulasi Tersedia</small>
        </div>

        {{-- Card 3: Tahun Terbanyak --}}
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.18); position: relative; overflow: hidden;">
          <div style="position: absolute; right: -10px; bottom: -10px; opacity: 0.15;">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
          </div>
          <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; font-weight: 500;">Tahun Terbanyak</span>
          <div id="stat-kpi-top-year" style="font-size: 38px; font-weight: 700; margin: 8px 0 4px; line-height: 1;">
            {{ $stats['summary']['top_year']['year'] ?? '-' }}
          </div>
          <small id="stat-kpi-top-year-count" style="opacity: 0.85; font-size: 12px;">
            {{ $stats['summary']['top_year']['count'] ?? 0 }} Produk Hukum Ditetapkan
          </small>
        </div>

        {{-- Card 4: Status Dokumen --}}
        <div class="stat-card" style="background: #ffffff; color: #1e293b; padding: 20px 22px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04); position: relative; display: flex; flex-direction: column; justify-content: space-between;">
          <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 600; display: block;">Status Keberlakuan</span>
          <div style="display: grid; grid-template-columns: 1fr 1px 1fr; align-items: stretch; gap: 14px; margin-top: 12px;">
            <div style="display: flex; flex-direction: column; justify-content: space-between; min-width: 0;">
              <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px; white-space: nowrap;">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: #16a34a; flex-shrink: 0;"></span>
                <span style="font-size: 12px; color: #16a34a; font-weight: 600; white-space: nowrap;">Berlaku</span>
              </div>
              <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; white-space: nowrap;">
                <div id="stat-kpi-berlaku-count" style="font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1; white-space: nowrap;">
                  {{ $stats['summary']['status_berlaku']['count'] }} <span style="font-size: 11px; font-weight: 400; color: #64748b;">dok</span>
                </div>
                <span id="stat-kpi-berlaku-badge" style="font-size: 11px; background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 999px; font-weight: 600; white-space: nowrap; line-height: 1.3;">
                  {{ $stats['summary']['status_berlaku']['percentage'] }}%
                </span>
              </div>
            </div>
            <div style="width: 1px; background: #e2e8f0;"></div>
            <div style="display: flex; flex-direction: column; justify-content: space-between; min-width: 0;">
              <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px; white-space: nowrap;">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: #dc2626; flex-shrink: 0;"></span>
                <span style="font-size: 12px; color: #dc2626; font-weight: 600; white-space: nowrap;">Tdk Berlaku</span>
              </div>
              <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; white-space: nowrap;">
                <div id="stat-kpi-tidak-berlaku-count" style="font-size: 22px; font-weight: 700; color: #0f172a; line-height: 1; white-space: nowrap;">
                  {{ $stats['summary']['status_tidak_berlaku']['count'] }} <span style="font-size: 11px; font-weight: 400; color: #64748b;">dok</span>
                </div>
                <span id="stat-kpi-tidak-berlaku-badge" style="font-size: 11px; background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 999px; font-weight: 600; white-space: nowrap; line-height: 1.3;">
                  {{ $stats['summary']['status_tidak_berlaku']['percentage'] }}%
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- DUAL FILTER BAR WITH PDF EXPORT --}}
      <div class="stat-filter-bar" style="background: #ffffff; padding: 18px 24px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 35px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span style="font-weight: 600; color: #1e293b; font-size: 14px;">Filter Statistik:</span>
          </div>

          <div style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap; flex: 1; justify-content: flex-end;">
            {{-- Filter Tahun --}}
            <div style="display: flex; align-items: center; gap: 8px;">
              <label for="filter-tahun" style="font-size: 13px; color: #475569; font-weight: 500; white-space: nowrap;">Tahun:</label>
              <select id="filter-tahun" style="padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #1e293b; background: #f8fafc; min-width: 130px; cursor: pointer;">
                <option value="all">Semua Tahun</option>
                @foreach ($stats['filters']['available_years'] as $yr)
                  <option value="{{ $yr }}" @selected($stats['filters']['selected_year'] == $yr)>{{ $yr }}</option>
                @endforeach
              </select>
            </div>

            {{-- Filter Jenis Peraturan --}}
            <div style="display: flex; align-items: center; gap: 8px;">
              <label for="filter-jenis" style="font-size: 13px; color: #475569; font-weight: 500; white-space: nowrap;">Jenis:</label>
              <select id="filter-jenis" style="padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #1e293b; background: #f8fafc; min-width: 180px; cursor: pointer;">
                <option value="all">Semua Jenis Peraturan</option>
                @foreach ($stats['filters']['available_rule_types'] as $rt)
                  <option value="{{ $rt['id'] }}" @selected($stats['filters']['selected_rule_type_id'] == $rt['id'])>{{ $rt['label'] }}</option>
                @endforeach
              </select>
            </div>

            {{-- Reset Button --}}
            <button id="btn-reset-filters" type="button" style="padding: 8px 14px; border: 1px solid #e2e8f0; background: #ffffff; color: #64748b; font-size: 12px; font-weight: 500; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
              </svg>
              Reset
            </button>

            {{-- PDF Export Button --}}
            <button id="btn-export-pdf" type="button" onclick="exportPublicPdf()" style="padding: 8px 16px; border: none; background: #2563eb; color: #ffffff; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(37,99,235,0.3);">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
              </svg>
              Unduh Laporan PDF
            </button>
          </div>
        </div>
      </div>

      {{-- SECTION 1: STATISTIK BERDASARKAN JENIS PERATURAN --}}
      <div class="middle__subtitle" style="margin-bottom: 20px;">
        <h5 style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
          <span style="width: 4px; height: 18px; background: #2563eb; border-radius: 2px;"></span>
          Statistik Berdasarkan Jenis Peraturan
        </h5>
        <small id="text-filter-indicator" style="color: #64748b; font-size: 13px;">
          Distribusi produk hukum berdasarkan jenis regulasi dan persentase terhadap total keseluruhan.
        </small>
      </div>

      <div class="statistik">
        {{-- TABLE WITH PERCENTAGE --}}
        <div class="statistik__left content-pages" style="flex: 0 0 460px; max-width: 460px;">
          <div id="tableStatistikWrapper" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px;">
            <table id="table" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
              <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                  <th style="padding: 12px 14px; font-size: 13px; font-weight: 600; color: #475569; width: 40px; text-align: center;">No</th>
                  <th style="padding: 12px 14px; font-size: 13px; font-weight: 600; color: #475569; text-align: left;">Jenis Peraturan</th>
                  <th style="padding: 12px 14px; font-size: 13px; font-weight: 600; color: #475569; width: 70px; text-align: center;">Jumlah</th>
                  <th style="padding: 12px 14px; font-size: 13px; font-weight: 600; color: #475569; width: 120px; text-align: left;">Persentase</th>
                </tr>
              </thead>
              <tbody id="stat-table-body">
                @forelse ($stats['by_type'] as $data)
                  <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 12px 14px; text-align: center; font-size: 13px; color: #64748b;">{{ $loop->iteration }}</td>
                    <td style="padding: 12px 14px; font-size: 13px; font-weight: 500; color: #1e293b;">
                      <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: {{ $data['color'] }}; margin-right: 6px;"></span>
                      <a href="javascript:void(0)" onclick="triggerDrilldown({{ $data['id'] }}, 'all', '{{ e($data['label']) }}')" style="color: #1e293b; text-decoration: none;">
                        {{ $data['label'] }}
                      </a>
                    </td>
                    <td style="padding: 12px 14px; text-align: center; font-weight: 600; font-size: 13px; color: #0f172a;">
                      @if($data['count'] > 0)
                        <button type="button" onclick="triggerDrilldown({{ $data['id'] }}, 'all', '{{ e($data['label']) }}')" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 4px; padding: 2px 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
                          {{ $data['count'] }}
                        </button>
                      @else
                        0
                      @endif
                    </td>
                    <td style="padding: 12px 14px;">
                      <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                          <div style="width: {{ $data['percentage'] }}%; height: 100%; background: {{ $data['color'] }}; border-radius: 3px;"></div>
                        </div>
                        <span style="font-size: 12px; font-weight: 600; color: #475569; min-width: 38px; text-align: right;">{{ $data['percentage'] }}%</span>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px;">Tidak ada data dokumen ditemukan.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <button 
            type="button"
            class="button-outline button-icon"
            onclick="downloadChartHTML('tableStatistikWrapper', 'tabel-statistik-jenis-peraturan.png')"
            style="width: 100%; justify-content: center; font-size: 13px; padding: 10px 16px;"
          >
            {{ lang::translate('about-statistik.download.table') }} <i class="wa-icon wa-ic-download-solid"></i>
          </button>
        </div>

        {{-- CHART 1: BY TYPE --}}
        <div class="statistik__right" style="flex: 0 0 calc(100% - 460px); max-width: calc(100% - 460px); padding-left: 35px; padding-top: 0;">
          <div id="chartPeraturanWrapper" class="chart" style="background: #ffffff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px; min-height: 380px;">
            <canvas id="chartPeraturan"></canvas>
          </div>
          <button 
            type="button"
            class="button-outline button-icon"
            onclick="downloadChartHTML('chartPeraturanWrapper', 'grafik-distribusi-jenis-peraturan.png')"
            style="font-size: 13px; padding: 10px 16px;"
          >
            {{ lang::translate('about-statistik.download.chart-peraturan') }} <i class="wa-icon wa-ic-download-solid"></i>
          </button>
        </div>
      </div>

      {{-- SECTION 2: STATISTIK BERDASARKAN TAHUN --}}
      <div class="chart-year" style="margin-top: 60px;">
        <div class="middle__subtitle" style="margin-bottom: 20px;">
          <h5 style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
            <span style="width: 4px; height: 18px; background: #0d6efd; border-radius: 2px;"></span>
            Statistik Tren Tahunan Produk Hukum
          </h5>
          <p style="margin-bottom: 0; color: #64748b; font-size: 13px;">
            Jumlah dan perbandingan status keberlakuan dokumen (Berlaku vs Tidak Berlaku) dari tahun ke tahun.
          </p>
        </div>

        <div id="statusChartWrapper" class="chart" style="background: #ffffff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02); height: 420px; margin-bottom: 16px;">
          <canvas id="statusChart"></canvas>
        </div>

        <button
          type="button"
          onclick="downloadChartHTML('statusChartWrapper', 'grafik-tren-tahunan.png')" 
          class="button-outline button-icon"
          style="font-size: 13px; padding: 10px 16px;"
        >
          {{ lang::translate('about-statistik.download.chart-produk-hukum') }} <i class="wa-icon wa-ic-download-solid"></i>
        </button>
      </div>

      {{-- SECTION 3: TABEL MATRIKS PERBANDINGAN JENIS PERATURAN & TAHUN --}}
      <div class="matrix-section" style="margin-top: 60px;">
        <div class="middle__subtitle" style="margin-bottom: 20px;">
          <h5 style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
            <span style="width: 4px; height: 18px; background: #8b5cf6; border-radius: 2px;"></span>
            Tabel Matriks Perbandingan Jenis Peraturan dan Tahun
          </h5>
          <p style="margin-bottom: 0; color: #64748b; font-size: 13px;">
            Distribusi komprehensif jumlah produk hukum per jenis dan per tahun penetapan. Klik pada angka mana pun untuk melihat dokumen sumbernya di bawah.
          </p>
        </div>

        <div id="matrixWrapper" style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px;">
          <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
            <thead>
              <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 40px;">No</th>
                <th style="padding: 12px 14px; text-align: left; color: #475569; min-width: 200px;">Jenis Peraturan</th>
                @foreach($matrix['years'] as $yr)
                  <th style="padding: 12px 10px; text-align: center; color: #475569; min-width: 55px;">{{ $yr }}</th>
                @endforeach
                <th style="padding: 12px 14px; text-align: center; color: #1e3a8a; background: #eff6ff; font-weight: 700;">Total</th>
              </tr>
            </thead>
            <tbody id="matrix-tbody">
              @php $mNo = 1; @endphp
              @foreach($matrix['rows'] as $r)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                  <td style="padding: 10px 14px; text-align: center; color: #64748b;">{{ $mNo++ }}</td>
                  <td style="padding: 10px 14px; font-weight: 500; color: #1e293b;">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: {{ $r['color'] }}; margin-right: 6px;"></span>
                    {{ $r['label'] }}
                  </td>
                  @foreach($matrix['years'] as $yr)
                    @php $c = $r['years'][$yr] ?? 0; @endphp
                    <td style="padding: 10px; text-align: center;">
                      @if($c > 0)
                        <button type="button" onclick="triggerDrilldown({{ $r['id'] }}, {{ $yr }}, '{{ e($r['label']) }}')" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 4px; padding: 2px 7px; font-weight: 700; cursor: pointer; font-size: 11px;">
                          {{ $c }}
                        </button>
                      @else
                        <span style="color: #cbd5e1;">-</span>
                      @endif
                    </td>
                  @endforeach
                  <td style="padding: 10px 14px; text-align: center; font-weight: 700; background: #f8fafc; color: #1e3a8a;">
                    @if($r['total'] > 0)
                      <button type="button" onclick="triggerDrilldown({{ $r['id'] }}, 'all', '{{ e($r['label']) }}')" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 4px; padding: 2px 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
                        {{ $r['total'] }}
                      </button>
                    @else
                      0
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr style="background: #f8fafc; border-top: 2px solid #cbd5e1; font-weight: 700;">
                <td colspan="2" style="padding: 12px 14px; text-align: left; text-transform: uppercase; color: #0f172a;">Total Keseluruhan</td>
                @foreach($matrix['years'] as $yr)
                  @php $totYr = $matrix['col_totals'][$yr] ?? 0; @endphp
                  <td style="padding: 12px 10px; text-align: center;">
                    @if($totYr > 0)
                      <button type="button" onclick="triggerDrilldown('all', {{ $yr }}, 'Semua Jenis')" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 4px; padding: 2px 7px; font-weight: 700; cursor: pointer; font-size: 11px;">
                        {{ $totYr }}
                      </button>
                    @else
                      0
                    @endif
                  </td>
                @endforeach
                <td style="padding: 12px 14px; text-align: center; background: #2563eb; color: #ffffff; font-weight: 800; font-size: 14px;">
                  <button type="button" onclick="triggerDrilldown('all', 'all', 'Semua Jenis')" style="background: transparent; color: #ffffff; border: none; font-weight: 800; cursor: pointer; font-size: 13px;">
                    {{ $matrix['grand_total'] }}
                  </button>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      {{-- SECTION 4: DAFTAR DOKUMEN SUMBER STATISTIK (DRILLDOWN SECTION) --}}
      <div id="drilldown-container" style="margin-top: 60px; scroll-margin-top: 90px;">
        <div class="middle__subtitle" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px;">
          <div>
            <h5 style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
              <span style="width: 4px; height: 18px; background: #10b981; border-radius: 2px;"></span>
              Daftar Dokumen Sumber Statistik
            </h5>
            <div id="drilldown-badge-context" style="margin-top: 6px; font-size: 13px; color: #2563eb; font-weight: 600;">
              Menampilkan seluruh dokumen produk hukum
            </div>
          </div>

          <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            {{-- Search Input --}}
            <div style="position: relative;">
              <input type="text" id="publicDocSearch" placeholder="Cari judul / no peraturan..." style="padding: 8px 12px 8px 32px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 12px; width: 230px;" onkeyup="onPublicSearchDebounce()">
              <svg style="position: absolute; left: 10px; top: 9px; color: #94a3b8;" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>

            {{-- Sort By --}}
            <select id="publicDocSort" style="padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 12px; color: #334155; cursor: pointer;" onchange="fetchPublicDocuments(1)">
              <option value="tanggal_penetapan:desc">Tgl Penetapan (Terbaru)</option>
              <option value="tanggal_penetapan:asc">Tgl Penetapan (Terlama)</option>
              <option value="no_peraturan:asc">Nomor Peraturan (A-Z)</option>
              <option value="year:desc">Tahun (Terbaru)</option>
            </select>
          </div>
        </div>

        <div style="background: #ffffff; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px;">
          <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
              <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 40px;">No</th>
                <th style="padding: 12px 14px; text-align: left; color: #475569; width: 110px;">No. Peraturan</th>
                <th style="padding: 12px 14px; text-align: left; color: #475569; width: 150px;">Jenis</th>
                <th style="padding: 12px 14px; text-align: left; color: #475569;">Judul Dokumen</th>
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 60px;">Tahun</th>
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 110px;">Penetapan</th>
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 100px;">Status</th>
                <th style="padding: 12px 14px; text-align: center; color: #475569; width: 90px;">Aksi</th>
              </tr>
            </thead>
            <tbody id="public-docs-tbody">
              <tr>
                <td colspan="8" style="padding: 24px; text-align: center; color: #94a3b8;">Memuat data dokumen...</td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- Pagination & Summary --}}
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 40px;">
          <div id="public-docs-page-info" style="font-size: 12px; color: #64748b;">
            Menampilkan 0 dari 0 dokumen
          </div>
          <div id="public-docs-pagination" style="display: flex; gap: 4px;">
            {{-- Rendered via JS --}}
          </div>
        </div>
      </div>
    </div>
  </section>

  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
    <style>
      .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }
      .stat-card:hover {
        transform: translateY(-3px);
      }
      .loading-fade {
        opacity: 0.5;
        pointer-events: none;
        transition: opacity 0.2s ease;
      }
      @media (max-width: 991px) {
        .statistik {
          flex-direction: column !important;
        }
        .statistik__left, .statistik__right {
          flex: 0 0 100% !important;
          max-width: 100% !important;
          padding-left: 0 !important;
        }
        .statistik__right {
          margin-top: 30px;
        }
      }

      /* Pagination Button Fix */
      #public-docs-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
      }
      .stat-page-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        min-width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        border-radius: 6px !important;
        text-decoration: none !important;
        box-sizing: border-box !important;
        transition: all 0.2s ease !important;
      }
      .stat-page-btn.inactive {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #1e293b !important;
      }
      .stat-page-btn.inactive span {
        color: #1e293b !important;
      }
      .stat-page-btn.inactive svg {
        stroke: #1e293b !important;
      }
      .stat-page-btn.inactive:hover {
        background: #f1f5f9 !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
      }
      .stat-page-btn.inactive:hover span {
        color: #0f172a !important;
      }
      .stat-page-btn.inactive:hover svg {
        stroke: #0f172a !important;
      }
      .stat-page-btn.active {
        background: #1e40af !important;
        border: 1px solid #1e40af !important;
        color: #ffffff !important;
        box-shadow: 0 2px 4px rgba(30, 64, 175, 0.2) !important;
      }
      .stat-page-btn.active span {
        color: #ffffff !important;
      }
      .stat-page-btn.disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #cbd5e1 !important;
        pointer-events: none !important;
      }
      .stat-page-btn.disabled svg {
        stroke: #cbd5e1 !important;
      }
      .stat-page-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 36px;
        color: #64748b;
        font-weight: 700;
        font-size: 13px;
        user-select: none;
      }
    </style>
  @endpush

  @push('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
      let chartPeraturan = null;
      let chartStatus = null;
      let currentStats = @json($stats);
      let currentMatrix = @json($matrix);
      let publicSearchTimer = null;

      let publicFilterState = {
        year: 'all',
        rule_type_id: 'all',
        q: '',
        sort_by: 'tanggal_penetapan',
        sort_dir: 'desc',
        page: 1,
        per_page: 10
      };

      document.addEventListener("DOMContentLoaded", function() {
        initChartPeraturan(currentStats.by_type);
        initChartStatus(currentStats.by_year);
        bindFilterEvents();
        fetchPublicDocuments(1);
      });

      function initChartPeraturan(byTypeData) {
        const ctx = document.getElementById('chartPeraturan').getContext('2d');
        const displayData = byTypeData.filter(item => item.count > 0);
        const labels = displayData.map(item => item.label);
        const counts = displayData.map(item => item.count);
        const colors = displayData.map(item => item.color);
        const pcts = displayData.map(item => item.percentage);
        const ids = displayData.map(item => item.id);

        if (chartPeraturan) chartPeraturan.destroy();

        chartPeraturan = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels.length ? labels : ['Tidak Ada Data'],
            datasets: [{
              label: 'Jumlah Dokumen',
              data: counts.length ? counts : [0],
              backgroundColor: colors.length ? colors : ['#cbd5e1'],
              borderRadius: 6,
              borderSkipped: false,
              pcts: pcts,
              ruleTypeIds: ids
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#ffffff',
                titleFont: { weight: '600', size: 13 },
                bodyColor: '#e2e8f0',
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                  label: function(context) {
                    const idx = context.dataIndex;
                    const val = context.raw || 0;
                    const pct = context.dataset.pcts ? context.dataset.pcts[idx] : 0;
                    return ` Jumlah: ${val} dokumen (${pct}%) - Klik untuk drilldown`;
                  }
                }
              }
            },
            scales: {
              x: {
                ticks: {
                  font: { size: 11 },
                  color: '#475569',
                  maxRotation: 35,
                  minRotation: 0,
                  callback: function(val) {
                    const label = this.getLabelForValue(val);
                    return label.length > 20 ? label.substr(0, 18) + '...' : label;
                  }
                },
                grid: { display: false }
              },
              y: {
                beginAtZero: true,
                ticks: { precision: 0, font: { size: 11 }, color: '#64748b' },
                grid: { color: '#f1f5f9' }
              }
            },
            onClick: (event, elements) => {
              if (elements.length > 0) {
                const idx = elements[0].index;
                const rtId = displayData[idx].id;
                const label = displayData[idx].label;
                triggerDrilldown(rtId, document.getElementById('filter-tahun').value, label);
              }
            }
          }
        });
      }

      function initChartStatus(byYearData) {
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        const labels = byYearData.map(item => item.year);
        const berlakuData = byYearData.map(item => item.berlaku_count);
        const tidakBerlakuData = byYearData.map(item => item.tidak_berlaku_count);

        if (chartStatus) chartStatus.destroy();

        chartStatus = new Chart(ctx2, {
          type: "bar",
          data: {
            labels: labels.length ? labels : ['-'],
            datasets: [
              {
                label: "Berlaku",
                data: berlakuData.length ? berlakuData : [0],
                backgroundColor: "#2563eb",
                borderRadius: 6
              },
              {
                label: "Tidak Berlaku",
                data: tidakBerlakuData.length ? tidakBerlakuData : [0],
                backgroundColor: "#ef4444",
                borderRadius: 6
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: { grid: { display: false }, ticks: { font: { size: 12, weight: '500' }, color: "#334155" } },
              y: { beginAtZero: true, grid: { color: "#f1f5f9" }, ticks: { precision: 0, font: { size: 11 }, color: "#64748b" } }
            },
            plugins: {
              legend: { position: "bottom" },
              tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#ffffff',
                bodyColor: '#e2e8f0',
                padding: 12,
                cornerRadius: 8
              }
            },
            onClick: (event, elements) => {
              if (elements.length > 0) {
                const idx = elements[0].index;
                const yr = labels[idx];
                triggerDrilldown(document.getElementById('filter-jenis').value, yr, 'Tahun ' + yr);
              }
            }
          }
        });
      }

      function bindFilterEvents() {
        const filterTahun = document.getElementById('filter-tahun');
        const filterJenis = document.getElementById('filter-jenis');
        const btnReset = document.getElementById('btn-reset-filters');

        function triggerFilter() {
          const year = filterTahun.value;
          const ruleTypeId = filterJenis.value;

          publicFilterState.year = year;
          publicFilterState.rule_type_id = ruleTypeId;
          publicFilterState.page = 1;

          fetchFilteredData(year, ruleTypeId);
          fetchPublicDocuments(1);
        }

        filterTahun.addEventListener('change', triggerFilter);
        filterJenis.addEventListener('change', triggerFilter);

        btnReset.addEventListener('click', function() {
          filterTahun.value = 'all';
          filterJenis.value = 'all';
          document.getElementById('publicDocSearch').value = '';
          publicFilterState.year = 'all';
          publicFilterState.rule_type_id = 'all';
          publicFilterState.q = '';
          publicFilterState.page = 1;
          fetchFilteredData('all', 'all');
          fetchPublicDocuments(1);
        });
      }

      function fetchFilteredData(year, ruleTypeId) {
        const contentContainer = document.querySelector('.middle');
        if (contentContainer) contentContainer.classList.add('loading-fade');

        const params = new URLSearchParams();
        if (year && year !== 'all') params.append('year', year);
        if (ruleTypeId && ruleTypeId !== 'all') params.append('rule_type_id', ruleTypeId);

        // Fetch both stats and matrix
        Promise.all([
          fetch('/api/statistics/legal-products?' + params.toString()).then(r => r.json()),
          fetch('/api/statistics/legal-products/matrix?' + params.toString()).then(r => r.json())
        ])
        .then(([statsRes, matrixRes]) => {
          if (statsRes.status === 'success' && statsRes.data) {
            currentStats = statsRes.data;
            updateUI(currentStats);
          }
          if (matrixRes.status === 'success' && matrixRes.data) {
            currentMatrix = matrixRes.data;
            renderMatrixUI(currentMatrix);
          }
        })
        .catch(err => console.error('Error fetching statistics:', err))
        .finally(() => {
          if (contentContainer) contentContainer.classList.remove('loading-fade');
        });
      }

      function updateUI(data) {
        document.getElementById('stat-kpi-total').textContent = Number(data.summary.total_documents).toLocaleString();
        document.getElementById('stat-kpi-types').textContent = data.summary.total_active_rule_types;
        document.getElementById('stat-kpi-top-year').textContent = data.summary.top_year.year || '-';
        document.getElementById('stat-kpi-top-year-count').textContent = (data.summary.top_year.count || 0) + ' Produk Hukum Ditetapkan';

        document.getElementById('stat-kpi-berlaku-badge').textContent = data.summary.status_berlaku.percentage + '%';
        document.getElementById('stat-kpi-berlaku-count').innerHTML = data.summary.status_berlaku.count + ' <span style="font-size: 11px; font-weight: 400; color: #64748b;">dok</span>';

        document.getElementById('stat-kpi-tidak-berlaku-badge').textContent = data.summary.status_tidak_berlaku.percentage + '%';
        document.getElementById('stat-kpi-tidak-berlaku-count').innerHTML = data.summary.status_tidak_berlaku.count + ' <span style="font-size: 11px; font-weight: 400; color: #64748b;">dok</span>';

        const tbody = document.getElementById('stat-table-body');
        tbody.innerHTML = '';

        if (!data.by_type || data.by_type.length === 0) {
          tbody.innerHTML = '<tr><td colspan="4" style="padding: 24px; text-align: center; color: #94a3b8; font-size: 13px;">Tidak ada data dokumen ditemukan.</td></tr>';
        } else {
          data.by_type.forEach((item, idx) => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #f1f5f9';
            tr.innerHTML = `
              <td style="padding: 12px 14px; text-align: center; font-size: 13px; color: #64748b;">${idx + 1}</td>
              <td style="padding: 12px 14px; font-size: 13px; font-weight: 500; color: #1e293b;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: ${item.color}; margin-right: 6px;"></span>
                <a href="javascript:void(0)" onclick="triggerDrilldown(${item.id}, 'all', '${item.label.replace(/'/g, "\\'")}')" style="color: #1e293b; text-decoration: none;">
                  ${item.label}
                </a>
              </td>
              <td style="padding: 12px 14px; text-align: center; font-weight: 600; font-size: 13px; color: #0f172a;">
                ${item.count > 0 ? `<button type="button" onclick="triggerDrilldown(${item.id}, 'all', '${item.label.replace(/'/g, "\\'")}')" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 4px; padding: 2px 8px; font-weight: 700; cursor: pointer; font-size: 12px;">${item.count}</button>` : '0'}
              </td>
              <td style="padding: 12px 14px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <div style="flex: 1; height: 6px; background: #f1f5f9; border-radius: 3px; overflow: hidden;">
                    <div style="width: ${item.percentage}%; height: 100%; background: ${item.color}; border-radius: 3px;"></div>
                  </div>
                  <span style="font-size: 12px; font-weight: 600; color: #475569; min-width: 38px; text-align: right;">${item.percentage}%</span>
                </div>
              </td>
            `;
            tbody.appendChild(tr);
          });
        }

        initChartPeraturan(data.by_type);
        initChartStatus(data.by_year);
      }

      function renderMatrixUI(matrix) {
        const theadTr = document.querySelector('#matrixWrapper thead tr');
        let headerHtml = `<th style="padding: 12px 14px; text-align: center; color: #475569; width: 40px;">No</th>
                          <th style="padding: 12px 14px; text-align: left; color: #475569; min-width: 200px;">Jenis Peraturan</th>`;
        matrix.years.forEach(yr => {
          headerHtml += `<th style="padding: 12px 10px; text-align: center; color: #475569; min-width: 55px;">${yr}</th>`;
        });
        headerHtml += `<th style="padding: 12px 14px; text-align: center; color: #1e3a8a; background: #eff6ff; font-weight: 700;">Total</th>`;
        theadTr.innerHTML = headerHtml;

        const tbody = document.getElementById('matrix-tbody');
        let bodyHtml = '';
        matrix.rows.forEach((r, idx) => {
          bodyHtml += `<tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; text-align: center; color: #64748b;">${idx + 1}</td>
            <td style="padding: 10px 14px; font-weight: 500; color: #1e293b;">
              <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: ${r.color}; margin-right: 6px;"></span>
              ${r.label}
            </td>`;
          matrix.years.forEach(yr => {
            const c = r.years[yr] || 0;
            bodyHtml += `<td style="padding: 10px; text-align: center;">
              ${c > 0 ? `<button type="button" onclick="triggerDrilldown(${r.id}, ${yr}, '${r.label.replace(/'/g, "\\'")}')" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 4px; padding: 2px 7px; font-weight: 700; cursor: pointer; font-size: 11px;">${c}</button>` : '<span style="color: #cbd5e1;">-</span>'}
            </td>`;
          });
          bodyHtml += `<td style="padding: 10px 14px; text-align: center; font-weight: 700; background: #f8fafc; color: #1e3a8a;">
            ${r.total > 0 ? `<button type="button" onclick="triggerDrilldown(${r.id}, 'all', '${r.label.replace(/'/g, "\\'")}')" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 4px; padding: 2px 8px; font-weight: 700; cursor: pointer; font-size: 12px;">${r.total}</button>` : '0'}
          </td></tr>`;
        });
        tbody.innerHTML = bodyHtml;
      }

      // INTERACTIVE DRILLDOWN
      function triggerDrilldown(ruleTypeId, year, label) {
        publicFilterState.rule_type_id = ruleTypeId;
        publicFilterState.year = year;
        publicFilterState.page = 1;

        if (ruleTypeId !== 'all') {
          document.getElementById('filter-jenis').value = ruleTypeId;
        }
        if (year !== 'all') {
          document.getElementById('filter-tahun').value = year;
        }

        let context = label || 'Semua Produk Hukum';
        if (year !== 'all') context += ' — Tahun ' + year;
        document.getElementById('drilldown-badge-context').innerHTML = `<i class="wa-icon wa-ic-check-solid"></i> Filter Dokumen: <strong>${context}</strong>`;

        fetchPublicDocuments(1);

        const target = document.getElementById('drilldown-container');
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }

      function fetchPublicDocuments(page = 1, shouldScroll = false) {
        publicFilterState.page = page;
        const sortVal = document.getElementById('publicDocSort').value.split(':');
        publicFilterState.sort_by = sortVal[0];
        publicFilterState.sort_dir = sortVal[1] || 'desc';
        publicFilterState.q = document.getElementById('publicDocSearch').value.trim();

        const tbody = document.getElementById('public-docs-tbody');
        tbody.innerHTML = `<tr><td colspan="8" style="padding: 24px; text-align: center; color: #94a3b8;">Memuat data dokumen...</td></tr>`;

        const params = new URLSearchParams({
          year: publicFilterState.year,
          rule_type_id: publicFilterState.rule_type_id,
          q: publicFilterState.q,
          sort_by: publicFilterState.sort_by,
          sort_dir: publicFilterState.sort_dir,
          page: publicFilterState.page,
          per_page: publicFilterState.per_page,
          is_admin: 0
        });

        fetch('/api/statistics/legal-products/documents?' + params.toString())
          .then(r => r.json())
          .then(res => {
            if (res.status === 'success' && res.data) {
              renderPublicDocsTable(res.data);
              if (shouldScroll) {
                const target = document.getElementById('public-doc-list');
                if (target) {
                  target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
              }
            }
          })
          .catch(err => {
            console.error('Error fetching documents:', err);
            tbody.innerHTML = `<tr><td colspan="8" style="padding: 24px; text-align: center; color: #ef4444;">Gagal memuat dokumen.</td></tr>`;
          });
      }

      function renderPublicDocsTable(pageData) {
        const tbody = document.getElementById('public-docs-tbody');
        const items = pageData.data || [];

        if (items.length === 0) {
          tbody.innerHTML = `<tr><td colspan="8" style="padding: 32px; text-align: center; color: #94a3b8;">Tidak ada produk hukum yang sesuai dengan filter ini.</td></tr>`;
          document.getElementById('public-docs-page-info').textContent = 'Menampilkan 0 dari 0 dokumen';
          document.getElementById('public-docs-pagination').innerHTML = '';
          return;
        }

        let html = '';
        const offset = pageData.from || 1;
        items.forEach((item, index) => {
          const no = offset + index;
          const statusHtml = item.status_berlaku === 1
            ? `<span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Berlaku</span>`
            : `<span style="background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Tdk Berlaku</span>`;

          html += `
            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
              <td style="padding: 12px 14px; text-align: center; color: #64748b;">${no}</td>
              <td style="padding: 12px 14px; font-weight: 600; color: #0f172a;">${item.no_peraturan || '-'}</td>
              <td style="padding: 12px 14px; color: #475569;"><span style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 11px;">${item.rule_type_name}</span></td>
              <td style="padding: 12px 14px; font-weight: 500; color: #1e293b; line-height: 1.35;">
                ${item.public_url ? `<a href="${item.public_url}" style="color: #1e293b; text-decoration: none;" target="_blank">${escapeHtml(item.title)}</a>` : escapeHtml(item.title)}
              </td>
              <td style="padding: 12px 14px; text-align: center; font-weight: 600;">${item.year}</td>
              <td style="padding: 12px 14px; text-align: center; color: #64748b; font-size: 12px;">${item.tanggal_penetapan_formatted || '-'}</td>
              <td style="padding: 12px 14px; text-align: center;">${statusHtml}</td>
              <td style="padding: 12px 14px; text-align: center; white-space: nowrap;">
                ${item.public_url ? `<a href="${item.public_url}" target="_blank" style="padding: 4px 8px; background: #eff6ff; color: #2563eb; border-radius: 4px; font-size: 11px; text-decoration: none; font-weight: 600; margin-right: 4px;">Detail</a>` : ''}
                ${item.pdf_url ? `<a href="${item.pdf_url}" target="_blank" style="padding: 4px 8px; background: #fef2f2; color: #dc2626; border-radius: 4px; font-size: 11px; text-decoration: none; font-weight: 600;">PDF</a>` : ''}
              </td>
            </tr>
          `;
        });

        tbody.innerHTML = html;
        document.getElementById('public-docs-page-info').textContent = `Menampilkan ${pageData.from} - ${pageData.to} dari ${pageData.total} dokumen`;

        // Render pagination buttons
        renderPublicPagination(pageData);
      }

      function renderPublicPagination(pageData) {
        const container = document.getElementById('public-docs-pagination');
        const curr = parseInt(pageData.current_page) || 1;
        const last = parseInt(pageData.last_page) || 1;

        if (last <= 1) {
          container.innerHTML = '';
          return;
        }

        const btnBase = "display:inline-flex !important;align-items:center !important;justify-content:center !important;width:36px !important;min-width:36px !important;height:36px !important;padding:0 !important;font-size:13px !important;font-weight:700 !important;line-height:1 !important;border-radius:6px !important;text-decoration:none !important;box-sizing:border-box !important;vertical-align:middle !important;";
        const btnActive = btnBase + "background:#1e40af !important;border:1px solid #1e40af !important;color:#ffffff !important;box-shadow:0 2px 4px rgba(30,64,175,0.2) !important;cursor:default !important;";
        const btnInactive = btnBase + "background:#ffffff !important;border:1px solid #cbd5e1 !important;color:#1e293b !important;cursor:pointer !important;";
        const btnDisabled = btnBase + "background:#f8fafc !important;border:1px solid #e2e8f0 !important;color:#cbd5e1 !important;cursor:not-allowed !important;pointer-events:none !important;opacity:0.6 !important;";

        const prevIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polyline points="15 18 9 12 15 6"></polyline></svg>`;
        const nextIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polyline points="9 18 15 12 9 6"></polyline></svg>`;

        let html = '';

        // Tombol Sebelumnya (<)
        if (curr > 1) {
          html += `<a href="javascript:void(0)" class="stat-page-btn inactive" style="${btnInactive}" onclick="fetchPublicDocuments(${curr - 1}, true); return false;" title="Halaman Sebelumnya" aria-label="Halaman Sebelumnya">${prevIcon}</a>`;
        } else {
          html += `<a href="javascript:void(0)" class="stat-page-btn disabled" style="${btnDisabled}" title="Halaman Sebelumnya" aria-disabled="true">${prevIcon}</a>`;
        }

        // Helper untuk render nomor halaman
        const renderPageNum = (p) => {
          if (p === curr) {
            return `<a href="javascript:void(0)" class="stat-page-btn active" style="${btnActive}" title="Halaman ${p}" aria-current="page"><span style="color:#ffffff !important;font-weight:700 !important;font-size:13px !important;line-height:1 !important;">${p}</span></a>`;
          } else {
            return `<a href="javascript:void(0)" class="stat-page-btn inactive" style="${btnInactive}" onclick="fetchPublicDocuments(${p}, true); return false;" title="Halaman ${p}"><span style="color:#1e293b !important;font-weight:700 !important;font-size:13px !important;line-height:1 !important;">${p}</span></a>`;
          }
        };

        if (last <= 7) {
          for (let i = 1; i <= last; i++) {
            html += renderPageNum(i);
          }
        } else {
          // Halaman 1
          html += renderPageNum(1);

          if (curr > 3) {
            html += `<span class="stat-page-ellipsis" style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:36px;color:#64748b;font-weight:700;font-size:13px;line-height:1;">&hellip;</span>`;
          }

          const start = Math.max(2, curr - 1);
          const end = Math.min(last - 1, curr + 1);

          for (let i = start; i <= end; i++) {
            html += renderPageNum(i);
          }

          if (curr < last - 2) {
            html += `<span class="stat-page-ellipsis" style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:36px;color:#64748b;font-weight:700;font-size:13px;line-height:1;">&hellip;</span>`;
          }

          // Halaman Terakhir
          html += renderPageNum(last);
        }

        // Tombol Selanjutnya (>)
        if (curr < last) {
          html += `<a href="javascript:void(0)" class="stat-page-btn inactive" style="${btnInactive}" onclick="fetchPublicDocuments(${curr + 1}, true); return false;" title="Halaman Selanjutnya" aria-label="Halaman Selanjutnya">${nextIcon}</a>`;
        } else {
          html += `<a href="javascript:void(0)" class="stat-page-btn disabled" style="${btnDisabled}" title="Halaman Selanjutnya" aria-disabled="true">${nextIcon}</a>`;
        }

        container.innerHTML = html;
      }

      function onPublicSearchDebounce() {
        clearTimeout(publicSearchTimer);
        publicSearchTimer = setTimeout(() => {
          fetchPublicDocuments(1);
        }, 400);
      }

      function exportPublicPdf() {
        const year = document.getElementById('filter-tahun').value;
        const ruleType = document.getElementById('filter-jenis').value;
        const q = document.getElementById('publicDocSearch').value.trim();

        const params = new URLSearchParams({
          mode: 'all',
          year: year,
          rule_type_id: ruleType,
          q: q,
          is_admin: 0,
          download: 1
        });

        window.open('/api/statistics/legal-products/export-pdf?' + params.toString(), '_blank');
      }

      function downloadChartHTML(elementId, filename = "chart.png") {
        const target = document.getElementById(elementId);
        if (!target) return;

        html2canvas(target, {
          backgroundColor: '#ffffff',
          scale: 2
        }).then(canvas => {
          canvas.toBlob((blob) => {
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
          });
        });
      }

      function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
      }
    </script>
  @endpush
@endsection
