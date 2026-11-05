<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @hasSection('page-title')
            @yield('page-title') -
        @endif
        {{ isset($baseTitle) ? strip_tags($baseTitle) : 'JDIH Kemenko Pangan' }} - Admin Panel
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/css/light.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/custom/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/icheck-bootstrap/icheck-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/base/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/c.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/admin/adminC.css') }}">
    <link rel="stylesheet" href="{{ asset('nwcms/webarq-icons/style.css') }}">

    <script src="{{ asset('nwcms/base/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('nwcms/base/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <meta name="robots" content="noindex">

    @if (isset($website) && $website && $website->favicon)
        <link rel="icon" href="{{ media::url($website->favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @endif

    <style>
        /* Scoped e-Regulasi Module Styles inside JDIH Admin Panel */
        .ereg-admin-container {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1a1a2e;
        }

        .ereg-admin-container * {
            box-sizing: border-box;
        }

        /* Module Top Sub-Navigation Bar */
        .ereg-subnav-bar {
            background: #ffffff;
            border: 1px solid #e4eaf6;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0, 32, 96, 0.04);
        }

        .ereg-subnav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .ereg-subnav-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            text-decoration: none !important;
            transition: all 0.16s ease;
            border: 1px solid transparent;
        }

        .ereg-subnav-item:hover {
            background: #f1f5f9;
            color: #002060;
        }

        .ereg-subnav-item.active {
            background: #002060;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 32, 96, 0.18);
        }

        .ereg-subnav-item.btn-create-shortcut {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .ereg-subnav-item.btn-create-shortcut:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        .ereg-subnav-item.btn-create-shortcut.active {
            background: #002060;
            color: #ffffff !important;
            border-color: #002060;
        }

        .ereg-subnav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ereg-public-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: #0f766e;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            text-decoration: none !important;
            transition: all 0.16s ease;
        }

        .ereg-public-link:hover {
            background: #ccfbf1;
            color: #115e59;
        }

        .ereg-admin-container .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e4eaf6;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ereg-admin-container .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #0d1b3e;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .ereg-admin-container .page-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ereg-admin-container .user-badge {
            background: #eaf0ff;
            color: #002060;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #d0dfff;
        }

        /* STATS */
        .ereg-admin-container .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 18px;
        }

        .ereg-admin-container .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px 22px;
            border-left: 4px solid #ccc;
            box-shadow: 0 1px 3px rgba(0, 32, 96, 0.06);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .ereg-admin-container .stat-card:hover {
            box-shadow: 0 6px 18px rgba(0, 32, 96, 0.1);
            transform: translateY(-2px);
        }

        .ereg-admin-container .stat-card.navy { border-color: #003580; }
        .ereg-admin-container .stat-card.blue { border-color: #1976d2; }
        .ereg-admin-container .stat-card.teal { border-color: #0097a7; }
        .ereg-admin-container .stat-card.amber { border-color: #ffa000; }
        .ereg-admin-container .stat-card.red { border-color: #e53935; }
        .ereg-admin-container .stat-card.indigo { border-color: #5c6bc0; }

        .ereg-admin-container .stat-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #8a93a6;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .ereg-admin-container .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #0d1b3e;
            margin-top: 8px;
            letter-spacing: -0.01em;
        }

        /* CARD */
        .ereg-admin-container .card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 1px 3px rgba(0, 32, 96, 0.06);
            border: 1px solid #eef1f8;
            margin-bottom: 18px;
        }

        .ereg-admin-container .card-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #002060;
            margin-bottom: 16px;
        }

        /* TABLE */
        .ereg-admin-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .ereg-admin-container th {
            text-align: left;
            padding: 11px 12px;
            font-size: 11.5px;
            color: #8a93a6;
            border-bottom: 2px solid #eef1f8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .ereg-admin-container td {
            padding: 14px 12px;
            font-size: 13.5px;
            color: #2d3a55;
            border-bottom: 1px solid #f3f5fa;
            vertical-align: middle;
        }

        .ereg-admin-container tr:last-child td {
            border-bottom: none;
        }

        .ereg-admin-container tbody tr {
            transition: background 0.15s ease;
        }

        .ereg-admin-container tbody tr:hover {
            background: #f8faff;
        }

        /* BADGES */
        .ereg-admin-container .badge {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .ereg-admin-container .badge-draft { background: #f0f0f0; color: #666; }
        .ereg-admin-container .badge-proses { background: #e3f2fd; color: #1565c0; }
        .ereg-admin-container .badge-publik { background: #f3e5f5; color: #7b1fa2; }
        .ereg-admin-container .badge-penetapan { background: #e8f5e9; color: #2e7d32; }

        /* BUTTONS */
        .ereg-admin-container .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .ereg-admin-container .btn-primary {
            background: #002060;
            color: white !important;
        }

        .ereg-admin-container .btn-primary:hover {
            background: #003580;
            color: white !important;
            transform: translateY(-1px);
        }

        .ereg-admin-container .btn-detail {
            background: #002060;
            color: white !important;
            padding: 7px 15px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.18s ease;
        }

        .ereg-admin-container .btn-detail:hover {
            background: #003580;
            color: white !important;
        }

        .ereg-admin-container .btn-danger {
            background: #fdeded;
            color: #c62828;
            padding: 7px 15px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            border: 1px solid #f5c2c2;
            transition: all 0.18s ease;
        }

        .ereg-admin-container .btn-danger:hover {
            background: #e53935;
            color: white !important;
            border-color: #e53935;
        }

        .ereg-admin-container .btn-outline {
            background: white;
            color: #002060;
            border: 1.5px solid #002060;
        }

        .ereg-admin-container .btn-outline:hover {
            background: #f0f4ff;
            color: #002060;
        }

        /* FORM */
        .ereg-admin-container .form-card {
            background: white;
            border-radius: 12px;
            padding: 26px;
            margin-bottom: 18px;
            box-shadow: 0 1px 3px rgba(0, 32, 96, 0.06);
            border: 1px solid #eef1f8;
        }

        .ereg-admin-container .form-section-title {
            font-size: 14px;
            font-weight: 700;
            color: #002060;
            border-bottom: 2px solid #002060;
            padding-bottom: 9px;
            margin-bottom: 20px;
        }

        .ereg-admin-container .form-group {
            margin-bottom: 18px;
        }

        .ereg-admin-container .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3a55;
            margin-bottom: 7px;
        }

        .ereg-admin-container .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #d5dded;
            border-radius: 8px;
            font-size: 14px;
            color: #0d1b3e;
            outline: none;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .ereg-admin-container .form-control:focus {
            border-color: #002060;
            box-shadow: 0 0 0 3px rgba(0, 32, 96, 0.1);
        }

        .ereg-admin-container .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #f4f6fb;
            border: 1.5px solid #d5dded;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #5a6a85;
            transition: all 0.18s ease;
        }

        .ereg-admin-container .upload-btn:hover {
            border-color: #002060;
            color: #002060;
        }

        .ereg-admin-container .file-info {
            font-size: 12px;
            color: #002060;
            margin-top: 6px;
            font-weight: 600;
        }

        /* SEARCH */
        .ereg-admin-container .search-input {
            padding: 9px 14px;
            border: 1.5px solid #d5dded;
            border-radius: 8px;
            font-size: 13px;
            width: 240px;
            outline: none;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .ereg-admin-container .search-input:focus {
            border-color: #002060;
            box-shadow: 0 0 0 3px rgba(0, 32, 96, 0.1);
        }

        @media (max-width: 768px) {
            .ereg-admin-container .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            .ereg-admin-container .search-input {
                width: 100%;
            }
        }
    </style>
</head>
<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
<div class="wrapper">
    @if(!request()->get('opener') && auth()->check() && !in_array(auth()->user()->role, ['admin_operator', 'operator_eregulasi']))
        @include('cactuar::admin.layout-nav')
    @endif

    <div class="main">
        @if(!request()->get('opener'))
            @include('cactuar::admin.layout-top-menu')
        @endif

        <main class="content">
            <div class="container-fluid p-0 ereg-admin-container">
                {{-- Sub-Navigation Bar for e-Regulasi & Partisipasi Publik inside JDIH Admin Panel --}}
                @auth
                    <div class="ereg-subnav-bar">
                        <div class="ereg-subnav-links">
                            <a href="{{ route('dashboard') }}"
                               class="ereg-subnav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fa fa-chart-pie"></i>
                                <span>Dashboard PUU</span>
                            </a>
                            <a href="{{ route('regulasi.index') }}"
                               class="ereg-subnav-item {{ (request()->routeIs('regulasi.*') && !request()->routeIs('regulasi.create')) ? 'active' : '' }}">
                                <i class="fa fa-folder-open"></i>
                                <span>Daftar Pengajuan PUU</span>
                            </a>
                            <a href="{{ route('regulasi.create') }}"
                               class="ereg-subnav-item btn-create-shortcut {{ request()->routeIs('regulasi.create') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle"></i>
                                <span>Ajukan Regulasi Baru</span>
                            </a>
                            <a href="{{ route('admin.partisipasi.index') }}"
                               class="ereg-subnav-item {{ request()->routeIs('admin.partisipasi.*') ? 'active' : '' }}">
                                <i class="fa fa-comments"></i>
                                <span>Kelola Partisipasi Publik</span>
                            </a>
                            @if(auth()->user()->role === 'super_admin')
                                <a href="{{ route('users.index') }}"
                                   class="ereg-subnav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    <i class="fa fa-users-cog"></i>
                                    <span>Manajemen Operator Unit</span>
                                </a>
                            @endif
                        </div>

                        <div class="ereg-subnav-right">
                            @if(auth()->user()->role === 'super_admin')
                                <a href="{{ url('/admin-panel') }}" class="ereg-public-link" style="background:#eef2ff; color:#3730a3; border-color:#c7d2fe;" title="Kembali ke Panel Pengelolaan JDIH">
                                    <i class="fa fa-arrow-left"></i>
                                    <span>Kembali ke Admin Panel JDIH</span>
                                </a>
                            @endif
                            <a href="{{ route('partisipasi-publik') }}" target="_blank" class="ereg-public-link" title="Buka halaman Partisipasi Publik di Website Utama JDIH">
                                <i class="fa fa-external-link-alt"></i>
                                <span>Lihat Halaman Publik</span>
                            </a>
                            <span class="user-badge">
                                <i class="fa fa-user-shield" style="margin-right: 4px;"></i>
                                {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin / Operator' }}
                                @if(auth()->user()->unit_kerja)
                                    &middot; {{ auth()->user()->unit_kerja }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endauth

                <div class="page-header">
                    <h1 class="page-title">@yield('page-title')</h1>
                </div>

                @if(session('success') && !request()->routeIs('regulasi.show'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px; margin-bottom: 18px;">
                        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error') && !request()->routeIs('regulasi.show'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px; margin-bottom: 18px;">
                        <i class="fa fa-exclamation-circle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <strong>JDIH Kementerian Koordinator Bidang Pangan &mdash; Modul e-Regulasi Terintegrasi</strong>
                        </p>
                    </div>
                    @if(!request()->get('opener'))
                    <div class="col-6 text-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a class="text-muted" href="{{ url('/') }}" target="_blank" rel="noopener">Website Utama JDIH</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="{{ route('partisipasi-publik') }}" target="_blank" rel="noopener">Partisipasi Publik</a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    var $url = "{{ admin::url() }}";
    var $asset = "{{ asset('') }}";
    var $mediaPath = "{{ media::baseurl() }}";
    var $token = "{{ csrf_token() }}";
    var $locale = "{{ App::getLocale() }}";
    var $lang = "{{ Config::get('cadmin.lang.default') }}";
</script>

<script src="{{ asset('nwcms/base/js/app.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('nwcms/admin/autoNumeric-1.6.2.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('nwcms/base/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('nwcms/admin/jquery-validation-1.19.5/jquery.validate.min.js')}}"></script>
<script src="{{ asset('nwcms/admin/jquery-validation-1.19.5/additional-methods.min.js')}}"></script>
<script src="{{ asset('nwcms/admin/jquery-swapsies.js') }}"></script>
<script src="{{ asset('nwcms/admin/c.js')}}"></script>
<script src="{{ asset('nwcms/admin/adminC.js')}}"></script>
<script src="{{ asset('nwcms/webarq-icons/script.js')}}"></script>

@stack('assets')
</body>
</html>
