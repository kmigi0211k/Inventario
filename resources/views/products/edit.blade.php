@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="mb-3">
        <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="inv-card overflow-hidden">
                <div class="p-4 border-bottom" style="background-color: var(--bg-subtle); border-color: var(--border-warm) !important;">
                    <span class="overline">Edición de Catálogo</span>
                    <h1 class="h4 fw-bold mb-0" style="font-family: var(--font-display);">Editar Producto: {{ $product->name }}</h1>
                </div>

                <div class="p-4 p-md-5">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Imagen del Producto -->
                        <div class="p-3 mb-4 rounded-2 border" style="background-color: var(--bg-canvas); border-color: var(--border-warm) !important;">
                            @if($product->image)
                                <div class="mb-3 d-flex align-items-center gap-3">
                                    <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                         class="rounded-2 border" 
                                         style="width: 72px; height: 72px; object-fit: cover; background-color: var(--bg-surface); border-color: var(--border-warm) !important;">
                                    <div>
                                        <div class="fw-bold small text-dark">Imagen Actual</div>
                                        <div class="text-muted small">Puedes conservarla o subir una nueva a continuación.</div>
                                    </div>
                                </div>
                            @endif

                            <label class="form-label d-block fw-bold mb-2">Cambiar Imagen</label>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Subir nuevo archivo:</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">O enlazar nueva URL:</label>
                                    <input type="text" name="image_url" class="form-control" placeholder="https://images.unsplash.com/...">
                                </div>
                            </div>

                            @error('image')
                                <div class="text-danger small mt-2"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label">Descripción Detallada</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio y Stock -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Precio (COP)</label>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                                <div class="form-text small text-muted">Ingresa el valor numérico sin comas ni puntos.</div>
                                @error('price')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stock en Inventario</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado Activo -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label text-dark" for="isActiveCheck">
                                Producto activo (visible para los clientes)
                            </label>
                        </div>

                        <!-- Acciones -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top" style="border-color: var(--border-warm) !important;">
                            <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-arrow-repeat me-1"></i> Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection