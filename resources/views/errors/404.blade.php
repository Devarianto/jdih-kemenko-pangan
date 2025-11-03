@php
use Cactuar\Admin\Models\Menu;

	try {
		$webConfig = conf('site-setting');
    $mainMenu = Cactuar\Admin\Models\Menu::position('main');
    $footTopMenu = Cactuar\Admin\Models\Menu::position('foot-top');
    $footBottomMenu = Cactuar\Admin\Models\Menu::position('foot-bottom');
    if (!$webConfig || $webConfig->status == 'offline') {
        echo view('dynamic.errors.offline');
        die();
    }

	} catch(\Exception $e) {}
@endphp

@extends('dynamic.layouts.layout')

@section('content')
  <section class="misc">
    <div class="wrapper-content">
      <div class="misc__left">
        <figure><img src="{{ media::url(conf('404-page')->image) }}" alt="{{ media::initial(conf('404-page')->image)->alt }}"></figure>
      </div>
      <div class="misc__right">
        <h2>{{ conf('404-page')->translated('title') }}</h2>
        <p>{{ conf('404-page')->translated('intro') }}</p>
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
