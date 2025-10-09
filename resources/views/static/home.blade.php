@extends('static.layouts.layout')

@section('content')
  <!-- middle -->
  {{-- Your code --}}

  <!-- end of middle -->
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/home.scss')}}" preload>
  @endpush
  @push('footer')
    <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/home.js') }}"></script>
  @endpush
@endsection
