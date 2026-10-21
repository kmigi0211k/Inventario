@extends('layouts.app')

@section('content')
<div class="container py-3">

    <!-- Top Bar / Cabecera -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="overline mb-1">Visión General del Sistema</div>
            <h1 class="h2 fw-bold mb-1" style="font-family: var(--font-display);">Panel General</h1>
            <p class="text-secondary small mb-0">
                Bienvenido, <strong>{{ Auth::user()->user_name }}</strong>. Resumen ejecutivo de inventario, stock crítico y métricas de usuarios.
            </p>
        </div>
        <!-- Accesos Rápidos -->
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm" id="btn-quick-products-dashboard">
                <i class="bi bi-speedometer2"></i> Ver Dashboard de Productos
            </a>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-warm" id="btn-quick-admin-users">
                <i class="bi bi-people"></i> Administrar Usuarios
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary" id="btn-quick-create-product">
                <i class="bi bi-plus-lg"></i> Crear Producto
            </a>
        </div>
    </div>

    <!-- Tarjetas de Indicadores Principales -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Productos (Activos e Inactivos) -->
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Total Productos</span>
                    <i class="bi bi-box-seam text-secondary fs-5"></i>
                </div>
                <div class="inv-stat-number" id="stat-total-products">{{ $totalProducts }}</div>
                <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                    <span class="inv-badge badge-stock-in" title="Productos visibles en tienda">
                        <i class="bi bi-check-circle"></i> {{ $activeProducts }} activos
                    </span>
                    <span class="inv-badge badge-role-user" title="Productos ocultos">
                        <i class="bi bi-eye-slash"></i> {{ $inactiveProducts }} inactivos
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Stock Bajo y Agotados -->
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Alertas de Stock</span>
                    <i class="bi bi-exclamation-triangle fs-5" style="color: var(--stock-low-text);"></i>
                </div>
                <div class="d-flex align-items-baseline gap-3 my-2">
                    <div>
                        <div class="inv-stat-number m-0" id="stat-low-stock" style="color: var(--stock-low-text); font-size: 1.85rem;">{{ $lowStockProducts }}</div>
                        <div class="small text-muted" style="font-size: 12px;">Stock bajo (&le; {{ $lowStockThreshold }})</div>
                    </div>
                    <div class="border-start ps-3" style="border-color: var(--border-warm) !important;">
                        <div class="inv-stat-number m-0" id="stat-out-of-stock" style="color: var(--stock-out-text); font-size: 1.85rem;">{{ $outOfStockProducts }}</div>
                        <div class="small text-muted" style="font-size: 12px;">Agotados</div>
                    </div>
                </div>
                <div class="small text-muted">
                    Total productos en alerta: <strong>{{ $lowStockProducts + $outOfStockProducts }}</strong>
                </div>
            </div>
        </div>

        <!-- 3. Valor Total de Inventario -->
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Valor del Inventario</span>
                    <i class="bi bi-currency-dollar text-secondary fs-5"></i>
                </div>
                <div class="inv-stat-number" id="stat-inventory-value" style="color: var(--color-accent); font-size: 1.75rem;">
                    ${{ number_format($totalInventoryValue, 0, ',', '.') }}
                </div>
                <div class="small text-muted">
                    COP &bull; Suma (precio &times; stock) de activos
                </div>
            </div>
        </div>

        <!-- 4. Total Usuarios (Administradores y Regulares) -->
        <div class="col-sm-6 col-xl-3">
            <div class="inv-stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="overline">Usuarios Registrados</span>
                    <i class="bi bi-people text-secondary fs-5"></i>
                </div>
                <div class="inv-stat-number" id="stat-total-users">{{ $totalUsers }}</div>
                <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                    <span class="inv-badge badge-role-admin" title="Administradores">
                        <i class="bi bi-shield-lock-fill"></i> {{ $adminUsers }} admin
                    </span>
                    <span class="inv-badge badge-role-user" title="Usuarios sin rol administrativo">
                        <i class="bi bi-person"></i> {{ $regularUsers }} estándar
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Listas Cortas (2 Columnas) -->
    <div class="row g-4">
        <!-- 5a. Menor Stock (5 productos) -->
        <div class="col-lg-6">
            <div class="inv-table-card h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-battery-charging text-secondary"></i>
                        <h2 class="h6 fw-bold mb-0" style="font-family: var(--font-display);">Productos con Menor Stock</h2>
                    </div>
                    <span class="inv-badge badge-role-user">{{ $lowestStockProducts->count() }} ítems</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="inv-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 20px;">Producto</th>
                                <th>Stock</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center; padding-right: 20px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowestStockProducts as $product)
                            <tr>
                                <td style="padding-left: 20px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 overflow-hidden flex-shrink-0" style="width: 36px; height: 36px; background-color: var(--bg-subtle); border: 1px solid var(--border-warm); display: flex; align-items: center; justify-content: center;">
                                            @if($product->image)
                                                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="bi bi-box-seam text-muted small"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">{{ $product->name }}</div>
                                            <div class="small text-muted">${{ number_format($product->price ?? 0, 0, ',', '.') }} COP</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->stock == 0)
                                        <span class="inv-badge badge-stock-out"><i class="bi bi-x"></i> 0 un.</span>
                                    @elseif($product->stock <= $lowStockThreshold)
                                        <span class="inv-badge badge-stock-low"><i class="bi bi-exclamation-circle"></i> {{ $product->stock }} un.</span>
                                    @else
                                        <span class="inv-badge badge-stock-in"><i class="bi bi-check2"></i> {{ $product->stock }} un.</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($product->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">Activo</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle" style="font-size: 11px;">Inactivo</span>
                                    @endif
                                </td>
                                <td style="text-align: center; padding-right: 20px;">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warm py-1 px-2 small" title="Editar producto">
                                        <i class="bi bi-pencil"></i>
                                        <span class="d-none d-sm-inline">Editar</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-inbox text-muted fs-4 d-block mb-2"></i>
                                    <p class="text-muted small mb-0">No hay productos con stock bajo en el inventario.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 5b. Últimos Creados (5 productos) -->
        <div class="col-lg-6">
            <div class="inv-table-card h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center p-3 px-4 border-bottom" style="background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-secondary"></i>
                        <h2 class="h6 fw-bold mb-0" style="font-family: var(--font-display);">Últimos Productos Registrados</h2>
                    </div>
                    <span class="inv-badge badge-role-user">{{ $latestProducts->count() }} recientes</span>
                </div>

                <div class="table-responsive flex-grow-1">
                    <table class="inv-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 20px;">Producto</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th style="text-align: center; padding-right: 20px;">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProducts as $product)
                            <tr>
                                <td style="padding-left: 20px;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 overflow-hidden flex-shrink-0" style="width: 36px; height: 36px; background-color: var(--bg-subtle); border: 1px solid var(--border-warm); display: flex; align-items: center; justify-content: center;">
                                            @if($product->image)
                                                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="bi bi-box-seam text-muted small"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 180px;">{{ $product->name }}</div>
                                            <div class="small text-muted">{{ $product->stock }} unidades</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold" style="font-family: var(--font-display);">${{ number_format($product->price ?? 0, 0, ',', '.') }}</span>
                                    <span class="small text-muted">COP</span>
                                </td>
                                <td>
                                    <div class="text-dark small">{{ $product->created_at ? $product->created_at->format('d/m/Y') : '-' }}</div>
                                    <div class="text-muted" style="font-size: 11px;">{{ $product->created_at ? $product->created_at->diffForHumans() : '' }}</div>
                                </td>
                                <td style="text-align: center; padding-right: 20px;">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warm py-1 px-2 small" title="Editar producto">
                                        <i class="bi bi-pencil"></i>
                                        <span class="d-none d-sm-inline">Editar</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-inbox text-muted fs-4 d-block mb-2"></i>
                                    <p class="text-muted small mb-0">No hay productos registrados en el sistema.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
