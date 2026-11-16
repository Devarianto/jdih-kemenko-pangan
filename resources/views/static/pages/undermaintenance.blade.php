@extends('static.layouts.layout-2')

@section('content')
  <section class="misc under">
    <div class="wrapper-content">
      <div class="misc__left">
        <figure><img src="{{ asset('images/content/misc-under.png') }}" alt=""></figure>
      </div>
      <div class="misc__right">
        <h2>UNDER MAINTENANCE</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
        <div class="medsos">
          <label for="">SOCIAL MEDIA</label>
          <div class="wrap">
            <a href=""><img src="{{ asset('images/material/ic-link.svg') }}" alt=""></a>
            <a href=""><img src="{{ asset('images/material/ic-wa.svg') }}" alt=""></a>
            <a href=""><img src="{{ asset('images/material/ic-x.svg') }}" alt=""></a>
            <a href=""><img src="{{ asset('images/material/ic-fb.svg') }}" alt=""></a>
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
    <div class="top">
      <div class="box">
        <div class="logo logo-multi">
          <img src="{{ asset('images/material/logo.svg') }}" alt="">
          @include('dynamic.component.logo-links', ['homeUrl' => route('front.index')])
        </div>
        <p>Jaringan Dokumentasi dan Informasi Hukum - Kementerian Kordinator Republik Indonesia</p>
        <address>Graha Mandiri, Jalan Imam Bonjol No. 61, Thamrin, Jakarta Pusat</address>
      </div>
      <div class="box">
        <a href="" class="button button-icon button-outline ">
          <i class="wa-icon wa-ic-phone-solid"></i>
          (021) 319 36802
        </a>
      </div>
    </div>
    <div class="bot">
      <p>©{{ date('Y') }} Biro Hukum Kementerian Koordinator Bidang Pangan. All rights reserved.</p>
      <div class="bot__right">
        <a href=""><img src="{{asset('images/material/ic-ig.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-x.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-yt.svg')  }}" alt=""></a>
        <a href=""><img src="{{asset('images/material/ic-fb.svg')  }}" alt=""></a>
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
