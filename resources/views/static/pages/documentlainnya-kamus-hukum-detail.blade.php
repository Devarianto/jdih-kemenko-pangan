@extends('static.layouts.layout')

@section('content')
  <section class="detail-pages no-banner">
    <div class="wrapper-content">
      <div class="wrap-result">
        <div class="detail-pages--top">
          <a href="" class="back">Kembali Ke Kipling Hukum</a>
          <div class="medsos">
            <label for="">Share:</label>
            <div class="wrap">
              <a href=""><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
              <a href=""><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
              <a href=""><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
              <a href=""><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
            </div>
          </div>
        </div>  
        <div class="result-kamus">
          <div class="result-kamus__item">
            <h3>Bahan Pangan</h3>
            <p>Abrasi adalah peristiwa rusaknya pantai sebagai akibat dari hantaman ombak atau gaya air laut</p>
          </div>
        </div>    
      </div>
      <div class="referensi">
        <h6>REFERENSI</h6>
        <a href="">Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 10 Tahun 2022</a>
        <a href="">Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 10 Tahun 2022</a>
        <a href="">Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 10 Tahun 2022</a>
      </div>
    </div>

  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> --}}
  @endpush
@endsection
