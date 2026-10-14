<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirmar Contraseña — Inventario</title>

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
    <div class="w-100" style="max-width: 420px;">

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
            <!-- Icono de seguridad -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width: 60px; height: 60px; background-color: var(--color-accent-subtle); border: 1px solid var(--color-accent-border);">
                    <i class="bi bi-lock-fill fs-4" style="color: var(--color-accent);"></i>
                </div>
                <div class="overline mb-1">Zona Segura</div>
                <h1 class="h4 fw-bold mb-2" style="font-family: var(--font-display);">Confirmar Contraseña</h1>
                <p class="text-secondary small mb-0">
                    Esta es una área protegida. Por favor confirma tu contraseña para continuar.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña Actual</label>
                    <div class="position-relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••">
                        <button type="button" class="btn p-0 position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); background: none; border: none;" onclick="togglePass(this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2" id="btn-confirm-pass">
                    <i class="bi bi-shield-check me-1"></i> Confirmar y Continuar
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePass(btn) {
        const field = document.getElementById('password');
        const icon = btn.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
</body>
</html>
