<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informations du Profil
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Mettez à jour les informations de votre profil et votre adresse email.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="form-label">Nom</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-muted">
                        Votre adresse email n'est pas vérifiée.
                        <button form="send-verification" class="btn btn-link p-0">
                            Cliquez ici pour renvoyer l'email de vérification.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-2">
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Enregistrer</button>

            @if (session('status') === 'profile-updated')
                <p class="text-success mb-0">
                    Enregistré avec succès.
                </p>
            @endif
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
</section>
