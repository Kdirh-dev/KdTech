@extends('layouts.app')

@section('title', 'Gestion des Médias - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Gestion des Médias</h1>
        <div class="btn-group">
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Télécharger des fichiers
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($media->count() > 0)
            <div class="row g-3">
                @foreach($media as $item)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card media-card">
                        @if($item->isImage())
                        <img src="{{ $item->url }}" class="card-img-top" alt="{{ $item->name }}"
                             style="height: 150px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 150px;">
                            <i class="fas fa-file fa-3x text-muted"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title small text-truncate" title="{{ $item->name }}">
                                {{ $item->name }}
                            </h6>
                            <p class="card-text small text-muted mb-1">
                                {{ $item->formatted_size }}
                            </p>
                            <p class="card-text small text-muted mb-2">
                                {{ $item->mime_type }}
                            </p>
                            <div class="btn-group w-100">
                                <a href="{{ $item->url }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-success copy-url"
                                        data-url="{{ $item->url }}">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <form action="{{ route('admin.media.delete', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $media->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun fichier média</h4>
                <p class="text-muted mb-4">Commencez par télécharger vos premières images.</p>
                <a href="{{ route('admin.media.create') }}" class="btn btn-primary">
                    <i class="fas fa-upload me-2"></i>Télécharger des fichiers
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.media-card {
    transition: transform 0.2s ease;
}

.media-card:hover {
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copier l'URL dans le presse-papier
    document.querySelectorAll('.copy-url').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                // Changer temporairement l'icône pour confirmer
                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fas fa-check';

                setTimeout(() => {
                    icon.className = originalClass;
                }, 2000);
            });
        });
    });
});
</script>
@endsection
