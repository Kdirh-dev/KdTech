<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Supprimer le compte
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        Supprimer le compte
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">
                        Êtes-vous sûr de vouloir supprimer votre compte ?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-muted">
                            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
                        </p>
                        <div class="mt-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Votre mot de passe">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer le compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
