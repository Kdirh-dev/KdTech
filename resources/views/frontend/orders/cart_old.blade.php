@extends('layouts.app')

@section('title', 'Panier - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-5">Votre Panier</h1>

        @if(count($cart) > 0)
        <div class="row">
            <!-- Liste des produits -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            @foreach($cart as $id => $item)
                            <div class="row align-items-center mb-4 pb-4 border-bottom">
                                <div class="col-md-2">
                                    <img src="{{ $item['image'] }}" class="img-fluid rounded"
                                         alt="{{ $item['name'] }}" style="height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">{{ $item['name'] }}</h6>
                                    <p class="text-muted small mb-0">Réf: {{ $id }}</p>
                                </div>
                                <div class="col-md-2">
                                    <span class="h6 text-primary">{{ number_format($item['price'], 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="quantity[{{ $id }}]"
                                           value="{{ $item['quantity'] }}" min="1" max="10"
                                           class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                    <span class="h6">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sync me-2"></i>Mettre à jour le panier
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Récapitulatif -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Récapitulatif</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Sous-total:</span>
                            <span class="fw-bold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Livraison:</span>
                            <span class="fw-bold">Gratuite</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total:</span>
                            <span class="h5 text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-lock me-2"></i>Procéder au paiement
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h3 class="text-muted">Votre panier est vide</h3>
            <p class="text-muted mb-4">Découvrez nos produits et ajoutez-les à votre panier</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
