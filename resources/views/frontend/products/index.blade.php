@extends('layouts.app')

@section('title', 'Catalogue — KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h1 class="fw-bold display-6">Notre Catalogue</h1>
                <p class="text-muted mb-0">Trouvez les meilleurs produits électroniques — garantie & livraison rapide.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-outline-primary d-inline-flex align-items-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtersOffcanvas" aria-controls="filtersOffcanvas">
                    <i class="fas fa-filter me-2"></i>Filtres
                </button>
            </div>
        </div>

        <div class="row gx-4">
            <!-- Sidebar for large screens -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterFormDesktop" method="GET" action="{{ route('products.index') }}">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Catégories</label>
                                <div class="list-group list-group-flush">
                                    <label class="list-group-item d-flex justify-content-between align-items-center p-2">
                                        <div>
                                            <input type="radio" name="category" value="all" id="catAllDesktop" class="form-check-input me-2" {{ request('category') == 'all' || !request('category') ? 'checked' : '' }}>
                                            <span>Toutes</span>
                                        </div>
                                        <small class="text-muted">{{ $categories->count() }}</small>
                                    </label>
                                    @foreach($categories as $category)
                                    <label class="list-group-item d-flex justify-content-between align-items-center p-2">
                                        <div>
                                            <input type="radio" name="category" value="{{ $category->slug }}" id="cat{{ $category->id }}Desktop" class="form-check-input me-2" {{ request('category') == $category->slug ? 'checked' : '' }}>
                                            <span>{{ $category->name }}</span>
                                        </div>
                                        <small class="text-muted">{{ $category->products_count ?? 0 }}</small>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Prix</label>
                                <select class="form-select" name="price_range">
                                    <option value="all" {{ !request('price_range') || request('price_range') == 'all' ? 'selected' : '' }}>Tous les prix</option>
                                    <option value="0-100" {{ request('price_range') == '0-100' ? 'selected' : '' }}>0 - 100.000 FCFA</option>
                                    <option value="100-500" {{ request('price_range') == '100-500' ? 'selected' : '' }}>100.000 - 500.000 FCFA</option>
                                    <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>500.000 - 1.000.000 FCFA</option>
                                    <option value="1000+" {{ request('price_range') == '1000+' ? 'selected' : '' }}>Plus de 1.000.000 FCFA</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Disponibilité</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="in_stock" id="inStockDesktop" {{ request('in_stock') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inStockDesktop">Afficher uniquement en stock</label>
                                </div>
                            </div>

                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Appliquer</button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-2">Réinitialiser</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-3">
                    <h6 class="fw-semibold">Tendances</h6>
                    <div class="mt-3">
                        @php
                            // If controller didn't provide $featured, fall back to first products
                            $featuredList = isset($featured) ? $featured : (isset($products) ? $products->take(4) : collect());
                        @endphp

                        @foreach($featuredList as $f)
                        <a href="{{ route('products.show', $f->id) }}" class="d-flex align-items-center gap-3 text-decoration-none mb-3">
                            <img src="{{ $f->main_image }}" alt="{{ $f->name }}" style="width:48px; height:48px; object-fit:cover;" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                            <div>
                                <div class="small fw-semibold">{{ Str::limit($f->name, 40) }}</div>
                                <div class="small text-muted">{{ number_format($f->price, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">{{ $products->total() }} produit(s) trouvé(s)</p>
                    </div>
                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        <form id="searchSortForm" action="{{ route('products.index') }}" method="GET" class="d-flex justify-content-md-end gap-2">
                            <div class="input-group" style="max-width: 380px;">
                                <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>

                            <select name="sort" class="form-select ms-2" style="width: 180px;" onchange="this.form.submit()">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom A-Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row g-3">
                    @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 product-card border-0 shadow-sm">
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: cover; transition: transform .35s;" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                                </a>
                                @if($product->has_discount)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ $product->discount_percentage }}%</span>
                                @endif
                                @if($product->stock == 0)
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Rupture</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                    <h6 class="mb-1 fw-semibold">{{ Str::limit($product->name, 60) }}</h6>
                                </a>
                                <p class="text-muted small mb-3">{{ Str::limit($product->short_description ?? $product->description, 80) }}</p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 text-primary mb-0">{{ number_format($product->price, 0, ',', ' ') }} FCFA</div>
                                        @if($product->has_discount)
                                        <small class="text-muted text-decoration-line-through">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</small>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-column align-items-end">
                                        <div class="mb-2">
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary me-2">Voir</a>
                                            @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-primary">Ajouter</button>
                                            </form>
                                            @else
                                            <button class="btn btn-sm btn-secondary" disabled>Rupture</button>
                                            @endif
                                        </div>
                                        <small class="text-muted">Livraison 48h</small>
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
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Voir tous les produits</a>
                    </div>
                    @endforelse
                </div>

                <div class="row mt-4">
                    <div class="col">
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Filters (mobile) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filtersOffcanvas" aria-labelledby="filtersOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="filtersOffcanvasLabel" class="mb-0">Filtres</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="filterFormMobile" method="GET" action="{{ route('products.index') }}">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <select class="form-select" name="category">
                        <option value="all">Toutes</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Prix</label>
                    <select class="form-select" name="price_range">
                        <option value="all">Tous les prix</option>
                        <option value="0-100" {{ request('price_range') == '0-100' ? 'selected' : '' }}>0 - 100.000 FCFA</option>
                        <option value="100-500" {{ request('price_range') == '100-500' ? 'selected' : '' }}>100.000 - 500.000 FCFA</option>
                        <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>500.000 - 1.000.000 FCFA</option>
                        <option value="1000+" {{ request('price_range') == '1000+' ? 'selected' : '' }}>Plus de 1.000.000 FCFA</option>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="inStockMobile" name="in_stock" {{ request('in_stock') ? 'checked' : '' }}>
                    <label class="form-check-label" for="inStockMobile">Afficher uniquement en stock</label>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">Appliquer</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-2">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.product-card img:hover { transform: scale(1.06); }
.product-card { transition: transform .3s ease, box-shadow .3s ease; }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
@media (max-width: 991px) {
    .d-none.d-lg-block { display: none !important; }
}
</style>

<script>
// Auto-submit desktop filters when changed
document.querySelectorAll('#filterFormDesktop input, #filterFormDesktop select').forEach(el => {
    el.addEventListener('change', () => document.getElementById('filterFormDesktop').submit());
});

// Mobile: nothing fancy, standard submit
</script>
@endsection
