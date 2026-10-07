<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Cuenta — Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #f8fafc, #eef2ff, #f1f5f9, #e0e7ff);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08), transparent 70%);
            border-radius: 50%;
            top: -150px; right: -150px;
            animation: float 9s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.06), transparent 70%);
            border-radius: 50%;
            bottom: -100px; left: -100px;
            animation: float 11s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-25px); }
        }

        .register-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .brand-name span { color: #10b981; }

        .register-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .register-title h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .register-title p {
            font-size: 13px;
            color: #64748b;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 7px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            z-index: 5;
        }

        .form-control {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #0f172a;
            padding: 12px 14px 12px 40px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder { color: #94a3b8; }

        .form-control:focus {
            background: #fff;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            color: #0f172a;
            outline: none;
        }

        .form-control.is-invalid { border-color: #ef4444; }
        .text-danger { color: #ef4444 !important; font-size: 12px; margin-top: 5px; }
        .invalid-feedback { color: #ef4444; font-size: 12px; }

        .row-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
            cursor: pointer;
            margin-top: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            background: linear-gradient(135deg, #059669, #047857);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 16px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span { font-size: 12px; color: #64748b; font-weight: 600; }

        .login-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .login-link a {
            color: #10b981;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link a:hover { color: #047857; text-decoration: underline; }

        .mb-field { margin-bottom: 16px; }

        @media (max-width: 480px) {
            .register-card { padding: 32px 22px; }
            .row-fields { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="register-card">

    <div class="brand-logo">
        <div class="brand-icon">🛍️</div>
        <div class="brand-name">Inventario</div>
    </div>

    <div class="register-title">
        <h1>Crea tu cuenta gratis</h1>
        <p>Únete a la comunidad de Inventario</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre completo -->
        <div class="mb-field">
            <label for="names" class="form-label">Nombre Completo</label>
            <div class="input-wrapper">
                <i class="bi bi-person input-icon"></i>
                <input id="names" type="text" name="names"
                    class="form-control @error('names') is-invalid @enderror"
                    value="{{ old('names') }}" required autofocus placeholder="Juan Pérez">
            </div>
            @error('names')
                <div class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-field">
            <label for="email" class="form-label">Correo Electrónico</label>
            <div class="input-wrapper">
                <i class="bi bi-envelope input-icon"></i>
                <input id="email" type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required placeholder="juan@ejemplo.com">
            </div>
            @error('email')
                <div class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Usuario -->
        <div class="mb-field">
            <label for="user_name" class="form-label">Nombre de Usuario</label>
            <div class="input-wrapper">
                <i class="bi bi-at input-icon"></i>
                <input id="username_reg" type="text" name="user_name"
                    class="form-control @error('user_name') is-invalid @enderror"
                    value="{{ old('user_name') }}" required placeholder="juanperez123">
            </div>
            @error('user_name')
                <div class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseñas en 2 columnas -->
        <div class="row-fields mb-field">
            <div>
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required placeholder="••••••••">
                </div>
                @error('password')
                    <div class="text-danger" style="font-size:11px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="form-label">Confirmar</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control" required placeholder="••••••••">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-register" id="btn-register-submit">
            <i class="bi bi-person-plus me-2"></i>Crear Cuenta Ahora
        </button>
    </form>

    <div class="divider"><span>¿Ya tienes cuenta?</span></div>

    <div class="login-link">
        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Inicia Sesión</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
