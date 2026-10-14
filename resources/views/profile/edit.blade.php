@extends('layouts.app')

@section('content')
<div class="container py-3">

    <!-- Hero Perfil Editorial -->
    <div class="inv-hero mb-4">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                 style="width: 52px; height: 52px; background-color: var(--color-accent); color: white; font-family: var(--font-display); font-size: 1.35rem;">
                {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}
            </div>
            <div>
                <span class="overline">Cuenta de Usuario</span>
                <h1 class="h3 fw-bold mb-0" style="font-family: var(--font-display);">¡Hola, {{ Auth::user()->user_name }}!</h1>
            </div>
        </div>
        <p class="text-secondary small mb-0" style="max-width: 500px;">
            Desde aquí puedes gestionar tu información personal, actualizar credenciales de acceso y revisar el estado de tu cuenta en la plataforma.
        </p>
    </div>

    <!-- Grid de Secciones -->
    <div class="row g-3 mb-5">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('profile.info') }}" class="inv-card inv-card-hover p-4 d-flex flex-column justify-content-between text-decoration-none h-100" style="color: inherit;">
                <div>
                    <div class="rounded-2 d-inline-flex align-items-center justify-content-center p-2 mb-3" style="background-color: var(--color-accent-subtle); color: var(--color-accent); width: 44px; height: 44px;">
                        <i class="bi bi-person-vcard fs-5"></i>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="font-family: var(--font-display);">Datos Personales</h2>
                    <p class="text-secondary small mb-3">
                        Revisa y actualiza tus nombres, correo de contacto, teléfono de WhatsApp y contraseña.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-1 small fw-bold" style="color: var(--color-accent);">
                    <span>Gestionar datos</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('products.index') }}" class="inv-card inv-card-hover p-4 d-flex flex-column justify-content-between text-decoration-none h-100" style="color: inherit;">
                <div>
                    <div class="rounded-2 d-inline-flex align-items-center justify-content-center p-2 mb-3" style="background-color: var(--color-secondary-subtle); color: var(--color-secondary); width: 44px; height: 44px;">
                        <i class="bi bi-shop fs-5"></i>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="font-family: var(--font-display);">Catálogo de Tienda</h2>
                    <p class="text-secondary small mb-3">
                        Explora la lista completa de artículos disponibles y novedades tecnológicas.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-1 small fw-bold" style="color: var(--color-secondary);">
                    <span>Ir a comprar</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>

        @if(Auth::user()->isAdmin())
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('products.dashboard') }}" class="inv-card inv-card-hover p-4 d-flex flex-column justify-content-between text-decoration-none h-100" style="color: inherit;">
                <div>
                    <div class="rounded-2 d-inline-flex align-items-center justify-content-center p-2 mb-3" style="background-color: var(--bg-subtle); color: var(--text-primary); width: 44px; height: 44px;">
                        <i class="bi bi-speedometer2 fs-5"></i>
                    </div>
                    <h2 class="h5 fw-bold mb-2" style="font-family: var(--font-display);">Panel de Administración</h2>
                    <p class="text-secondary small mb-3">
                        Gestión total de productos, actualización rápida de stock, precios y permisos de usuarios.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-1 small fw-bold" style="color: var(--text-primary);">
                    <span>Abrir panel</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>
        @endif
    </div>

    <!-- Cerrar Sesión -->
    <div class="text-center pt-3 border-top" style="border-color: var(--border-warm) !important;">
        <form method="POST" action="{{ route('logout') }}" class="d-inline-block">
            @csrf
            <button type="submit" class="btn btn-danger-subtle px-4 py-2">
                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión en este dispositivo
            </button>
        </form>
    </div>

</div>
@endsection
