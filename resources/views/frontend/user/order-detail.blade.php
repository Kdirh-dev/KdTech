@extends('layouts.app')

@section('title', 'Détail Commande - KdTech')

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
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Commande {{ $order->order_number }}</h4>
                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : 'warning' }} fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Informations Commande -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Informations de Livraison</h6>
                                <p class="mb-1"><strong>Nom:</strong> {{ $order->customer_name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                                <p class="mb-1"><strong>Téléphone:</strong> {{ $order->customer_phone }}</p>
                                <p class="mb-0"><strong>Adresse:</strong> {{ $order->shipping_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Informations de Paiement</h6>
                                <p class="mb-1"><strong>Méthode:</strong> {{ ucfirst($order->payment_method) }}</p>
                                <p class="mb-1"><strong>Statut Paiement:</strong>
                                    <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                                        {{ $order->payment_status ? 'Payé' : 'En attente' }}
                                    </span>
                                </p>
                                <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Produits Commandés -->
                        <h6>Produits Commandés</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->main_image }}"
                                                     alt="{{ $item->product->name }}"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     class="rounded me-3">
                                                <div>
                                                    <strong>{{ $item->product->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->total_price, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($order->notes)
                        <div class="alert alert-info mt-3">
                            <strong>Notes:</strong> {{ $order->notes }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
