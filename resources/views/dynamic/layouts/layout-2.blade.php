<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        {!! og::render() !!}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        @vite(['resources/assets/sass/app.scss', 'resources/assets/js/app.js'])
        @stack('head')
    </head>
    <body>
        <!-- header -->
        <header class="undermaintenance">
          <a href="{{ lang::url('/') }}" class="logo">
            <img src="{{asset('images/material/logo.svg')}}" alt="">
          </a>
        </header>
        <!-- end of header -->

        @yield('content')

        <!--Footer -->
        @include('dynamic.component.footer')
        <!--end of Footer -->
        @stack('footer')
    </body>
</html>
