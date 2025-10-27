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
      <h2>PERATURAN HUKUM</h2>
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
    <div class="wrapper">
      <div class="middle__search">
        <div class="row">
          <div class="column column-85">
            <label for="">Nama Peraturan</label>
            <input type="text" placeholder="Ketik Kata Kunci Pencarian">
          </div>
          <div class="column column-15">
            <button type="submit" class="button-icon button-gradient">
              Cari
              <i class="wa-icon wa-ic-search-outline"></i>
            </button>
          </div>
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
                  <button type="submit" class="button-icon button-gradient">
                    Cari
                    <i class="wa-icon wa-ic-search-outline"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="listing-rules">
        @for ($i = 1; $i <= 9; $i++)
          <div class="listing-rules__item">
            <figure><img src="{{ asset('images/content/rules-1.jpg') }}" alt=""></figure>
            <figcaption>
              <div class="wrap-flex">
                <div class="text">
                  <span class="category">Baru</span>
                  <p>Undang-Undang Nomor 31 Tahun 2025</p>
                  <small>Tentang Perubahan Keempat Atas Undang-Undang Nomor 4 Tahun 2009 Tentang</small>
                </div>
                <a href="{{ route('front.document-peraturan-detail') }}" class="button button-outline">Lihat Selengkapnya</a>
              </div>
              <div class="bottom">
                <div class="bottom__left">
                  <small class="visited">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    124,000 Dilihat
                  </small>
                  <small class="downloaded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#999999"/>
                    </svg>
                    50,000 Diunduh
                  </small>
                </div>
                <div class="bottom__right">
                  <span class="button button-outline button-icon">
                    Abstrak
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M9.33366 1.33301H4.00033C3.6467 1.33301 3.30756 1.47348 3.05752 1.72353C2.80747 1.97358 2.66699 2.31272 2.66699 2.66634V13.333C2.66699 13.6866 2.80747 14.0258 3.05752 14.2758C3.30756 14.5259 3.6467 14.6663 4.00033 14.6663H12.0003C12.3539 14.6663 12.6931 14.5259 12.9431 14.2758C13.1932 14.0258 13.3337 13.6866 13.3337 13.333V5.33301L9.33366 1.33301Z" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.33301 1.33301V5.33301H13.333" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10.6663 8.66699H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M10.6663 11.333H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6.66634 6H5.99967H5.33301" stroke="#2063D2" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                  <span class="button button-outline button-icon" download>
                    Unduh
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6663 10.6663V13.333C14.6663 14.0694 14.0694 14.6663 13.333 14.6663H2.66634C1.92996 14.6663 1.33301 14.0694 1.33301 13.333V10.6663H2.66634V13.333H13.333V10.6663H14.6663ZM8.66634 8.3902L10.8616 6.19494L11.8044 7.13775L7.99967 10.9425L4.19494 7.13775L5.13775 6.19494L7.33301 8.3902V1.33301H8.66634V8.3902Z" fill="#2063D2"/>
                    </svg>
                  </span>
                </div>
              </div>
            </figcaption>
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
