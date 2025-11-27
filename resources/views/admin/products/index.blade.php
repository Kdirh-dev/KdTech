@extends('layouts.app')

@section('title', 'Gestion des Produits - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Gestion des Produits</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un Produit
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->main_image }}"
                                     alt="{{ $product->name }}"
                                     style="width: 50px; height: 50px; object-fit: cover;"
                                     class="rounded">
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured)
                                <span class="badge bg-warning ms-1">Featured</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.delete', $product->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucun produit trouvé</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                    Ajouter le premier produit
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
