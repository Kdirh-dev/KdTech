@extends('layouts.app')

@section('title', 'Détails Commande - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Commande {{ $order->order_number }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimer
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Produits Commandés</h5>
                </div>
                <div class="card-body">
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
                                                <br>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
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
                                    <td colspan="3" class="text-end"><strong>Sous-total:</strong></td>
                                    <td><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Livraison:</strong></td>
                                    <td><strong class="text-success">Gratuite</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong class="h5 text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informations Client -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations Client</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Téléphone:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Adresse:</strong> {{ $order->shipping_address }}</p>

                    @if($order->user)
                    <hr>
                    <p><strong>Compte client:</strong> {{ $order->user->name }}</p>
                    <p><strong>Membre depuis:</strong> {{ $order->user->created_at->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>

            <!-- Informations Commande -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations Commande</h5>
                </div>
                <div class="card-body">
                    <p><strong>N° Commande:</strong> {{ $order->order_number }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Statut:</strong>
                        <span class="badge bg-{{ match($order->status) {
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'processing' => 'primary',
                            'shipped' => 'secondary',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                            default => 'secondary'
                        } }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Paiement:</strong>
                        <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                            {{ $order->payment_status ? 'Payé' : 'En attente' }}
                        </span>
                    </p>
                    <p><strong>Méthode:</strong> {{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label for="status{{ $order->id }}" class="form-label">Changer le statut</label>
                            <select class="form-select" id="status{{ $order->id }}" name="status" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En traitement</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                    </form>

                    @if($order->notes)
                    <div class="alert alert-info">
                        <strong>Notes du client:</strong><br>
                        {{ $order->notes }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
