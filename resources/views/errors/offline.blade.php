@extends('dynamic.layouts.layout-2')

@section('content')
  <section class="misc under">
    <div class="wrapper-content">
      <div class="misc__left">
        <figure><img src="{{ media::url(conf('offline-page')->image) }}" alt="{{ media::initial(conf('offline-page')->image)->alt }}"></figure>
      </div>
      <div class="misc__right">
        <h2>{{ conf('offline-page')->translated('title') }}</h2>
        <p>{{ conf('offline-page')->translated('intro') }}</p>
        <div class="medsos">
          <label for="">{{ lang::translate('offline-page.social-media') }}</label>
          <div class="wrap">
            @foreach (widget_conf('offline-page', 'social-media') as $social)
            <a href=""><img src="{{ media::url($social->image) }}" alt="{{ media::initial($social->image)->alt }}"></a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer undermaintenance">
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
    <div class="wrapper">
      @php($footer = widget(99, 'site-setting-conf', 'footer', false))
      @if($footer)
      <div class="top">
        <div class="box">
          <div class="logo logo-multi">
            <img src="{{ media::initial($footer->logo)->url }}" alt="{{ media::initial($footer->logo)->alt }}">
            @include('dynamic.component.logo-links', ['homeUrl' => lang::url('/')])
          </div>
          <p>{{ $footer->translated('title') }}</p>
          <address>{!! nl2br(strip_tags($footer->address, '<br>')) !!}</address>
        </div>
        <div class="box">
          <a href="tel:{{ preg_replace('/\D/', '', $footer->phone) }}" class="button button-icon button-outline ">
            <i class="wa-icon wa-ic-phone-solid"></i>
            {{ $footer->phone }}
          </a>
        </div>
      </div>
      @endif
      <div class="bot">
        <p>{!! og::copyright() !!}</p>
        <div class="bot__right">
          @php($socmed = widget(99, 'site-setting-conf', 'socmed'))
          @foreach ($socmed as $data)
          <a href="{{ $data->link }}" target="__BLANK"><img src="{{ media::initial($data->icon)->url }}" alt="{{ media::initial($data->icon)->alt }}"></a>
          @endforeach
        </div>
      </div>
    </div>
  </footer>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/misc.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
