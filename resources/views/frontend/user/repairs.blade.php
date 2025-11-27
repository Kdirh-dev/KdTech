@extends('layouts.app')

@section('title', 'Mes Réparations - KdTech')

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
                        <h4 class="mb-0">Mes Réparations</h4>
                    </div>
                    <div class="card-body">
                        @forelse($repairs as $repair)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <strong>{{ $repair->repair_number }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $repair->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <small>{{ $repair->device_brand }} {{ $repair->device_model }}</small>
                                        <br>
                                        <small class="text-muted">{{ $repair->device_type }}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <span class="badge bg-{{ $repair->status_color }}">
                                            {{ ucfirst($repair->status) }}
                                        </span>
                                        @if($repair->estimated_cost)
                                        <br>
                                        <small class="text-muted">{{ number_format($repair->estimated_cost, 0, ',', ' ') }} FCFA</small>
                                        @endif
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('repairs.track') }}?repair_number={{ $repair->repair_number }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Suivre
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Aucune réparation</h4>
                            <p class="text-muted mb-4">Vous n'avez pas encore demandé de réparation.</p>
                            <a href="{{ route('repairs.index') }}" class="btn btn-primary">
                                <i class="fas fa-tools me-2"></i>Demander une réparation
                            </a>
                        </div>
                        @endforelse

                        <!-- Pagination -->
                        @if($repairs->hasPages())
                        <div class="mt-4">
                            {{ $repairs->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
