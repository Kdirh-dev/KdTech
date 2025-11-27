@extends('layouts.app')

@section('title', 'Mes Commandes - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.user.partials.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Mes Commandes</h4>
                    </div>
                    <div class="card-body">
                        @forelse($orders as $order)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <strong>{{ $order->order_number }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Aucune commande</h4>
                            <p class="text-muted mb-4">Vous n'avez pas encore passé de commande.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
                            </a>
                        </div>
                        @endforelse

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
