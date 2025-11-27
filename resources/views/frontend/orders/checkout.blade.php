@extends('layouts.app')

@section('title', 'Checkout - KdTech')

@section('content')

<!-- Stepper Header -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                        1
                    </div>
                    <small class="mt-2 fw-semibold">Livraison</small>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                        2
                    </div>
                    <small class="mt-2 fw-semibold">Paiement</small>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                        3
                    </div>
                    <small class="mt-2 fw-semibold">Confirmation</small>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                        <i class="fas fa-check"></i>
                    </div>
                    <small class="mt-2 fw-semibold">Succès</small>
                </div>
            </div>
        </div>
    </div>
</section>

@if(count($cart) > 0)

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row gap-4">
                <!-- Left Column: Forms -->
                <div class="col-lg-8">
                    <!-- Shipping Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-map-marker-alt"></i>
                                <h5 class="mb-0">Informations de Livraison</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label fw-semibold">Nom Complet</label>
                                    <input type="text" class="form-control form-control-lg @error('customer_name') is-invalid @enderror"
                                           id="customer_name" name="customer_name" 
                                           value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                           placeholder="Jean Dupont" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control form-control-lg @error('customer_email') is-invalid @enderror"
                                           id="customer_email" name="customer_email" 
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                           placeholder="jean@example.com" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="customer_phone" class="form-label fw-semibold">Téléphone</label>
                                    <input type="tel" class="form-control form-control-lg @error('customer_phone') is-invalid @enderror"
                                           id="customer_phone" name="customer_phone" 
                                           value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                           placeholder="+228 XX XX XX XX" required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="shipping_address" class="form-label fw-semibold">Adresse de Livraison</label>
                                    <textarea class="form-control form-control-lg @error('shipping_address') is-invalid @enderror"
                                              id="shipping_address" name="shipping_address" rows="3"
                                              placeholder="Rue, numéro, quartier, Lomé..."
                                              required>{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="notes" class="form-label fw-semibold">Notes de Livraison (Optionnel)</label>
                                    <textarea class="form-control"
                                              id="notes" name="notes" rows="2"
                                              placeholder="Ex: Sonner à la porte, étage 3...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-credit-card"></i>
                                <h5 class="mb-0">Méthode de Paiement</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <!-- Cash Payment -->
                                <div class="col-12">
                                    <div class="form-check p-3 border rounded-3" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="cash" value="cash" checked>
                                        <label class="form-check-label w-100 mb-0" for="cash" style="cursor: pointer;">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                                <div>
                                                    <strong class="d-block">Paiement à la Livraison</strong>
                                                    <small class="text-muted">Payez au livreur avec espèces</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Mobile Money -->
                                <div class="col-12">
                                    <div class="form-check p-3 border rounded-3" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="mobile" value="mobile_money">
                                        <label class="form-check-label w-100 mb-0" for="mobile" style="cursor: pointer;">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="fas fa-mobile-alt fa-2x text-info"></i>
                                                <div>
                                                    <strong class="d-block">Mobile Money</strong>
                                                    <small class="text-muted">Virement instantané via téléphone</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Bank Transfer -->
                                <div class="col-12">
                                    <div class="form-check p-3 border rounded-3" style="cursor: pointer;">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="bank" value="bank_transfer">
                                        <label class="form-check-label w-100 mb-0" for="bank" style="cursor: pointer;">
                                            <div class="d-flex align-items-center gap-3">
                                                <i class="fas fa-university fa-2x text-warning"></i>
                                                <div>
                                                    <strong class="d-block">Virement Bancaire</strong>
                                                    <small class="text-muted">Transférez depuis votre compte bancaire</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-bold">Récapitulatif de Commande</h5>
                        </div>
                        <div class="card-body p-4">
                            <!-- Products List -->
                            <div class="mb-4 pb-4 border-bottom">
                                <h6 class="fw-bold mb-3">Produits</h6>
                                @foreach($cart as $id => $item)
                                <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                    <div class="flex-grow-1">
                                        <small class="fw-bold d-block mb-1">{{ Str::limit($item['name'], 30) }}</small>
                                        <small class="text-muted">
                                            {{ $item['quantity'] }} × {{ number_format($item['price'], 0, ',', ' ') }} FCFA
                                        </small>
                                    </div>
                                    <small class="fw-bold text-primary ms-2">
                                        {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA
                                    </small>
                                </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Sous-total</span>
                                    <span class="fw-semibold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Livraison</span>
                                    <span class="text-success fw-semibold"><i class="fas fa-check me-1"></i>Gratuite</span>
                                </div>
                            </div>

                            <hr>

                            <!-- Total -->
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">TOTAL</span>
                                <span class="h5 text-primary fw-bold">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3 fw-semibold">
                                <i class="fas fa-check-circle me-2"></i>Confirmer la Commande
                            </button>

                            <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100 mb-3">
                                <i class="fas fa-arrow-left me-2"></i>Retour au Panier
                            </a>

                            <!-- Security Info -->
                            <div class="alert alert-info border-0 p-3" role="alert">
                                <div class="d-flex gap-2">
                                    <i class="fas fa-shield-alt text-info"></i>
                                    <small class="mb-0">
                                        Votre commande et vos données sont 100% sécurisées
                                    </small>
                                </div>
                            </div>

                            <!-- Terms -->
                            <small class="text-muted text-center d-block">
                                En confirmant, vous acceptez nos
                                <a href="#" class="text-decoration-none">conditions générales</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@else

<!-- Empty Cart -->
<section class="py-5">
    <div class="container">
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h2 class="fw-bold text-dark mb-3">Panier vide</h2>
            <p class="lead text-muted mb-4">Vous ne pouvez pas procéder au paiement avec un panier vide</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
            </a>
        </div>
    </div>
</section>

@endif

<style>
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.375rem;
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    @media (max-width: 768px) {
        .sticky-top {
            position: static !important;
            margin-top: 2rem;
        }
    }
</style>

@endsection
