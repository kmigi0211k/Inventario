@extends('layouts.app')

@section('content')
<div class="container py-3">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="overline mb-1">Control de Acceso</div>
            <h1 class="h2 fw-bold mb-1" style="font-family: var(--font-display);">Gestión de Usuarios</h1>
            <p class="text-secondary small mb-0">Administra los roles y cuentas registradas en la plataforma.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <div class="inv-card py-2 px-3 d-inline-flex align-items-center gap-2">
                <span class="overline mb-0">Total:</span>
                <span class="fw-bold" style="font-family: var(--font-display); color: var(--color-accent);">{{ $users->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="inv-table-card">
        <div class="table-responsive">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th class="ps-4">Usuario / Email</th>
                        <th>Nombre Registrado</th>
                        <th class="text-center">Rol</th>
                        <th>Fecha Registro</th>
                        <th>Último Acceso</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                                     style="width: 38px; height: 38px; background-color: var(--color-accent-subtle); color: var(--color-accent); border: 1px solid var(--color-accent-border); font-size: 14px;">
                                    {{ strtoupper(substr($user->user_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->user_name }}</div>
                                    <div class="text-muted small">{{ $user->email ?? 'Sin correo' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->person)
                                <span class="text-dark">{{ $user->person->names }} {{ $user->person->last_name }}</span>
                            @else
                                <span class="text-muted small fst-italic">Sin perfil asignado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->isAdmin())
                                <span class="inv-badge badge-role-admin">
                                    <i class="bi bi-shield-lock-fill"></i> Administrador
                                </span>
                            @else
                                <span class="inv-badge badge-role-user">
                                    <i class="bi bi-person"></i> Usuario
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="text-dark small">{{ $user->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted" style="font-size: 11px;">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            @if(isset($user->last_login_at) && $user->last_login_at)
                                <div class="text-dark small">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}</div>
                                <div class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</div>
                            @else
                                <span class="text-muted small">No registrado</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($user->id !== Auth::id())
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline admin-toggle-form mb-0">
                                        @csrf
                                        @if($user->isAdmin())
                                            <button type="button" class="btn btn-outline-warm py-1 px-2 small btn-toggle-admin" data-name="{{ $user->user_name }}" data-action="quitar">
                                                <i class="bi bi-shield-minus me-1"></i> Quitar Admin
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-warm py-1 px-2 small btn-toggle-admin" data-name="{{ $user->user_name }}" data-action="hacer" style="border-color: var(--color-accent-border) !important; color: var(--color-accent) !important;">
                                                <i class="bi bi-shield-plus me-1"></i> Hacer Admin
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.users.reset', $user->id) }}" method="POST" class="d-inline admin-reset-form mb-0">
                                        @csrf
                                        <button type="button" class="btn btn-warm-subtle py-1 px-2 small btn-reset-pass" data-name="{{ $user->user_name }}" title="Resetear contraseña a 1234">
                                            <i class="bi bi-key"></i> Resetear
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="inv-badge badge-role-user">Tú (Sesión actual)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-toggle-admin').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            const name = this.dataset.name;
            const action = this.dataset.action;
            
            Swal.fire({
                title: '¿Modificar permisos?',
                text: `¿Deseas ${action} administrador al usuario "${name}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#C8522C',
                cancelButtonColor: '#6B6255',
                confirmButtonText: 'Sí, cambiar rol',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.btn-reset-pass').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            const name = this.dataset.name;
            
            Swal.fire({
                title: '¿Resetear contraseña?',
                text: `La contraseña de ${name} se restablecerá a "1234". ¿Continuar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9A6014',
                cancelButtonColor: '#6B6255',
                confirmButtonText: 'Sí, restablecer',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
