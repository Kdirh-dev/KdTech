@extends('layouts.app')

@section('title', 'Catalogue Produits - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Notre Catalogue</h1>
                <p class="text-muted">Découvrez tous nos produits électroniques</p>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Filtres -->
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm">
                            <!-- Filtre Catégorie -->
                            <div class="mb-4">
                                <h6 class="fw-bold">Catégories</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="all"
                                           id="catAll" {{ request('category') == 'all' || !request('category') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="catAll">Toutes les catégories</label>
                                </div>
                                @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $category->slug }}"
                                           id="cat{{ $category->id }}" {{ request('category') == $category->slug ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                            </div>

                            <!-- Filtre Prix -->
                            <div class="mb-4">
                                <h6 class="fw-bold">Prix</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range" value="all"
                                           id="priceAll" {{ !request('price_range') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="priceAll">Tous les prix</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range" value="0-100"
                                           id="price1" {{ request('price_range') == '0-100' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price1">0 - 100.000 FCFA</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range" value="100-500"
                                           id="price2" {{ request('price_range') == '100-500' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price2">100.000 - 500.000 FCFA</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range" value="500-1000"
                                           id="price3" {{ request('price_range') == '500-1000' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price3">500.000 - 1.000.000 FCFA</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="price_range" value="1000+"
                                           id="price4" {{ request('price_range') == '1000+' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="price4">Plus de 1.000.000 FCFA</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste Produits -->
            <div class="col-lg-9">
                <!-- Barre Recherche -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Rechercher un produit..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Résultats -->
                <div class="row mb-4">
                    <div class="col">
                        <p class="text-muted mb-0">
                            {{ $products->total() }} produit(s) trouvé(s)
                        </p>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="sortSelect">
                            <option value="newest">Nouveautés</option>
                            <option value="price_low">Prix croissant</option>
                            <option value="price_high">Prix décroissant</option>
                            <option value="name">Nom A-Z</option>
                        </select>
                    </div>
                </div>

                <!-- Grille Produits -->
                <div class="row g-4">
                    @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}"
                                    style="height: 200px; object-fit: cover;"
                                    onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
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
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Aucun produit trouvé</h4>
                        <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Voir tous les produits</a>
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
        </div>
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

.form-check {
    margin-bottom: 0.5rem;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}
</style>

<script>
document.getElementById('filterForm').addEventListener('change', function() {
    this.submit();
});

document.getElementById('sortSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', this.value);
    window.location.href = url.toString();
});
</script>
@endsection
