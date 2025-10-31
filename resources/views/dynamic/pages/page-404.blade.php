@extends('static.layouts.layout')

@section('content')
  <section class="misc">
    <div class="wrapper-content">
      <div class="misc__left">
        <figure><img src="{{ asset('images/content/misc-404.png') }}" alt=""></figure>
      </div>
      <div class="misc__right">
        <h2>404 PAGE NOT FOUND</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
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
