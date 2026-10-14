@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-warm py-2 px-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <span class="overline">Información de Cuenta</span>
                    <h1 class="h3 fw-bold mb-0" style="font-family: var(--font-display);">Mis Datos Personales</h1>
                </div>
            </div>

            <div class="inv-card overflow-hidden">
                <div class="p-4 p-md-5">
                    <form method="POST" action="{{ route('profile.info.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Sección 1: Cuenta -->
                        <div class="mb-4">
                            <span class="overline text-primary" style="color: var(--color-accent) !important;">Acceso al Sistema</span>
                            <h2 class="h5 fw-bold mb-3" style="font-family: var(--font-display);">Credenciales de Usuario</h2>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre de Usuario</label>
                                    <input type="text" name="user_name" class="form-control" value="{{ old('user_name', $user->user_name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->person->email ?? $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: var(--border-warm); opacity: 1;">

                        <!-- Sección 2: Persona -->
                        <div class="mb-4">
                            <span class="overline text-secondary">Identidad y Contacto</span>
                            <h2 class="h5 fw-bold mb-3" style="font-family: var(--font-display);">Datos de la Persona</h2>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombres</label>
                                    <input type="text" name="names" class="form-control" value="{{ old('names', $user->person->names ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellidos</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->person->last_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono o WhatsApp</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->person->phone ?? '') }}" placeholder="Ej. 302 385 0997">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dirección de Residencia</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->person->address ?? '') }}" placeholder="Ej. Calle 48 E # 93-53">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: var(--border-warm); opacity: 1;">

                        <!-- Sección 3: Contraseña -->
                        <div class="mb-4">
                            <span class="overline text-muted">Seguridad (Opcional)</span>
                            <h2 class="h5 fw-bold mb-2" style="font-family: var(--font-display);">Cambiar Contraseña</h2>
                            <p class="text-secondary small mb-3">Deja estos dos campos vacíos si no deseas modificar tu clave actual.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres">
                                    @error('password') <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña">
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-color: var(--border-warm) !important;">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warm">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2 me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
