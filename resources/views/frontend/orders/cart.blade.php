@extends('layouts.app')

@section('title', 'Panier - KdTech')

@section('content')

<!-- Header Section -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
            <div>
                <h1 class="h2 fw-bold mb-0">Votre Panier</h1>
                <p class="text-muted mb-0">{{ count($cart) }} article{{ count($cart) > 1 ? 's' : '' }}</p>
            </div>
        </div>
    </div>
</section>

@if(count($cart) > 0)

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row gap-4">
            <!-- Products List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Produits</h5>
                        
                        <form action="{{ route('cart.update') }}" method="POST" id="cartForm">
                            @csrf
                            
                            @foreach($cart as $id => $item)
                            <div class="cart-item mb-4 pb-4 border-bottom" data-product-id="{{ $id }}">
                                <div class="row align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-lg-2 col-md-3 mb-3 mb-md-0">
                                        <div class="position-relative overflow-hidden rounded" style="aspect-ratio: 1;">
                                            <img src="{{ $item['image'] }}" class="w-100 h-100 object-fit-cover" 
                                                 alt="{{ $item['name'] }}" style="transition: transform 0.3s;">
                                        </div>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="col-lg-4 col-md-5">
                                        <h6 class="fw-bold mb-2">{{ $item['name'] }}</h6>
                                        <p class="text-muted small mb-2">SKU: <code>{{ $id }}</code></p>
                                        <p class="text-primary fw-bold">{{ number_format($item['price'], 0, ',', ' ') }} FCFA</p>
                                    </div>
                                    
                                    <!-- Quantity -->
                                    <div class="col-lg-2 col-md-2">
                                        <label class="form-label small text-muted">Quantité</label>
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary btn-decrement" type="button">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity[{{ $id }}]" 
                                                   value="{{ $item['quantity'] }}" min="1" max="10"
                                                   class="form-control text-center quantity-input">
                                            <button class="btn btn-outline-secondary btn-increment" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Subtotal -->
                                    <div class="col-lg-2 col-md-2 text-end">
                                        <label class="form-label small text-muted d-block">Sous-total</label>
                                        <span class="h6 fw-bold text-primary item-subtotal">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>
                                    
                                    <!-- Remove -->
                                    <div class="col-lg-2 col-md-1 text-end">
                                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i><span class="d-none d-sm-inline">Retirer</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Actions -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sync me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar: Summary -->
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Récapitulatif</h5>
                        
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Sous-total</span>
                            <span class="fw-semibold" id="subtotal">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="summary-item d-flex justify-content-between mb-3">
                            <span class="text-muted">Livraison</span>
                            <span class="text-success fw-semibold"><i class="fas fa-check me-1"></i>Gratuite</span>
                        </div>
                        
                        <div class="summary-item d-flex justify-content-between mb-4">
                            <span class="text-muted">Taxes</span>
                            <span class="fw-semibold">Non applicable</span>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h6 fw-bold">TOTAL</span>
                            <span class="h5 text-primary fw-bold" id="total-amount">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg w-100 mb-3 fw-semibold">
                            <i class="fas fa-lock me-2"></i>Procéder au paiement
                        </a>
                        
                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="offcanvas" data-bs-target="#discountOffcanvas">
                            <i class="fas fa-tag me-2"></i>Code promo
                        </button>
                    </div>
                </div>
                
                <!-- Security Badge -->
                <div class="alert alert-info border-0" role="alert">
                    <div class="d-flex gap-2">
                        <i class="fas fa-shield-alt text-primary fa-lg"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Paiement sécurisé</h6>
                            <small>Vos données sont chiffrées et protégées</small>
                        </div>
                    </div>
                </div>
                
                <!-- Info Cards -->
                <div class="d-flex flex-column gap-2">
                    <div class="card border-0 bg-light">
                        <div class="card-body py-3">
                            <div class="d-flex gap-2">
                                <i class="fas fa-shipping-fast text-info fa-lg"></i>
                                <div>
                                    <small class="fw-bold d-block">Livraison express</small>
                                    <small class="text-muted">Demain avant 17h</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 bg-light">
                        <div class="card-body py-3">
                            <div class="d-flex gap-2">
                                <i class="fas fa-undo text-warning fa-lg"></i>
                                <div>
                                    <small class="fw-bold d-block">Retour gratuit</small>
                                    <small class="text-muted">30 jours pour changer d'avis</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@else

<!-- Empty Cart -->
<section class="py-5">
    <div class="container">
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
            </div>
            <h2 class="fw-bold text-dark mb-3">Panier vide</h2>
            <p class="lead text-muted mb-4">Vous n'avez pas encore ajouté de produits à votre panier. Découvrez notre sélection et commencez vos achats!</p>
            
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-shopping-bag me-2"></i>Découvrir les produits
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-5">
                    <i class="fas fa-arrow-left me-2"></i>Retourner à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>

@endif

<!-- Discount Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="discountOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">Code Promo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="mb-3">
                <label for="promoCode" class="form-label fw-semibold">Entrez votre code</label>
                <input type="text" class="form-control form-control-lg" id="promoCode" placeholder="EX: PROMO2024">
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">
                <i class="fas fa-check me-2"></i>Appliquer
            </button>
        </form>
    </div>
</div>

<style>
    .cart-item {
        transition: background-color 0.2s ease;
    }
    
    .cart-item:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    .btn-increment, .btn-decrement {
        width: 36px;
        height: 36px;
        padding: 0;
    }
    
    .quantity-input {
        font-weight: bold;
        border: 1px solid #dee2e6;
    }
    
    .summary-item {
        padding: 0.5rem 0;
    }
    
    .object-fit-cover {
        object-fit: cover !important;
    }
    
    @media (max-width: 768px) {
        .sticky-top {
            position: static !important;
            margin-top: 2rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Increment/Decrement buttons
    document.querySelectorAll('.btn-increment').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value = Math.min(10, parseInt(input.value) + 1);
            updateSummary();
        });
    });
    
    document.querySelectorAll('.btn-decrement').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            input.value = Math.max(1, parseInt(input.value) - 1);
            updateSummary();
        });
    });
    
    // Update on quantity change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateSummary);
    });
    
    function updateSummary() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const priceText = item.querySelector('.text-primary.fw-bold').textContent;
            const price = parseInt(priceText.replace(/\D/g, ''));
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            const subtotal = price * quantity;
            item.querySelector('.item-subtotal').textContent = 
                new Intl.NumberFormat('fr-FR').format(subtotal) + ' FCFA';
            total += subtotal;
        });
        
        document.getElementById('subtotal').textContent = 
            new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
        document.getElementById('total-amount').textContent = 
            new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
    }
});
</script>

@endsection
