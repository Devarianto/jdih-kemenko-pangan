@extends('dynamic.layouts.layout')

@section('content')
  <section class="detail-pages no-banner no-pad-bot with-other">
    <div class="wrapper-content">
      <div class="detail-pages--title">
        <span class="date">{{ date2string($news->date) }}</span>
        <h3>{{ $news->translated('title') }}</h3>
      </div>    
      <div class="detail-pages--images">
        <figure><img src="{{ media::initial($news->image)->url }}" alt="{{ media::initial($news->image)->alt }}"></figure>
      </div>
      <div class="content-pages">
        {!! $news->description !!}
      </div>
      <div class="detail-pages--top bottom-version">
        <a href="{{ $menu->permalink }}" class="back">{{ lang::translate('news.back-to-news') }}</a>
        <div class="medsos">
          <label for="">{{ lang::translate("news.share") }}</label>
          <div class="wrap">
            <a href="{{ $news->share('link') }}" target="__BLANK"><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
            <a href="{{ $news->share('wa') }}" target="__BLANK"><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
            <a href="{{ $news->share('twitter') }}" target="__BLANK"><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
            <a href="{{ $news->share('tw') }}" target="__BLANK"><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
          </div>
        </div>
      </div>  
    </div>
    <div class="other-listing">
      <div class="wrapper">
        <h4>{{ lang::translate('news.other-news') }}</h4>
        <div class="listing-card col-3">
          @foreach ($others as $other)
          <a href="{{ $other->permalink }}" class="listing-card__item">
            <figure><img src="{{ media::initial($other->thumbnail)->url }}" alt="{{ media::initial($other->thumbnail)->alt }}"></figure>
            <figcaption>
              <span class="date">{{ date2string($other->date) }}</span>
              <p>{{ $other->translated('title') }}</p>
              <span class="link"><b>{{ lang::translate('news.read-more') }}</b></span>
            </figcaption>
          </a>
          @endforeach
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
