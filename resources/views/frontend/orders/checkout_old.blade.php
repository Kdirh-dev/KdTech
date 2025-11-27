@extends('layouts.app')

@section('title', 'Checkout - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="fw-bold mb-5">Finaliser la Commande</h1>

        @if(count($cart) > 0)
        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Informations Client -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informations de Livraison</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Nom Complet *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                           id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                           id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                       id="customer_phone" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Adresse de Livraison *</label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                          id="shipping_address" name="shipping_address" rows="3"
                                          placeholder="Adresse complète pour la livraison..." required>{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes (Optionnel)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"
                                          placeholder="Instructions spéciales pour la livraison...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Méthode de Paiement -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Méthode de Paiement</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method"
                                       id="cash" value="cash" checked>
                                <label class="form-check-label" for="cash">
                                    <i class="fas fa-money-bill-wave me-2"></i>Paiement à la Livraison (Cash)
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method"
                                       id="mobile" value="mobile_money">
                                <label class="form-check-label" for="mobile">
                                    <i class="fas fa-mobile-alt me-2"></i>Mobile Money
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method"
                                       id="bank" value="bank_transfer">
                                <label class="form-check-label" for="bank">
                                    <i class="fas fa-university me-2"></i>Virement Bancaire
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Récapitulatif Commande -->
                <div class="col-lg-4">
                    <div class="card sticky-top" style="top: 100px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Récapitulatif de Commande</h5>
                        </div>
                        <div class="card-body">
                            <!-- Produits -->
                            <div class="mb-3">
                                <h6>Produits</h6>
                                @foreach($cart as $id => $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div>
                                        <small class="fw-bold">{{ $item['name'] }}</small>
                                        <br>
                                        <small class="text-muted">{{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', ' ') }} FCFA</small>
                                    </div>
                                    <small class="fw-bold">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</small>
                                </div>
                                @endforeach
                            </div>

                            <!-- Totaux -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sous-total:</span>
                                    <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Livraison:</span>
                                    <span class="text-success">Gratuite</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="h5 text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-lock me-2"></i>Confirmer la Commande
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    En confirmant, vous acceptez nos
                                    <a href="#">conditions générales</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
            <h3 class="text-muted">Votre panier est vide</h3>
            <p class="text-muted mb-4">Ajoutez des produits avant de procéder au paiement</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
            </a>
        </div>
        @endif
    </div>
</section>

<style>
.sticky-top {
    position: -webkit-sticky;
    position: sticky;
    z-index: 1020;
}
</style>
@endsection
