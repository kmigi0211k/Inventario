@extends('layouts.app')

@section('content')
<style>
    body { background: #f8fafc !important; }

    .hero-section {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border-radius: 24px;
        padding: 52px 48px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(99,102,241,0.08), transparent 70%);
        border-radius: 50%;
        top: -100px; right: -100px;
        pointer-events: none;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(139,92,246,0.06), transparent 70%);
        border-radius: 50%;
        bottom: -60px; left: 40%;
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0e7ff;
        border: 1px solid #c7d2fe;
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 12px;
        color: #4f46e5;
        font-weight: 700;
        margin-bottom: 16px;
        letter-spacing: 0.5px;
    }

    .hero-title {
        font-size: 2.6rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -1px;
        margin-bottom: 12px;
    }

    .hero-title span {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        color: #475569;
        font-size: 15px;
        margin-bottom: 0;
        max-width: 420px;
    }

    .btn-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        border-radius: 12px;
        padding: 12px 22px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        position: relative;
        z-index: 10;
    }

    .btn-panel:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(79,70,229,0.3);
    }

    /* Stats bar */
    .stats-bar {
        display: flex;
        gap: 32px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .stat-item { text-align: left; }
    .stat-number {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
    }
    .stat-label {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Filter bar */
    .filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .section-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Product Cards Light Design */
    .product-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        border-color: #cbd5e1;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: #f8fafc;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image-wrapper img {
        transform: scale(1.05);
    }

    .product-placeholder {
        width: 100%;
        height: 100%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 56px;
        opacity: 0.5;
    }

    .price-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: #10b981;
        border-radius: 12px;
        padding: 6px 16px;
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        box-shadow: 0 4px 10px rgba(16,185,129,0.3);
        z-index: 2;
    }

    .stock-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        backdrop-filter: blur(4px);
    }

    .stock-ok { background: rgba(16,185,129,0.9); color: #fff; }
    .stock-low { background: rgba(245,158,11,0.9); color: #fff; }
    .stock-out { background: rgba(239,68,68,0.9); color: #fff; }

    .product-body {
        padding: 24px 20px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    @media (max-width: 768px) {
        .hero-section { padding: 32px 24px; border-radius: 16px; }
        .hero-title { font-size: 1.8rem; }
    }

    .product-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        background: #fafafa;
    }

    .stock-info {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-cart {
        background: #0f172a;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: rgba(255,255,255,0.3);
    }

    .empty-state .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        color: rgba(255,255,255,0.5);
        margin-bottom: 8px;
    }

    .empty-state p { font-size: 14px; }

    /* Alert override */
    .alert-success {
        background: rgba(16,185,129,0.12);
        border: 1px solid rgba(16,185,129,0.25);
        color: #6ee7b7;
        border-radius: 12px;
    }
</style>

<div class="container-fluid px-4 py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="hero-section mb-4">
        <div class="row align-items-center">
            <div class="col-lg-7">
                @auth
                    <div class="welcome-container animate__animated animate__backInDown mb-4">
                        <div class="welcome-card-glass p-3 rounded-4 d-inline-flex align-items-center">
                            <div class="welcome-avatar me-3">
                                {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="welcome-label">Bienvenido de nuevo,</div>
                                <div class="welcome-name">{{ Auth::user()->user_name }}! 👋</div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .welcome-card-glass {
                            background: rgba(255, 255, 255, 0.7);
                            backdrop-filter: blur(10px);
                            border: 1px solid rgba(99, 102, 241, 0.2);
                            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
                        }
                        .welcome-avatar {
                            width: 50px; height: 50px;
                            background: linear-gradient(135deg, #6366f1, #4f46e5);
                            color: white;
                            border-radius: 12px;
                            display: flex; align-items: center; justify-content: center;
                            font-weight: 800; font-size: 20px;
                            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
                        }
                        .welcome-label {
                            font-size: 13px;
                            color: #64748b;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                        }
                        .welcome-name {
                            font-size: 24px;
                            font-weight: 800;
                            background: linear-gradient(135deg, #1e293b, #475569);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                        }
                    </style>
                @endauth
                <h1 class="hero-title">Explora nuestros<br><span>productos</span></h1>
                <p class="hero-subtitle">
                    Encuentra la mejor calidad y precios increíbles en un solo lugar. 
                    Más de {{ $products->count() }} productos disponibles para ti.
                </p>
                <div class="stats-bar">
                    <div class="stat-item">
                        <div class="stat-number">{{ $products->count() }}</div>
                        <div class="stat-label">Productos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $products->where('stock', '>', 0)->count() }}</div>
                        <div class="stat-label">En Stock</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Disponible</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('products.dashboard') }}" class="btn-panel">
                    <i class="bi bi-speedometer2"></i> Panel de Gestión
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="product-card">
                <a href="{{ route('products.show', $product) }}" style="text-decoration:none; color:inherit; display:flex; flex-direction:column; flex:1;">
                    <div class="product-image-wrapper">
                        @if($product->stock > 0)
                            @if($product->stock < 5)
                                <div class="stock-badge stock-low"><i class="bi bi-exclamation-circle me-1"></i>¡Solo {{ $product->stock }}!</div>
                            @else
                                <div class="stock-badge stock-ok"><i class="bi bi-check2-circle me-1"></i>Stock: {{ $product->stock }}</div>
                            @endif
                        @else
                            <div class="stock-badge stock-out"><i class="bi bi-x-circle me-1"></i>Agotado</div>
                        @endif

                        @if($product->image)
                            <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-placeholder">📦</div>
                        @endif
                        <div class="price-badge">$ {{ number_format($product->price, 0, ',', '.') }} COP</div>
                    </div>

                    <div class="product-body">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-desc">{{ $product->description }}</div>
                    </div>
                </a>

                <div class="product-footer mt-auto">
                    <a href="{{ route('products.show', $product->id) }}" class="btn-add-cart text-decoration-none text-center d-inline-flex align-items-center justify-content-center">
                        <i class="bi bi-eye me-1"></i> Ver Detalle
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>No hay productos disponibles</h3>
                <p>Vuelve más tarde o contacta con el administrador.</p>
            </div>
        </div>
        @endforelse
    </div>

</div>
@endsection
