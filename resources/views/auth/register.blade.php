<x-guest-layout>
    <x-slot:title>Inscription - KdTech</x-slot:title>
    <x-slot:auth-subtitle>Rejoignez la communauté KdTech</x-slot:auth-subtitle>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-floating">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" placeholder="Votre nom complet"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            <label for="name"><i class="fas fa-user me-2"></i>Nom complet</label>
            @error('name')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" placeholder="name@example.com"
                   value="{{ old('email') }}" required autocomplete="username">
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
                   id="password" name="password" placeholder="Votre mot de passe"
                   required autocomplete="new-password">
            <label for="password"><i class="fas fa-lock me-2"></i>Mot de passe</label>
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
                   placeholder="Confirmez votre mot de passe" required autocomplete="new-password">
            <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirmer le mot de passe</label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-user-plus me-2"></i>Créer mon compte
        </button>

        <div class="auth-links">
            <div class="mt-3">
                <span class="text-muted">Déjà membre ?</span>
                <a href="{{ route('login') }}" class="auth-link ms-2">
                    <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
