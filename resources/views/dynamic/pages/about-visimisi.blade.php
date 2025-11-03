@extends('dynamic.layouts.layout')

@section('content')
  @include('dynamic.component.banner')
  <section class="middle">
    <div class="wrapper-content">
      @foreach(widget($menu->id, 'menu', 'vision') as $vision)
      <div class="visi">
        <figure>
          <img src="{{ media::initial($vision->image)->url }}" 
            data-img-large="{{ media::initial($vision->image)->url }}" 
            data-img-medium="{{ media::initial($vision->value('image-medium'))->url }}" 
            data-img-small="{{ media::initial($vision->value('image-small'))->url }}" alt="{{ media::initial($vision->image)->alt }}">
          <figcaption>
            <p>{{ $vision->translated('subtitle') }}</p>
            <h6>{{ $vision->translated('title') }}</h6>
          </figcaption>
        </figure>
      </div>
      @endforeach
      @foreach(widget($menu->id, 'menu', 'mission') as $mission)
      <div class="misi content-pages">
        <h6>{{ $mission->translated('title') }}</h6>
        {!! $mission->translated('content') !!}
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
