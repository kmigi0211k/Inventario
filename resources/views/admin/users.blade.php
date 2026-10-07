@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>Gestión de Usuarios</h3>
            <p class="text-muted small">Administra los roles y visualiza los usuarios registrados en la plataforma.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-4 shadow-sm border">
            <span class="text-muted small">Total Usuarios:</span>
            <span class="fw-bold text-primary h5 mb-0 ms-2">{{ $users->count() }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Usuario / Email</th>
                        <th class="py-3">Nombre Real</th>
                        <th class="py-3 text-center">Rol</th>
                        <th class="py-3">Fecha Registro</th>
                        <th class="py-3">Última Conexión</th>
                        <th class="py-3 text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ strtoupper(substr($user->user_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->user_name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->person)
                                <span class="text-dark">{{ $user->person->names }} {{ $user->person->last_names }}</span>
                            @else
                                <span class="text-muted small italic">Sin perfil completado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->isAdmin())
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-bold">Administrador</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2 fw-bold">Usuario</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-dark small">{{ $user->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted" style="font-size: 10px;">Creado {{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            @if(isset($user->last_login_at) && $user->last_login_at)
                                <div class="text-dark small">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</div>
                            @else
                                <span class="text-muted small">No disponible</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($user->id !== Auth::id())
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline admin-toggle-form">
                                        @csrf
                                        @if($user->isAdmin())
                                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold btn-toggle-admin" data-name="{{ $user->user_name }}" data-action="quitar">
                                                Quitar Admin
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold btn-toggle-admin" data-name="{{ $user->user_name }}" data-action="hacer">
                                                Hacer Admin
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.users.reset', $user->id) }}" method="POST" class="d-inline admin-reset-form">
                                        @csrf
                                        <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm btn-reset-pass" data-name="{{ $user->user_name }}">
                                            <i class="bi bi-key-fill"></i> Resetear
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-light text-muted rounded-pill px-3 py-2">Tú (Admin)</span>
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
                title: '¿Estás seguro?',
                text: `¿Quieres ${action} administrador al usuario ${name}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
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
                title: 'Resetear Contraseña',
                text: `La clave de ${name} volverá a ser "12345678". ¿Continuar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, resetear',
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
