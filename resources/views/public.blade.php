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
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/document.scss') }}" preload>
    @stack('head')

    <style>
        /* Scoped Public Partisipasi Publik Styles inside JDIH Layout */
        .pub-hero-banner {
            background: linear-gradient(135deg, #002060 0%, #1a56c4 100%);
            min-height: 290px;
            display: flex;
            align-items: center;
            position: relative;
            padding: 110px 0 65px;
            overflow: hidden;
        }

        .pub-hero-banner::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 320px;
            height: 320px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .pub-hero-inner {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;
        }

        .pub-hero-text {
            max-width: 740px;
        }

        .pub-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 11.5px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 14px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .pub-hero-banner h2 {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 10px;
            line-height: 1.3;
        }

        .pub-hero-banner p {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.86);
            margin: 0;
            line-height: 1.65;
        }

        .pub-content {
            padding: 20px 0 48px;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1a1a2e;
        }

        .pub-section-title {
            font-size: 17px;
            font-weight: 700;
            color: #002060;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pub-search-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 14px;
        }

        .pub-search {
            padding: 10px 16px;
            border: 1.5px solid #d8e0ee;
            border-radius: 8px;
            font-size: 13.5px;
            width: 280px;
            outline: none;
            background: white;
            transition: 0.2s;
            color: #1a1a2e;
        }

        .pub-search:focus {
            border-color: #1a56c4;
            box-shadow: 0 0 0 3px rgba(26, 86, 196, 0.1);
        }

        .pub-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 22px;
        }

        .pub-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 32, 96, 0.06);
            border: 1px solid #e4eaf6;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .pub-card:hover {
            box-shadow: 0 8px 26px rgba(0, 32, 96, 0.11);
            transform: translateY(-2px);
            border-color: #c5d3ee;
        }

        .pub-card-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pub-badges-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pub-card-title {
            font-size: 15.5px;
            font-weight: 700;
            color: #0d1b3e;
            line-height: 1.5;
            flex: 1;
        }

        .badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .badge-publik { background: #eaf0ff; color: #003580; }
        .badge-draft { background: #f0f0f0; color: #666; }
        .badge-proses { background: #e3f2fd; color: #1565c0; }
        .badge-penetapan { background: #e8f5e9; color: #2e7d32; }

        .pub-card-urgent {
            border-left: 3px solid #c0392b !important;
        }

        .pub-tag-jenis {
            display: inline-block;
            max-width: 100%;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #003580;
            background: #eaf0ff;
            border-radius: 6px;
            padding: 4px 9px;
            line-height: 1.4;
        }

        .pub-tag-sisa {
            font-size: 11px;
            font-weight: 600;
            color: #2e7d32;
            background: #f1f8f3;
            border: 1px solid #c8e6c9;
            border-radius: 20px;
            padding: 2px 9px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .pub-tag-sisa.urgent {
            color: #c0392b;
            background: #fdf3f2;
            border-color: #f1a9a4;
        }

        .pub-card-periode {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #64748b;
        }

        .pub-periode-sep {
            color: #c0cce0;
        }

        .text-urgent {
            color: #c0392b;
            font-weight: 600;
        }

        .pub-masukan-count {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 600;
            color: #5a6480;
            background: #f4f6fb;
            border: 1px solid #e0e7f4;
            border-radius: 20px;
            padding: 2px 9px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .pub-card-btn {
            display: block;
            text-align: center;
            padding: 11px 16px;
            border-radius: 8px;
            background: #003580;
            color: #fff !important;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: background .15s;
            margin-top: auto;
        }

        .pub-card-btn:hover {
            background: #002060;
            color: #fff !important;
        }

        .pub-alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pub-alert-success {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #a5d6a7;
        }

        .pub-alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .pub-empty {
            text-align: center;
            padding: 56px 24px;
            color: #64748b;
            background: white;
            border-radius: 12px;
            border: 1px solid #e4eaf6;
        }

        .pub-empty-icon {
            font-size: 38px;
            margin-bottom: 10px;
            display: block;
        }

        @media (max-width: 768px) {
            .pub-hero-banner {
                padding: 95px 0 50px;
                min-height: 240px;
            }
            .pub-hero-banner h2 {
                font-size: 22px;
            }
            .pub-grid {
                grid-template-columns: 1fr;
            }
            .pub-search {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    {!! og::body() !!}

    <!-- JDIH Official Header & Mega Menu -->
    <header>
        @include('dynamic.component.menu')
    </header>

    <!-- Hero Banner Partisipasi Publik -->
    <section class="banner-middle pub-hero-banner">
        <div class="wrapper pub-hero-inner">
            <div class="pub-hero-text">
                <div class="pub-hero-label">⚖️ Pembentukan PUU &middot; e-Regulasi Terintegrasi</div>
                <h2>@yield('hero-title', 'Partisipasi Publik Rancangan Peraturan')</h2>
                <p>@yield('hero-desc', 'Sampaikan masukan, tanggapan, dan aspirasi Anda terhadap rancangan peraturan perundang-undangan Kementerian Koordinator Bidang Pangan.')</p>
            </div>
        </div>
        <div class="wave">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="80" viewBox="0 180 2500 200" fill="#F8F8F8" preserveAspectRatio="none">
                <path class="st1" d="M 0 250 C 1200 320 1200 100 3000 250 L 3000 550 L 0 550 L 0 250"></path>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <section class="middle">
        <div class="wrapper pub-content">
            @if(session('success'))
                <div class="pub-alert pub-alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="pub-alert pub-alert-danger">⚠️ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </section>

    <!-- JDIH Official Footer -->
    <script src="https://www.google.com/recaptcha/api.js?hl={{ App::getLocale() }}"></script>
    @include('dynamic.component.footer')

    @stack('footer')
    {!! og::foot() !!}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateVisitorCount() {
                fetch('{{ route('api.visitor') }}')
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengambil data');
                        return response.json();
                    })
                    .then(data => {
                        var elToday = document.getElementById('visitor-today');
                        var elYesterday = document.getElementById('visitor-yesterday');
                        var elMonth = document.getElementById('visitor-month');
                        var elTotal = document.getElementById('visitor-total');
                        var formatCount = function(n) { return Number(n || 0).toLocaleString('id-ID'); };
                        if (elToday) elToday.textContent = formatCount(data.today);
                        if (elYesterday) elYesterday.textContent = formatCount(data.yesterday);
                        if (elMonth) elMonth.textContent = formatCount(data.month);
                        if (elTotal) elTotal.textContent = formatCount(data.total);
                    })
                    .catch(() => {});
            }
            updateVisitorCount();
        });
    </script>

    {{-- Widget Aksesibilitas Web --}}
    @include('dynamic.component.accessibility-widget')
</body>
</html>
