@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper-content">
      @foreach (widget($menu->id, 'menu', 'content') as $content)
      <div class="content-pages">
        <h4>{{ $content->translated('title') }}</h4>
        {!! $content->translated('description') !!}
      </div>
      @endforeach
      @foreach (widget($menu->id, 'menu', 'box-content') as $content)
      <div class="contact-highlight">
        <figure class="bg">
          <img 
          src="{{ media::initial($content->image)->url }}" 
          data-img-large="{{ media::initial($content->image)->url }}"
          data-img-medium="{{ media::initial($content->value('image-medium'))->url }}"
          data-img-small="{{ media::initial($content->value('image-small'))->url }}"
          alt="{{ media::initial($content->image)->alt }}">
        </figure>
        <div class="contact-highlight__left">
          <h5>{{ $content->translated('title') }}</h5>
          <p>{{ $content->translated('intro') }}</p>
          @if (Auth::guard('account')->check())
          <a href="{{ lang::url('dashboard') }}" class="button button-outline-secondary">
            {{ $content->translated('button') }}
          </a>
          @else
          <a href="javascript:void(0)" onclick="openPopup('#popup-login')" class="button button-outline-secondary">
            {{ $content->translated('button') }}
          </a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
