<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Mettre à jour le mot de passe
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            @error('current_password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Enregistrer</button>

            @if (session('status') === 'password-updated')
                <p class="text-success mb-0">
                    Mot de passe mis à jour avec succès.
                </p>
            @endif
        </div>
    </form>
</section>
