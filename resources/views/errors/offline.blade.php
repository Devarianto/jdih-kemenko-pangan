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
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/misc.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
