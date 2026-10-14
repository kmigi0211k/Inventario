@extends('layouts.app')

@section('content')
<div class="container py-3">
    <!-- Enlace Volver -->
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-warm">
            <i class="bi bi-arrow-left"></i> Volver a la Tienda
        </a>
    </div>

    <div class="inv-card overflow-hidden">
        <div class="row g-0">
            <!-- Imagen del Producto -->
            <div class="col-lg-6 border-end" style="border-color: var(--border-warm) !important;">
                <div class="d-flex align-items-center justify-content-center p-4 p-md-5" style="background-color: var(--bg-subtle); min-height: 440px; height: 100%;">
                    @if($product->image)
                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded-2 shadow-sm"
                             style="max-height: 400px; width: auto; object-fit: contain;">
                    @else
                        <div class="text-center text-muted p-5">
                            <i class="bi bi-box-seam display-1"></i>
                            <div class="overline mt-3">Sin imagen disponible</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Producto -->
            <div class="col-lg-6">
                <div class="p-4 p-md-5 d-flex flex-column h-100">
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="overline">Ficha de Producto</span>
                        @if($product->stock > 0)
                            @if($product->stock < 5)
                                <span class="inv-badge badge-stock-low">
                                    <i class="bi bi-exclamation-circle"></i> ¡Últimas {{ $product->stock }} unidades!
                                </span>
                            @else
                                <span class="inv-badge badge-stock-in">
                                    <i class="bi bi-check2"></i> En Stock ({{ $product->stock }})
                                </span>
                            @endif
                        @else
                            <span class="inv-badge badge-stock-out">
                                <i class="bi bi-x"></i> Agotado
                            </span>
                        @endif
                    </div>

                    <h1 class="h2 fw-bold mb-3" style="font-family: var(--font-display); line-height: 1.2;">
                        {{ $product->name }}
                    </h1>

                    <div class="mb-4">
                        <div class="h2 fw-bold mb-0" style="font-family: var(--font-display); color: var(--color-accent);">
                            ${{ number_format($product->price, 0, ',', '.') }} <span class="small text-muted fw-normal" style="font-size: 15px;">COP</span>
                        </div>
                    </div>

                    <div class="border-top border-bottom py-3 mb-4" style="border-color: var(--border-warm) !important;">
                        <h2 class="overline mb-2">Descripción</h2>
                        <p class="text-secondary mb-0" style="font-size: 15px; line-height: 1.6;">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3 p-3 rounded-2" style="background-color: var(--bg-subtle); border: 1px solid var(--border-warm);">
                                <i class="bi bi-shield-check fs-4" style="color: var(--color-secondary);"></i>
                                <div>
                                    <div class="fw-bold small">Garantía Directa</div>
                                    <div class="text-muted small">12 meses de cobertura</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-3 p-3 rounded-2" style="background-color: var(--bg-subtle); border: 1px solid var(--border-warm);">
                                <i class="bi bi-truck fs-4" style="color: var(--color-accent);"></i>
                                <div>
                                    <div class="fw-bold small">Envío Nacional</div>
                                    <div class="text-muted small">Entrega asegurada</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-primary flex-grow-1 py-3">
                                <i class="bi bi-arrow-left"></i> Volver a Explorar Productos
                            </a>
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warm py-3 px-4">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
