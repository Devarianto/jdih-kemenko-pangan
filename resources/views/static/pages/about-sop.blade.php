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
      <h2>Standar Opersional Prosedur (SOP)</h2>
    </figcaption>
    <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg" widht="3000" height="180" viewBox="0 180 2500 200" fill="#F8F8F8">
        <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
            <animate attributeName="d" dur="5s" values="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 400 50 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250" repeatCount="indefinite"></animate>
        </path>
      </svg>
    </div>
  </section>
  <section class="middle">
    <div class="wrapper-content">
      <div class="middle__title">
        <h4>SOP JDIH merupakan sebuah panduan yang bertujuan untuk memastikan pekerjaan dan kegiatan pengelolaan layanan JDIH berjalan dengan lancar.</h4>
        <p>SOP di bidang hukum bertujuan untuk mewujudkan tata kelola pemerintahan yang baik dan menjamin kelancaran serta transparansi penyelesaian suatu jenis kegiatan pelayanan internal dan eksternal di lingkungan Kementerian Koordinator Bidang Pangan</p>
        <p>Berikut daftar SOP yang berkaitan dengan bidang hukum, antara lain:</p>
      </div>
      <div class="box-shadow">
        <p>1. Standar Operasional Prosedur (SOP) Pengelolaan Dokumen dan Informasi Hukum</p>
        <figure><img src="{{ asset('images/content/sop-1.png') }}" alt=""></figure>
      </div>
      <div class="box-shadow">
        <p>2. Standar Operasional Prosedur (SOP) Pengelolaan Dokumen dan Informasi Hukum</p>
        <figure><img src="{{ asset('images/content/sop-2.png') }}" alt=""></figure>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
