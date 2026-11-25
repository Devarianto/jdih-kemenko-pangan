<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <script>
            (function() {
                try {
                    if (localStorage.getItem('jdih_theme_default_light_v1') !== '1') {
                        localStorage.setItem('jdih_theme', 'light');
                        localStorage.setItem('jdih_theme_default_light_v1', '1');
                    }
                    var saved = localStorage.getItem('jdih_theme');
                    var theme = (saved === 'dark' || saved === 'light') ? saved : 'light';
                    document.documentElement.setAttribute('data-theme', theme);
                } catch(e) {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
                // Sinkronkan halaman aktif dengan jdih.kemenkopangan.go.id saat dibuka di dalam iframe wrapper
                try {
                    var curFull = window.location.pathname + window.location.search + window.location.hash;
                    if (window.self !== window.top) {
                        var lastSubPath = sessionStorage.getItem('jdih_iframe_last_path');
                        var explicitHome = sessionStorage.getItem('jdih_iframe_explicit_home') === '1';
                        sessionStorage.removeItem('jdih_iframe_explicit_home');
                        if (curFull === '/' && lastSubPath && lastSubPath !== '/' && !explicitHome) {
                            window.location.replace(lastSubPath);
                            return;
                        }
                        sessionStorage.setItem('jdih_iframe_last_path', curFull);
                        window.parent.postMessage({ type: 'JDIH_ROUTE_CHANGE', path: curFull, title: document.title }, '*');
                        document.addEventListener('click', function(ev) {
                            var a = ev.target && ev.target.closest ? ev.target.closest('a[href]') : null;
                            if (!a) return;
                            try {
                                var u = new URL(a.href, window.location.origin);
                                if (u.origin === window.location.origin && (u.pathname === '/' || u.pathname === '/en')) {
                                    sessionStorage.setItem('jdih_iframe_explicit_home', '1');
                                }
                            } catch(err) {}
                        }, true);
                    }
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
                
                const btnOpenLogin = document.getElementById('button-open-login');
                if (btnOpenLogin) {
                    btnOpenLogin.addEventListener('click', function () {
                        resetRecaptcha('.recaptcha-container');
                        openPopup('#popup-login');
                    });
                }

                function updateVisitorCount() {
                fetch('{{ route('api.visitor') }}')
                    .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data');
                        return response.json();
                    })
                    .then(data => {
                        const formatCount = (n) => Number(n || 0).toLocaleString('id-ID');
                        const elToday = document.getElementById('visitor-today');
                        const elYesterday = document.getElementById('visitor-yesterday');
                        const elMonth = document.getElementById('visitor-month');
                        const elTotal = document.getElementById('visitor-total');
                        if (elToday) elToday.textContent = formatCount(data.today);
                        if (elYesterday) elYesterday.textContent = formatCount(data.yesterday);
                        if (elMonth) elMonth.textContent = formatCount(data.month);
                        if (elTotal) elTotal.textContent = formatCount(data.total);
                    })
                    .catch(() => {
                        console.log('Gagal mengambil data visitor');
                    });
                }

                // Jalankan langsung
                updateVisitorCount();

                const form = document.getElementById('frm-search-global');
                if (form) {
                    form.addEventListener('keypress', function(event) {
                        // Cek apakah tombol yang ditekan adalah Enter (key code 13)
                        if (event.key === 'Enter') {
                            event.preventDefault(); // Hindari submit default (jika ada input lain)
                            form.submit(); // Submit form secara otomatis
                        }
                    });
                }
            })
        </script>

        {{-- Widget Aksesibilitas Web (UserWay & EqualWeb Standard) --}}
        @include('dynamic.component.accessibility-widget')
    </body>
</html>