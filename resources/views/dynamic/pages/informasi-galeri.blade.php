@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  
  <section class="middle">
    <div class="wrapper">
      <div class="filter-galeri">
        <nav>
          <ul>
            <li><a href="javascript:;" data-filter="all" @if(!request()->query('filter') || request()->query('filter') == 'all') class="active" @endif>{{ lang::translate('gallery.filter.all') }}</a></li>
            <li><a href="javascript:;" data-filter="image" @if(request()->query('filter') == 'image') class="active" @endif>{{ lang::translate('gallery.filter.image') }}</a></li>
            <li><a href="javascript:;" data-filter="video" @if(request()->query('filter') == 'video') class="active" @endif>{{ lang::translate('gallery.filter.video') }}</a></li>
          </ul>
        </nav>
        <div class="filter-right">
          <form action="">
            <div class="col">
              <label for="">{{ lang::translate('global.sorting.title') }}</label>
              <select name="sort" id="">
                <option value="latest" @selected(request()->query('sort') == 'latest')>{{ lang::translate('global.sorting.latest') }}</option>
                <option value="oldest" @selected(request()->query('sort') == 'oldest')>{{ lang::translate('global.sorting.oldest') }}</option>
              </select>
            </div>
          </form>
        </div>
      </div>
      <div class="listing-galeri">
        @foreach ($galleries as $gallery)
        @if ($gallery->type == 'image')
        <div class="listing-galeri__item photo" data-target="#list-{{ $loop->iteration }}">
          <div class="tag photo">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
              <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
              <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
            </svg>
            {{ lang::translate('gallery.tag.image') }}
          </div>
          <figure>
            <img src="{{ media::initial($gallery->thumbnail)->url }}" alt="{{ media::initial($gallery->thumbnail)->alt }}">
          </figure>
          <figcaption>
            <span class="date">{{ Carbon\Carbon::parse($gallery->date)->format('d F Y') }}</span>
            <p>{{ $gallery->translated('title') }}</p>
          </figcaption>
        </div>
        @else
        <div class="listing-galeri__item" data-video="{{ $gallery->iframe }}">
          <div class="tag video">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
              <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
              <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
            </svg>
            {{ lang::translate('gallery.tag.video') }}
          </div>
          <figure>
            <img src="{{ media::initial($gallery->thumbnail)->url }}" alt="{{ media::initial($gallery->thumbnail)->alt }}">
            
          </figure>
          <figcaption>
            <span class="date">{{ Carbon\Carbon::parse($gallery->date)->format('d F Y') }}</span>
            <p>{{ $gallery->translated('title') }}</p>
          </figcaption>
          <div class="icon-play">
            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" viewBox="0 0 66 66" fill="none">
              <path d="M64.6206 17.1146C63.8616 14.2748 61.6256 12.0387 58.7858 11.2798C53.6383 9.90039 32.9997 9.90039 32.9997 9.90039C32.9997 9.90039 12.3612 9.90039 7.21359 11.2798C4.37443 12.0387 2.13778 14.2748 1.37878 17.1146C0 22.2616 0 33.0005 0 33.0005C0 33.0005 0 43.7394 1.37878 48.8859C2.13778 51.7257 4.37443 53.9624 7.21359 54.7212C12.3612 56.1001 32.9997 56.1001 32.9997 56.1001C32.9997 56.1001 53.6383 56.1001 58.7858 54.7212C61.6256 53.9624 63.8616 51.7257 64.6206 48.8859C66 43.7394 66 33.0005 66 33.0005C66 33.0005 66 22.2616 64.6206 17.1146Z" fill="#ED1F24"/>
              <path d="M26.4004 42.9018L43.5472 33.0017L26.4004 23.1016V42.9018Z" fill="white"/>
            </svg>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      {{ $galleries->appends(request()->query())->links('dynamic.component.pagination') }}
    </div>
  </section>
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
        @foreach ($galleries as $gallery)
        @if ($gallery->type == 'image')
        <div class="wrap-slider" id="list-{{ $loop->iteration }}">
          <div class="swiper photo-slider">
            <div class="swiper-wrapper">
              @foreach(widget($gallery->id, 'information-gallery', 'image') as $image)
              <div class="swiper-slide">
                <figure>
                  <img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}">
                  <figcaption>
                    <span class="date">{{ date2string($gallery->date) }}</span>
                    <p>{{ $image->translated('title') }}</p>
                  </figcaption>
                </figure>
              </div>
              @endforeach
            </div>
          </div>
          <div class="photo-slider-thumbs swiper">
            <div class="swiper-wrapper">
              @foreach(widget($gallery->id, 'information-gallery', 'image') as $image)
              <div class="swiper-slide">
                <figure>
                  <img src="{{ media::initial($image->thumbnail)->url }}" alt="{{ media::initial($image->thumbnail)->alt }}">
                </figure>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </div>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menambah/mengubah parameter filter di URL
        function applyFilter(paramValue) {
          const url = new URL(window.location.href);

          // Jika nilainya kosong, hapus parameternya
          if (!paramValue) {
            url.searchParams.delete('filter');
          } else {
            url.searchParams.set('filter', paramValue);
          }

          // Redirect ke URL baru dengan parameter yang diperbarui
          window.location.href = url.toString();
        }

        function sort(){
          const sort = document.querySelector('select[name="sort"]').value;

          const url = new URL(window.location.href);

          if (sort) url.searchParams.set('sort', sort);

          window.location.href = url.toString();
        }

        document.querySelector('select[name="sort"]').addEventListener('change', function() {
          sort();
        });

        // Tambahkan event listener ke semua link filter
        document.querySelectorAll('a[data-filter]').forEach(function(link) {
          link.addEventListener('click', function(event) {
            event.preventDefault();

            // Ambil nama dan nilai filter dari atribut data-*
            const filter = this.dataset.filter;   // contoh: data-filter="category"
            applyFilter(filter);
          });
        });
      });
    </script>
  @endpush
@endsection
