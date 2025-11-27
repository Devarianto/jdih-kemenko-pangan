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
      <h2>Struktur Organisasi</h2>
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
        <h4>Berdasarkan Peraturan Menteri Koordinator Bidang Kemaritiman dan Investasi Nomor 2 Tahun 2020 tentang Organisasi dan Tata kerja Kementerian Koordinator Bidang Kemaritiman dan Investasi </h4>
      </div>
      <div class="organisasi">
        <span class="tag">Struktur Organisasi JDIH Kementerian Kordinator Bidang Pangan</span>
        <p>Jaringan Dokumentasi dan Informasi Hukum Kementerian Kordinator Bidang Pangan</p>
        <figure><img src="{{ asset('images/content/struktur-1.png') }}" alt=""></figure>
      </div>
      <div class="organisasi">
        <span class="tag">Struktur Organisasi Biro Hukum Kementerian Kordinator Bidang Pangan</span>
        <p>Biro Hukum Kementerian Kordinator Bidang Pangan</p>
        <figure><img src="{{ asset('images/content/struktur-2.png') }}" alt=""></figure>
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
