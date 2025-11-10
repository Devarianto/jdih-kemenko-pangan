@extends('static.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'project'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <a href="{{ route('dashboard') }}" class="back">
            Kembali
          </a>
        </div>
        <div class="box-white table">
          <h5>DETAIL USULAN PROJECT</h5>
          <table>
            <tr>
              <td>Nomor Project</td>
              <td>A1234567HG</td>
            </tr>
             <tr>
              <td>Judul</td>
              <td>Rancangan Peraturan Presiden</td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td>RUU</td>
            </tr>
            <tr>
              <td>Tanggal Ulasan</td>
              <td>15 Juli 2025</td>
            </tr>
            <tr>
              <td>Lampiran</td>
              <td><a href="">dokumen-usulan.pdf</a></td>
            </tr>
          </table>
          <hr>
          <h5>INFORMASI PEMOHON</h5>
          <table>
            <tr>
              <td>Divisi/Pemohon</td>
              <td>Dokumentasi, BPN</td>
            </tr>
            <tr>
              <td>Nama Pemohon</td>
              <td>John Doe</td>
            </tr>
          </table>
          <hr>
          <h5>Status Project</h5>
          <div class="status-project">
            <div class="status-project__step done">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">15 Juli 2025</span>
              <div class="text">
                <p><b>Perencanaan</b></p>
              </div>
            </div>
            <div class="status-project__step done">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">15 Juli 2025</span>
              <div class="text">
                <p><b>Penyusunan</b></p>
                <p>Project ini dalam proses di divisi pengembangan</p>
                <a href="">dokumen-usulan.pdf</a>
              </div>
            </div>
            <div class="status-project__step done">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">15 Juli 2025</span>
              <div class="text">
                <p><b>Pembahasan</b></p>
                <p>Project ini dalam proses di divisi pengembangan</p>
                <a href="">dokumen-usulan.pdf</a>
              </div>
            </div>
            <div class="status-project__step">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                  <rect x="2" y="2" width="44" height="44" rx="22" fill="white" stroke="#999999" stroke-width="4"/>
                  <path d="M16.8008 22.6L21.3008 28L31.2008 19" stroke="#999999" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <span class="date">15 Juli 2025</span>
              <div class="text">
                <p><b>Penyusunan</b></p>
                <p>Project ini dalam proses di divisi pengembangan</p>
                <a href="">dokumen-usulan.pdf</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
