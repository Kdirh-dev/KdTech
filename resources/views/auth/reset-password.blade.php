<x-guest-layout>
    <x-slot:title>Nouveau mot de passe - KdTech</x-slot:title>
    <x-slot:auth-subtitle>Créez votre nouveau mot de passe</x-slot:auth-subtitle>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" placeholder="name@example.com"
                   value="{{ old('email', $request->email) }}" required autofocus>
            <label for="email"><i class="fas fa-envelope me-2"></i>Adresse Email</label>
            @error('email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   id="password" name="password" placeholder="Nouveau mot de passe" required>
            <label for="password"><i class="fas fa-lock me-2"></i>Nouveau mot de passe</label>
            @error('password')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating">
            <input type="password" class="form-control"
                   id="password_confirmation" name="password_confirmation"
                   placeholder="Confirmez le mot de passe" required>
            <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirmer le mot de passe</label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-sync-alt me-2"></i>Réinitialiser le mot de passe
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
