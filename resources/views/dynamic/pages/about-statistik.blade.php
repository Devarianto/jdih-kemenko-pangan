@extends('static.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'content') as $content)
      <div class="middle__title">
        <h4>{{ $content->translated('title') }}</h4>
        {!! $content->translated('description') !!}
      </div>
      @endforeach
      <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="">{{ lang::translate('about-statistik.year-select.title') }}</label>
            <select name="tahun" id="tahun" onchange="if(this.value) window.location.href=this.value;">
              <option value="" disabled selected>{{ lang::translate('about-statistik.year-select.placeholder') }}</option>
              @foreach ($years as $data)
                <option value="{{ url()->current().'?year='.$data->year }}" @selected(request()->query('year') == $data->year)>{{ $data->year }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="statistik">
        <div class="statistik__left content-pages">
          <table>
            <thead>
              <tr>
                <th>{{ lang::translate('about-statistik.table-header.no') }}</th>
                <th>{{ lang::translate('about-statistik.table-header.jenis-peraturan') }}</th>
                <th>{{ lang::translate('about-statistik.table-header.total') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rule_types as $data)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->label }}</td>
                <td>{{ $data->documents_count }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="statistik__right">
          <div class="chart">
            <canvas id="chartPeraturan"></canvas>
          </div>
        </div>
      </div>
      <div class="chart-year">
        <p>{{ lang::translate('about-statistik.chart.title') }}</p>
        <div class="chart">
          <canvas id="statusChart"></canvas>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function(event) { 
        const ctx = document.getElementById('chartPeraturan').getContext('2d');
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: @json($arr_rule_label),
            datasets: [{
              label: '{{ lang::translate("about-statistik.chart.berlaku") }}',
              data: @json($arr_rule_count),
              backgroundColor: @json($colors),
              borderRadius: 6,
              borderSkipped: false
            }]
          },
          options: {
            plugins: {
              legend: { display: false },
              tooltip: {
                usePointStyle: true,
                backgroundColor: 'white',
                titleColor: '#373737',
                titleFont: { weight: '400', size: 14 },
                bodyColor: '#373737',
                bodyFont: { size: 12 },
                borderColor: '#E0E0E0',
                borderWidth: 1,
                boxPadding: 6,
                displayColors: true,
                callbacks: {
                  title: (context) => context[0].label,
                  label: (context) => `{{ lang::translate("about-statistik.chart.berlaku") }}  ${context.formattedValue}`,
                  labelPointStyle: (context) => ({
                    pointStyle: 'circle',
                    rotation: 0,
                    backgroundColor: context.dataset.backgroundColor[context.dataIndex],
                  })
                },
                padding: 12,
                cornerRadius: 6
              }
            },
            scales: {
              x: {
                ticks: { 
                  font:{
                    size: 7
                  },
                  maxRotation: 45, 
                  minRotation: 45 
                },
                grid: { display: false }
              },
              y: {
                beginAtZero: true,
                grid: { color: '#eee' },
                ticks: { 
                  font: { size: 9 },
                  stepSize: 50 
                }
              }
            },
            animation: {
              duration: 600,
              easing: 'easeOutQuart'
            },
            hover: {
              mode: 'nearest',
              intersect: true
            }
          }
        });
        new Chart(ctx2, {
          type: "bar",
          data: {
            labels: @json($arr_year_berlaku['year']),
            datasets: [
              {
                label: "{{ lang::translate("about-statistik.chart.berlaku") }}",
                data:  @json($arr_year_berlaku['data']),
                backgroundColor: "#2063D2",
                borderRadius: 8,
                barPercentage: 0.8,
                categoryPercentage: 0.8
              },
              {
                label: "{{ lang::translate("about-statistik.chart.tidak-berlaku") }}",
                data: @json($arr_year_tidak_berlaku['data']),
                backgroundColor: "#8DB7FF",
                borderRadius: 8,
                barPercentage: 0.8,
                categoryPercentage: 0.8
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                grid: {
                  color: "#E5E7EB", // Warna garis halus
                  drawBorder: false,
                  offset: false
                },
                ticks: {
                  font: {
                    size: 14
                  },
                  color: "#333"
                },
                border: {
                  display: true,
                  color: "#000"
                }
              },
              y: {
                beginAtZero: true,
                max: 100,
                grid: {
                  color: "#E5E7EB"
                },
                ticks: {
                  stepSize: 20,
                  font: {
                    size: 13
                  },
                  color: "#333"
                },
                border: {
                  display: false
                }
              }
            },
            plugins: {
            legend: {
              position: "bottom",
              align:"start",
              labels: {
                usePointStyle: true,
                pointStyle: "circle",
                boxWidth: 11,
                boxHeight: 11,
                textAlign: "left",
                padding: 20,
                font: { size: 11 },
                color: "#373737",
                boxPadding: 6  
              }
            }
          }
          }
        });
      });
    </script>
  @endpush
@endsection
