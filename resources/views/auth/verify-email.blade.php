<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verificar Correo — Inventario</title>

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
<body style="background-color: var(--bg-canvas);">

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3">
    <div class="w-100" style="max-width: 480px;">

        <!-- Logo -->
        <div class="text-center mb-4">
            <a href="{{ url('/') }}" class="inv-brand d-inline-flex">
                <span class="inv-brand-badge">
                    <i class="bi bi-box-seam"></i>
                </span>
                <span>Inventario</span>
            </a>
        </div>

        <div class="inv-card p-4 p-md-5">
            <!-- Icono de verificación -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width: 64px; height: 64px; background-color: var(--stock-in-bg); border: 1px solid var(--stock-in-border);">
                    <i class="bi bi-envelope-check-fill fs-3" style="color: var(--stock-in-text);"></i>
                </div>
                <div class="overline mb-1">Verificación Requerida</div>
                <h1 class="h4 fw-bold mb-3" style="font-family: var(--font-display);">Verifica tu Correo</h1>
            </div>

            <p class="text-secondary mb-4 text-center" style="font-size: 15px; line-height: 1.6;">
                ¡Gracias por registrarte! Antes de continuar, revisa tu bandeja de entrada y haz clic en el enlace de verificación que te enviamos.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert border py-3 px-4 mb-4" style="background-color: var(--stock-in-bg); color: var(--stock-in-text); border-color: var(--stock-in-border) !important; border-radius: var(--radius-sm);">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-check-circle-fill mt-1" style="flex-shrink: 0;"></i>
                        <div class="small">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex flex-column gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2" id="btn-resend-verify">
                        <i class="bi bi-send me-1"></i> Reenviar Correo de Verificación
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-warm w-100 py-2" id="btn-logout-verify">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted small mb-0">
                ¿No encuentras el correo? Revisa tu carpeta de spam o correo no deseado.
            </p>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
