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
		{!! og::render() !!}

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        @vite(['resources/assets/js/app.js'])
        <link rel="preload" href="{{ Vite::asset('resources/assets/sass/app.scss') }}" as="style">
        <link rel="stylesheet" href="{{ Vite::asset('resources/assets/sass/app.scss') }}">
        @stack('head')
    </head>
    <body>
        {!! og::body() !!}
        <!-- header -->
        <header>
            @include('dynamic.component.menu')
        </header>
        <!-- end of header -->

        @yield('content')

        <!--Footer -->
        <script src="https://www.google.com/recaptcha/api.js?hl={{App::getLocale()}}"></script>
        @include('dynamic.component.footer')
        <!--end of Footer -->
        <script>
            window.recaptchaWidgets = new Map();

            function renderRecaptcha(selector) {
                document.querySelectorAll(selector).forEach(container => {

                    // JANGAN render ulang jika sudah ada
                    if (window.recaptchaWidgets.has(container)) return;

                    const widgetId = grecaptcha.render(container, {
                        sitekey: "{{ config('cadmin.cadmin.recaptcha.key') }}"
                    });

                    window.recaptchaWidgets.set(container, widgetId);
                });
            }

            function resetRecaptcha(selector) 
            {
                document.querySelectorAll(selector).forEach(container => {
                    if (!window.recaptchaWidgets.has(container)) return;

                    grecaptcha.reset(window.recaptchaWidgets.get(container));
                });
            }
        </script>
        @stack('footer')
        {!! og::foot() !!}
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                setTimeout(() => {
                    renderRecaptcha('.recaptcha-container');                    
                }, 1000);
                
                document.getElementById('button-open-login').addEventListener('click', function (e) {
                    resetRecaptcha('.recaptcha-container');
                    openPopup('#popup-login')
                })

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

                const form = document.getElementById('frm-search-global');

                form.addEventListener('keypress', function(event) {
                    // Cek apakah tombol yang ditekan adalah Enter (key code 13)
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Hindari submit default (jika ada input lain)
                        form.submit(); // Submit form secara otomatis
                    }
                });
            })
        </script>

        {{-- Widget Aksesibilitas Web (UserWay & EqualWeb Standard) --}}
        @include('dynamic.component.accessibility-widget')
    </body>
</html>