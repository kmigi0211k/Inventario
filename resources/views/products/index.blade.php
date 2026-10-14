@extends('layouts.app')

@section('content')
<div class="container py-3">

    <!-- Hero Editorial -->
    <div class="inv-hero mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                @auth
                    <div class="d-inline-flex align-items-center gap-3 px-3 py-2 mb-3 rounded-2" style="background-color: var(--bg-subtle); border: 1px solid var(--border-warm);">
                        <div class="inv-brand-badge" style="width: 28px; height: 28px; font-size: 13px;">
                            {{ strtoupper(substr(Auth::user()->user_name, 0, 1)) }}
                        </div>
                        <div class="small">
                            <span class="text-muted">Conectado como</span>
                            <span class="fw-bold text-dark ms-1">{{ Auth::user()->user_name }}</span>
                        </div>
                    </div>
                @endauth

                <div class="overline mb-2">Catálogo Tecnológico</div>
                <h1 class="display-5 fw-bold mb-3" style="font-family: var(--font-display); line-height: 1.15;">
                    Explora nuestros productos seleccionados
                </h1>
                <p class="text-muted mb-4" style="max-width: 520px; font-size: 15px;">
                    Equipos, periféricos y accesorios con garantía oficial. Calidad garantizada para tu trabajo y proyectos.
                </p>

                <div class="d-flex align-items-center gap-4 pt-3 border-top" style="border-color: var(--border-warm) !important;">
                    <div>
                        <div class="h4 mb-0 fw-bold" style="font-family: var(--font-display); color: var(--color-accent);">{{ $products->count() }}</div>
                        <div class="overline">Total Equipos</div>
                    </div>
                    <div class="vr" style="background-color: var(--border-warm); opacity: 1;"></div>
                    <div>
                        <div class="h4 mb-0 fw-bold" style="font-family: var(--font-display); color: var(--stock-in-text);">{{ $products->where('stock', '>', 0)->count() }}</div>
                        <div class="overline">Disponibles</div>
                    </div>
                    <div class="vr" style="background-color: var(--border-warm); opacity: 1;"></div>
                    <div>
                        <div class="h4 mb-0 fw-bold" style="font-family: var(--font-display); color: var(--text-primary);">100%</div>
                        <div class="overline">Garantía</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm">
                    <i class="bi bi-speedometer2"></i> Ir al Panel de Gestión
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Barra de Listado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h5 fw-bold mb-0" style="font-family: var(--font-display);">Disponibles en Tienda</h2>
            <p class="text-muted small mb-0">Mostrando {{ $products->count() }} resultados actualizados</p>
        </div>
    </div>

    <!-- Grid de Productos -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="inv-product-card">
                <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset d-flex flex-column flex-grow-1">
                    <div class="inv-product-media">
                        <!-- Badge de Stock Sobrio -->
                        <div style="position: absolute; top: 12px; left: 12px; z-index: 2;">
                            @if($product->stock > 0)
                                @if($product->stock < 5)
                                    <span class="inv-badge badge-stock-low">
                                        <i class="bi bi-exclamation-circle"></i> Últimas {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="inv-badge badge-stock-in">
                                        <i class="bi bi-check2"></i> Stock: {{ $product->stock }}
                                    </span>
                                @endif
                            @else
                                <span class="inv-badge badge-stock-out">
                                    <i class="bi bi-x"></i> Agotado
                                </span>
                            @endif
                        </div>

                        @if($product->image)
                            <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="placeholder-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        @endif
                    </div>

                    <div class="inv-product-body">
                        <div class="overline mb-1">Hardware & Tech</div>
                        <h3 class="inv-product-title">{{ $product->name }}</h3>
                        <p class="text-muted small mb-3 text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px;">
                            {{ $product->description }}
                        </p>
                        <div class="mt-auto pt-2">
                            <div class="inv-product-price">
                                ${{ number_format($product->price, 0, ',', '.') }} <span class="small fw-normal text-muted" style="font-size: 13px;">COP</span>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="px-3 pb-3 pt-0">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-warm-subtle w-100">
                        <i class="bi bi-eye me-1"></i> Ver Detalle
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="inv-card p-5 text-center my-4">
                <div class="display-6 mb-3 text-muted">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">No hay productos disponibles por ahora</h3>
                <p class="text-muted small mb-3">Vuelve más tarde o consulta con el administrador.</p>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="{{ route('products.create') }}" class="btn btn-primary d-inline-flex">
                        <i class="bi bi-plus-lg me-1"></i> Registrar Primer Producto
                    </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

</div>
@endsection
