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
      <small>DOKUMEN HUKUM</small>
      <h2>MONOGRAFI HUKUM</h2>
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
      <div class="middle__search">
        <div class="row">
          <div class="column column-65">
            <label for="">Nama Peraturan</label>
            <input type="text" placeholder="Ketik Kata Kunci Pencarian">
          </div>
          <div class="column column-20">
            <label for="">Tahun</label>
            <select name="" id="">
              <option value="">Tahun</option>
            </select>
          </div>
          <div class="column column-15">
            <button type="submit" class="button-icon button-gradient">
              Cari
              <i class="wa-icon wa-ic-search-outline"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="listing-card">
        @for ($i = 1; $i <= 3; $i++)
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
