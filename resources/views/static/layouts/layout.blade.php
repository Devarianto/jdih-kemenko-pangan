<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <title>Laravel 11 | WEBARQ</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <meta name="description" content="">

        @vite(['resources/assets/sass/app.scss', 'resources/assets/js/app.js'])
        @stack('head')
    </head>
    <body>
        <!-- header -->
        <header>
            @include('static.component.menu')
        </header>
        <!-- end of header -->

        @yield('content')

        <!--Footer -->
        @include('static.component.footer')
        <!--end of Footer -->
        @stack('footer')
    </body>
</html>
