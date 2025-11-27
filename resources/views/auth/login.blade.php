<x-guest-layout>
    <x-slot:title>Connexion - KdTech</x-slot:title>
    <x-slot:auth-subtitle>Connectez-vous à votre compte</x-slot:auth-subtitle>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" placeholder="name@example.com"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
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
                   required autocomplete="current-password">
            <label for="password"><i class="fas fa-lock me-2"></i>Mot de passe</label>
            @error('password')
                <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
        </button>

        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    <i class="fas fa-key me-1"></i>Mot de passe oublié ?
                </a>
            @endif

            @if (Route::has('register'))
                <div class="mt-3">
                    <span class="text-muted">Nouveau chez KdTech ?</span>
                    <a href="{{ route('register') }}" class="auth-link ms-2">
                        <i class="fas fa-user-plus me-1"></i>Créer un compte
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
