@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">Mis Datos Personales</h3>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('profile.info.update') }}">
                        @csrf
                        @method('PATCH')

                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información de la Cuenta</h5>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="user_name" class="form-control border-start-0 rounded-end-3" value="{{ old('user_name', $user->user_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 rounded-end-3" value="{{ old('email', $user->person->email ?? $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Información Personal</h5>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nombres</label>
                                <input type="text" name="names" class="form-control rounded-3" value="{{ old('names', $user->person->names ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Apellidos</label>
                                <input type="text" name="last_name" class="form-control rounded-3" value="{{ old('last_name', $user->person->last_name ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Teléfono / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0 rounded-end-3" value="{{ old('phone', $user->person->phone ?? '') }}" placeholder="Ej: 302 385 0997">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Dirección de Residencia</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="address" class="form-control border-start-0 rounded-end-3" value="{{ old('address', $user->person->address ?? '') }}" placeholder="Ej: Calle 48 E # 93-53">
                                </div>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-4 text-primary border-bottom pb-2">Seguridad (Opcional)</h5>
                        <p class="text-muted small mb-3">Deja estos campos vacíos si no deseas cambiar tu contraseña.</p>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 rounded-end-3" placeholder="Mínimo 8 caracteres">
                                </div>
                                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control border-start-0 rounded-end-3" placeholder="Repite la contraseña">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                Guardar Cambios <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
