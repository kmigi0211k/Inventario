<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nueva Contraseña — Inventario</title>

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
                <div class="overline mb-3">Seguridad de Cuenta</div>
                <h2 class="display-6 fw-bold mb-4" style="font-family: var(--font-display); line-height: 1.2;">
                    Elige una contraseña segura y fácil de recordar.
                </h2>
                <p class="text-secondary mb-4" style="font-size: 15px; line-height: 1.6;">
                    Tu nueva contraseña debe ser única y no compartirla con nadie. Una vez guardada, podrás acceder con tus nuevas credenciales.
                </p>

                <div class="p-4 rounded-3 border" style="background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="bi bi-shield-lock-fill fs-5" style="color: var(--color-accent);"></i>
                        <span class="fw-bold small text-dark">Consejos de Seguridad</span>
                    </div>
                    <ul class="text-secondary small mb-0 ps-3">
                        <li>Mínimo 8 caracteres</li>
                        <li>Combina letras, números y símbolos</li>
                        <li>Evita datos personales obvios</li>
                    </ul>
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
                <div class="overline mb-1">Restablecimiento</div>
                <h1 class="h3 fw-bold mb-2" style="font-family: var(--font-display);">Nueva Contraseña</h1>
                <p class="text-secondary small mb-0">
                    Ingresa y confirma tu nueva contraseña para recuperar el acceso.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token oculto -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Correo Electrónico -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="tu@correo.com">
                    @error('email')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nueva Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <div class="position-relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres">
                        <button type="button" class="btn p-0 position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); background: none; border: none;" onclick="togglePass('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                    <div class="position-relative">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            required
                            autocomplete="new-password"
                            placeholder="Repite tu contraseña">
                        <button type="button" class="btn p-0 position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); background: none; border: none;" onclick="togglePass('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3" id="btn-reset-submit">
                    <i class="bi bi-check2-circle me-1"></i> Guardar Nueva Contraseña
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
                </a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePass(fieldId, btn) {
        const field = document.getElementById(fieldId);
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
