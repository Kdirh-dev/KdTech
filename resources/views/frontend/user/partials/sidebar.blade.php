<div class="card">
    <div class="card-body text-center">
        <div class="mb-3">
            <i class="fas fa-user-circle fa-3x text-primary"></i>
        </div>
        <h6>{{ Auth::user()->name }}</h6>
        <p class="text-muted small">{{ Auth::user()->email }}</p>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord
            </a>
            <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-shopping-bag me-2"></i>Mes Commandes
            </a>
            <a href="{{ route('user.repairs') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tools me-2"></i>Mes Réparations
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user me-2"></i>Mon Profil
            </a>
        </div>
    </div>
</div>
