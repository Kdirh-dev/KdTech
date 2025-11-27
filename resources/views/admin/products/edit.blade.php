@extends('layouts.app')

@section('title', 'Modifier le Produit - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Modifier le Produit</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom du produit *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Catégorie *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">Choisir une catégorie</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Prix (FCFA) *</label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="compare_price" class="form-label">Prix de comparaison</label>
                                <input type="number" step="0.01" class="form-control @error('compare_price') is-invalid @enderror"
                                       id="compare_price" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}">
                                @error('compare_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                       id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label">Marque</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                       id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                       id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Caractéristiques</label>
                            <input type="text" class="form-control"
                                   id="features" name="features"
                                   placeholder="Séparer par des virgules (ex: Écran 6.1, 128GB, Double caméra)"
                                   value="{{ old('features', $product->features ? implode(', ', $product->features) : '') }}">
                        </div>

                        <!-- Section Images Simplifiée -->
                        <div class="mb-4">
                            <label for="images" class="form-label">Nouvelles images</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                   id="images" name="images[]" multiple accept="image/*">
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Laissez vide pour garder les images actuelles. Formats: JPG, PNG, GIF, WEBP. Max: 5MB par image.
                            </div>
                        </div>

                        <!-- Aperçu des images actuelles -->
                        @if($product->images && count($product->images) > 0)
                        <div class="mb-4">
                            <label class="form-label">Images actuelles</label>
                            <div class="border rounded p-3">
                                <div class="row g-2">
                                    @foreach($product->images as $image)
                                    <div class="col-xl-3 col-lg-4 col-md-6 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ $image }}" class="img-thumbnail w-100"
                                                 style="height: 100px; object-fit: cover;"
                                                 alt="Image produit">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Aperçu des nouvelles images -->
                        <div class="mb-4">
                            <label class="form-label">Aperçu des nouvelles images</label>
                            <div class="border rounded p-3">
                                <div id="image-preview" class="row g-2">
                                    <div class="col-12">
                                        <p class="text-muted small mb-0">Aucune nouvelle image sélectionnée</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                           id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Produit en vedette</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                           id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Produit actif</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations du Produit</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}"
                             class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <p><strong>Slug:</strong> {{ $product->slug }}</p>
                    <p><strong>Créé le:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Modifié le:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-eye me-1"></i>Voir en public
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-preview-item {
    position: relative;
}

.image-preview-item img {
    height: 100px;
    object-fit: cover;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 255, 255, 0.8);
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview');

    fileInput.addEventListener('change', function(e) {
        previewContainer.innerHTML = '';

        if (this.files.length > 0) {
            Array.from(this.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-xl-3 col-lg-4 col-md-6 mb-2';
                        col.innerHTML = `
                            <div class="image-preview-item">
                                <img src="${e.target.result}" class="img-thumbnail w-100" alt="Preview">
                                <button type="button" class="remove-image" onclick="removeImage(${index})">
                                    <i class="fas fa-times text-danger"></i>
                                </button>
                            </div>
                        `;
                        previewContainer.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        } else {
            previewContainer.innerHTML = `
                <div class="col-12">
                    <p class="text-muted small mb-0">Aucune nouvelle image sélectionnée</p>
                </div>
            `;
        }
    });
});

function removeImage(index) {
    const dt = new DataTransfer();
    const fileInput = document.getElementById('images');

    Array.from(fileInput.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });

    fileInput.files = dt.files;
    const event = new Event('change');
    fileInput.dispatchEvent(event);
}
</script>
@endsection
