<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — Inventario</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #f8fafc, #eef2ff, #f1f5f9, #e0e7ff);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs in background */
        body::before {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08), transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: fixed;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.06), transparent 70%);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        .login-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%;
            max-width: 420px;
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
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .brand-name span { color: #4f46e5; }

        .login-title {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title h1 {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .login-title p {
            font-size: 14px;
            color: #64748b;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            z-index: 5;
        }

        .form-control {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #0f172a;
            padding: 13px 14px 13px 42px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder { color: #94a3b8; }
        .form-control:focus {
            background: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            color: #0f172a;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .text-danger { color: #ef4444 !important; font-size: 12px; margin-top: 6px; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .form-check-input {
            background-color: #fff;
            border-color: #cbd5e1;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .form-check-label {
            font-size: 13px;
            color: #475569;
        }

        .forgot-link {
            font-size: 13px;
            color: #4f46e5;
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 600;
        }

        .forgot-link:hover { color: #3730a3; text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span { font-size: 12px; color: #64748b; font-weight: 600; }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .register-link a {
            color: #4f46e5;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-link a:hover { color: #3730a3; text-decoration: underline; }

        .alert-success-custom {
            background: rgba(52, 211, 153, 0.15);
            border: 1px solid rgba(52, 211, 153, 0.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #6ee7b7;
            margin-bottom: 20px;
        }

        @media (max-width: 480px) {
            .login-card { padding: 36px 28px; }
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- Logo/Brand -->
    <div class="brand-logo">
        <div class="brand-icon">🛍️</div>
        <div class="brand-name">Inventario</div>
    </div>

    <div class="login-title">
        <h1>Bienvenido de nuevo</h1>
        <p>Inicia sesión para continuar</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Usuario -->
        <div class="mb-4">
            <label for="user_name" class="form-label">Nombre de Usuario</label>
            <div class="input-wrapper">
                <i class="bi bi-person input-icon"></i>
                <input
                    id="username"
                    type="text"
                    name="user_name"
                    class="form-control @error('user_name') is-invalid @enderror"
                    value="{{ old('user_name') }}"
                    required
                    autofocus
                    placeholder="Escribe tu usuario aquí"
                    autocomplete="username">
            </div>
            @error('user_name')
                <div class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-wrapper">
                <i class="bi bi-lock input-icon"></i>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                    placeholder="••••••••"
                    autocomplete="current-password">
            </div>
            @error('password')
                <div class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember + Forgot -->
        <div class="remember-row">
            <div class="form-check mb-0">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label" for="remember_me">Recuérdame</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <!-- Botón Login -->
        <button type="submit" class="btn-login" id="btn-login-submit">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>
    </form>

    <div class="divider"><span>¿Primera vez aquí?</span></div>

    <div class="register-link">
        ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate gratis</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
