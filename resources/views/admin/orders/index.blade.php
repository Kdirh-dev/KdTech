@extends('layouts.app')

@section('title', 'Gestion des Commandes - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Gestion des Commandes</h1>
        <div class="btn-group">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimer
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $order->customer_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ match($order->status) {
                                    'pending' => 'warning',
                                    'confirmed' => 'info',
                                    'processing' => 'primary',
                                    'shipped' => 'secondary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                } }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status ? 'success' : 'warning' }}">
                                    {{ $order->payment_status ? 'Payé' : 'En attente' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $order->payment_method }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning btn-edit-status"
                                            data-action="{{ route('admin.orders.updateStatus', $order->id) }}"
                                            data-status="{{ $order->status }}"
                                            data-order-id="{{ $order->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>

                                    <!-- per-row modal removed in favor of reusable modal -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucune commande trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>

    <!-- Reusable modal for updating order status -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer le statut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusModalForm" action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Nouveau statut</label>
                            <select class="form-select" id="statusSelect" name="status" required>
                                <option value="pending">En attente</option>
                                <option value="confirmed">Confirmée</option>
                                <option value="processing">En traitement</option>
                                <option value="shipped">Expédiée</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('statusModal');
    const statusSelect = document.getElementById('statusSelect');
    const statusForm = document.getElementById('statusModalForm');
    const bsModal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.btn-edit-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.dataset.action;
            const status = this.dataset.status;
            // set form action
            statusForm.action = action;
            // set select value
            if (status) {
                statusSelect.value = status;
            } else {
                statusSelect.selectedIndex = 0;
            }
            bsModal.show();
        });
    });
});
</script>
@endpush
