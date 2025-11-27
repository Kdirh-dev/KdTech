@extends('layouts.app')

@section('title', 'Dashboard Admin - KdTech')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête avec lien boutique -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Tableau de Bord Administrateur</h1>
        <div class="btn-group">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-success">
                <i class="fas fa-store me-2"></i>Voir la Boutique
            </a>
            <button class="btn btn-outline-primary">
                <i class="fas fa-sync-alt me-2"></i>Actualiser
            </button>
        </div>
    </div>

    <!-- Cartes Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['total_products'] }}</h4>
                            <p class="mb-0">Produits</p>
                        </div>
                        <div class="feature-icon">
                            <i class="fas fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['total_orders'] }}</h4>
                            <p class="mb-0">Commandes</p>
                        </div>
                        <div class="feature-icon">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['total_repairs'] }}</h4>
                            <p class="mb-0">Réparations</p>
                        </div>
                        <div class="feature-icon">
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ number_format($stats['revenue'], 0, ',', ' ') }} FCFA</h4>
                            <p class="mb-0">Chiffre d'Affaires</p>
                        </div>
                        <div class="feature-icon">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Commandes Récentes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Commandes Récentes</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="card-body">
                    @forelse($recentOrders as $order)
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">{{ $order->order_number }}</h6>
                            <small class="text-muted">{{ $order->customer_name }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }} mb-2">
                                {{ ucfirst($order->status) }}
                            </span>
                            <br>
                            <small class="text-muted">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Aucune commande récente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Réparations Récentes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Réparations Récentes</h5>
                    <a href="{{ route('admin.repairs.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="card-body">
                    @forelse($recentRepairs as $repair)
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1">{{ $repair->repair_number }}</h6>
                            <small class="text-muted">{{ $repair->device_brand }} {{ $repair->device_model }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $repair->status_color }} mb-2">
                                {{ ucfirst($repair->status) }}
                            </span>
                            <br>
                            <small class="text-muted">{{ $repair->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-tools fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Aucune réparation récente</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Accès Rapide Admin -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Accès Rapide Administration</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('admin.products.index') }}" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-primary mb-2">
                                        <i class="fas fa-boxes fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Produits</h6>
                                    <small class="text-muted">Gestion stock</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('admin.orders.index') }}" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-success mb-2">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Commandes</h6>
                                    <small class="text-muted">Suivi clients</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('admin.repairs.index') }}" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-warning mb-2">
                                        <i class="fas fa-tools fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Réparations</h6>
                                    <small class="text-muted">Services</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('admin.products.create') }}" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-info mb-2">
                                        <i class="fas fa-plus-circle fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Nouveau</h6>
                                    <small class="text-muted">Ajouter produit</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('home') }}" target="_blank" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-success mb-2">
                                        <i class="fas fa-store fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Boutique</h6>
                                    <small class="text-muted">Voir le site</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-4 col-6">
                            <a href="{{ route('admin.settings.index') }}" class="card admin-quick-link text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-warning mb-2">
                                        <i class="fas fa-cog fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Paramètres</h6>
                                    <small class="text-muted">Site & Images</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes et Actions Rapides -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Alertes & Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($stats['pending_orders'] > 0)
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <strong>{{ $stats['pending_orders'] }} commande(s) en attente</strong>
                                    <p class="mb-0">Nécessitent votre attention</p>
                                </div>
                            </div>
                            @endif

                            @if($stats['pending_repairs'] > 0)
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-tools fa-2x me-3"></i>
                                <div>
                                    <strong>{{ $stats['pending_repairs'] }} réparation(s) en attente</strong>
                                    <p class="mb-0">En attente de diagnostic</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-plus me-2"></i>Ajouter un Produit
                                </a>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning">
                                    <i class="fas fa-chart-bar me-2"></i>Voir les Commandes
                                </a>
                                <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-info">
                                    <i class="fas fa-tools me-2"></i>Gérer les Réparations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.feature-icon {
    opacity: 0.8;
}

.admin-quick-link {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.admin-quick-link:hover {
    transform: translateY(-5px);
    border-color: #0d6efd;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.admin-quick-link .feature-icon {
    transition: transform 0.3s ease;
}

.admin-quick-link:hover .feature-icon {
    transform: scale(1.1);
}
</style>
@endsection
