@extends('layouts.app')

@section('title', 'À Propos - KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{{ data_get($aboutSettings, 'title', 'À propos de KdTech') }}</h1>
                <p class="lead mb-4">{{ data_get($aboutSettings, 'description', 'Nous sommes spécialisés dans la vente et la réparation d\'équipements électroniques.') }}</p>

                <div class="mb-4">
                    <h4>Notre Mission</h4>
                    <p>{{ data_get($aboutSettings, 'mission', 'Offrir des produits fiables au meilleur prix.') }}</p>
                </div>

                <div class="mb-4">
                    <h4>Notre Vision</h4>
                    <p>{{ data_get($aboutSettings, 'vision', 'Être le leader régional en solutions tech.') }}</p>
                </div>

                <div class="mb-4">
                    <h4>Nos Valeurs</h4>
                    <ul>
                        <li>Qualité et fiabilité</li>
                        <li>Service client exceptionnel</li>
                        <li>Innovation technologique</li>
                        <li>Transparence et honnêteté</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ data_get($aboutSettings, 'image', asset('images/about-hero.jpg')) }}"
                     class="img-fluid rounded-3 shadow"
                     alt="À Propos KdTech"
                     onerror="this.src='https://via.placeholder.com/600x400?text=À+Propos'">
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Notre Équipe</h2>
        <div class="row g-4">
            @foreach(data_get($aboutSettings, 'team', []) as $member)
            <div class="col-md-4 text-center">
                <div class="team-member">
                    <img src="{{ data_get($member, 'image', 'https://via.placeholder.com/150x150?text=Photo') }}"
                         class="rounded-circle mb-3"
                         alt="{{ data_get($member, 'name', 'Membre') }}"
                         style="width: 150px; height: 150px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/150x150?text=Photo'">
                    <h5>{{ data_get($member, 'name', 'Membre de l\'équipe') }}</h5>
                    <p class="text-muted">{{ data_get($member, 'position', '') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
