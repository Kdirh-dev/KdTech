@extends('layouts.app')

@section('title', 'Détails Réparation - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Réparation {{ $repair->repair_number }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-secondary">
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
                    <h5 class="mb-0">Informations de la Réparation</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Description du problème</th>
                            <td>{{ $repair->issue_description }}</td>
                        </tr>
                        <tr>
                            <th>Type d'appareil</th>
                            <td>{{ $repair->device_type }}</td>
                        </tr>
                        <tr>
                            <th>Marque</th>
                            <td>{{ $repair->device_brand }}</td>
                        </tr>
                        <tr>
                            <th>Modèle</th>
                            <td>{{ $repair->device_model }}</td>
                        </tr>
                        <tr>
                            <th>Statut</th>
                            <td>
                                <span class="badge bg-{{ $repair->status_color }} fs-6">
                                    {{ ucfirst($repair->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Coût estimé</th>
                            <td>
                                @if($repair->estimated_cost)
                                <strong class="text-primary">{{ number_format($repair->estimated_cost, 0, ',', ' ') }} FCFA</strong>
                                @else
                                <span class="text-muted">En attente d'estimation</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Coût final</th>
                            <td>
                                @if($repair->final_cost)
                                <strong class="text-success">{{ number_format($repair->final_cost, 0, ',', ' ') }} FCFA</strong>
                                @else
                                <span class="text-muted">À déterminer</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date estimation livraison</th>
                            <td>
                                @if($repair->estimated_completion)
                                <strong>{{ $repair->estimated_completion->format('d/m/Y') }}</strong>
                                @else
                                <span class="text-muted">Non définie</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($repair->technician_notes)
                    <div class="mt-4">
                        <h6>Notes du technicien</h6>
                        <div class="alert alert-info">
                            {{ $repair->technician_notes }}
                        </div>
                    </div>
                    @endif
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
                    <p><strong>Nom:</strong> {{ $repair->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $repair->customer_email }}</p>
                    <p><strong>Téléphone:</strong> {{ $repair->customer_phone }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <!-- Changer statut -->
                    <form action="{{ route('admin.repairs.updateStatus', $repair->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label for="status{{ $repair->id }}" class="form-label">Changer le statut</label>
                            <select class="form-select" id="status{{ $repair->id }}" name="status" required>
                                <option value="pending" {{ $repair->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="diagnosis" {{ $repair->status == 'diagnosis' ? 'selected' : '' }}>Diagnostic</option>
                                <option value="repairing" {{ $repair->status == 'repairing' ? 'selected' : '' }}>En réparation</option>
                                <option value="repaired" {{ $repair->status == 'repaired' ? 'selected' : '' }}>Réparé</option>
                                <option value="ready" {{ $repair->status == 'ready' ? 'selected' : '' }}>Prêt à récupérer</option>
                                <option value="delivered" {{ $repair->status == 'delivered' ? 'selected' : '' }}>Récupéré</option>
                                <option value="cancelled" {{ $repair->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                    </form>

                    <!-- Mettre à jour le devis -->
                    <form action="{{ route('admin.repairs.updateEstimate', $repair->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="estimated_cost" class="form-label">Coût estimé (FCFA)</label>
                            <input type="number" step="0.01" class="form-control"
                                   id="estimated_cost" name="estimated_cost"
                                   value="{{ old('estimated_cost', $repair->estimated_cost) }}">
                        </div>
                        <div class="mb-3">
                            <label for="estimated_completion" class="form-label">Date estimation livraison</label>
                            <input type="date" class="form-control"
                                   id="estimated_completion" name="estimated_completion"
                                   value="{{ old('estimated_completion', $repair->estimated_completion?->format('Y-m-d')) }}">
                        </div>
                        <div class="mb-3">
                            <label for="technician_notes" class="form-label">Notes du technicien</label>
                            <textarea class="form-control" id="technician_notes" name="technician_notes"
                                      rows="3">{{ old('technician_notes', $repair->technician_notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Mettre à jour le devis</button>
                    </form>
                </div>
            </div>

            <!-- Informations Techniques -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations Techniques</h5>
                </div>
                <div class="card-body">
                    <p><strong>N° Réparation:</strong> {{ $repair->repair_number }}</p>
                    <p><strong>Créé le:</strong> {{ $repair->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Modifié le:</strong> {{ $repair->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
