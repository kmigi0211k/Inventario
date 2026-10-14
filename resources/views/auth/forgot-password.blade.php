<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recuperar Contraseña — Inventario</title>

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
                <div class="overline mb-3">Recuperación de Acceso</div>
                <h2 class="display-6 fw-bold mb-4" style="font-family: var(--font-display); line-height: 1.2;">
                    ¿Olvidaste tu contraseña? No hay problema.
                </h2>
                <p class="text-secondary mb-4" style="font-size: 15px; line-height: 1.6;">
                    Ingresa tu correo electrónico registrado y te enviaremos un enlace seguro para restablecer tu contraseña en segundos.
                </p>

                <div class="d-flex flex-column gap-3 pt-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-envelope-check text-success fs-5"></i>
                        <span class="small text-secondary">Enlace enviado a tu correo</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-shield-lock text-success fs-5"></i>
                        <span class="small text-secondary">Token de seguridad de un solo uso</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-clock text-success fs-5"></i>
                        <span class="small text-secondary">Enlace válido por 60 minutos</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-muted small">
            &copy; {{ date('Y') }} Inventario. Todos los derechos reservados.
        </div>
    </div>

    <!-- Lado Derecho: Formulario -->
    <div class="inv-auth-form-side">
        <div class="w-100" style="max-width: 380px; margin: 0 auto;">

            <div class="mb-4">
                <div class="overline mb-1">Acceso Seguro</div>
                <h1 class="h3 fw-bold mb-2" style="font-family: var(--font-display);">Recuperar Contraseña</h1>
                <p class="text-secondary small mb-0">
                    Escribe el correo de tu cuenta y te enviaremos un enlace de restablecimiento.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert border py-3 px-4 mb-4" style="background-color: var(--stock-in-bg); color: var(--stock-in-text); border-color: var(--stock-in-border) !important; border-radius: var(--radius-sm);">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-check-circle-fill mt-1" style="flex-shrink: 0;"></i>
                        <div>
                            <div class="fw-bold small mb-1">¡Correo enviado!</div>
                            <div class="small">{{ session('status') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="position-relative">
                        <i class="bi bi-envelope position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;"></i>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="tu@correo.com"
                            autocomplete="email"
                            style="padding-left: 42px;">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3" id="btn-forgot-submit">
                    <i class="bi bi-send me-1"></i> Enviar Enlace de Recuperación
                </button>
            </form>

            <div class="border-top pt-4 text-center" style="border-color: var(--border-warm) !important;">
                <span class="text-muted small">¿Recordaste tu contraseña?</span>
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
