@extends('layouts.app')

@section('title', 'Services de Réparation - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Services de Réparation</h1>
                <p class="lead">Votre appareil est en panne ? Notre équipe d'experts est là pour le réparer rapidement et efficacement.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif


        {{-- Ajouter cette section après le message de succès --}}
        @if(!auth()->check())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Connexion requise</strong> -
            <a href="{{ route('login') }}" class="alert-link">Connectez-vous</a>
            ou
            <a href="{{ route('register') }}" class="alert-link">créez un compte</a>
            pour soumettre une demande de réparation.
        </div>
        @endif

        <div class="row g-5">
            <!-- Formulaire de Demande -->
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Demande de Réparation</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('repairs.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Nom Complet *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                           id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                           id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                       id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="device_type" class="form-label">Type d'appareil *</label>
                                    <select class="form-select @error('device_type') is-invalid @enderror"
                                            id="device_type" name="device_type" required>
                                        <option value="">Choisir...</option>
                                        <option value="Smartphone" {{ old('device_type') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                                        <option value="Tablette" {{ old('device_type') == 'Tablette' ? 'selected' : '' }}>Tablette</option>
                                        <option value="Laptop" {{ old('device_type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                        <option value="Ordinateur Bureau" {{ old('device_type') == 'Ordinateur Bureau' ? 'selected' : '' }}>Ordinateur Bureau</option>
                                        <option value="Écran" {{ old('device_type') == 'Écran' ? 'selected' : '' }}>Écran</option>
                                        <option value="Autre" {{ old('device_type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('device_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="device_brand" class="form-label">Marque *</label>
                                    <input type="text" class="form-control @error('device_brand') is-invalid @enderror"
                                           id="device_brand" name="device_brand" value="{{ old('device_brand') }}"
                                           placeholder="Ex: Samsung, Apple..." required>
                                    @error('device_brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="device_model" class="form-label">Modèle *</label>
                                    <input type="text" class="form-control @error('device_model') is-invalid @enderror"
                                           id="device_model" name="device_model" value="{{ old('device_model') }}"
                                           placeholder="Ex: iPhone 13, Galaxy S21..." required>
                                    @error('device_model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="issue_description" class="form-label">Description du problème *</label>
                                <textarea class="form-control @error('issue_description') is-invalid @enderror"
                                          id="issue_description" name="issue_description" rows="4"
                                          placeholder="Décrivez en détail le problème rencontré..." required>{{ old('issue_description') }}</textarea>
                                @error('issue_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Soumettre la demande
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informations Services -->
            <div class="col-lg-6">
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Nos Services de Réparation</h3>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-primary mb-3">
                                        <i class="fas fa-mobile-alt fa-2x"></i>
                                    </div>
                                    <h5>Smartphones & Tablettes</h5>
                                    <p class="text-muted small">Écran cassé, batterie, connectique, logiciel</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-primary mb-3">
                                        <i class="fas fa-laptop fa-2x"></i>
                                    </div>
                                    <h5>Ordinateurs Portables</h5>
                                    <p class="text-muted small">Clavier, écran, carte mère, ventilation</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-primary mb-3">
                                        <i class="fas fa-desktop fa-2x"></i>
                                    </div>
                                    <h5>Ordinateurs Bureau</h5>
                                    <p class="text-muted small">Alimentation, carte graphique, RAM</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="feature-icon text-primary mb-3">
                                        <i class="fas fa-tools fa-2x"></i>
                                    </div>
                                    <h5>Dépannage Logiciel</h5>
                                    <p class="text-muted small">Virus, système, réinstallation, sauvegarde</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Processus de Réparation -->
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Notre Processus</h5>
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge bg-primary rounded-circle me-3 p-2">1</span>
                            <div>
                                <h6 class="mb-1">Diagnostic</h6>
                                <p class="text-muted small mb-0">Analyse complète de l'appareil</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge bg-primary rounded-circle me-3 p-2">2</span>
                            <div>
                                <h6 class="mb-1">Devis Gratuit</h6>
                                <p class="text-muted small mb-0">Estimation des coûts de réparation</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge bg-primary rounded-circle me-3 p-2">3</span>
                            <div>
                                <h6 class="mb-1">Réparation</h6>
                                <p class="text-muted small mb-0">Intervention par nos techniciens experts</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <span class="badge bg-primary rounded-circle me-3 p-2">4</span>
                            <div>
                                <h6 class="mb-1">Livraison</h6>
                                <p class="text-muted small mb-0">Test et remise de l'appareil réparé</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
