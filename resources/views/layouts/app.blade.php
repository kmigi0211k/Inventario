<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm py-3">
            <div class="container flex-wrap flex-md-nowrap">
                <a class="navbar-brand fw-bold mb-2 mb-md-0 me-md-4 fs-3" href="{{ url('/') }}">
                    <i class="bi bi-box-seam me-2 text-primary"></i>Inventario
                </a>

                <div class="d-flex flex-grow-1 justify-content-between align-items-center flex-wrap gap-3">
                    <ul class="navbar-nav flex-row gap-2 gap-md-3 mb-0">
                        <li class="nav-item">
                            <a class="btn {{ request()->routeIs('products.index') ? 'btn-primary' : 'btn-outline-light' }} px-3 py-2 fw-bold shadow-sm" href="{{ route('products.index') }}">
                                <i class="bi bi-shop me-1"></i> Tienda
                            </a>
                        </li>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <li class="nav-item d-none d-sm-block">
                            <a class="btn {{ request()->routeIs('products.dashboard') ? 'btn-primary' : 'btn-outline-light' }} px-3 py-2 fw-bold shadow-sm" href="{{ route('products.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Panel
                            </a>
                        </li>
                        @endif
                    </ul>
                    
                    <div class="d-flex align-items-center gap-2 gap-md-3 flex-wrap justify-content-end">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-light px-3 py-2 shadow-sm fw-bold" id="btn-edit-profile">
                                <i class="bi bi-person me-1 fs-5"></i> <span class="d-none d-sm-inline">{{ Auth::user()->user_name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger px-3 py-2 border-0 shadow-none" id="btn-logout">
                                    <i class="bi bi-box-arrow-right fs-4"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light px-4 py-2 fw-bold" id="btn-entrar">
                                Entrar
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" id="btn-registro-nav">
                                Registro
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        
        <main>
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
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
