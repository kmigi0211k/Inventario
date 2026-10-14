<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventario') }}</title>

        <!-- Bootstrap 5.3 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

        <!-- Google Fonts: Fraunces & DM Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,600&display=swap" rel="stylesheet">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <nav class="inv-navbar mb-4">
            <div class="container d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-4">
                    <a class="inv-brand" href="{{ url('/') }}">
                        <span class="inv-brand-badge">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <span>Inventario</span>
                    </a>

                    <ul class="nav d-flex flex-row align-items-center gap-1 mb-0">
                        <li class="nav-item">
                            <a class="inv-nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <i class="bi bi-shop"></i> Tienda
                            </a>
                        </li>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="inv-nav-link {{ request()->routeIs('products.dashboard') ? 'active' : '' }}" href="{{ route('products.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Panel Admin
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-warm" id="btn-edit-profile">
                            <i class="bi bi-person"></i>
                            <span class="d-none d-sm-inline">{{ Auth::user()->user_name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                            @csrf
                            <button type="submit" class="btn btn-warm-subtle text-danger" id="btn-logout" title="Cerrar Sesión">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="d-none d-md-inline">Salir</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-warm" id="btn-entrar">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary" id="btn-registro-nav">
                            Registro
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
        
        <main class="pb-5">
            <div class="container mb-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border" style="background-color: var(--stock-in-bg); color: var(--stock-in-text); border-color: var(--stock-in-border) !important; border-radius: var(--radius-sm);" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border" style="background-color: var(--stock-out-bg); color: var(--stock-out-text); border-color: var(--stock-out-border) !important; border-radius: var(--radius-sm);" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
