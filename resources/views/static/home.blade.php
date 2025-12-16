@extends('static.layouts.layout')

@section('content')
<!-- middle -->
<div class="banner-homepage">
  <figure>
    <img
      src="{{asset('images/content/banner-homepage.webp')}}"
      data-img-large="{{ asset('images/content/banner-homepage.webp') }}"
      data-img-medium="{{ asset('images/content/banner-homepage-m.webp') }}"
      data-img-small="{{ asset('images/content/banner-homepage-s.webp') }}"
      width="1380" height="620" alt="img">
  </figure>
  <div class="banner-homepage__caption">
    <h3>Selamat Datang di JDIH</h3>
    <h1>Kementerian Kordinator Bidang Pangan</h1>
    <div class="wrap-input">
      <input type="text" placeholder="Ketik Kata Kunci Pencarian">
      <button class="voice">
        <img src="{{ asset('images/material/voice.svg') }}" width="20" height="20" decoding="async" alt="">
      </button>
      <button type="submit" class="search button-icon">
        Cari
        <i class="wa-icon wa-ic-search-outline"></i>
      </button>
    </div>
    <div class="wrap-filter">
      <a href="">Pencarian Spesifik</a>
      <div class="filter">
        <div class="filter__title">
          <h6>Pencarian Spesifik</h6>
          <div class="filter__close"></div>
        </div>
        <form action="">
          <div class="row">
            <div class="column column-35">
              <label for="">Jenis Peraturan</label>
              <select name="" id="">
                <option value="" selected disabled>Pilih Peraturan</option>
                <option value="">Peraturan</option>
              </select>
            </div>
            <div class="column column-30">
              <label for="">Tema</label>
              <select name="" id="">
                <option value="" selected disabled>Pilih Tema</option>
                <option value="">Tema</option>
              </select>
            </div>
            <div class="column column-20">
              <label for="">Tahun</label>
              <select name="" id="">
                <option value="" selected disabled>Pilih Tahun</option>
                <option value="">Tema</option>
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button button-gradient">Cari</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="wave">
    <svg xmlns="http://www.w3.org/2000/svg"
      width="100%" height="140"
      viewBox="0 180 2500 200"
      fill="#EEF4FE"
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
</div>
<section class="document animating-scroll" data-animate-trigger=".trigger-1">
  <div class="trigger trigger-1"></div>
  <div class="wrapper">
    <div class="document__title">
      <h4>DOKUMEN TERBARU</h4>
      <div class="arrow">
        <div class="swiper-arrow swiper-prev"></div>
        <div class="swiper-arrow swiper-next"></div>
      </div>
    </div>
    <div class="document__listing swiper">
      <div class="swiper-wrapper">
        <a href="" class="document__listing--item swiper-slide">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #D2E3FF; color:#2063D2;">PUTUSAN HUKUM</span>
            <p>Keputusan </p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item swiper-slide">
          <figure>
            <img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document">
          </figure>
          <figcaption>
            <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
            <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/023</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item swiper-slide">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #D2E8ED; color:#0086A7;">ARTIKEL HUKUM</span>
            <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item swiper-slide">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
            <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item swiper-slide">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
            <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
      </div>
    </div>
  </div>
</section>
<section class="tema animating-scroll" data-animate-trigger=".trigger-2">
  <div class="trigger trigger-2"></div>
  <div class="bg">
    <img
      src="{{asset('images/content/bg-tema.webp')}}"
      data-img-large="{{ asset('images/content/bg-tema.webp') }}"
      data-img-medium="{{ asset('images/content/bg-tema-m.webp') }}"
      data-img-small="{{ asset('images/content/bg-tema-s.webp') }}"
      width="1380" height="620" loading="lazy" decoding="async" alt="img">
  </div>
  <div class="wave">
    <svg xmlns="http://www.w3.org/2000/svg" widht="5000" height="200" viewBox="0 180 2500 200" fill="#F8F8F8">
      <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
        <animate attributeName="d" dur="5s" values="
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 400 100 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250"
          keyTimes="0; 0.5; 1" repeatCount="indefinite">
        </animate>
      </path>
    </svg>
  </div>
  <div class="wrapper">
    <div class="tema__title">
      <h3>TEMA PERATURAN</h3>
      <p>Kumpulan peraturan yang saling berkaitan dari setiap deputi bidang</p>
    </div>
    <div class="tema-slider">
      <div class="navigation">
        <div class="swiper-arrow swiper-button-prev"></div>
        <div class="swiper-arrow swiper-button-next"></div>
      </div>
      <div class="swiper">
        <div class="tema__listing swiper-wrapper">
          <a href="" class="tema__listing--item swiper-slide">
            <figure>
              <img src="{{asset('images/content/tem-1.webp')}}" loading="lazy" decoding="async"
              width="280" height="220"
              alt="">
            </figure>
            <figcaption>
              <span class="ico">
                <img src="{{ asset('images/content/ic-tema-1.svg') }}"
                width="48" height="48"
                alt="">
              </span>
              <h6>Tata Niaga dan Distribusi Pangan</h6>
            </figcaption>
          </a>
          <a href="" class="tema__listing--item swiper-slide">
            <figure>
              <img src="{{asset('images/content/tem-2.webp')}}" loading="lazy" decoding="async" 
              width="280" height="220"
              alt="">
            </figure>
            <figcaption>
              <span class="ico"><img src="{{ asset('images/content/ic-tema-2.svg') }}" 
                width="48" height="48"
                alt=""></span>
              <h6>Usaha Pangan dan Pertanian</h6>
            </figcaption>
          </a>
          <a href="" class="tema__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/tem-3.webp')}}" loading="lazy" decoding="async" 
              width="280" height="220"
              alt=""></figure>
            <figcaption>
              <span class="ico"><img src="{{ asset('images/content/ic-tema-3.svg') }}" width="48" height="48" alt=""></span>
              <h6>Keterjangkauan dan Keamanan Pangan</h6>
            </figcaption>
          </a>
          <a href="" class="tema__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/tem-4.webp')}}" loading="lazy" decoding="async"
              width="280" height="220" 
              alt=""></figure>
            <figcaption>
              <span class="ico"><img src="{{ asset('images/content/ic-tema-4.svg') }}" width="48" height="48" alt=""></span>
              <h6>Sumber Daya Maritim</h6>
            </figcaption>
          </a>
          <a href="" class="tema__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/tem-3.webp')}}" loading="lazy" decoding="async" 
              width="280" height="220"
              alt=""></figure>
            <figcaption>
              <span class="ico"><img src="{{ asset('images/content/ic-tema-3.svg') }}" width="48" height="48" alt=""></span>
              <h6>Keterjangkauan dan Keamanan Pangan</h6>
            </figcaption>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="artikel animating-scroll" data-animate-trigger=".trigger-3">
  <div class="trigger trigger-3"></div>
  <div class="wrapper">
    <div class="artikel__left">
      <div class="list">
        <div class="list-monografi">
          <div class="list-title">
            <h5>Monografi (67)</h5>
            <a href="{{ route('front.document-monografi') }}" class="readmore">Lihat Semua</a>
          </div>
          <div class="listing-card without-box">
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-1.jpg')}}" 
                width="218" height="281"
                loading="lazy" decoding="async" alt="">
              </figure>
              <figcaption>
                <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-2.jpg')}}" 
                width="218" height="281"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-3.jpg')}}" 
                width="218" height="281"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-4.jpg')}}" 
                width="218" height="281"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
          </div>
        </div>
        <div class="list-rules">
          <div class="list-title">
            <h5>PERATURAN HUKUM (148)</h5>
            <a href="{{ route('front.document-peraturan') }}" class="readmore">Lihat Semua</a>
          </div>
          <div class="listing-card">
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-1.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Undang-Undang Nomor 31 Tahun 2025</p>
                <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-2.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Undang-Undang Nomor 45 1Tahun 2025</p>
                <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-3.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Undang-Undang Nomor 200 Tahun 2025</p>
                <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-4.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <p>Undang-Undang Nomor 18 Tahun 2025</p>
                <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
          </div>
        </div>
        <div class="list-putusan">
          <div class="list-title">
            <h5>Putusan Hukum (197)</h5>
            <a href="{{ route('front.document-putusan') }}" class="readmore">Lihat Semua</a>
          </div>
          <div class="listing-card">
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-1.jpg')}}"
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="tag"># Putusan Komisi</small>
                <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/IV/KIP-PS-A/2022</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-2.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="tag"># Putusan Komisi</small>
                <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/IV/KIP-PS-A/2022</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-3.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="tag"># Putusan Komisi</small>
                <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/IV/KIP-PS-A/2022</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-4.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="tag"># Putusan Komisi</small>
                <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/IV/KIP-PS-A/2022</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
          </div>
        </div>
        <div class="list-artikel">
          <div class="list-title">
            <h5>artikel Hukum (311)</h5>
            <a href="{{ route('front.document-article') }}" class="readmore">Lihat Semua</a>
          </div>
          <div class="listing-card">
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-1.jpg')}}"
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="date">Edisi Desember 2025</small>
                <p>Kedaulatan pangan dalam perspektif hukum dan keamanan manusia</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-2.jpg')}}"
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="date">Edisi Desember 2025</small>
                <p>Perlindungan hukum dan partisipasi masyrakat untuk menjaga</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-3.jpg')}}"
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="date">Edisi Desember 2025</small>
                <p>Perlindungan hukum dan partisipasi masyrakat untuk menjaga</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
            <a href="" class="listing-card__item">
              <figure><img src="{{asset('images/content/mon-4.jpg')}}" 
                width="218" height="120"
                loading="lazy" decoding="async" alt=""></figure>
              <figcaption>
                <small class="date">Edisi Desember 2025</small>
                <p>Perlindungan hukum dan partisipasi masyrakat untuk menjaga</p>
                <small class="visited">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  124,000 Dilihat
                </small>
              </figcaption>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="artikel__right">
      <div class="artikel__right-title">
        <h5>
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <g clip-path="url(#clip0_7898_1134)">
              <path d="M19.9375 4.8125L11.6875 13.0625L8.25 9.625L2.0625 15.8125" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M19.9375 10.3125V4.8125H14.4375" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <defs>
              <clipPath id="clip0_7898_1134">
                <rect width="22" height="22" fill="white" />
              </clipPath>
            </defs>
          </svg>
          Terpopuler
        </h5>
      </div>
      <div class="document__listing">
        <a href="" class="document__listing--item ">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #D2E3FF; color:#2063D2;">PUTUSAN HUKUM</span>
            <p>Keputusan Menteri Nomor 1841 Tahun 2026 Nomor 1841 Tahun 2026</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item ">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" loading="lazy" decoding="async" width="80" height="105" alt="document"></figure>
          <figcaption>
            <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
            <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/023</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item ">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" 
            width="80" height="105" alt=""></figure>
          <figcaption>
            <span class="tag" style="background-color: #D2E8ED; color:#0086A7;">ARTIKEL HUKUM</span>
            <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
        <a href="" class="document__listing--item ">
          <figure><img src="{{asset('images/cover_370_240_news-xlarge.jpg.webp')}}" 
            width="80" height="105" alt=""></figure>
          <figcaption>
            <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
            <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
            <small class="visited">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              124,000 Dilihat
            </small>
          </figcaption>
        </a>
      </div>
    </div>
  </div>
</section>
<section class="news animating-scroll" data-animate-trigger=".trigger-4">
  <div class="trigger trigger-4"></div>
  <div class="grid">
    <div class="grid__item">
      <div class="tag news">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
          <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6" />
          <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6" />
        </svg>
        Berita
      </div>
      <figure>
        <img src="{{ asset('images/content/large-news.webp') }}"
        width="1270" height="720"
        loading="lazy" decoding="async" alt="">
      </figure>
      <div class="grid__item--caption">
        <span class="date">30 Juli 2025</span>
        <h4>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</h4>
        <a href="" class="readmore">Baca Selengkapnya</a>
      </div>
      <div class="highlight">
        @for ($i = 1; $i <= 3; $i++)
          <a href="" class="highlight-item">
          <figure><img src="{{ asset('images/content/news-small-'.$i.'.jpg') }}"
            width="84" height="84"
             loading="lazy" decoding="async" alt=""></figure>
          <figcaption>
            <p>Rapat Pembahasan Tentang Perkembangan Situasi Terkini di Rangkaian dengan Rakor Pengendalian Inflasi Tahun 2025</p>
            <small class="date">30 Juli 2025</small>
          </figcaption>
          </a>
          @endfor
      </div>
    </div>
    <div class="grid__item photo" onclick="openPopup('#popup-photo')">
      <div class="tag photo">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
          <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6" />
          <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6" />
        </svg>
        Galeri Foto
      </div>
      <figure>
        <img src="{{ asset('images/content/news-1.jpg') }}" 
        width="635" height="360"
        loading="lazy" decoding="async" alt=""></figure>
      <figcaption>
        <span class="date">30 Juli 2025</span>
        <p>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan</p>
      </figcaption>
    </div>
    <div class="grid__item" data-video="https://www.youtube.com/embed/ScMzIvxBSi4">
      <div class="tag video">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
          <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6" />
          <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6" />
        </svg>
        Galeri Video
      </div>
      <figure>
        <img src="{{ asset('images/content/news-2.webp') }}"
        width="635" height="360"
        loading="lazy" decoding="async" alt="">
      </figure>
      <figcaption>
        <span class="date">30 Juli 2025</span>
        <p>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan</p>
      </figcaption>
      <div class="icon-play">
        <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" viewBox="0 0 66 66" fill="none">
          <path d="M64.6206 17.1146C63.8616 14.2748 61.6256 12.0387 58.7858 11.2798C53.6383 9.90039 32.9997 9.90039 32.9997 9.90039C32.9997 9.90039 12.3612 9.90039 7.21359 11.2798C4.37443 12.0387 2.13778 14.2748 1.37878 17.1146C0 22.2616 0 33.0005 0 33.0005C0 33.0005 0 43.7394 1.37878 48.8859C2.13778 51.7257 4.37443 53.9624 7.21359 54.7212C12.3612 56.1001 32.9997 56.1001 32.9997 56.1001C32.9997 56.1001 53.6383 56.1001 58.7858 54.7212C61.6256 53.9624 63.8616 51.7257 64.6206 48.8859C66 43.7394 66 33.0005 66 33.0005C66 33.0005 66 22.2616 64.6206 17.1146Z" fill="#ED1F24" />
          <path d="M26.4004 42.9018L43.5472 33.0017L26.4004 23.1016V42.9018Z" fill="white" />
        </svg>
      </div>
    </div>
  </div>
</section>
<section class="statistik animating-scroll" data-animate-trigger=".trigger-5">
  <div class="trigger trigger-5"></div>
  <div class="wrapper">
    <div class="statistik__left box">
      <h5>Grafik Statistik Hukum</h5>
      <div class="wrap-chart">
        <canvas id="statusChart"></canvas>
      </div>
      <a href="" class="button button-outline">
        <span>Lihat Selengkapnya</span>
        <div class="wave"></div>
      </a>
    </div>
    <div class="statistik__right box">
      <h5>Indeks Kepuasan Masyarakat</h5>
      <div class="rating-box">
        <div class="rating-summary">
          <h2 id="average">0.0</h2>
          <div class="stars" id="stars"></div>
          <small id="total-reviews" data-title="Review">0 Penilaian</small>
        </div>
        <div class="rating-breakdown" id="ratingBreakdown"></div>
      </div>
      <p>Terima kasih atas penilaian yang telah anda berikan, masukan anda sangat bermanfaat agar terus memperbaiki dan meningkatkan kualitas pelayanan bagi masyarakat</p>
      <a href="javascript:void(0)" class="button button-outline" onclick="openPopup('#popup-rating')">
        <span>Lihat Selengkapnya</span>
        <div class="wave"></div>
      </a>
    </div>
  </div>
</section>
<section class="partner animating-scroll" data-animate-trigger=".trigger-6">
  <div class="trigger trigger-6"></div>
  <div class="wrapper">
    <h5>Institusi Terkait</h5>
  </div>
  <div class="logo-slider swiper">
    <div class="swiper-arrow swiper-prev"></div>
    <div class="swiper-arrow swiper-next"></div>
    <div class="swiper-wrapper">
      @for ($i = 1; $i <= 5; $i++)
        <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-'.$i.'.webp') }}" loading="lazy" decoding="async" alt="">
        </a>
      @endfor
      <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-2.webp') }}" loading="lazy" decoding="async" alt="">
      </a>
      <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-1.webp') }}" loading="lazy" decoding="async" alt="">
      </a>
      {{-- <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-2.webp') }}" loading="lazy" decoding="async" alt="">
      </a>
      <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-2.webp') }}" loading="lazy" decoding="async" alt="">
      </a>
      <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-2.webp') }}" loading="lazy" decoding="async" alt="">
      </a>
      <a href="" class="swiper-slide">
        <img src="{{ asset('images/content/partner-2.webp') }}" loading="lazy" decoding="async" alt="">
      </a> --}}
    </div>
  </div>
</section>

<div class="popup scroll-out" id="popup-home">
  <div class="wrap-popup">
    <div class="wrap-popup__main">
      <div class="popup__overlay"></div>
      <div class="popup__box">
        <div class="popup__content home-popup">
          <figure>
            <img src="{{ asset('images/content/large-news.webp') }}" loading="lazy" decoding="async" alt="">
          </figure>
          <figcaption class="content-pages">
            <h4>Lorem Ipsum Dolor Sit Amet</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa consectetur perspiciatis officia doloremque ullam unde similique temporibus sint, vero, autem incidunt, eveniet laboriosam fuga cum vel tenetur soluta magni animi!</p>
            <a href="javascript:void(0)" class="button button-outline">
              <span>Lihat Selengkapnya</span>
              <div class="wave"></div>
            </a>
          </figcaption>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup scroll-out popup-rating" id="popup-rating">
  <div class="wrap-popup">
    <div class="wrap-popup__main">
      <div class="popup__overlay"></div>
      <div class="popup__box popup__box--large">
        <div class="popup__close">
          <i class="wa-icon wa-ic-close-solid"></i>
        </div>
        <div class="popup__content box-form">
          <h6>BERIKAN RATING</h6>
          <form action="">
            <div class="row row-wrap">
              <div class="column column-100">
                <label for="">Rating<i>*</i></label>
                <div class="rates">
                  <input type="radio" id="starR5" name="rateR" value="5">
                  <label for="starR5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                      <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6" />
                    </svg>
                  </label>
                  <input type="radio" id="starR4" name="rateR" value="4">
                  <label for="starR4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                      <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6" />
                    </svg>
                  </label>
                  <input type="radio" id="starR3" name="rateR" value="3">
                  <label for="starR3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                      <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6" />
                    </svg>
                  </label>
                  <input type="radio" id="starR2" name="rateR" value="2">
                  <label for="starR2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                      <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6" />
                    </svg>
                  </label>
                  <input type="radio" id="starR1" name="rateR" value="1">
                  <label for="starR1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26.522" height="24.864" viewBox="0 0 26.522 24.864">
                      <path id="star" d="M12.539,1.515a.8.8,0,0,1,1.444,0L17.05,7.951a.8.8,0,0,0,.624.45l7.138.884a.8.8,0,0,1,.445,1.381L20.025,15.5a.8.8,0,0,0-.242.74L21.133,23.2a.8.8,0,0,1-1.167.856l-6.324-3.432a.8.8,0,0,0-.763,0L6.555,24.055A.8.8,0,0,1,5.388,23.2l1.351-6.956A.8.8,0,0,0,6.5,15.5L1.265,10.667A.8.8,0,0,1,1.71,9.285L8.847,8.4a.8.8,0,0,0,.624-.45Z" fill="#e6e6e6" />
                    </svg>
                  </label>
                </div>
              </div>
              <div class="column column-100">
                <label for="">Nama<i>*</i></label>
                <input type="text" placeholder="Nama Lengkap">
              </div>
              <div class="column column-100">
                <label for="">Email<i>*</i></label>
                <input type="text" placeholder="Alamat Email">
              </div>
              <div class="column column-100">
                <label for="">Komentar<i>*</i></label>
                <textarea name="" id="" placeholder="Tuliskan Komentar Anda"></textarea>
              </div>
              <div class="column column-100">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
              </div>
              <div class="column column-100">
                <button type="submit" class="button button-gradient">Kirim</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="popup popup-video" id="popup-video">
  <div class="popup__overlay"></div>
  <div class="popup__box popup__box--large">
    <div class="popup__content">
      <div class="wrap-video">
        <iframe src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
<div class="popup popup-photo" id="popup-photo">
  <div class="popup__overlay"></div>
  <div class="popup__box popup__box--large">
    <div class="popup__close">
      <i class="wa-icon wa-ic-close-solid"></i>
    </div>
    <div class="popup__content">
      <div class="wrap-slider">
        <div class="swiper photo-slider">
          <div class="swiper-wrapper">
            @for ($i = 1; $i <= 6; $i++)
              <div class="swiper-slide">
              <figure>
                <img src="{{ asset('images/content/news-xlarge.jpg') }}" alt="">
                <figcaption>
                  <span class="date">30 Juli 2025</span>
                  <p>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan</p>
                </figcaption>
              </figure>
          </div>
          @endfor
        </div>
      </div>
      <div class="photo-slider-thumbs swiper">
        <div class="swiper-wrapper">
          @for ($a = 1; $a <= 2; $a++)
            @for ($i=1; $i <=3; $i++)
            <div class="swiper-slide">
            <figure>
              <img src="{{ asset('images/content/news-thumb-'.$i.'.jpg') }}" alt="">
            </figure>
        </div>
        @endfor
        @endfor
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- end of middle -->
@push('head')
<link rel="preload" href="{{ Vite::asset('resources/assets/sass/pages/home.scss') }}"
  as="style"
  onload="this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ Vite::asset('resources/assets/sass/pages/home.scss') }}"></noscript>
@endpush
@push('footer')
<script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/home.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  window.ratingData = {
    average: 4.7,
    total: 10,
    breakdown: {
      5: 5,
      4: 3,
      3: 2,
      2: 0,
      1: 0
    }
  };
</script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    // openPopup('#popup-home')
    const ctx = $("#statusChart");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["2022", "2023", "2024", "2025", "2026"],
        datasets: [{
            label: "Berlaku",
            data: [88, 68, 72, 83, 82],
            backgroundColor: "#2063D2",
            borderRadius: 8,
            barPercentage: 0.8,
            categoryPercentage: 0.8
          },
          {
            label: "Tidak Berlaku",
            data: [76, 72, 45, 40, 38],
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
            align: "start",
            labels: {
              usePointStyle: true,
              pointStyle: "circle",
              boxWidth: 11,
              boxHeight: 11,
              textAlign: "left",
              padding: 20,
              font: {
                size: 11
              },
              color: "#373737",
              boxPadding: 6
            }
          }
        }
      }
    });
  })
</script>
@endpush
@endsection