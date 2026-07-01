<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'InternLink')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Public Sans:300,400,500,600,700"]},
            custom: {
                "families":["Font Awesome 5 Solid","Font Awesome 5 Regular","Font Awesome 5 Brands","simple-line-icons"],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"]
            },
            active: function() { sessionStorage.fonts = true; }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

<<<<<<< HEAD
    {{-- Global UI overrides — InternLink dark/purple bot theme --}}
    <style>
        :root {
            --il-bg-1: #2a1f6e;
            --il-bg-2: #1a1146;
            --il-bg-3: #0e0a2e;
            --il-purple: #7c5cff;
            --il-purple-dark: #6342d6;
            --il-purple-light: #c4b0ff;
            --il-pink: #ff8ad4;
            --il-blue: #7ac7ff;
            --il-orange: #ff9678;
            --il-text: #ffffff;
            --il-text-soft: rgba(220,210,255,0.65);
            --il-text-mute: rgba(220,210,255,0.5);
            --il-text-faint: rgba(220,210,255,0.4);
            --il-card-bg: rgba(124,92,255,0.08);
            --il-card-border: rgba(168,140,255,0.25);
        }

        html, body { background: #0e0a2e; }

        body {
            background: radial-gradient(circle at 20% 15%, var(--il-bg-1) 0%, var(--il-bg-2) 45%, var(--il-bg-3) 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* ── Brand & sidebar ── */
        .sidebar[data-background-color="dark"] { background: rgba(14,10,46,0.6); border-right: 1px solid rgba(168,140,255,0.15); backdrop-filter: blur(6px); }
        .sidebar .sidebar-wrapper { background: transparent; }
        .logo-header[data-background-color="dark"] { background: transparent !important; border-bottom: 1px solid rgba(168,140,255,0.15); }

        /* InternLink bot logo */
        .il-brand { display: flex; align-items: center; gap: 10px; padding-left: 4px; }
        .il-brand-text { color: #fff; font-size: 17px; font-weight: 500; letter-spacing: .3px; }
        .il-brand-text span { color: var(--il-pink); }

        /* Nav items */
        .sidebar .nav.nav-secondary .nav-item > a {
            border-radius: 10px;
            margin: 2px 10px;
            padding: 9px 14px;
            color: var(--il-text-soft) !important;
            transition: background .15s, color .15s;
        }
        .sidebar .nav.nav-secondary .nav-item > a i { color: var(--il-text-mute); }
        .sidebar .nav.nav-secondary .nav-item > a p { color: inherit; }
        .sidebar .nav.nav-secondary .nav-item > a:hover { background: rgba(168,140,255,0.1); color: #fff !important; }
        .sidebar .nav.nav-secondary .nav-item.active > a { background: rgba(124,92,255,0.22); color: var(--il-purple-light) !important; border: 1px solid rgba(168,140,255,0.25); }
        .sidebar .nav.nav-secondary .nav-item.active > a i { color: var(--il-purple-light) !important; }
        .sidebar .nav-section h4 { font-size: 10px; letter-spacing: .09em; color: rgba(220,210,255,0.3); margin: 16px 0 4px 22px; }

        /* Main panel */
        .main-panel { background: transparent; }

        /* Navbar */
        .navbar.navbar-header { background: transparent !important; border-bottom: none !important; box-shadow: none; }
        .main-header { background: transparent !important; }
        .main-header-logo { background: transparent !important; }
        .navbar .profile-username { font-size: 13px; color: #fff; }

        /* Card refinements — glassmorphic */
        .card {
            background: var(--il-card-bg) !important;
            border: 1.5px solid var(--il-card-border) !important;
            box-shadow: none !important;
            border-radius: 16px !important;
            backdrop-filter: blur(4px);
        }
        .card-round { border-radius: 16px !important; }
        .card-header { border-bottom: 1px solid rgba(168,140,255,0.15) !important; background: transparent !important; padding: 1rem 1.25rem !important; }
        .card-title { font-size: 14px !important; font-weight: 600 !important; color: #fff !important; }
        .card-body { color: var(--il-text-soft); }

        /* Buttons */
        .btn-round { border-radius: 50px !important; }
        .btn-primary { background: var(--il-purple) !important; border-color: var(--il-purple) !important; }
        .btn-primary:hover { background: var(--il-purple-dark) !important; border-color: var(--il-purple-dark) !important; }
        .btn-warning { background: var(--il-orange) !important; border-color: var(--il-orange) !important; color: #1a1146 !important; }
        .btn-success { background: #4ade80 !important; border-color: #4ade80 !important; color: #0e0a2e !important; }
        .btn-outline-secondary, .btn-secondary { background: rgba(255,255,255,0.06) !important; border-color: rgba(168,140,255,0.3) !important; color: var(--il-text-soft) !important; }

        /* Table */
        .table { color: var(--il-text-soft); --bs-table-bg: transparent; --bs-table-striped-bg: rgba(255,255,255,0.03); background-color: transparent !important; }
        .table > :not(caption) > * > * { background-color: transparent !important; color: var(--il-text-soft); }
        .table thead th { font-size: 11px !important; text-transform: uppercase; letter-spacing: .06em; color: rgba(220,210,255,0.5) !important; font-weight: 600 !important; border-bottom: 1px solid rgba(168,140,255,0.15) !important; background: rgba(255,255,255,0.02) !important; }
        .table td { border-color: rgba(168,140,255,0.1) !important; vertical-align: middle; font-size: 13px; color: var(--il-text-soft); background-color: transparent !important; }
        .table-head-bg-light thead th { background: rgba(255,255,255,0.03) !important; }
        .table tbody tr:hover td { background-color: rgba(124,92,255,.08) !important; }

        /* Badges */
        .badge { font-size: 11px !important; font-weight: 600 !important; }

        /* Footer */
        .footer { background: transparent; border-top: 1px solid rgba(168,140,255,0.15); }
        .footer .copyright { color: var(--il-text-faint) !important; }

        /* Form controls */
        .form-control, .form-select {
            background: rgba(255,255,255,0.05) !important;
            border-color: rgba(168,140,255,0.3) !important;
            border-radius: 10px !important;
            font-size: 13px !important;
            color: #fff !important;
        }
        .form-control::placeholder { color: var(--il-text-faint) !important; }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08) !important;
            border-color: var(--il-purple) !important;
            box-shadow: 0 0 0 3px rgba(124,92,255,.18) !important;
            color: #fff !important;
        }
        .form-label { color: var(--il-text-soft) !important; }
        select.form-select option { background: #1a1146; color: #fff; }

        /* Page header */
        .page-header h3 { font-size: 20px !important; color: #fff !important; }
        .breadcrumbs .nav-item a, .breadcrumbs .separator i, .breadcrumbs .nav-home i { color: var(--il-text-faint); font-size: 12px; }
        .breadcrumbs .nav-item a:hover { color: var(--il-purple-light); }

        /* Alert */
        .alert { border-radius: 10px !important; font-size: 13px; }

        /* SweetAlert confirm btn fix */
        .swal-button { border-radius: 50px !important; }

        /* Generic text helpers used inline throughout content pages */
        .text-muted { color: var(--il-text-faint) !important; }
        h1, h2, h3, h4, h5, h6 { color: #fff; }
        a { color: var(--il-purple-light); }

        /* ── Search bar ── */
        .search-bar-wrapper {
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(168,140,255,0.25);
            border-radius: 50px;
            padding: 6px 16px;
            gap: 8px;
            width: 280px;
            transition: border-color .2s, box-shadow .2s;
        }
        .search-bar-wrapper:focus-within {
            border-color: var(--il-purple);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 3px rgba(124,92,255,.15);
        }
        .search-bar-icon {
            color: var(--il-text-faint);
            font-size: 12px;
            flex-shrink: 0;
        }
        .search-bar-wrapper:focus-within .search-bar-icon {
            color: var(--il-purple-light);
        }
        .search-bar-input {
            border: none !important;
            background: transparent !important;
            outline: none !important;
            font-size: 13px !important;
            color: #fff !important;
            width: 100%;
            box-shadow: none !important;
            padding: 0 !important;
            height: auto !important;
            border-radius: 0 !important;
        }
        .search-bar-input::placeholder { color: var(--il-text-faint); font-size: 13px; }

        /* Dropdown menu (navbar user menu) */
        .dropdown-menu { background: #1a1146 !important; border: 1px solid rgba(168,140,255,0.25) !important; }
        .dropdown-item { color: var(--il-text-soft) !important; }
        .dropdown-item:hover { background: rgba(124,92,255,0.15) !important; color: #fff !important; }
        .dropdown-divider { border-color: rgba(168,140,255,0.15) !important; }
=======
    <style>
        /* ... (Keep your existing styles here) ... */
>>>>>>> refs/remotes/origin/main
    </style>
    @stack('styles')
</head>
<body>
<div class="wrapper">

    {{-- Safety check for sidebar --}}
    @if(view()->exists('layouts.sidebar'))
        @include('layouts.sidebar')
    @endif

    <div class="main-panel">
        <div class="main-header">
<<<<<<< HEAD
            <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('/dashboard') }}" class="logo il-brand" style="text-decoration:none;">
                        <img src="{{ asset('assets/img/internlink-icon.png') }}" alt="InternLink" style="height:32px;width:auto;flex-shrink:0;">
                        <span class="il-brand-text">Intern<span>Link</span></span>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>

=======
>>>>>>> refs/remotes/origin/main
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        @auth
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 pe-0"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- Use null-coalescing operators to prevent crashes --}}
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                         alt="Avatar" style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:2px solid #eaebf0;">
                                @else
                                    <div style="width:30px;height:30px;border-radius:50%;background:#5867dd;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#fff;">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                                    </div>
                                @endif
                                <span style="font-size:13px;font-weight:500;">{{ Auth::user()->name ?? 'User' }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius:10px;min-width:220px;">
                                <li class="px-3 py-2 d-flex align-items-center gap-2">
                                    <div style="font-size:13px;font-weight:600;color:#1a1a2e;">{{ Auth::user()->name ?? 'User' }}</div>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center gap-2">
                                        <i class="fas fa-user-circle" style="color:#5867dd;"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <div class="page-inner">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
@stack('scripts')
</body>
</html>
