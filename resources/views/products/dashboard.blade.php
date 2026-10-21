@extends('layouts.app')

@section('content')
<div class="container py-3">

    <!-- Top Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="overline mb-1">Administración de Inventario</div>
            <h1 class="h2 fw-bold mb-1" style="font-family: var(--font-display);">Panel de Control</h1>
            <p class="text-secondary small mb-0">
                Bienvenido, <strong>{{ Auth::user()->user_name }}</strong>. Monitorea stock, precios y estado del catálogo.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warm" id="btn-back-general-dashboard">
                <i class="bi bi-arrow-left"></i> Panel General
            </a>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-warm">
                <i class="bi bi-people"></i> Gestión de Usuarios
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Total Catálogo</span>
                    <i class="bi bi-box-seam text-secondary fs-5"></i>
                </div>
                <div class="inv-stat-number">{{ $products->count() }}</div>
                <div class="small text-muted">Productos registrados</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Stock Normal</span>
                    <i class="bi bi-check2-circle fs-5" style="color: var(--stock-in-text);"></i>
                </div>
                <div class="inv-stat-number" style="color: var(--stock-in-text);">{{ $products->where('stock', '>', 5)->count() }}</div>
                <div class="small text-muted">Más de 5 unidades</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Stock Bajo</span>
                    <i class="bi bi-exclamation-triangle fs-5" style="color: var(--stock-low-text);"></i>
                </div>
                <div class="inv-stat-number" style="color: var(--stock-low-text);">{{ $products->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}</div>
                <div class="small text-muted">1 a 5 unidades restantes</div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Sin Existencias</span>
                    <i class="bi bi-x-circle fs-5" style="color: var(--stock-out-text);"></i>
                </div>
                <div class="inv-stat-number" style="color: var(--stock-out-text);">{{ $products->where('stock', 0)->count() }}</div>
                <div class="small text-muted">Requiere reabastecimiento</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Productos -->
    <div class="inv-table-card">
        <div class="d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-table text-secondary"></i>
                <h2 class="h6 fw-bold mb-0" style="font-family: var(--font-display);">Listado de Inventario</h2>
            </div>
            <span class="inv-badge badge-role-user">{{ $products->count() }} ítems</span>
        </div>

        <div class="table-responsive">
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="padding-left: 24px; min-width: 260px;">Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th style="text-align: center;">Visible en Tienda</th>
                        <th style="text-align: center; padding-right: 24px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-2 overflow-hidden flex-shrink-0" style="width: 48px; height: 48px; background-color: var(--bg-subtle); border: 1px solid var(--border-warm); display: flex; align-items: center; justify-content: center;">
                                    @if($product->image)
                                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-box-seam text-muted"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <div class="text-muted small text-truncate" style="max-width: 320px;">{{ $product->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold" style="font-family: var(--font-display);">${{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="small text-muted">COP</span>
                        </td>
                        <td>
                            @if($product->stock > 5)
                                <span class="inv-badge badge-stock-in"><i class="bi bi-check2"></i> {{ $product->stock }} un.</span>
                            @elseif($product->stock > 0)
                                <span class="inv-badge badge-stock-low"><i class="bi bi-exclamation-circle"></i> {{ $product->stock }} un.</span>
                            @else
                                <span class="inv-badge badge-stock-out"><i class="bi bi-x"></i> Agotado</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('products.toggleActive', $product->id) }}" method="POST" class="d-inline-block toggle-active-form mb-0">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input" type="checkbox" role="switch" onchange="this.form.submit()" {{ $product->is_active ? 'checked' : '' }} style="cursor: pointer; width: 38px; height: 20px;">
                                </div>
                            </form>
                        </td>
                        <td style="text-align: center; padding-right: 24px;">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warm py-1 px-2 small" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                    <span class="d-none d-md-inline">Editar</span>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block delete-form mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger-subtle py-1 px-2 small btn-delete" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                        <span class="d-none d-md-inline">Borrar</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-inbox display-6 text-muted mb-3 d-block"></i>
                            <div class="h6 fw-bold mb-1">No hay productos en inventario</div>
                            <p class="text-muted small mb-3">Comienza creando tu primer producto.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary d-inline-flex">
                                <i class="bi bi-plus-lg me-1"></i> Crear Producto
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "Esta acción no se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#A23838',
            cancelButtonColor: '#6B6255',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });
</script>
@endsection