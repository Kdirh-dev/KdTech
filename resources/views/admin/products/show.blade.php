@extends('layouts.app')

@section('title', $product->name . ' - KdTech Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Détails du Produit</h1>
        <div class="btn-group">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}"
                             class="img-fluid rounded" style="max-height: 300px;">
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nom</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Catégorie</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $product->description }}</td>
                        </tr>
                        <tr>
                            <th>Prix</th>
                            <td>
                                <strong class="text-primary">{{ number_format($product->price, 0, ',', ' ') }} FCFA</strong>
                                @if($product->has_discount)
                                <br>
                                <small class="text-muted text-decoration-line-through">
                                    {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                                </small>
                                <span class="badge bg-danger ms-2">-{{ $product->discount_percentage }}%</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6">
                                    {{ $product->stock }} unité(s)
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Marque</th>
                            <td>{{ $product->brand ?? 'Non spécifiée' }}</td>
                        </tr>
                        <tr>
                            <th>SKU</th>
                            <td>{{ $product->sku ?? 'Non spécifié' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statut et Caractéristiques</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Statut</th>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }} fs-6">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>En vedette</th>
                            <td>
                                <span class="badge bg-{{ $product->is_featured ? 'warning' : 'secondary' }} fs-6">
                                    {{ $product->is_featured ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $product->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Créé le</th>
                            <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Modifié le</th>
                            <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    @if($product->features && count($product->features) > 0)
                    <div class="mt-4">
                        <h6>Caractéristiques</h6>
                        <ul class="list-group">
                            @foreach($product->features as $feature)
                            <li class="list-group-item">
                                <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($product->images && count($product->images) > 1)
                    <div class="mt-4">
                        <h6>Galerie d'images</h6>
                        <div class="row g-2">
                            @foreach($product->images as $image)
                            <div class="col-4">
                                <img src="{{ $image }}" alt="{{ $product->name }}"
                                     class="img-thumbnail" style="height: 80px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Zone Danger</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Ces actions sont irréversibles. Soyez certain de ce que vous faites.
                    </p>
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit? Cette action est irréversible.')">
                            <i class="fas fa-trash me-2"></i>Supprimer le produit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
