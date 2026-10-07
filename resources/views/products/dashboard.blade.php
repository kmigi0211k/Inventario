@extends('layouts.app')

@section('content')
<style>
    /* Dashboard - Estilo limpio y profesional */
    .dash-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding: 32px 24px;
    }

    /* Header */
    .dash-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .dash-greeting {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .dash-greeting span { color: #6366f1; }

    .dash-date {
        font-size: 13px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .btn-primary-new {
        background: #6366f1;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s;
        box-shadow: 0 4px 14px rgba(99,102,241,0.35);
    }

    .btn-primary-new:hover {
        background: #4f46e5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99,102,241,0.45);
    }

    .btn-volunteers-btn {
        background: #fff;
        color: #f59e0b;
        border: 2px solid #fde68a;
        border-radius: 12px;
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s;
    }

    .btn-volunteers-btn:hover {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #d97706;
    }

    /* Stat Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) { .stats-row { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .stats-row { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon-box {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .icon-indigo { background: #eef2ff; color: #6366f1; }
    .icon-green  { background: #f0fdf4; color: #16a34a; }
    .icon-amber  { background: #fffbeb; color: #d97706; }
    .icon-red    { background: #fff1f2; color: #e11d48; }

    .stat-info { flex: 1; }
    .stat-value { font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1; }
    .stat-label { font-size: 13px; color: #94a3b8; margin-top: 5px; }

    /* Main Table Card */
    .table-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 8px 24px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .table-header {
        padding: 22px 28px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-title {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .table-count {
        font-size: 12px;
        color: #94a3b8;
        background: #f1f5f9;
        border-radius: 20px;
        padding: 4px 12px;
    }

    table { width: 100%; border-collapse: collapse; }

    thead th {
        background: #f8fafc;
        padding: 13px 20px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
    }

    tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }

    tbody td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }

    .product-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .product-thumb {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #f1f5f9;
        flex-shrink: 0;
    }

    .product-thumb-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        border: 2px solid #f1f5f9;
    }

    .product-name-big {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }

    .product-desc-small {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 3px;
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge-price {
        display: inline-block;
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 14px;
        font-weight: 700;
    }

    .badge-stock-ok {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eef2ff;
        color: #6366f1;
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .badge-stock-low {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .badge-stock-zero {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 13px;
        font-weight: 700;
    }

    /* Action Buttons */
    .actions-wrap { display: flex; align-items: center; gap: 8px; }

    .btn-act {
        border-radius: 9px;
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-cart  { background: #eef2ff; color: #6366f1; }
    .btn-cart:hover  { background: #e0e7ff; color: #4f46e5; }

    .btn-edit  { background: #fffbeb; color: #d97706; }
    .btn-edit:hover  { background: #fef3c7; color: #b45309; }

    .btn-del   { background: #fff1f2; color: #e11d48; }
    .btn-del:hover   { background: #ffe4e6; color: #be123c; }

    /* Empty state */
    .empty-cell { text-align: center; padding: 70px 20px; }
    .empty-cell .empty-icon { font-size: 52px; margin-bottom: 12px; opacity: 0.35; }
    .empty-cell p { color: #94a3b8; font-size: 14px; margin-top: 6px; }

    /* Alert */
    .alert-ok {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        color: #166534;
        padding: 14px 18px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }

    /* iOS Switch */
    .ios-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin: 0;
    }
    .ios-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    input:checked + .slider {
        background-color: #10b981;
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
</style>

<div class="dash-wrapper">
    <div class="container-fluid">

        @if(session('success'))
        <div class="alert-ok">
            <i class="bi bi-check-circle-fill" style="color:#16a34a; font-size:18px;"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Top Bar -->
        <div class="dash-topbar">
            <div>
                <div class="dash-greeting">
                    Panel de <span>Gestión</span>
                </div>
                <div class="dash-date">
                    Hola, <strong>{{ Auth::user()->user_name }}</strong> — Administra tus productos
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.users') }}" class="btn-volunteers-btn" style="color: #6366f1; border-color: #c7d2fe;">
                    <i class="bi bi-people-fill"></i> Usuarios
                </a>
                <a href="{{ route('products.create') }}" class="btn-primary-new">
                    <i class="bi bi-plus-lg"></i> Nuevo Producto
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon-box icon-indigo"><i class="bi bi-box-seam-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $products->count() }}</div>
                    <div class="stat-label">Total Productos</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box icon-green"><i class="bi bi-check-circle-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $products->where('stock', '>', 5)->count() }}</div>
                    <div class="stat-label">Stock Suficiente</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box icon-amber"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $products->where('stock', '<=', 5)->where('stock', '>', 0)->count() }}</div>
                    <div class="stat-label">Stock Bajo</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box icon-red"><i class="bi bi-x-circle-fill"></i></div>
                <div class="stat-info">
                    <div class="stat-value">{{ $products->where('stock', 0)->count() }}</div>
                    <div class="stat-label">Sin Stock</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">📦 Lista de Productos</div>
                <span class="table-count">{{ $products->count() }} productos</span>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th style="padding-left:28px; min-width:240px;">Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th style="text-align:center;">Estado</th>
                            <th style="text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td style="padding-left:28px;">
                                <div class="product-row">
                                    @if($product->image)
                                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" class="product-thumb">
                                    @else
                                        <div class="product-thumb-placeholder">📦</div>
                                    @endif
                                    <div>
                                        <div class="product-name-big">{{ $product->name }}</div>
                                        <div class="product-desc-small">{{ $product->description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-price">$ {{ number_format($product->price, 0, ',', '.') }} COP</span>
                            </td>
                            <td>
                                @if($product->stock > 5)
                                    <span class="badge-stock-ok"><i class="bi bi-archive"></i>{{ $product->stock }} unid.</span>
                                @elseif($product->stock > 0)
                                    <span class="badge-stock-low"><i class="bi bi-exclamation-triangle"></i>{{ $product->stock }} unid.</span>
                                @else
                                    <span class="badge-stock-zero"><i class="bi bi-x-circle"></i>Sin stock</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <form action="{{ route('products.toggleActive', $product->id) }}" method="POST" class="toggle-active-form">
                                    @csrf
                                    @method('PATCH')
                                    <label class="ios-switch">
                                        <input type="checkbox" onchange="this.form.submit()" {{ $product->is_active ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </form>
                            </td>
                            <td>
                                <div class="actions-wrap" style="justify-content:center;">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn-act btn-edit">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-act btn-del btn-delete">
                                            <i class="bi bi-trash-fill"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-cell">
                                    <div class="empty-icon">📭</div>
                                    <strong style="font-size:16px; color:#475569;">No hay productos aún</strong>
                                    <p>Empieza añadiendo tu primer producto.</p>
                                    <a href="{{ route('products.create') }}" class="btn-primary-new" style="display:inline-flex; margin-top:12px;">
                                        <i class="bi bi-plus-lg"></i> Crear producto
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) { form.submit(); }
        });
    });
</script>
@endsection