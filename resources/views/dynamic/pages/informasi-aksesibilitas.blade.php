@extends('dynamic.layouts.layout')

@section('content')
@if(count(widget($menu->id, 'menu', 'banner')) > 0)
  @include('dynamic.component.banner')
@else
  <section class="banner-middle" style="background: linear-gradient(135deg, #0a3d62 0%, #1e3799 100%); min-height: 240px; display: flex; align-items: center; position: relative;">
    <div class="wrapper" style="position: relative; z-index: 2; padding: 40px 20px;">
      <small style="color: #68d391; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Pusat Informasi & Aksesibilitas</small>
      <h2 style="color: #ffffff; font-weight: 700; margin-top: 6px;">Video Aksesibilitas</h2>
    </div>
    <div class="wave">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="80" viewBox="0 180 2500 200" fill="#F8F8F8" preserveAspectRatio="none">
            <path class="st1" d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"></path>
        </svg>
    </div>
  </section>
@endif

  <section class="middle">
    <div class="wrapper">
      <div class="filter-galeri" style="margin-bottom: 30px;">
        <div class="filter-left" style="display: flex; align-items: center; gap: 12px;">
          <span style="font-weight: 600; color: #198754; display: inline-flex; align-items: center; gap: 6px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="23 7 16 12 23 17 23 7"></polygon>
              <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
            </svg>
            Video Aksesibilitas
          </span>
          <span style="background: #e8f5e9; color: #1b5e20; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">
            {{ $videos->total() }} Video Tersedia
          </span>
        </div>
        <div class="filter-right">
          <form action="" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <div class="col" style="min-width: 200px;">
              <input type="text" name="search" value="{{ request()->query('search') }}" placeholder="Cari video aksesibilitas..." style="padding: 8px 14px; border: 1px solid #ced4da; border-radius: 6px; font-size: 13px; width: 100%;">
            </div>
            <div class="col">
              <select name="sort" onchange="this.form.submit()" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 13px;">
                <option value="latest" @selected(request()->query('sort') != 'oldest')>Terbaru</option>
                <option value="oldest" @selected(request()->query('sort') == 'oldest')>Terlama</option>
              </select>
            </div>
            @if(request()->query('search'))
              <a href="{{ url()->current() }}" style="font-size: 12px; color: #dc3545; text-decoration: underline;">Reset</a>
            @endif
          </form>
        </div>
      </div>

      @if($videos->count() > 0)
        <div class="listing-galeri">
          @foreach ($videos as $video)
            <div class="listing-galeri__item video-aksesibilitas-card" data-video="{{ $video->embed_url }}" style="cursor: pointer;">
              <div class="tag video" style="background: #198754; color: #fff;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                  <path d="M9.6175 1.375H2.3825C1.5515 1.375 0.875 2.051 0.875 2.8825V10.118C0.875 10.949 1.551 11.6255 2.3825 11.6255H9.618C10.449 11.6255 11.1255 10.9495 11.1255 10.118V2.8825C11.125 2.051 10.449 1.375 9.6175 1.375ZM10.522 10.1175C10.522 10.616 10.1165 11.022 9.6175 11.022H2.3825C1.884 11.022 1.478 10.6165 1.478 10.1175V9.027L3.911 6.3235L7.1975 9.311L9.015 7.7965L10.5225 9.0525L10.522 10.1175ZM10.522 8.268L9.0145 7.012L7.214 8.512L3.8685 5.47L1.478 8.126V2.8825C1.478 2.384 1.8835 1.978 2.3825 1.978H9.618C10.1165 1.978 10.5225 2.3835 10.5225 2.8825L10.522 8.268Z" fill="white" stroke="white" stroke-width="0.6"/>
                  <path d="M8.11102 5.89684C8.94202 5.89684 9.61852 5.22084 9.61852 4.38934C9.61852 3.55784 8.94252 2.88184 8.11102 2.88184C7.28002 2.88184 6.60352 3.55784 6.60352 4.38934C6.60352 5.22084 7.27952 5.89684 8.11102 5.89684ZM8.11102 3.48534C8.60952 3.48534 9.01552 3.89084 9.01552 4.38984C9.01552 4.88884 8.61002 5.29434 8.11102 5.29434C7.61202 5.29434 7.20652 4.88884 7.20652 4.38984C7.20652 3.89084 7.61202 3.48534 8.11102 3.48534Z" fill="white" stroke="white" stroke-width="0.6"/>
                </svg>
                Aksesibilitas
              </div>
              <figure>
                <img src="{{ $video->thumbnail_url ?: asset('images/material/default-video.jpg') }}" alt="{{ $video->translated('title') }}">
              </figure>
              <figcaption>
                <span class="date">{{ Carbon\Carbon::parse($video->date)->format('d F Y') }}</span>
                <p>{{ $video->translated('title') }}</p>
                @if($video->translated('description'))
                  <small style="color: #e0e0e0; font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-top: 4px;">
                    {{ $video->translated('description') }}
                  </small>
                @endif
              </figcaption>
              <div class="icon-play">
                <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" viewBox="0 0 66 66" fill="none">
                  <path d="M64.6206 17.1146C63.8616 14.2748 61.6256 12.0387 58.7858 11.2798C53.6383 9.90039 32.9997 9.90039 32.9997 9.90039C32.9997 9.90039 12.3612 9.90039 7.21359 11.2798C4.37443 12.0387 2.13778 14.2748 1.37878 17.1146C0 22.2616 0 33.0005 0 33.0005C0 33.0005 0 43.7394 1.37878 48.8859C2.13778 51.7257 4.37443 53.9624 7.21359 54.7212C12.3612 56.1001 32.9997 56.1001 32.9997 56.1001C32.9997 56.1001 53.6383 56.1001 58.7858 54.7212C61.6256 53.9624 63.8616 51.7257 64.6206 48.8859C66 43.7394 66 33.0005 66 33.0005C66 33.0005 66 22.2616 64.6206 17.1146Z" fill="#198754"/>
                  <path d="M26.4004 42.9018L43.5472 33.0017L26.4004 23.1016V42.9018Z" fill="white"/>
                </svg>
              </div>
            </div>
          @endforeach
        </div>
        {{ $videos->appends(request()->query())->links('dynamic.component.pagination') }}
      @else
        <div class="empty-state" style="text-align: center; padding: 70px 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin: 40px 0;">
          <div style="width: 80px; height: 80px; margin: 0 auto 20px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #16a34a;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="m22 8-6 4 6 4V8Z"/>
              <rect width="14" height="12" x="2" y="6" rx="2"/>
            </svg>
          </div>
          <h4 style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Belum ada video aksesibilitas yang tersedia.</h4>
          <p style="color: #64748b; font-size: 14px; max-width: 480px; margin: 0 auto;">Konten video panduan aksesibilitas sedang dipersiapkan dan akan segera dipublikasikan pada halaman ini.</p>
        </div>
      @endif
    </div>
  </section>

  {{-- Popup Modal Video Player --}}
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

  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Klik pada kartu video memicu play popup
        document.querySelectorAll('.video-aksesibilitas-card').forEach(function(card) {
          card.addEventListener('click', function(e) {
            if (!e.target.closest('.icon-play')) {
              const playIcon = this.querySelector('.icon-play');
              if (playIcon) playIcon.click();
            }
          });
        });
      });
    </script>
  @endpush
@endsection
