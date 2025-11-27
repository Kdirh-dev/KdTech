@extends('layouts.app')

@section('title', 'Mon Tableau de Bord - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <!-- Sidebar Profil -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <h5>{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier le profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Menu Utilisateur -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action active">
                                <i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord
                            </a>
                            <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-bag me-2"></i>Mes Commandes
                            </a>
                            <a href="{{ route('user.repairs') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-tools me-2"></i>Mes Réparations
                            </a>
                            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-user me-2"></i>Mon Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Tableau de Bord</h4>
                    </div>
                    <div class="card-body">
                        <!-- Statistiques Rapides -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $recentOrders->count() }}</h3>
                                        <p class="mb-0">Commandes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $recentRepairs->count() }}</h3>
                                        <p class="mb-0">Réparations</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ Auth::user()->created_at->diffForHumans() }}</h3>
                                        <p class="mb-0">Membre depuis</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Commandes Récentes -->
                        <div class="mb-4">
                            <h5>Commandes Récentes</h5>
                            @forelse($recentOrders as $order)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <strong>{{ $order->order_number }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>
                                            <br>
                                            <a href="{{ route('user.order.detail', $order->id) }}" class="btn btn-sm btn-outline-primary mt-1">
                                                Détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucune commande récente</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Faire des achats</a>
                            </div>
                            @endforelse
                        </div>

                        <!-- Réparations Récentes -->
                        <div>
                            <h5>Réparations Récentes</h5>
                            @forelse($recentRepairs as $repair)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <strong>{{ $repair->repair_number }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $repair->device_brand }} {{ $repair->device_model }}</small>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-{{ $repair->status_color }}">
                                                {{ ucfirst($repair->status) }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <small class="text-muted">{{ $repair->created_at->format('d/m/Y') }}</small>
                                            <br>
                                            <a href="{{ route('repairs.track') }}?repair_number={{ $repair->repair_number }}" class="btn btn-sm btn-outline-primary mt-1">
                                                Suivre
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-tools fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucune réparation récente</p>
                                <a href="{{ route('repairs.index') }}" class="btn btn-primary">Demander une réparation</a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
