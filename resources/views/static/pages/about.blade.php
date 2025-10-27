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
      <h2>Landasan Hukum</h2>
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
      <section class="section-text">
        <div class="section-text__left">
          <span class="tag">Landasan Hukum Kementerian Kordinator Bidang Pangan</span>
          <h4>Jaringan Dokumentasi dan Informasi Hukum di Lingkungan Kemenko Bidang Pangan adalah wadah pendayagunaan bersama atas dokumen hukum </h4>
        </div>
        <div class="section-text__right">
          <p>Merupakan suatu sistem pendayagunaan bersama peraturan perundang-undangan di bidang pangan dan bahan dokumentasi hukum lainnya secara tertib, terpadu, dan berkesinambungan serta merupakan sarana pemberian pelayanan informasi hukum secara mudah, cepat, dan akurat. JDIH Kementerian Koordinator Bidang Pangan merupakan sistem yang dibangun untuk melaksanakan sebagian tugas pokok dan fungsi Biro Hukum Sekretariat Kementerian Koordinator Bidang Pangan, yaitu penyusunan dokumentasi dan informasi peraturan perundang-undangan di bidang pangan, khususnya yang berkaitan dengan tugas pokok dan fungsi Kementerian Koordinator Bidang Pangan.</p>
        </div>
      </section>
      <section class="list-pdf">
        @for ($i = 1; $i <= 3; $i++)
          <div class="list-pdf__item">
            <span>Landasan Hukum ke-{{$i}}</span>
            <div class="inner">
              <figure>
                <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
              </figure>
              <h6>Undang-Undang Republik Indonesia Nomor 12 Tahun 2011 tentang Pembentukan Peraturan Perundang-undangan</h6>
              <a href="#" class="button button-outline button-icon" download>
                Download PDF
                <i class="wa-icon wa-ic-download-outline"></i>
              </a>
            </div>
          </div>
        @endfor
      </section>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
