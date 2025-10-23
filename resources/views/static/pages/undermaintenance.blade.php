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
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/misc.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
