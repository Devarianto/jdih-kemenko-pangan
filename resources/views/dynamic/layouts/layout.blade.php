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
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        @vite(['resources/assets/sass/app.scss', 'resources/assets/js/app.js'])
        @stack('head')
    </head>
    <body>
        <!-- header -->
        <header>
            @include('dynamic.component.menu')
        </header>
        <!-- end of header -->

        @yield('content')

        <!--Footer -->
        @include('dynamic.component.footer')
        <!--end of Footer -->
        @stack('footer')
        <script>
            document.addEventListener("DOMContentLoaded", function(event) { 
                function updateVisitorCount() {
                fetch('{{ route('api.visitor') }}')
                    .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('visitor-today').textContent = data.today;
                        document.getElementById('visitor-yesterday').textContent = data.yesterday;
                        document.getElementById('visitor-month').textContent = data.month;
                        document.getElementById('visitor-total').textContent = data.total;
                    })
                    .catch(() => {
                        console.log('Gagal mengambil data visitor');
                    });
                }

                // Jalankan langsung
                updateVisitorCount();
            })
        </script>
    </body>
</html>