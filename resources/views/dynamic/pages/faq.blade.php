@extends('dynamic.layouts.layout')

@section('content')
@include('dynamic.component.banner')

<section class="middle">
  <div class="wrapper">
    <div class="accordion" data-type="multiple">
      @foreach (widget($menu->id, 'menu', 'faq') as $data)
      <div class="accordion__list">
        <div class="accordion__list--button">
          <h5>{{ $data->translated('title') }}</h5>
        </div>
        <div class="accordion__list--content">
          <div class="content-pages">
            {!! $data->translated('description') !!}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@push('head')
<link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss')}}" preload>
@endpush
@push('footer')
<script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script>
@endpush
@endsection