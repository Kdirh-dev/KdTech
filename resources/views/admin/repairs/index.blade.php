@extends('layouts.app')

@section('title', 'Gestion des Réparations - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Gestion des Réparations</h1>
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
                            <th>N° Réparation</th>
                            <th>Client</th>
                            <th>Appareil</th>
                            <th>Problème</th>
                            <th>Coût Estimé</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($repairs as $repair)
                        <tr>
                            <td>
                                <strong>{{ $repair->repair_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $repair->customer_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $repair->customer_email }}</small>
                                    <br>
                                    <small class="text-muted">{{ $repair->customer_phone }}</small>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $repair->device_brand }}</strong>
                                <br>
                                <small class="text-muted">{{ $repair->device_model }}</small>
                                <br>
                                <small class="text-muted">{{ $repair->device_type }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($repair->issue_description, 50) }}</small>
                            </td>
                            <td>
                                @if($repair->estimated_cost)
                                <strong class="text-primary">{{ number_format($repair->estimated_cost, 0, ',', ' ') }} FCFA</strong>
                                @else
                                <span class="text-muted">En attente</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $repair->status_color }} fs-6">
                                    {{ ucfirst($repair->status) }}
                                </span>
                            </td>
                            <td>{{ $repair->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.repairs.show', $repair->id) }}"
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning btn-edit-repair-status"
                                            data-action="{{ route('admin.repairs.updateStatus', $repair->id) }}"
                                            data-status="{{ $repair->status }}"
                                            data-repair-id="{{ $repair->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>

                                <!-- per-row modal removed in favor of reusable repair modal -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-tools fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucune réparation trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $repairs->links() }}
        </div>
    </div>

    <!-- Reusable modal for updating repair status -->
    <div class="modal fade" id="repairStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer le statut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="repairStatusModalForm" action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="repairStatusSelect" class="form-label">Nouveau statut</label>
                            <select class="form-select" id="repairStatusSelect" name="status" required>
                                <option value="pending">En attente</option>
                                <option value="diagnosis">Diagnostic</option>
                                <option value="repairing">En réparation</option>
                                <option value="repaired">Réparé</option>
                                <option value="ready">Prêt à récupérer</option>
                                <option value="delivered">Récupéré</option>
                                <option value="cancelled">Annulé</option>
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
    const modalEl = document.getElementById('repairStatusModal');
    const statusSelect = document.getElementById('repairStatusSelect');
    const statusForm = document.getElementById('repairStatusModalForm');
    const bsModal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.btn-edit-repair-status').forEach(btn => {
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
