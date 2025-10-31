@extends('static.layouts.layout')

@section('content')
  <section class="detail-pages no-banner no-pad-bot with-other">
    <div class="wrapper-content">
      <div class="detail-pages--title">
        <span class="date">23 September 2024</span>
        <h3>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan </h3>
      </div>    
      <div class="detail-pages--images">
        <figure><img src="{{ asset('images/content/berita-detail.jpg') }}" alt=""></figure>
      </div>
      <div class="content-pages">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>Why do we use it? <br>
        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). 
        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
      </div>
      <div class="detail-pages--top bottom-version">
        <a href="" class="back">Kembali Ke Berita</a>
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
    </div>
    <div class="other-listing">
      <div class="wrapper">
        <h4>BERITA LAINNYA</h4>
        <div class="listing-card col-3">
          <a href="{{ route('front.documentlainnya-berita-detail') }}" class="listing-card__item">
            <figure><img src="{{asset('images/content/mon-1.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="date">30 Juli 2025</span>
              <p>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</p>
              <span class="link"><b>Selengkapnya</b></span>
            </figcaption>
          </a>
          <a href="{{ route('front.documentlainnya-berita-detail') }}" class="listing-card__item">
            <figure><img src="{{asset('images/content/mon-2.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="date">30 Juli 2025</span>
              <p>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</p>
              <span class="link"><b>Selengkapnya</b></span>
            </figcaption>
          </a>
          <a href="{{ route('front.documentlainnya-berita-detail') }}" class="listing-card__item">
            <figure><img src="{{asset('images/content/mon-3.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="date">30 Juli 2025</span>
              <p>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</p>
              <span class="link"><b>Selengkapnya</b></span>
            </figcaption>
          </a>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
