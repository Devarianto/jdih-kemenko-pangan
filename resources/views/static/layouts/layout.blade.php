<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <script>
            (function() {
                try {
                    var saved = localStorage.getItem('jdih_theme');
                    var sysDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    var theme = saved ? saved : (sysDark ? 'dark' : 'light');
                    document.documentElement.setAttribute('data-theme', theme);
                } catch(e) {}
            })();
        </script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <title>JDIH</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <meta name="description" content="">

        @vite(['resources/assets/js/app.js'])
        <link rel="preload" href="{{ Vite::asset('resources/assets/sass/app.scss') }}" as="style">
        <link rel="stylesheet" href="{{ Vite::asset('resources/assets/sass/app.scss') }}">
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
