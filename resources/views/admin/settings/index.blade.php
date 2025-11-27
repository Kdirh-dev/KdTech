@extends('layouts.app')

@section('title', 'Paramètres du Site - KdTech')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Paramètres du Site</h1>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-success">
            <i class="fas fa-eye me-2"></i>Voir le site
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Carousel Hero -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Carousel Hero</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.updateHero') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @foreach($heroSettings as $index => $slide)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Slide {{ $index + 1 }}</h6>
                            </div>
                            <div class="card-body">
                                <!-- Image du slide -->
                                <div class="mb-3">
                                    <label class="form-label">Image du slide</label>
                                    <div class="text-center mb-2">
                                        <img src="{{ $slide['image'] ?? 'https://via.placeholder.com/800x400?text=Slide+' . ($index + 1) }}"
                                             class="img-fluid rounded"
                                             style="max-height: 150px;"
                                             alt="Slide {{ $index + 1 }}">
                                    </div>
                                    <input type="file" class="form-control"
                                           name="hero_images[{{ $index }}]"
                                           accept="image/*">

                                    <div class="form-text">
                                        Format recommandé: 1920x800px pour un affichage optimal
                                    </div>
                                </div>

                                <!-- Titre -->
                                <div class="mb-3">
                                    <label class="form-label">Titre</label>
                                    <input type="text" class="form-control"
                                           name="hero[{{ $index }}][title]"
                                           value="{{ $slide['title'] ?? '' }}" required>
                                </div>

                                <!-- Sous-titre -->
                                <div class="mb-3">
                                    <label class="form-label">Sous-titre</label>
                                    <textarea class="form-control"
                                              name="hero[{{ $index }}][subtitle]"
                                              rows="3" required>{{ $slide['subtitle'] ?? '' }}</textarea>
                                </div>

                                <!-- Bouton 1 -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bouton 1 - Texte</label>
                                        <input type="text" class="form-control"
                                               name="hero[{{ $index }}][button1_text]"
                                               value="{{ $slide['button1_text'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bouton 1 - Lien</label>
                                        <input type="text" class="form-control"
                                               name="hero[{{ $index }}][button1_link]"
                                               value="{{ $slide['button1_link'] ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Bouton 2 -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bouton 2 - Texte</label>
                                        <input type="text" class="form-control"
                                               name="hero[{{ $index }}][button2_text]"
                                               value="{{ $slide['button2_text'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bouton 2 - Lien</label>
                                        <input type="text" class="form-control"
                                               name="hero[{{ $index }}][button2_link]"
                                               value="{{ $slide['button2_link'] ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Utiliser comme arrière-plan -->
                                <div class="form-check form-switch mt-3">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           id="hero_bg_{{ $index }}"
                                           name="hero[{{ $index }}][use_as_background]"
                                           {{ isset($slide['use_as_background']) && $slide['use_as_background'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hero_bg_{{ $index }}">Utiliser l'image comme arrière-plan (background)</label>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour le Carousel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page À Propos -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Page À Propos</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.updateAbout') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Image principale -->
                        <div class="mb-3">
                            <label class="form-label">Image principale</label>
                            <div class="text-center mb-2">
                                <img src="{{ $aboutSettings['image'] ?? 'https://via.placeholder.com/600x400?text=À+Propos' }}"
                                     class="img-fluid rounded"
                                     style="max-height: 200px;"
                                     alt="Image about">
                            </div>
                            <input type="file" class="form-control"
                                   name="about_image"
                                   accept="image/*">
                            <div class="form-text">
                                Format recommandé: 600x400px
                            </div>
                        </div>

                        <!-- Titre -->
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" class="form-control"
                                   name="about_title"
                                   value="{{ $aboutSettings['title'] ?? '' }}" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control"
                                      name="about_description"
                                      rows="3" required>{{ $aboutSettings['description'] ?? '' }}</textarea>
                        </div>

                        <!-- Mission -->
                        <div class="mb-3">
                            <label class="form-label">Mission</label>
                            <textarea class="form-control"
                                      name="about_mission"
                                      rows="2" required>{{ $aboutSettings['mission'] ?? '' }}</textarea>
                        </div>

                        <!-- Vision -->
                        <div class="mb-3">
                            <label class="form-label">Vision</label>
                            <textarea class="form-control"
                                      name="about_vision"
                                      rows="2" required>{{ $aboutSettings['vision'] ?? '' }}</textarea>
                        </div>

                        <!-- Équipe -->
                        <div class="mb-4">
                            <label class="form-label">Équipe</label>

                            @foreach($aboutSettings['team'] as $index => $member)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6>Membre {{ $index + 1 }}</h6>

                                    <!-- Photo -->
                                    <div class="mb-2">
                                        <div class="text-center">
                                            <img src="{{ $member['image'] ?? 'https://via.placeholder.com/80x80?text=Photo' }}"
                                                 class="rounded-circle"
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 alt="{{ $member['name'] ?? 'Membre' }}">
                                        </div>
                                        <input type="file" class="form-control mt-2"
                                               name="team_images[{{ $index }}]"
                                               accept="image/*">
                                    </div>

                                    <!-- Nom -->
                                    <div class="mb-2">
                                        <label class="form-label">Nom</label>
                                        <input type="text" class="form-control"
                                               name="team[{{ $index }}][name]"
                                               value="{{ $member['name'] ?? '' }}" required>
                                    </div>

                                    <!-- Poste -->
                                    <div class="mb-2">
                                        <label class="form-label">Poste</label>
                                        <input type="text" class="form-control"
                                               name="team[{{ $index }}][position]"
                                               value="{{ $member['position'] ?? '' }}" required>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Mettre à jour À Propos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection
