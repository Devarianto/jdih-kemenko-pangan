@extends('static.layouts.layout')

@section('content')
  <section class="banner-middle">
    <figure>
      <img 
        src="{{asset('images/content/banner-about.webp')}}" 
        data-img-large="{{ asset('images/content/banner-about.webp') }}"
        data-img-medium="{{ asset('images/content/banner-about.webp') }}"
        data-img-small="{{ asset('images/content/banner-about.webp') }}"
        width="1380" height="400" alt="img">
    </figure>
    <figcaption>
      <small>TENTANG KAMI</small>
      <h2>Statistik Produk Hukum</h2>
    </figcaption>
     <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg"
        width="100%" height="140"
        viewBox="0 180 2500 200"
        fill="#F8F8F8"
        preserveAspectRatio="none">
        <path class="st1"
          d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250">
          <animate attributeName="d" dur="5s"
            values="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 400 100 400 320 3000 250 L 3000 550 L 0 550 L 0 250;
                    M 0 250 C 1200 280 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"
            repeatCount="indefinite" />
        </path>
      </svg>
    </div>
  </section>
  <section class="middle">
    <div class="wrapper-content">
      <div class="middle__title">
        <h4>Statistik Produk Hukum Berdasarkan Status</h4>
        <p>Berikut ini disajikan data mengenai jumlah peraturan perundang-undangan yang telah diterbitkan pada tingkat pusat. Informasi ini mencakup keseluruhan regulasi yang berlaku secara nasional, yang terdiri dari berbagai jenis peraturan mulai dari Undang-Undang, Peraturan Pemerintah, Peraturan Presiden, hingga peraturan-peraturan lain yang menjadi bagian dari sistem hukum di Indonesia</p>
      </div>
      <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="">Kategori Grafik</label>
            <select name="tahun" id="tahun">
              <option value="" disabled selected>Pilih Tahun</option>
              @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
              @endfor
            </select>
          </div>
        </form>
      </div>
      <div class="statistik">
        <div class="statistik__left content-pages" >
          <table id="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Peraturan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Undang - Undang Dasar</td>
                <td>1</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Ketetapan MPR</td>
                <td>0</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Undang - Undang</td>
                <td>104</td>
              </tr>
              <tr>
                <td>4</td>
                <td>Peraturan Pemerintah Pengganti Undang - Undang</td>
                <td>22</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Peraturan Pemerintah</td>
                <td>212</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Peraturan Presiden</td>
                <td>90</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Instruksi Presiden</td>
                <td>32</td>
              </tr>
            </tbody>
          </table>
          <button 
            class="button-outline button-icon"
            onclick="downloadChartHTML('table', 'table.png')"
            >
            Download <i class="wa-icon wa-ic-download-solid"></i>
          </button>
        </div>
        <div class="statistik__right">
          <div id="chartPeraturanWrapper" class="chart">
            <canvas id="chartPeraturan"></canvas>
          </div>
          <button 
          class="button-outline button-icon"
          onclick="downloadChartHTML('chartPeraturanWrapper', 'chart-peraturan.png')"
          >
          Download <i class="wa-icon wa-ic-download-solid"></i>
          </button>
        </div>
      </div>
      <div class="chart-year">
        <p>Jumlah Produk Hukum Berlaku/ Tidak Berlaku</p>
        <div id="statusChartWrapper" class="chart">
          <canvas id="statusChart"></canvas>
        </div>
        <button
        onclick="downloadChartHTML('statusChartWrapper', 'status-chart.png')" 
        class="button-outline button-icon">Download <i class="wa-icon wa-ic-download-solid"></i></button>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function(event) { 
        const ctx = document.getElementById('chartPeraturan').getContext('2d');
        const ctx2 = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: [
              'Undang-Undang Dasar',
              'Ketetapan MPR',
              'Undang-Undang',
              'Peraturan Pemerintah Pengganti Undang-Undang',
              'Peraturan Pemerintah',
              'Peraturan Presiden',
              'Peraturan Daerah'
            ],
            datasets: [{
              label: 'Berlaku',
              data: [5, 15, 100, 10, 212, 100, 60],
              backgroundColor: [
                '#5E5CE6',
                '#9E9CF0',
                '#6699FF',
                '#F4A261',
                '#B197FC',
                '#E63946',
                '#3BA99C'
              ],
              borderRadius: 6,
              borderSkipped: false
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // ini penting agar height dari container diikuti
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
                  label: (context) => `Berlaku  ${context.formattedValue}`,
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
            labels: ["2020","2021","2022", "2023", "2024", "2025", "2026"],
            datasets: [
              {
                label: "Berlaku",
                data: [50, 54 ,22, 44, 88, 68, 72],
                backgroundColor: "#2063D2",
                borderRadius: 8,
                barPercentage: 0.8,
                categoryPercentage: 0.8
              },
              {
                label: "Tidak Berlaku",
                data: [22 ,40, 76, 72, 45, 40, 38],
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
     function downloadChartHTML(elementId, filename = "chart.png") {
        const target = document.getElementById(elementId);

        html2canvas(target, {
            backgroundColor: '#fff',
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
    </script>
  @endpush
@endsection
