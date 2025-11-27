@extends('layouts.app')

@section('title', 'Suivi Réparation - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <h1 class="text-center fw-bold mb-5">Suivi de Réparation</h1>

                <!-- Formulaire Recherche -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('repairs.track') }}" method="GET">
                            <div class="mb-3">
                                <label for="repair_number" class="form-label">Numéro de Réparation</label>
                                <input type="text" class="form-control" id="repair_number" name="repair_number"
                                       placeholder="Ex: REP202412340001" value="{{ request('repair_number') }}" required>
                                <div class="form-text">
                                    Entrez le numéro de réparation reçu lors de votre demande.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Résultats -->
                @if(request()->has('repair_number'))
                    @if($repair)
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">État de la Réparation</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <strong>Numéro:</strong> {{ $repair->repair_number }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Date:</strong> {{ $repair->created_at->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <strong>Appareil:</strong> {{ $repair->device_brand }} {{ $repair->device_model }} ({{ $repair->device_type }})
                                </div>
                            </div>

                            <!-- Barre de Progression -->
                            <div class="mb-4">
                                @php
                                    $statuses = [
                                        'pending' => ['Étape' => 'En attente', 'Pourcentage' => 20],
                                        'diagnosis' => ['Étape' => 'Diagnostic', 'Pourcentage' => 40],
                                        'repairing' => ['Étape' => 'En réparation', 'Pourcentage' => 60],
                                        'repaired' => ['Étape' => 'Réparé', 'Pourcentage' => 80],
                                        'ready' => ['Étape' => 'Prêt à récupérer', 'Pourcentage' => 90],
                                        'delivered' => ['Étape' => 'Récupéré', 'Pourcentage' => 100]
                                    ];
                                    $currentStatus = $statuses[$repair->status] ?? ['Étape' => 'Inconnu', 'Pourcentage' => 0];
                                @endphp

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Statut actuel:</span>
                                    <span class="fw-bold text-primary">{{ $currentStatus['Étape'] }}</span>
                                </div>

                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $currentStatus['Pourcentage'] }}%">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <span class="badge bg-{{ $repair->status_color }} fs-6">
                                        {{ strtoupper($repair->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Informations Complémentaires -->
                            @if($repair->estimated_cost)
                            <div class="alert alert-info">
                                <strong>Coût estimé:</strong> {{ number_format($repair->estimated_cost, 0, ',', ' ') }} FCFA
                            </div>
                            @endif

                            @if($repair->estimated_completion)
                            <div class="alert alert-warning">
                                <strong>Date estimée de complétion:</strong> {{ $repair->estimated_completion->format('d/m/Y') }}
                            </div>
                            @endif

                            @if($repair->technician_notes)
                            <div class="alert alert-light border">
                                <strong>Notes du technicien:</strong><br>
                                {{ $repair->technician_notes }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <h4>Aucune réparation trouvée</h4>
                        <p class="mb-0">Vérifiez le numéro de réparation ou contactez-nous.</p>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
