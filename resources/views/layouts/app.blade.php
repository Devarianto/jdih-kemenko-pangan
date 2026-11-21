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

        /* Unified Single-Row Top Navigation Bar (Attached to Top & Floating on Scroll) */
        .ereg-unified-topbar {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 22px;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0, 32, 96, 0.05);
            transition: box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .ereg-unified-topbar.is-floating {
            position: fixed;
            top: 0;
            border-bottom-color: #cbd5e1;
            box-shadow: 0 8px 24px rgba(15, 43, 72, 0.12);
        }

        .ereg-topbar-placeholder {
            display: none;
        }

        .ereg-topbar-placeholder.is-active {
            display: block;
        }

        .ereg-topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .ereg-topbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none !important;
            color: #002060 !important;
            font-weight: 700;
            font-size: 14px;
            white-space: nowrap;
        }

        .ereg-topbar-brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, #002060, #1d4ed8);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 32, 96, 0.2);
        }

        .ereg-topbar-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.18;
        }

        .ereg-topbar-brand-sub {
            font-size: 10.5px;
            font-weight: 500;
            color: #64748b;
        }

        .ereg-topbar-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
            gap: 5px;
            flex: 1 1 auto;
            min-width: 0;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 4px 2px;
        }

        .ereg-topbar-nav::-webkit-scrollbar {
            display: none;
        }

        .ereg-subnav-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            text-decoration: none !important;
            transition: all 0.16s ease;
            border: 1px solid transparent;
            white-space: nowrap;
            flex-shrink: 0;
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

        .ereg-topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            flex-shrink: 0;
        }

        .ereg-public-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #0f766e;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            text-decoration: none !important;
            transition: all 0.16s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .ereg-public-link:hover {
            background: #ccfbf1;
            color: #115e59;
        }

        .ereg-profile-dropdown {
            position: relative;
            flex-shrink: 0;
        }

        .ereg-profile-trigger {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 11px 5px 7px;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b !important;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.16s ease;
            white-space: nowrap;
            cursor: pointer;
        }

        .ereg-profile-trigger:hover,
        .ereg-profile-trigger[aria-expanded="true"] {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #002060 !important;
        }

        .ereg-profile-trigger::after {
            display: none !important;
        }

        .ereg-profile-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, #002060, #2563eb);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .ereg-profile-name {
            max-width: 190px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ereg-profile-caret {
            font-size: 10px;
            color: #64748b;
            transition: transform 0.18s ease;
        }

        .ereg-profile-trigger[aria-expanded="true"] .ereg-profile-caret {
            transform: rotate(180deg);
        }

        @media (max-width: 1200px) and (min-width: 769px) {
            .ereg-unified-topbar {
                padding: 0 14px;
                gap: 8px;
            }
            .ereg-topbar-brand-sub {
                display: none;
            }
            .ereg-subnav-item {
                padding: 6px 10px;
                font-size: 12px;
                gap: 5px;
            }
            .ereg-public-link span {
                display: none;
            }
            .ereg-profile-name {
                max-width: 140px;
            }
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

        .ereg-admin-container select.form-control,
        .ereg-admin-container .filter-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 15px 15px;
            padding-right: 38px !important;
            cursor: pointer;
        }

        .ereg-admin-container select.form-control.filter-select {
            width: auto;
            min-width: 210px;
        }

        @media (max-width: 640px) {
            .ereg-admin-container select.form-control.filter-select {
                width: 100%;
                min-width: 0;
            }
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

        /* Mobile Top Bar & Left Slide-Out Navigation Drawer */
        .ereg-mobile-topbar,
        .ereg-drawer-backdrop,
        .ereg-drawer {
            display: none;
        }

        @media (max-width: 768px) {
            .main .content {
                padding: 14px 12px 28px !important;
            }

            .ereg-unified-topbar {
                padding: 0 12px;
                min-height: 56px;
            }

            /* Sembunyikan menu link tengah & tombol publik desktop saat mobile, digantikan slide-left drawer */
            .ereg-topbar-nav,
            .ereg-topbar-right .ereg-public-link {
                display: none !important;
            }

            .ereg-profile-name {
                max-width: 120px;
                font-size: 12px;
            }

            /* Bar Pemicu Menu di Atas Halaman saat Mobile */
            .ereg-mobile-topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                background: #ffffff;
                border: 1px solid #e4eaf6;
                border-radius: 12px;
                padding: 10px 14px;
                margin-bottom: 14px;
                box-shadow: 0 2px 6px rgba(0, 32, 96, 0.05);
            }

            .ereg-mobile-menu-btn {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                background: #002060;
                color: #ffffff;
                border: none;
                border-radius: 9px;
                padding: 8px 14px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                box-shadow: 0 2px 6px rgba(0, 32, 96, 0.18);
                transition: background 0.15s ease, transform 0.15s ease;
            }

            .ereg-mobile-menu-btn:active {
                transform: scale(0.97);
            }

            .ereg-mobile-current-page {
                font-size: 12px;
                font-weight: 600;
                color: #475569;
                background: #f1f5f9;
                padding: 6px 11px;
                border-radius: 20px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 55%;
            }

            /* Backdrop Overlay Slide-Left Drawer */
            .ereg-drawer-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1055;
                background: rgba(15, 23, 42, 0.52);
                backdrop-filter: blur(2px);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.28s ease, visibility 0.28s ease;
            }

            .ereg-drawer-backdrop.is-open {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            /* Panel Slide-Left Drawer */
            .ereg-drawer {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 290px;
                max-width: 85vw;
                z-index: 1060;
                background: #ffffff;
                box-shadow: 10px 0 32px rgba(15, 43, 72, 0.22);
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .ereg-drawer.is-open {
                transform: translateX(0);
            }

            .ereg-drawer-header {
                padding: 20px 18px 18px;
                background: linear-gradient(135deg, #0f2b48 0%, #1d4ed8 100%);
                color: #ffffff;
                position: relative;
            }

            .ereg-drawer-header-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-bottom: 12px;
            }

            .ereg-drawer-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                font-size: 15px;
                color: #ffffff;
            }

            .ereg-drawer-brand-icon {
                width: 34px;
                height: 34px;
                border-radius: 9px;
                background: rgba(255, 255, 255, 0.18);
                border: 1px solid rgba(255, 255, 255, 0.35);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 15px;
            }

            .ereg-drawer-close {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                border: 1px solid rgba(255, 255, 255, 0.3);
                background: rgba(255, 255, 255, 0.14);
                color: #ffffff;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                cursor: pointer;
            }

            .ereg-drawer-user {
                font-size: 11.5px;
                color: rgba(255, 255, 255, 0.9);
                background: rgba(255, 255, 255, 0.12);
                padding: 7px 11px;
                border-radius: 8px;
                line-height: 1.4;
            }

            .ereg-drawer-body {
                flex: 1;
                padding: 14px 12px;
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .ereg-drawer-section-label {
                font-size: 10.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #94a3b8;
                padding: 6px 10px 2px;
            }

            .ereg-drawer-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 11px 14px;
                border-radius: 10px;
                font-size: 13.5px;
                font-weight: 600;
                color: #334155;
                text-decoration: none !important;
                transition: background 0.15s ease, color 0.15s ease;
            }

            .ereg-drawer-link i {
                width: 20px;
                text-align: center;
                font-size: 15px;
                color: #64748b;
            }

            .ereg-drawer-link:hover {
                background: #f1f5f9;
                color: #002060;
            }

            .ereg-drawer-link.active {
                background: #002060;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(0, 32, 96, 0.18);
            }

            .ereg-drawer-link.active i {
                color: #ffffff;
            }

            .ereg-drawer-link.drawer-cta {
                background: #eff6ff;
                color: #1d4ed8;
                border: 1px solid #bfdbfe;
            }

            .ereg-drawer-link.drawer-cta i {
                color: #1d4ed8;
            }

            .ereg-drawer-link.drawer-cta.active {
                background: #002060;
                color: #ffffff !important;
                border-color: #002060;
            }

            .ereg-drawer-link.drawer-cta.active i {
                color: #ffffff;
            }

            .ereg-drawer-footer {
                padding: 12px;
                border-top: 1px solid #eef2f6;
                background: #f8fafc;
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .ereg-admin-container .page-header {
                margin-bottom: 14px;
                padding-bottom: 10px;
            }

            .ereg-admin-container .page-title {
                font-size: 18px;
            }

            .ereg-admin-container .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .ereg-admin-container .card,
            .ereg-admin-container .form-card {
                padding: 16px;
                border-radius: 12px;
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
        @if(!request()->get('opener') && auth()->check())
            @php
                $authUser = auth()->user();
                $cleanDisplayName = $authUser->display_name;
                if (!$cleanDisplayName || stripos($cleanDisplayName, 'ibnu') !== false) {
                    $cleanDisplayName = ($authUser->name && stripos($authUser->name, 'ibnu') === false)
                        ? $authUser->name
                        : ($authUser->role === 'super_admin' ? 'Super Admin' : 'Operator e-Regulasi');
                }
                $rawTopName = trim(preg_replace('/\s*\(.*?\)\s*/', '', $cleanDisplayName ?: ($authUser->username ?? 'User')));
                if ($rawTopName === '') {
                    $rawTopName = $cleanDisplayName ?: 'User';
                }
                $topAvatarInitial = mb_strtoupper(mb_substr($rawTopName, 0, 1));
            @endphp

            {{-- Unified Single-Row Top Bar (Attached to Top & Floating on Scroll) --}}
            <div class="ereg-topbar-placeholder" id="eregTopbarPlaceholder"></div>
            <header class="ereg-unified-topbar" id="eregUnifiedTopbar">
                {{-- Left: Sidebar Toggle / Mobile Hamburger + Brand --}}
                <div class="ereg-topbar-left">
                    @if(in_array(auth()->user()->role, ['admin_operator', 'operator_eregulasi']))
                        <a class="sidebar-toggle js-ereg-drawer-toggle d-inline-flex d-md-none me-1" role="button" tabindex="0" aria-label="Buka Menu Navigasi e-Regulasi" style="cursor: pointer;">
                            <i class="hamburger align-self-center"></i>
                        </a>
                    @else
                        <a class="sidebar-toggle js-sidebar-toggle me-1" role="button" tabindex="0" aria-label="Toggle Sidebar">
                            <i class="hamburger align-self-center"></i>
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}" class="ereg-topbar-brand">
                        <span class="ereg-topbar-brand-icon">
                            <i class="fa fa-balance-scale"></i>
                        </span>
                        <span class="ereg-topbar-brand-text">
                            <span>e-Regulasi</span>
                            <span class="ereg-topbar-brand-sub">JDIH Kemenko Pangan</span>
                        </span>
                    </a>
                </div>

                {{-- Center: 1-Row Navigation Links (Desktop) --}}
                <nav class="ereg-topbar-nav" aria-label="Navigasi Utama e-Regulasi">
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
                            <span>Operator Unit</span>
                        </a>
                    @endif
                </nav>

                {{-- Right: Lihat Halaman Publik + Login Profile Dropdown (Aligned in Same Row) --}}
                <div class="ereg-topbar-right">
                    @if(auth()->user()->role === 'super_admin')
                        <a href="{{ url('/admin-panel') }}" class="ereg-public-link" style="background:#eef2ff; color:#3730a3; border-color:#c7d2fe;" title="Kembali ke Panel Pengelolaan JDIH">
                            <i class="fa fa-arrow-left"></i>
                            <span>Admin JDIH</span>
                        </a>
                    @endif
                    <a href="{{ route('partisipasi-publik') }}" target="_blank" class="ereg-public-link" title="Buka halaman Partisipasi Publik di Website Utama JDIH">
                        <i class="fa fa-external-link-alt"></i>
                        <span>Lihat Halaman Publik</span>
                    </a>

                    <div class="dropdown ereg-profile-dropdown">
                        <a class="ereg-profile-trigger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="ereg-profile-avatar">{{ $topAvatarInitial }}</span>
                            <span class="ereg-profile-name">{{ $cleanDisplayName }}</span>
                            <i class="fa fa-chevron-down ereg-profile-caret"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width: 220px; border-radius: 12px; border: 1px solid #e2e8f0; padding: 6px;">
                            <div class="px-3 py-2 border-bottom mb-1" style="background: #f8fafc; border-radius: 8px 8px 0 0;">
                                <div class="fw-bold text-dark" style="font-size: 13px;">{{ $rawTopName }}</div>
                                <div class="text-muted" style="font-size: 11.5px;">
                                    {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin / Operator e-Regulasi' }}
                                    @if(auth()->user()->unit_kerja)
                                        &middot; {{ auth()->user()->unit_kerja }}
                                    @endif
                                </div>
                            </div>
                            <a class="dropdown-item rounded-2 py-2" href="{{ url()->admin('profile') }}" style="font-size: 13px;">
                                <i class="align-middle me-2 fa fa-user text-secondary"></i> Profile
                            </a>
                            <a class="dropdown-item rounded-2 py-2" href="{{ route('partisipasi-publik') }}" target="_blank" style="font-size: 13px;">
                                <i class="align-middle me-2 fa fa-globe text-teal" style="color: #0f766e;"></i> Halaman Partisipasi Publik
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item rounded-2 py-2 text-danger" href="{{ url()->admin('logout') }}" style="font-size: 13px; font-weight: 600;">
                                <i class="align-middle me-2 fa fa-sign-out-alt"></i> Log out
                            </a>
                        </div>
                    </div>
                </div>
            </header>
        @endif

        <main class="content">
            <div class="container-fluid p-0 ereg-admin-container">
                {{-- Mobile Trigger & Slide-Left Offcanvas Drawer --}}
                @auth
                    @php
                        $activeMenuLabel = 'Dashboard PUU';
                        if (request()->routeIs('regulasi.create')) {
                            $activeMenuLabel = 'Ajukan Regulasi Baru';
                        } elseif (request()->routeIs('regulasi.*')) {
                            $activeMenuLabel = 'Daftar Pengajuan PUU';
                        } elseif (request()->routeIs('admin.partisipasi.*')) {
                            $activeMenuLabel = 'Kelola Partisipasi Publik';
                        } elseif (request()->routeIs('users.*')) {
                            $activeMenuLabel = 'Manajemen Operator Unit';
                        }
                    @endphp

                    {{-- Mobile Trigger Bar (membuka Slide-Left Drawer) --}}
                    <div class="ereg-mobile-topbar">
                        <button type="button" class="ereg-mobile-menu-btn js-ereg-drawer-toggle" aria-label="Buka Menu e-Regulasi">
                            <i class="fa fa-bars"></i>
                            <span>Menu e-Regulasi</span>
                        </button>
                        <span class="ereg-mobile-current-page">
                            {{ $activeMenuLabel }}
                        </span>
                    </div>

                    {{-- Mobile Slide-Left Offcanvas Drawer & Backdrop --}}
                    <div class="ereg-drawer-backdrop" id="eregDrawerBackdrop"></div>
                    <aside class="ereg-drawer" id="eregMobileDrawer" aria-label="Navigasi Slide e-Regulasi">
                        <div class="ereg-drawer-header">
                            <div class="ereg-drawer-header-top">
                                <div class="ereg-drawer-brand">
                                    <span class="ereg-drawer-brand-icon">
                                        <i class="fa fa-balance-scale"></i>
                                    </span>
                                    <div>
                                        <div style="line-height: 1.2;">e-Regulasi</div>
                                        <div style="font-size: 11px; font-weight: 400; opacity: 0.85;">JDIH Kemenko Pangan</div>
                                    </div>
                                </div>
                                <button type="button" class="ereg-drawer-close" id="eregDrawerClose" aria-label="Tutup Menu">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <div class="ereg-drawer-user">
                                <i class="fa fa-user-shield me-1"></i>
                                <strong>{{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Operator e-Regulasi' }}</strong>
                                @if(auth()->user()->unit_kerja)
                                    <div style="margin-top: 2px; opacity: 0.9;">{{ auth()->user()->unit_kerja }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="ereg-drawer-body">
                            <div class="ereg-drawer-section-label">Menu Utama</div>
                            <a href="{{ route('dashboard') }}"
                               class="ereg-drawer-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fa fa-chart-pie"></i>
                                <span>Dashboard PUU</span>
                            </a>
                            <a href="{{ route('regulasi.index') }}"
                               class="ereg-drawer-link {{ (request()->routeIs('regulasi.*') && !request()->routeIs('regulasi.create')) ? 'active' : '' }}">
                                <i class="fa fa-folder-open"></i>
                                <span>Daftar Pengajuan PUU</span>
                            </a>
                            <a href="{{ route('regulasi.create') }}"
                               class="ereg-drawer-link drawer-cta {{ request()->routeIs('regulasi.create') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle"></i>
                                <span>Ajukan Regulasi Baru</span>
                            </a>
                            <a href="{{ route('admin.partisipasi.index') }}"
                               class="ereg-drawer-link {{ request()->routeIs('admin.partisipasi.*') ? 'active' : '' }}">
                                <i class="fa fa-comments"></i>
                                <span>Kelola Partisipasi Publik</span>
                            </a>
                            @if(auth()->user()->role === 'super_admin')
                                <a href="{{ route('users.index') }}"
                                   class="ereg-drawer-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    <i class="fa fa-users-cog"></i>
                                    <span>Manajemen Operator Unit</span>
                                </a>
                            @endif
                        </div>

                        <div class="ereg-drawer-footer">
                            <div class="ereg-drawer-section-label">Pintasan & Akun</div>
                            @if(auth()->user()->role === 'super_admin')
                                <a href="{{ url('/admin-panel') }}" class="ereg-drawer-link" style="color: #3730a3;">
                                    <i class="fa fa-arrow-left" style="color: #3730a3;"></i>
                                    <span>Admin Panel JDIH</span>
                                </a>
                            @endif
                            <a href="{{ route('partisipasi-publik') }}" target="_blank" class="ereg-drawer-link" style="color: #0f766e;">
                                <i class="fa fa-external-link-alt" style="color: #0f766e;"></i>
                                <span>Lihat Halaman Publik</span>
                            </a>
                            <a href="{{ url()->admin('profile') }}" class="ereg-drawer-link">
                                <i class="fa fa-user"></i>
                                <span>Profil Pengguna</span>
                            </a>
                            <a href="{{ url()->admin('logout') }}" class="ereg-drawer-link" style="color: #dc2626;">
                                <i class="fa fa-sign-out-alt" style="color: #dc2626;"></i>
                                <span>Log Out</span>
                            </a>
                        </div>
                    </aside>
                @endauth

                @unless(request()->routeIs('dashboard'))
                    <div class="page-header">
                        <h1 class="page-title">@yield('page-title')</h1>
                    </div>
                @endunless

                {{-- Pesan "Selamat datang" ditampilkan di hero section dashboard, bukan sebagai alert --}}
                @if(session('success') && !request()->routeIs('regulasi.show') && !(request()->routeIs('dashboard') && str_starts_with(session('success'), 'Selamat datang')))
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
                <div class="row text-muted gy-2">
                    <div class="col-12 col-md-6 text-center text-md-start">
                        <p class="mb-0" style="font-size: 12.5px;">
                            <strong>JDIH Kementerian Koordinator Bidang Pangan &mdash; Modul e-Regulasi Terintegrasi</strong>
                        </p>
                    </div>
                    @if(!request()->get('opener'))
                    <div class="col-12 col-md-6 text-center text-md-end">
                        <ul class="list-inline mb-0" style="font-size: 12.5px;">
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
    (function () {
        var drawer = document.getElementById('eregMobileDrawer');
        var backdrop = document.getElementById('eregDrawerBackdrop');
        var closeBtn = document.getElementById('eregDrawerClose');
        var toggles = document.querySelectorAll('.js-ereg-drawer-toggle');

        if (!drawer || !backdrop) return;

        function openDrawer() {
            drawer.classList.add('is-open');
            backdrop.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            drawer.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        toggles.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (drawer.classList.contains('is-open')) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeDrawer);
        }

        backdrop.addEventListener('click', closeDrawer);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
                closeDrawer();
            }
        });

        // Dukungan gestur swipe kiri untuk menutup drawer di layar sentuh
        var touchStartX = 0;
        drawer.addEventListener('touchstart', function (e) {
            if (e.touches && e.touches.length === 1) {
                touchStartX = e.touches[0].clientX;
            }
        }, { passive: true });

        drawer.addEventListener('touchend', function (e) {
            if (e.changedTouches && e.changedTouches.length === 1) {
                var deltaX = e.changedTouches[0].clientX - touchStartX;
                if (deltaX < -50) {
                    closeDrawer();
                }
            }
        }, { passive: true });
    })();

    // Unified Top Bar Floating / Fixed at Top saat halaman di-scroll ke bawah
    (function () {
        var topbar = document.getElementById('eregUnifiedTopbar');
        var placeholder = document.getElementById('eregTopbarPlaceholder');
        var mainEl = document.querySelector('.main');
        if (!topbar || !placeholder || !mainEl) return;

        var isPinned = false;

        function syncTopbarState() {
            var scrollY = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollY > 4) {
                var mRect = mainEl.getBoundingClientRect();
                if (!isPinned) {
                    placeholder.style.height = topbar.offsetHeight + 'px';
                    placeholder.classList.add('is-active');
                    topbar.classList.add('is-floating');
                    isPinned = true;
                }
                topbar.style.width = mRect.width + 'px';
                topbar.style.left = mRect.left + 'px';
            } else if (isPinned) {
                isPinned = false;
                topbar.classList.remove('is-floating');
                topbar.style.width = '';
                topbar.style.left = '';
                placeholder.classList.remove('is-active');
                placeholder.style.height = '';
            }
        }

        window.addEventListener('load', syncTopbarState);
        window.addEventListener('scroll', syncTopbarState, { passive: true });
        window.addEventListener('resize', syncTopbarState);
    })();
</script>

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
