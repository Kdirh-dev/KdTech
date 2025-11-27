@extends('layouts.app')

@section('title', 'Contact - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center fw-bold mb-5">Contactez-Nous</h1>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row mb-5">
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Adresse</h5>
                        <p class="text-muted">Lomé, Togo</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Téléphone</h5>
                        <p class="text-muted">+228 XX XX XX XX</p>
                    </div>
                    <div class="col-md-4 text-center mb-4">
                        <div class="feature-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p class="text-muted">contact@kdtech.tg</p>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body p-4">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nom Complet *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Sujet *</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                       id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer le Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
