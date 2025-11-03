@extends('static.layouts.layout')

@section('content')
  <section class="detail-pages no-banner">
    <div class="wrapper-content">
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
      <div class="detail-pages--title">
        <small class="date">23 September 2024</small>
        <h3>Peran Kemenko Pangan dalam Strategis Kordinasi Swasembada Pangan</h3>
      </div>
      <div class="slider-caption swiper">
        <div class="swiper-wrapper">
          @for ($i = 1; $i <= 10; $i++)
            <div class="swiper-slide">
              <figure><img src="{{ asset('images/content/content-detail-1.jpg') }}" alt=""></figure>
             
            </div>
          @endfor
        </div>
        <div class="slider-caption__bottom">
          <p>Klik untuk baca artikel: <a href="">“Peran Kemenko Pangan dalam Strategis Kordinasi Swasembada Pangan”</a> </p>
          <div class="slider-caption__utils">
            <div class="swiper-arrow swiper-prev"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-arrow swiper-next"></div>
          </div>
        </div>
      </div>
    </div>
    <section class="box-detail-page no-minus">
      <div class="wrapper-content">
        <h5>Deskripsi</h5>
        <table>
          <tr>
            <th>Tipe</th>
            <td>Artikel</td>
          </tr>
          <tr>
            <th>Judul</th>
            <td>Zulkifli Hasan Ungkap RI Incar Makan Bergizi Gratis</td>
          </tr>
          <tr>
            <th>T.E.U. Badan / Pengarang</th>
            <td>Verda Nano Setiawan/CNBC Indonesia</td>
          </tr>
          <tr>
            <th>Tempat Terbit</th>
            <td>Jakarta</td>
          </tr>
          <tr>
            <th>Tahun Terbit</th>
            <td>2024</td>
          </tr>
          <tr>
            <th>Sumber</th>
            <td>Penerbit : CNBC Indonesia <br>
              Penulis : Verda Nano Setiawan <br>
              Foto : CNBC Indonesia/Faisal Rahman</td>
          </tr>
          <tr>
            <th>Subjek</th>
            <td>INDONESIA - KAWASAN PANGAN NEGARA</td>
          </tr>
          <tr>
            <th>Bahasa</th>
            <td>Bahasa Indonesia</td>
          </tr>
          <tr>
            <th>Bidang Hukum</th>
            <td>Hukum Administrasi Negara</td>
          </tr>
          <tr>
            <th>Lokasi</th>
            <td>CNBC</td>
          </tr>
          <tr>
            <th>Lampiran</th>
            <td>-</td>
          </tr>
        </table>
      </div>
    </section>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
