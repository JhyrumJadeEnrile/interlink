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

    {{-- Global UI overrides --}}
    <style>
        /* ── Brand & sidebar ── */
        .sidebar[data-background-color="dark"] { background: #0f1117; }
        .sidebar .sidebar-wrapper { background: #0f1117; }
        .logo-header[data-background-color="dark"] { background: #0f1117 !important; border-bottom: 1px solid rgba(255,255,255,0.06); }

        /* Nav items */
        .sidebar .nav.nav-secondary .nav-item > a {
            border-radius: 8px;
            margin: 2px 10px;
            padding: 9px 14px;
            transition: background .15s, color .15s;
        }
        .sidebar .nav.nav-secondary .nav-item > a:hover { background: rgba(255,255,255,0.07); }
        .sidebar .nav.nav-secondary .nav-item.active > a { background: rgba(88,103,221,0.22); color: #8e8fff !important; }
        .sidebar .nav.nav-secondary .nav-item.active > a i { color: #8e8fff !important; }
        .sidebar .nav-section h4 { font-size: 10px; letter-spacing: .09em; color: #44445a; margin: 16px 0 4px 22px; }

        /* Main panel */
        .main-panel { background: #f4f5f7; }

        /* Navbar */
        .navbar.navbar-header { background: #fff !important; border-bottom: 1px solid #eaebf0 !important; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
        .navbar .profile-username { font-size: 13px; }

        /* Card refinements */
        .card { border: 1px solid #eaebf0 !important; box-shadow: 0 1px 4px rgba(0,0,0,.05) !important; border-radius: 12px !important; }
        .card-round { border-radius: 12px !important; }
        .card-header { border-bottom: 1px solid #f0f0f5 !important; background: transparent !important; padding: 1rem 1.25rem !important; }
        .card-title { font-size: 14px !important; font-weight: 600 !important; color: #1a1a2e !important; }

        /* Buttons */
        .btn-round { border-radius: 50px !important; }
        .btn-primary { background: #5867dd !important; border-color: #5867dd !important; }
        .btn-primary:hover { background: #4455cc !important; border-color: #4455cc !important; }

        /* Table */
        .table thead th { font-size: 11px !important; text-transform: uppercase; letter-spacing: .06em; color: #999 !important; font-weight: 600 !important; border-bottom: 1px solid #f0f0f5 !important; background: #fafafa !important; }
        .table td { border-color: #f5f5f8 !important; vertical-align: middle; font-size: 13px; }
        .table-head-bg-light thead th { background: #f8f9fb !important; }
        .table tbody tr:hover td { background: rgba(88,103,221,.03); }

        /* Badges */
        .badge { font-size: 11px !important; font-weight: 600 !important; }

        /* Footer */
        .footer { background: #fff; border-top: 1px solid #eaebf0; }

        /* Form controls */
        .form-control, .form-select {
            border-color: #e0e0ea !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            color: #1a1a2e !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5867dd !important;
            box-shadow: 0 0 0 3px rgba(88,103,221,.1) !important;
        }

        /* Page header */
        .page-header h3 { font-size: 20px !important; }
        .breadcrumbs .nav-item a, .breadcrumbs .separator i { color: #aaa; font-size: 12px; }
        .breadcrumbs .nav-item a:hover { color: #5867dd; }

        /* Alert */
        .alert { border-radius: 10px !important; font-size: 13px; }

        /* SweetAlert confirm btn fix */
        .swal-button { border-radius: 50px !important; }

        /* ── Search bar ── */
        .search-bar-wrapper {
            background: #f4f5f7;
            border: 1.5px solid #e8e8f0;
            border-radius: 50px;
            padding: 6px 16px;
            gap: 8px;
            width: 280px;
            transition: border-color .2s, box-shadow .2s;
        }
        .search-bar-wrapper:focus-within {
            border-color: #5867dd;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(88,103,221,.1);
        }
        .search-bar-icon {
            color: #bbb;
            font-size: 12px;
            flex-shrink: 0;
        }
        .search-bar-wrapper:focus-within .search-bar-icon {
            color: #5867dd;
        }
        .search-bar-input {
            border: none !important;
            background: transparent !important;
            outline: none !important;
            font-size: 13px !important;
            color: #1a1a2e !important;
            width: 100%;
            box-shadow: none !important;
            padding: 0 !important;
            height: auto !important;
            border-radius: 0 !important;
        }
        .search-bar-input::placeholder { color: #bbb; font-size: 13px; }
    </style>

    @stack('styles')
</head>
<body>
<div class="wrapper">

    @include('layouts.sidebar')

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('/dashboard') }}" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="InternLink" class="navbar-brand" height="20">
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>

            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    {{-- Search --}}
                    <nav class="navbar-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                        <div class="search-bar-wrapper d-flex align-items-center">
                            <i class="fa fa-search search-bar-icon"></i>
                            <input type="text" placeholder="Search anything..." class="search-bar-input" id="globalSearch" />
                        </div>
                    </nav>

                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        @auth
                        {{-- User dropdown --}}
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 pe-0"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <div style="width:30px;height:30px;border-radius:50%;background:#5867dd;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#fff;">
                                    {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                                </div>
                                <span style="font-size:13px;font-weight:500;">{{ Auth::user()->name }}</span>
                                <span class="badge ms-1" style="background:rgba(88,103,221,.15);color:#5867dd;font-size:10px;">{{ session('role') }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius:10px;min-width:210px;">
                                <li class="px-3 py-2">
                                    <div style="font-size:13px;font-weight:600;color:#1a1a2e;">{{ Auth::user()->name }}</div>
                                    <div style="font-size:11px;color:#aaa;">{{ Auth::user()->email }}</div>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" style="font-size:13px;">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ url('/login') }}" class="btn btn-sm btn-primary btn-round px-3">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
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

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between align-items-center py-2">
                <div class="copyright" style="font-size:12px;color:#aaa;">
                    &copy; 2026 InternLink &mdash; made with <i class="fa fa-heart text-danger mx-1"></i>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

@stack('scripts')
</body>
</html>