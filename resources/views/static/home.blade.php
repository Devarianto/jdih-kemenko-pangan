@extends('static.layouts.layout')

@section('content')
  <!-- middle -->
  <div class="banner-homepage">
    <figure>
      <img src="{{asset('images/content/banner-homepage.jpg')}}" alt="">
    </figure>
    <div class="banner-homepage__caption">
      <h3>Selamat Datang di JDIH</h3>
      <h6>Kementerian Kordinator Bidang Pangan</h6>
      <div class="wrap-input">
        <input type="text" placeholder="Ketik Kata Kunci Pencarian">
        <button class="voice">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
            <path d="M10 17.375C8.3424 17.375 6.75269 16.7165 5.58058 15.5444C4.40848 14.3723 3.75 12.7826 3.75 11.125C3.75 10.9592 3.81585 10.8003 3.93306 10.6831C4.05027 10.5658 4.20924 10.5 4.375 10.5C4.54076 10.5 4.69973 10.5658 4.81694 10.6831C4.93415 10.8003 5 10.9592 5 11.125C5 12.4511 5.52678 13.7229 6.46447 14.6605C7.40215 15.5982 8.67392 16.125 10 16.125C11.3261 16.125 12.5979 15.5982 13.5355 14.6605C14.4732 13.7229 15 12.4511 15 11.125C15 10.9592 15.0658 10.8003 15.1831 10.6831C15.3003 10.5658 15.4592 10.5 15.625 10.5C15.7908 10.5 15.9497 10.5658 16.0669 10.6831C16.1842 10.8003 16.25 10.9592 16.25 11.125C16.25 12.7826 15.5915 14.3723 14.4194 15.5444C13.2473 16.7165 11.6576 17.375 10 17.375Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
            <path d="M10 19.875C9.83424 19.875 9.67527 19.8092 9.55806 19.6919C9.44085 19.5747 9.375 19.4158 9.375 19.25V16.75C9.375 16.5842 9.44085 16.4253 9.55806 16.3081C9.67527 16.1908 9.83424 16.125 10 16.125C10.1658 16.125 10.3247 16.1908 10.4419 16.3081C10.5592 16.4253 10.625 16.5842 10.625 16.75V19.25C10.625 19.4158 10.5592 19.5747 10.4419 19.6919C10.3247 19.8092 10.1658 19.875 10 19.875Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
            <path d="M10 14.875C9.00544 14.875 8.05161 14.4799 7.34835 13.7767C6.64509 13.0734 6.25 12.1196 6.25 11.125V4.875C6.25 3.88044 6.64509 2.92661 7.34835 2.22335C8.05161 1.52009 9.00544 1.125 10 1.125C10.9946 1.125 11.9484 1.52009 12.6517 2.22335C13.3549 2.92661 13.75 3.88044 13.75 4.875V11.125C13.75 12.1196 13.3549 13.0734 12.6517 13.7767C11.9484 14.4799 10.9946 14.875 10 14.875ZM10 2.375C9.33696 2.375 8.70107 2.63839 8.23223 3.10723C7.76339 3.57607 7.5 4.21196 7.5 4.875V11.125C7.5 11.788 7.76339 12.4239 8.23223 12.8928C8.70107 13.3616 9.33696 13.625 10 13.625C10.663 13.625 11.2989 13.3616 11.7678 12.8928C12.2366 12.4239 12.5 11.788 12.5 11.125V4.875C12.5 4.21196 12.2366 3.57607 11.7678 3.10723C11.2989 2.63839 10.663 2.375 10 2.375Z" fill="#2063D2" stroke="#2063D2" stroke-width="0.2"/>
          </svg>
        </button>
        <button type="submit" class="search">
          Cari
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
            <path d="M9.16667 16.3333C12.8486 16.3333 15.8333 13.3486 15.8333 9.66667C15.8333 5.98477 12.8486 3 9.16667 3C5.48477 3 2.5 5.98477 2.5 9.66667C2.5 13.3486 5.48477 16.3333 9.16667 16.3333Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17.625 17.625L14 14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
    <div class="wave">
      <svg xmlns="http://www.w3.org/2000/svg" widht="3000" height="250" viewBox="0 180 2500 200" fill="#EEF4FE">
        <path class="st1" d="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250">
            <animate attributeName="d" dur="5s" values="M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 400 50 400 400 3000 250 L 3000 550 L 0 550 L 0 250;
            M 0 250 C 1200 400 1200 50 3000 250 L 3000 550 L 0 550 L 0 250" repeatCount="indefinite"></animate>
        </path>
      </svg>
    </div>
  </div>
  <section class="document">
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
            <figure><img src="{{asset('images/content/dok-1.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E3FF; color:#2063D2;">PUTUSAN HUKUM</span>
              <p>Keputusan Menteri Nomor 1841 Tahun 2026 Nomor 1841 Tahun 2026</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/dok-2.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
              <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/023</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/dok-3.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E8ED; color:#0086A7;">ARTIKEL HUKUM</span>
              <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/dok-4.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
              <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item swiper-slide">
            <figure><img src="{{asset('images/content/dok-4.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
              <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
        </div>
      </div>
    </div>
  </section>
  <section class="tema">
    <div class="bg"><img src="{{asset('images/content/bg-tema.jpg')}}" alt="" /> </div>
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
      <div class="tema__listing">
        <a href="" class="tema__listing--item">
          <figure><img src="{{asset('images/content/tem-1.jpg')}}" alt=""></figure>
          <figcaption>
            <span class="ico"><img src="{{ asset('images/content/ic-tema-1.svg') }}" alt=""></span>
            <h6>Tata Niaga dan Distribusi Pangan</h6>
          </figcaption>
        </a>
        <a href="" class="tema__listing--item">
          <figure><img src="{{asset('images/content/tem-2.jpg')}}" alt=""></figure>
          <figcaption>
            <span class="ico"><img src="{{ asset('images/content/ic-tema-2.svg') }}" alt=""></span>
            <h6>Usaha Pangan dan Pertanian</h6>
          </figcaption>
        </a>
        <a href="" class="tema__listing--item">
          <figure><img src="{{asset('images/content/tem-3.jpg')}}" alt=""></figure>
          <figcaption>
            <span class="ico"><img src="{{ asset('images/content/ic-tema-3.svg') }}" alt=""></span>
            <h6>Keterjangkauan dan Keamanan Pangan</h6>
          </figcaption>
        </a>
        <a href="" class="tema__listing--item">
          <figure><img src="{{asset('images/content/tem-4.jpg')}}" alt=""></figure>
          <figcaption>
            <span class="ico"><img src="{{ asset('images/content/ic-tema-4.svg') }}" alt=""></span>
            <h6>Sumber Daya Maritim</h6>
          </figcaption>
        </a>
      </div>
    </div>
  </section>
  <section class="artikel">
    <div class="wrapper">
      <div class="artikel__left">
        <div class="list">
          <div class="list-monografi">
            <div class="list-title">
              <h5>Monografi (67)</h5>
              <a class="readmore">Lihat Semua</a>
            </div>
            <div class="listing-card without-box">
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-1.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-2.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-3.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-4.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Peran Strategis Kordinasi Swasembada Pangan</p>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
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
              <a class="readmore">Lihat Semua</a>
            </div>
            <div class="listing-card">
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-1.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 31 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-2.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 45 1Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-3.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 200 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-4.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 18 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
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
              <a class="readmore">Lihat Semua</a>
            </div>
            <div class="listing-card">
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-1.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 31 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-2.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 45 1Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-3.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 200 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-4.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 18 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
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
              <a class="readmore">Lihat Semua</a>
            </div>
            <div class="listing-card">
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-1.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 31 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-2.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 45 1Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-3.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 200 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                </figcaption>
              </a>
              <a href="" class="listing-card__item">
                <figure><img src="{{asset('images/content/mon-4.jpg')}}" alt=""></figure>
                <figcaption>
                  <p>Undang-Undang Nomor 18 Tahun 2025</p>
                  <span>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</span>
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
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
                <path d="M19.9375 4.8125L11.6875 13.0625L8.25 9.625L2.0625 15.8125" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19.9375 10.3125V4.8125H14.4375" stroke="#2063D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </g>
              <defs>
                <clipPath id="clip0_7898_1134">
                  <rect width="22" height="22" fill="white"/>
                </clipPath>
              </defs>
            </svg>
            Terpopuler
          </h5>
        </div>
        <div class="document__listing">
          <a href="" class="document__listing--item ">
            <figure><img src="{{asset('images/content/dok-1.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E3FF; color:#2063D2;">PUTUSAN HUKUM</span>
              <p>Keputusan Menteri Nomor 1841 Tahun 2026 Nomor 1841 Tahun 2026</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item ">
            <figure><img src="{{asset('images/content/dok-2.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
              <p>Putusan Komisi Informasi Pusat Republik Indonesia Nomor 023/023</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item ">
            <figure><img src="{{asset('images/content/dok-3.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #D2E8ED; color:#0086A7;">ARTIKEL HUKUM</span>
              <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
          <a href="" class="document__listing--item ">
            <figure><img src="{{asset('images/content/dok-4.jpg')}}" alt=""></figure>
            <figcaption>
              <span class="tag" style="background-color: #C1CCFF; color:#091D77;">PERATURAN HUKUM</span>
              <p>Perlindungan hukum dan partisipasi masyrakat untuk mengetahui</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                124,000 Dilihat
              </small>
            </figcaption>
          </a>
        </div>
      </div>
    </div>
  </section>
  <section class="news">
    <div class="grid">
      <div class="grid__item">
        <div class="tag news">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          Berita
        </div>
        <figure>
          <img src="{{ asset('images/content/large-news.jpg') }}" alt="">
        </figure>
        <div class="grid__item--caption">
          <span class="date">30 Juli 2025</span>
          <h4>Pemerintah akan mengirim bantuan strategis untuk swasembada pangan di daerah terpencil</h4>
          <a href="" class="readmore">Baca Selengkapnya</a>
        </div>
        <div class="highlight">
          @for ($i = 1; $i <= 3; $i++)
          <a href="" class="highlight-item">
            <figure><img src="{{ asset('images/content/news-small-'.$i.'.jpg') }}" alt=""></figure>
            <figcaption>
              <p>Rapat Pembahasan Tentang Perkembangan Situasi Terkini di Rangkaian dengan Rakor Pengendalian Inflasi Tahun 2025</p>
              <small class="date">30 Juli 2025</small>
            </figcaption>
          </a>
          @endfor
        </div>
      </div>
      <div class="grid__item">
         <div class="tag photo">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          Galeri Foto
        </div>
        <figure><img src="{{ asset('images/content/news-1.jpg') }}" alt=""></figure>
        <figcaption>
          <span class="date">30 Juli 2025</span>
          <p>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan</p>
        </figcaption>
      </div>
      <div class="grid__item">
         <div class="tag video">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
            <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
            <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
          </svg>
          Galeri Video
        </div>
        <figure><img src="{{ asset('images/content/news-2.jpg') }}" alt=""></figure>
        <figcaption>
          <span class="date">30 Juli 2025</span>
          <p>Rapat Koordinasi JDIH untuk kordinasi Nasional tentang Pangan</p>
        </figcaption>
      </div>
    </div>
  </section>
  <section class="statistik">
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
            <small id="total-reviews">0 Penilaian</small>
          </div>
          <div class="rating-breakdown" id="ratingBreakdown"></div>
        </div>
        <p>Terima kasih atas penilaian yang telah anda berikan, masukan anda sangat bermanfaat agar terus memperbaiki dan meningkatkan kualitas pelayanan bagi masyarakat</p>
        <a href="" class="button button-outline">
          <span>Lihat Selengkapnya</span>
          <div class="wave"></div>
        </a>
      </div>
    </div>
  </section>
  <section class="partner">
    <div class="wrapper">
      <h5>Institusi Terkait</h5>
    </div>
    <div class="logo-slider swiper">
      <div class="swiper-wrapper">
        @for ($i = 1; $i <= 5; $i++)
        <a href="" class="swiper-slide">
          <img src="{{ asset('images/content/partner-'.$i.'.png') }}" alt="">
        </a>
        @endfor
        <a href="" class="swiper-slide">
          <img src="{{ asset('images/content/partner-1.png') }}" alt="">
        </a>
           <a href="" class="swiper-slide">
          <img src="{{ asset('images/content/partner-2.png') }}" alt="">
        </a>
      </div>
    </div>
  </section>
  <!-- end of middle -->
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/home.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ratingData = {
        average: 4.7,
        total: 10,
        breakdown: { 5: 5, 4: 3, 3: 2, 2: 0, 1: 0 }
      };
      document.addEventListener("DOMContentLoaded", function(event) { 
        const ctx = $("#statusChart");
        new Chart(ctx, {
          type: "bar",
          data: {
            labels: ["2022", "2023", "2024", "2025", "2026"],
            datasets: [
              {
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
              align:"start",
              labels: {
                usePointStyle: true,
                pointStyle: "circle",
                boxWidth: 11,
                boxHeight: 11,
                textAlign: "left",
                padding: 20,
                font: { size: 11 },
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
