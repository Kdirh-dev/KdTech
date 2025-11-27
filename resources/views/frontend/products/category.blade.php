@extends('layouts.app')

@section('title', $category->name . ' - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <!-- En-tête de la catégorie -->
        <div class="row mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produits</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold">{{ $category->name }}</h1>
                        <p class="text-muted mb-0">{{ $category->description }}</p>
                    </div>
                    <span class="badge bg-primary fs-6">{{ $products->total() }} produit(s)</span>
                </div>
            </div>
        </div>

        <!-- Produits de la catégorie -->
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 product-card">
                    <div class="position-relative">
                        <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}"
                             style="height: 200px; object-fit: cover;">
                        @if($product->has_discount)
                        <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                            -{{ $product->discount_percentage }}%
                        </span>
                        @endif
                        @if($product->stock == 0)
                        <span class="position-absolute top-0 end-0 badge bg-warning m-2">Rupture</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ Str::limit($product->name, 50) }}</h6>
                        <p class="card-text text-muted small mb-2">{{ Str::limit($product->description, 60) }}</p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h6 text-primary mb-0">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                @if($product->has_discount)
                                <small class="text-muted text-decoration-line-through">
                                    {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                                </small>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Voir Détails
                                </a>
                                @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-cart-plus me-1"></i>Ajouter
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    <i class="fas fa-times me-1"></i>Rupture
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun produit dans cette catégorie</h4>
                <p class="text-muted mb-4">Revenez bientôt pour découvrir de nouveaux produits.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Voir tous les produits
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="row mt-4">
            <div class="col">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </div>
</section>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

.breadcrumb {
    background: transparent;
    padding: 0;
}
</style>
@endsection
