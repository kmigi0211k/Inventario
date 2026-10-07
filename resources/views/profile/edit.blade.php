@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f9 !important; }
    
    .profile-hero {
        background-color: #004b93; /* Azul Alkosto */
        color: white;
        padding: 50px 25px 100px 25px;
        margin-bottom: -50px;
        position: relative;
        border-radius: 0 0 30px 30px;
    }

    .profile-hero h1 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .profile-grid {
        padding: 0 15px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 0;
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 25px 20px;
        text-align: left;
        text-decoration: none;
        color: #333;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #edf2f7;
        min-height: 180px;
    }

    .profile-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        border-color: #004b93;
    }

    .card-icon {
        font-size: 32px;
        color: #004b93;
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 10px;
        color: #1a202c;
    }

    .card-desc {
        font-size: 13px;
        color: #718096;
        line-height: 1.5;
    }

    .logout-section {
        margin-top: 50px;
        padding: 0 15px 60px 15px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-logout-alt {
        width: 100%;
        background: #fff1f2;
        color: #e11d48;
        border: 2px solid #fb7185;
        padding: 15px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.1);
    }

    .btn-logout-alt:hover {
        background: #e11d48;
        color: white;
    }

    @media (max-width: 576px) {
        .profile-grid {
            grid-template-columns: repeat(1, 1fr);
        }
    }
</style>

<div class="profile-hero">
    <div class="container">
        <h1><i class="bi bi-person-circle me-2"></i>Mi cuenta</h1>
        <h3>¡Hola, {{ Auth::user()->user_name }}!</h3>
        <p>Aquí podrás consultar todos tus movimientos y gestionar tu información.</p>
    </div>
</div>

<div class="container">
    <div class="profile-grid">
        <!-- Mi Perfil -->
        <a href="{{ route('profile.info') }}" class="profile-card">
            <div>
                <div class="card-icon"><i class="bi bi-person-vcard"></i></div>
                <div class="card-title">Mi Perfil</div>
                <div class="card-desc">Revisa y edita tus datos personales, contraseña y seguridad.</div>
            </div>
        </a>

    </div>

    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-alt">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</div>
@endsection
