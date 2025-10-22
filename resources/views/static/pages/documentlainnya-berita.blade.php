@extends('static.layouts.layout')

@section('content')
  <section class="banner-middle">
    <figure>
      <img 
        src="{{asset('images/content/banner-peraturan.webp')}}" 
        data-img-large="{{ asset('images/content/banner-peraturan.webp') }}"
        data-img-medium="{{ asset('images/content/banner-peraturan.webp') }}"
        data-img-small="{{ asset('images/content/banner-peraturan.webp') }}"
        width="1380" height="400" alt="img">
    </figure>
    <figcaption>
      <small>INFORMASI LAINNYA</small>
      <h2>BERITA</h2>
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
    <div class="wrapper">
       <div class="filter-right">
        <form action="">
          <div class="col">
            <label for="">Urutkan</label>
            <select name="" id="">
              <option value="">Terbaru</option>
            </select>
          </div>
        </form>
      </div>
      <div class="listing-card col-3">
        @for ($i = 1; $i <= 3; $i++)
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
          <a href="{{ route('front.documentlainnya-berita-detail') }}" class="listing-card__item">
            <figure><img src="{{asset('images/content/mon-4.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="date">30 Juli 2025</span>
              <p>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</p>
              <span class="link"><b>Selengkapnya</b></span>
            </figcaption>
          </a>
        @endfor
      </div>
      @include('static.component.pagination')
    </div>
  </section>
  
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
