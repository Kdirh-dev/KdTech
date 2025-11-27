@extends('layouts.app')

@section('title', $product->name . ' - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produits</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Images Produit -->
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ $product->main_image }}" class="img-fluid rounded" alt="{{ $product->name }}"
                            id="mainImage" style="max-height: 400px; object-fit: contain;">
                    </div>
                </div>

                @if(count($product->image_urls) > 1)
                <div class="row g-2">
                    @foreach($product->image_urls as $image)
                    <div class="col-3">
                        <img src="{{ $image }}" class="img-thumbnail" alt="{{ $product->name }}"
                            style="cursor: pointer; height: 80px; object-fit: cover;"
                            onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'"
                            onclick="document.getElementById('mainImage').src = this.src">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Informations Produit -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2 fw-bold">{{ $product->name }}</h1>

                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $product->category->name }}</span>
                            @if($product->brand)
                            <span class="badge bg-secondary">{{ $product->brand }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            @if($product->has_discount)
                            <div class="d-flex align-items-center gap-3">
                                <span class="h3 text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                <span class="h5 text-muted text-decoration-line-through">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</span>
                                <span class="badge bg-danger fs-6">-{{ $product->discount_percentage }}%</span>
                            </div>
                            @else
                            <span class="h3 text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>

                        <!-- Stock -->
                        <div class="mb-4">
                            @if($product->stock > 0)
                            <span class="text-success">
                                <i class="fas fa-check-circle me-1"></i>En stock ({{ $product->stock }} disponible(s))
                            </span>
                            @else
                            <span class="text-danger">
                                <i class="fas fa-times-circle me-1"></i>Rupture de stock
                            </span>
                            @endif
                        </div>

                        <!-- Caractéristiques -->
                        @if($product->features && count($product->features) > 0)
                        <div class="mb-4">
                            <h5>Caractéristiques</h5>
                            <ul class="list-unstyled">
                                @foreach($product->features as $feature)
                                <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="d-grid gap-2 d-md-flex">
                            @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Ajouter au Panier
                                </button>
                            </form>
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-bolt me-2"></i>Acheter Maintenant
                            </a>
                            @else
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="fas fa-times me-2"></i>Rupture de Stock
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produits Similaires -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col">
                <h3 class="fw-bold mb-4">Produits Similaires</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                <img src="{{ $relatedProduct->main_image }}" class="card-img-top" alt="{{ $relatedProduct->name }}"
                                     style="height: 200px; object-fit: cover;">
                                @if($relatedProduct->has_discount)
                                <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                                    -{{ $relatedProduct->discount_percentage }}%
                                </span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 text-primary mb-0">{{ number_format($relatedProduct->price, 0, ',', ' ') }} FCFA</span>
                                        @if($relatedProduct->has_discount)
                                        <small class="text-muted text-decoration-line-through">
                                            {{ number_format($relatedProduct->compare_price, 0, ',', ' ') }} FCFA
                                        </small>
                                        @endif
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm">
                                            Voir Détails
                                        </a>
                                        @if($relatedProduct->stock > 0)
                                        <form action="{{ route('cart.add', $relatedProduct->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus me-1"></i>Ajouter
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
