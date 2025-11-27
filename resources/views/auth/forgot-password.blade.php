<x-guest-layout>
    <x-slot:title>Mot de passe oublié - KdTech</x-slot:title>
    <x-slot:auth-subtitle>Réinitialisez votre mot de passe</x-slot:auth-subtitle>

    <div class="mb-4 text-muted text-center">
        <i class="fas fa-key fa-2x mb-3 d-block" style="color: var(--secondary);"></i>
        <p>Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" placeholder="name@example.com"
                   value="{{ old('email') }}" required autofocus>
            <label for="email"><i class="fas fa-envelope me-2"></i>Adresse Email</label>
            @error('email')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-paper-plane me-2"></i>Envoyer le lien
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
