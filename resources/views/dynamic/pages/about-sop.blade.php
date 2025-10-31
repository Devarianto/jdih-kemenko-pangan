@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'content') as $content)
      <div class="middle__title">
        <h4>{{ $content->translated('title') }}</h4>
        {!! nl2br(strip_tags($content->translated('description'), '<br>')) !!}
      </div>
      @endforeach
      @foreach(widget($menu->id, 'menu', 'image') as $image)
      <div class="box-shadow">
        <p>{{ $image->translated('title') }}</p>
        <figure>{!! media::initial($image->translated('image'))->html !!}</figure>
      </div>
      @endforeach
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/about.scss')}}" preload>
  @endpush
  @push('footer')
    {{-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/.js') }}"></script> --}}
  @endpush
@endsection
