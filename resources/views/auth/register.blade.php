<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Cuenta — Inventario</title>

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
                <div class="overline mb-3">Nuevo Registro</div>
                <h2 class="display-6 fw-bold mb-4" style="font-family: var(--font-display); line-height: 1.2;">
                    Comienza a gestionar y explorar tecnología hoy.
                </h2>
                <p class="text-secondary mb-4" style="font-size: 15px; line-height: 1.6;">
                    Crea tu cuenta en pocos segundos para acceder a precios de catálogo, seguimiento de disponibilidad y herramientas de control.
                </p>

                <div class="p-4 rounded-3 border" style="background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="bi bi-shield-check text-success fs-5"></i>
                        <span class="fw-bold small text-dark">Privacidad y Seguridad</span>
                    </div>
                    <p class="text-secondary small mb-0">
                        Tus datos se almacenan de forma estructurada y con contraseñas encriptadas bajo los estándares de Laravel.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-muted small">
            &copy; {{ date('Y') }} Inventario. Todos los derechos reservados.
        </div>
    </div>

    <!-- Lado Derecho: Formulario Limpio -->
    <div class="inv-auth-form-side">
        <div class="w-100" style="max-width: 420px; margin: 0 auto;">
            
            <div class="mb-4">
                <div class="overline mb-1">Paso Inicial</div>
                <h1 class="h3 fw-bold mb-2" style="font-family: var(--font-display);">Crear Cuenta</h1>
                <p class="text-secondary small mb-0">Completa tus datos para registrarte en el sistema</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre completo -->
                <div class="mb-3">
                    <label for="names" class="form-label">Nombre Completo</label>
                    <input
                        id="names"
                        type="text"
                        name="names"
                        class="form-control @error('names') is-invalid @enderror"
                        value="{{ old('names') }}"
                        required
                        autofocus
                        placeholder="Ej. Juan Pérez">
                    @error('names')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        placeholder="juan@ejemplo.com">
                    @error('email')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nombre de Usuario -->
                <div class="mb-3">
                    <label for="username_reg" class="form-label">Nombre de Usuario (Único)</label>
                    <input
                        id="username_reg"
                        type="text"
                        name="user_name"
                        class="form-control @error('user_name') is-invalid @enderror"
                        value="{{ old('user_name') }}"
                        required
                        placeholder="Ej. juan12"
                        maxlength="15">
                    @error('user_name')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contraseña y Confirmación -->
                <div class="row g-2 mb-4">
                    <div class="col-sm-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            placeholder="••••••••">
                        @error('password')
                            <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label">Confirmar Clave</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Botón de Registro -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3" id="btn-register-submit">
                    <i class="bi bi-person-plus me-1"></i> Registrarme Ahora
                </button>
            </form>

            <div class="border-top pt-4 text-center" style="border-color: var(--border-warm) !important;">
                <span class="text-muted small">¿Ya tienes una cuenta?</span>
                <a href="{{ route('login') }}" class="small fw-bold ms-1 text-decoration-none" style="color: var(--color-accent);">
                    Iniciar sesión
                </a>
            </div>

            <div class="text-center mt-3">
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
