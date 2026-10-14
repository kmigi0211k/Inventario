<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — Inventario</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts: Fraunces & DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="inv-auth-wrapper">
    <!-- Lado Izquierdo: Identidad Editorial -->
    <div class="inv-auth-brand-side">
        <div>
            <a href="{{ url('/') }}" class="inv-brand mb-5">
                <span class="inv-brand-badge">
                    <i class="bi bi-box-seam"></i>
                </span>
                <span>Inventario</span>
            </a>

            <div class="mt-5 pt-3" style="max-width: 440px;">
                <div class="overline mb-3">Plataforma Tecnológica</div>
                <h2 class="display-6 fw-bold mb-4" style="font-family: var(--font-display); line-height: 1.2;">
                    Gestión precisa y catálogo confiable en un solo lugar.
                </h2>
                <p class="text-secondary mb-4" style="font-size: 15px; line-height: 1.6;">
                    Accede a tu panel para consultar productos en tiempo real, monitorear disponibilidad de stock y gestionar compras con total transparencia.
                </p>

                <div class="d-flex flex-column gap-3 pt-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check2 text-success fs-5"></i>
                        <span class="small text-secondary">Inventario sincronizado con base de datos</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check2 text-success fs-5"></i>
                        <span class="small text-secondary">Autenticación segura por usuario</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-check2 text-success fs-5"></i>
                        <span class="small text-secondary">Soporte directo y catálogo actualizado</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-muted small">
            &copy; {{ date('Y') }} Inventario. Todos los derechos reservados.
        </div>
    </div>

    <!-- Lado Derecho: Formulario Limpio -->
    <div class="inv-auth-form-side">
        <div class="w-100" style="max-width: 380px; margin: 0 auto;">
            
            <div class="mb-4">
                <div class="overline mb-1">Acceso a Cuenta</div>
                <h1 class="h3 fw-bold mb-2" style="font-family: var(--font-display);">Iniciar Sesión</h1>
                <p class="text-secondary small mb-0">Ingresa tus credenciales para continuar</p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success border py-2 px-3 mb-4 small" style="background-color: var(--stock-in-bg); color: var(--stock-in-text); border-color: var(--stock-in-border) !important;">
                    <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Nombre de Usuario -->
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre de Usuario</label>
                    <input
                        id="username"
                        type="text"
                        name="user_name"
                        class="form-control @error('user_name') is-invalid @enderror"
                        value="{{ old('user_name') }}"
                        required
                        autofocus
                        placeholder="Ej. juan12"
                        autocomplete="username">
                    @error('user_name')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color: var(--color-accent); font-weight: 500;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        placeholder="••••••••"
                        autocomplete="current-password">
                    @error('password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recordarme -->
                <div class="form-check mb-4">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label small text-secondary" for="remember_me">Mantener sesión iniciada</label>
                </div>

                <!-- Botón Login -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3" id="btn-login-submit">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar a mi cuenta
                </button>
            </form>

            <div class="border-top pt-4 text-center" style="border-color: var(--border-warm) !important;">
                <span class="text-muted small">¿Aún no tienes cuenta?</span>
                <a href="{{ route('register') }}" class="small fw-bold ms-1 text-decoration-none" style="color: var(--color-accent);">
                    Crear cuenta gratis
                </a>
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Tienda
                </a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
