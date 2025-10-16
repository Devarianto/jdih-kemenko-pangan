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
      <h2>Visi Misi</h2>
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
     <div class="visi">
      <figure>
        <img src="{{ asset('images/content/bg-visi.png') }}" alt="">
        <figcaption>
          <p>Visi Kami</p>
          <h6>Terwujudnya pengelolaan dokumentasi dan informasi hukum di bidang pangan yang tertib, terpadu, berkesinambungan, serta mudah diakses untuk mendukung transparansi dan kepastian hukum.</h6>
        </figcaption>
      </figure>
     </div>
     <div class="misi content-pages">
      <h6>MISI KAMI</h6>
      <ul>
        <li>Menyediakan peraturan perundang-undangan dan dokumen hukum bidang pangan secara lengkap, akurat, dan mutakhir</li>
        <li>Mengembangkan sistem informasi hukum yang cepat, mudah diakses, dan ramah pengguna</li>
        <li>Meningkatkan koordinasi dan integrasi dokumentasi hukum antarunit kerja di lingkungan Kemenko Pangan</li>
        <li>Memberikan pelayanan informasi hukum secara terbuka, transparan, dan dapat dipertanggungjawabkan</li>
        <li>Mendukung pelaksanaan tugas pokok dan fungsi Kemenko Pangan melalui ketersediaan dokumentasi dan informasi hukum yang berkualitas</li>
      </ul>
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
