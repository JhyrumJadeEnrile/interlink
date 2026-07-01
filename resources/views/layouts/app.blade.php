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

    <style>
        /* ... (Keep your existing styles here) ... */
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
