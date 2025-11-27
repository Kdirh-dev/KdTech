@extends('layouts.app')

@section('title', 'Télécharger des Médias - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Télécharger des Médias</h1>
        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="files" class="form-label">Sélectionner les fichiers</label>
                            <input type="file" class="form-control @error('files') is-invalid @enderror"
                                   id="files" name="files[]" multiple accept="image/*" required>
                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formats acceptés: JPG, JPEG, PNG, GIF, WEBP, SVG. Taille max: 10MB par fichier.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="collection" class="form-label">Collection (optionnel)</label>
                            <input type="text" class="form-control" id="collection" name="collection"
                                   placeholder="Ex: hero, products, categories...">
                            <div class="form-text">
                                Permet d'organiser vos fichiers par catégories.
                            </div>
                        </div>

                        <!-- Aperçu des fichiers -->
                        <div id="file-preview" class="mb-4 d-none">
                            <h6>Aperçu des fichiers</h6>
                            <div class="row g-2" id="preview-container"></div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                                <i class="fas fa-upload me-2"></i>Télécharger les fichiers
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Conseils d'optimisation</h6>
                        <ul class="small text-muted">
                            <li>Utilisez des images WebP pour de meilleures performances</li>
                            <li>Optimisez les images avant le téléchargement</li>
                            <li>Respectez les dimensions recommandées</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6>Dimensions recommandées</h6>
                        <ul class="small text-muted">
                            <li><strong>Hero:</strong> 1200x600px</li>
                            <li><strong>Produits:</strong> 800x800px</li>
                            <li><strong>Catégories:</strong> 400x300px</li>
                            <li><strong>Logos:</strong> 200x100px</li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Les images seront automatiquement redimensionnées et optimisées.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('files');
    const previewContainer = document.getElementById('preview-container');
    const filePreview = document.getElementById('file-preview');
    const submitBtn = document.getElementById('submit-btn');

    fileInput.addEventListener('change', function(e) {
        previewContainer.innerHTML = '';

        if (this.files.length > 0) {
            filePreview.classList.remove('d-none');
            submitBtn.disabled = false;

            Array.from(this.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4 col-lg-3';

                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top"
                                     style="height: 100px; object-fit: cover;" alt="Preview">
                                <div class="card-body p-2">
                                    <small class="text-truncate d-block" title="${file.name}">
                                        ${file.name}
                                    </small>
                                    <small class="text-muted">
                                        ${(file.size / 1024 / 1024).toFixed(2)} MB
                                    </small>
                                </div>
                            </div>
                        `;

                        previewContainer.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                }
            });
        } else {
            filePreview.classList.add('d-none');
            submitBtn.disabled = true;
        }
    });
});
</script>
@endsection
