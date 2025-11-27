@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')

  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'content') as $content)
      <section class="section-text">
        <div class="section-text__left">
          <span class="tag">{{ $content->translated('subtitle') }}</span>
          <h4>{{ $content->translated('title') }}</h4>
        </div>
        <div class="section-text__right">
          <p>{{ $content->translated('description') }}</p>
        </div>
      </section>
      @endforeach
      <section class="list-pdf">
      @foreach(widget($menu->id, 'menu', 'file') as $file)
        <div class="list-pdf__item">
          <span>{{ lang::translate('about.file-iteration', ['count' => $loop->iteration]) }}</span>
          <div class="inner">
            <figure>
              <img src="{{asset('images/material/pdf-icon.svg')}}" alt="pdf icon">
            </figure>
            <h6>{{ $file->translated('title') }}</h6>
            <a href="{{ media::url($file->translated('file')) }}" class="button button-outline button-icon" download>
              {{ lang::translate('global.download-pdf') }}
              <i class="wa-icon wa-ic-download-outline"></i>
            </a>
          </div>
        </div>
        @endforeach
      </section>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
