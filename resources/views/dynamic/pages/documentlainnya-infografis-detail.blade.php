@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner no-pad-bot with-other">
    <div class="wrapper-content">
      <div class="detail-pages--title">
        <span class="date">{{ date2string($infografis->date) }}</span>
        <h3>{{ $infografis->translated('title') }}</h3>
      </div>
      @php($total_slide = widget($infografis->id, 'information-infografis', 'image')->count())
      @if($total_slide > 0)
      <div class="slider-caption with-pagination swiper">
        <div class="swiper-wrapper">
          @foreach(widget($infografis->id, 'information-infografis', 'image') as $image)
            <div class="swiper-slide">
              <figure><img src="{{ media::initial($image->image)->url }}" alt="{{ media::initial($image->image)->alt }}"></figure>
            </div>
          @endforeach
        </div>
        <div class="custom-pagination">
          <span class="current-slide">1</span>/
          <span class="total-slide">4</span>
        </div>
        @if ($total_slide > 1)
        <div class="slider-caption__utils">
          <div class="swiper-arrow swiper-prev"></div>
          <div class="swiper-pagination"></div>
          <div class="swiper-arrow swiper-next"></div>
        </div>
        @endif
      </div>
      @endif
      <div class="content-pages">
        {!! $infografis->translated('description') !!}
      </div>
      <div class="detail-pages--top bottom-version">
        <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('infografis.back-to-infografis') }}</a>
        <div class="medsos">
          <label for="">{{ lang::translate('infografis.share') }}</label>
          <div class="wrap">
            <a href="javascript:;" data-url="{{ url()->current() }}" onclick="navigator.clipboard.writeText(this.dataset.url).then(()=>{ alert('{{ lang::translate('global.url-copy') }}'); });"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
            <a href="{{ $infografis->share('fb') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
          </div>
        </div>
      </div>  
    </div>
    @if (!$others->isEmpty())
    <div class="other-listing">
      <div class="wrapper">
        <h4>{{ lang::translate('infografis.other-infografis') }}</h4>
        <div class="listing-card without-box">
          @foreach ($others as $data)
          <a href="{{ $data->permalink }}" class="listing-card__item">
            <figure><img src="{{ media::initial($data->thumbnail)->url }}" alt="{{ media::initial($data->thumbnail)->alt }}"></figure>
            <figcaption>
              <p>{{ $data->translated('title') }}</p>
              <small class="visited">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M8 3.5C4.967 3.5 2.399 5.388 1.5 8C2.399 10.612 4.967 12.5 8 12.5C11.033 12.5 13.601 10.612 14.5 8C13.601 5.388 11.033 3.5 8 3.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M8 10.5C9.38071 10.5 10.5 9.38071 10.5 8C10.5 6.61929 9.38071 5.5 8 5.5C6.61929 5.5 5.5 6.61929 5.5 8C5.5 9.38071 6.61929 10.5 8 10.5Z" stroke="#999999" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ lang::translate('global.view', ['count' => $data->view_count]) }}
              </small>
            </figcaption>
          </a>
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
  @endpush
@endsection
