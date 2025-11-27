<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - KdTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .nav-header {
            background: linear-gradient(135deg, #17181d 0%, #1e1b20 100%);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-header">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-laptop-code me-2"></i>KdTech
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i>Accueil
                </a>
                @auth
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Tableau de bord
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="border: none; background: none;">
                            <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 fw-bold text-primary">
                        <i class="fas fa-user-circle me-2"></i>Mon Profil
                    </h1>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>Retour
                    </a>
                </div>

                <!-- Messages de statut -->
                @if(session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Profil mis à jour avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Mot de passe mis à jour avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Informations du compte -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informations du compte
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-user me-2"></i>Nom:</strong> {{ $user->name }}</p>
                                <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> {{ $user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar me-2"></i>Membre depuis:</strong>
                                    {{ $user->created_at->format('d/m/Y') }}</p>
                                <p><strong><i class="fas fa-shield-alt me-2"></i>Email vérifié:</strong>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Oui</span>
                                    @else
                                        <span class="badge bg-warning">Non</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modifier les informations du profil -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Modifier les informations
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nom complet</label>
                                <input id="name" name="name" type="text" class="form-control"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input id="email" name="email" type="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Changer le mot de passe -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-key me-2"></i>Changer le mot de passe
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mot de passe actuel</label>
                                <input id="current_password" name="current_password" type="password"
                                       class="form-control" required>
                                @error('current_password', 'updatePassword')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input id="password" name="password" type="password"
                                       class="form-control" required>
                                @error('password', 'updatePassword')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input id="password_confirmation" name="password_confirmation"
                                       type="password" class="form-control" required>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key me-1"></i>Changer le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Supprimer le compte -->
                <div class="card profile-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Supprimer le compte
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
                            Cette action est irréversible.
                        </p>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fas fa-trash me-1"></i>Supprimer mon compte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p class="text-danger fw-bold">
                            Êtes-vous sûr de vouloir supprimer votre compte ?
                        </p>
                        <p class="text-muted">
                            Cette action ne peut pas être annulée. Toutes vos données seront perdues.
                        </p>
                        <div class="mt-3">
                            <label for="delete_password" class="form-label">Entrez votre mot de passe pour confirmer :</label>
                            <input id="delete_password" name="password" type="password" class="form-control"
                                   placeholder="Votre mot de passe actuel" required>
                            @error('password', 'userDeletion')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>
