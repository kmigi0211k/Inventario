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
                    <span class="overline">Gestión de Catálogo</span>
                    <h1 class="h4 fw-bold mb-0" style="font-family: var(--font-display);">Crear Nuevo Producto</h1>
                </div>

                <div class="p-4 p-md-5">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Imagen del Producto -->
                        <div class="p-3 mb-4 rounded-2 border" style="background-color: var(--bg-canvas); border-color: var(--border-warm) !important;">
                            <label class="form-label d-block fw-bold mb-2">Fotografía o Imagen</label>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Subir archivo local:</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">O enlazar URL externa:</label>
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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ej. Laptop Dell XPS 13" required>
                            @error('name')
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label">Descripción Detallada</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Especificaciones, características y detalles del equipo..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio y Stock -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Precio (COP)</label>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Ej. 1500000" required>
                                <div class="form-text small text-muted">Ingresa el valor numérico sin comas ni puntos.</div>
                                @error('price')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stock en Inventario</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" placeholder="0" required>
                                @error('stock')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado Activo -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCheck" checked>
                            <label class="form-check-label text-dark" for="isActiveCheck">
                                Producto activo (visible inmediatamente para los clientes)
                            </label>
                        </div>

                        <!-- Acciones -->
                        <div class="d-flex gap-2 justify-content-end pt-3 border-top" style="border-color: var(--border-warm) !important;">
                            <a href="{{ route('products.dashboard') }}" class="btn btn-outline-warm">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection