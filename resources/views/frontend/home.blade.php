@extends('layouts.app')

@section('title', 'KdTech - Électronique & Réparations à Lomé')

@section('content')

<!-- Hero Carousel Section -->
<section id="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($heroSlides as $i => $slide)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                    class="{{ $i === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            @foreach($heroSlides as $i => $slide)
            @php
                $image = $slide['image'] ?? 'https://images.unsplash.com/photo-1498049794561-7780e7231661?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80';
                $title = $slide['title'] ?? 'Titre par défaut';
                $subtitle = $slide['subtitle'] ?? 'Sous-titre par défaut';
                $button1_text = $slide['button1_text'] ?? 'Bouton 1';
                $button1_link = $slide['button1_link'] ?? '#';
                $button2_text = $slide['button2_text'] ?? 'Bouton 2';
                $button2_link = $slide['button2_link'] ?? '#';
            @endphp
            <div class="carousel-item hero-slide {{ $i === 0 ? 'active' : '' }}"
                 style="background-image: url('{{ $image }}');">
                <div class="hero-overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="row w-100 align-items-center">
                        <div class="col-lg-8 mx-auto text-center text-white">
                            <div class="carousel-content">
                                <h1 class="display-4 fw-bold mb-4">{{ $title }}</h1>
                                <p class="lead mb-4 fs-5">{{ $subtitle }}</p>
                                <div class="d-flex gap-3 flex-wrap justify-content-center">
                                    <a href="{{ $button1_link }}" class="btn btn-light btn-lg px-4 py-3 fw-semibold">
                                        {{ $button1_text }}
                                    </a>
                                    <a href="{{ $button2_link }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                                        {{ $button2_text }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</section>

<!-- Le reste du contenu reste inchangé -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <h3 class="display-5 fw-bold text-primary">500+</h3>
                <p class="text-muted">Produits disponibles</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-5 fw-bold text-primary">2000+</h3>
                <p class="text-muted">Clients satisfaits</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-5 fw-bold text-primary">5000+</h3>
                <p class="text-muted">Réparations réussies</p>
            </div>
            <div class="col-md-3">
                <h3 class="display-5 fw-bold text-primary">24/7</h3>
                <p class="text-muted">Support disponible</p>
            </div>
        </div>
    </div>
</section>

<!-- ... Le reste de votre contenu existant ... -->
<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold display-6 mb-3">Nos Services</h2>
                <p class="text-muted lead">Nous offrons des solutions complètes pour tous vos besoins en électronique et réparation</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm service-card" style="transition: all 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Produits Premium</h5>
                        <p class="card-text text-muted">Sélection rigoureuse de produits électroniques de qualité supérieure avec garantie complète.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm mt-3">Parcourir</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm service-card" style="transition: all 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-tools fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Réparation Expert</h5>
                        <p class="card-text text-muted">Équipe qualifiée offrant des services de réparation rapides et fiables pour tous vos appareils.</p>
                        <a href="{{ route('repairs.index') }}" class="btn btn-outline-success btn-sm mt-3">Demander</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm service-card" style="transition: all 0.3s;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-truck fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Livraison Rapide</h5>
                        <p class="card-text text-muted">Livraison express disponible dans tout Lomé avec suivi en temps réel de votre commande.</p>
                        <a href="{{ route('cart') }}" class="btn btn-outline-info btn-sm mt-3">Commandes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
    </style>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col">
                <h2 class="fw-bold display-6">Produits Populaires</h2>
                <p class="text-muted">Découvrez nos meilleures ventes sélectionnées pour vous</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">Voir tous les produits</a>
            </div>
        </div>
        <div class="row g-4">
            @forelse($featuredProducts->take(4) as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 product-card border-0 shadow-sm">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="{{ $product->main_image }}" class="card-img-top h-100 object-fit-cover" alt="{{ $product->name }}" style="transition: transform 0.3s;">
                        @if($product->has_discount)
                        <span class="position-absolute top-0 start-0 badge bg-danger m-3 py-2 px-3">
                            <i class="fas fa-fire me-1"></i>-{{ $product->discount_percentage }}%
                        </span>
                        @endif
                        <a href="{{ route('products.show', $product->id) }}" class="position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-eye fa-2x text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s;"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ Str::limit($product->name, 40) }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 text-primary mb-0 fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            @if($product->has_discount)
                            <small class="text-muted text-decoration-line-through">{{ number_format($product->compare_price, 0, ',', ' ') }}</small>
                            @endif
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold">
                                <i class="fas fa-cart-plus me-2"></i>Ajouter au Panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Aucun produit disponible</h4>
                <p class="text-muted">Revenez bientôt pour découvrir nos nouveaux produits</p>
            </div>
            @endforelse
        </div>
    </div>
    <style>
        .product-card:hover img {
            transform: scale(1.1);
        }
        .product-card:hover .fa-eye {
            opacity: 1 !important;
        }
    </style>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold display-6 mb-3">Pourquoi KdTech ?</h2>
                <p class="text-muted lead">Nous nous engageons à vous offrir excellence et confiance</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <i class="fas fa-shield-alt fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Garantie Complète</h5>
                        <p class="text-muted">Tous nos produits et services sont couverts par une garantie complète pour votre sécurité.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                            <i class="fas fa-shipping-fast fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Livraison Express</h5>
                        <p class="text-muted">Livraison rapide et fiable partout à Lomé avec suivi en temps réel.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                            <i class="fas fa-handshake fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Service Professionnel</h5>
                        <p class="text-muted">Équipe formée et expérimentée prête à vous offrir un excellent service.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Support 24/7</h5>
                        <p class="text-muted">Notre équipe support est toujours disponible pour vous aider à tout moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold display-6 mb-3">Ce que nos clients disent</h2>
                <p class="text-muted lead">Des centaines de clients satisfaits nous font confiance</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm testimonial-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">"Service impeccable et produits de très bonne qualité. Je recommande vivement KdTech à tous!"</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Marie D.</h6>
                                <small class="text-muted">Client depuis 2 ans</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm testimonial-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">"Ils ont réparé mon téléphone en moins d'une heure. Prix juste et travail de qualité!"</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Jean K.</h6>
                                <small class="text-muted">Client depuis 1 an</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm testimonial-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text italic text-muted mb-3">"La livraison est rapide et les produits sont originaux. Très satisfait de mon achat!"</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);"></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Aminata S.</h6>
                                <small class="text-muted">Client depuis 6 mois</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
    </style>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
    <div class="position-absolute" style="top: -50%; right: -10%; width: 400px; height: 400px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center text-center text-lg-start">
            <div class="col-lg-8">
                <h2 class="fw-bold display-5 mb-3">Prêt à commencer ?</h2>
                <p class="lead mb-0">Rejoignez des milliers de clients satisfaits. Parcourez nos produits ou demandez une réparation dès aujourd'hui!</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5 fw-semibold me-2 mb-2">
                    Commencer
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold display-6 mb-3">Nos Catégories</h2>
                <p class="text-muted lead">Parcourez nos catégories pour trouver exactement ce que vous cherchez</p>
            </div>
        </div>
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('products.byCategory', $category->slug) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm category-card" style="transition: all 0.3s;">
                        <div class="card-body text-center p-5">
                            <div class="mb-3">
                                <i class="fas fa-tag fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                            <p class="card-text text-muted mb-3">{{ $category->products_count }} produits disponibles</p>
                            <span class="btn btn-outline-primary btn-sm">Explorer</span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Aucune catégorie disponible</h4>
            </div>
            @endforelse
        </div>
    </div>
    <style>
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }
    </style>
</section>

<style>
    /* Styles pour le Hero Carousel */
    #hero-carousel-section {
        margin-top: -80px;
        padding-top: 80px;
        height: 100vh;
        min-height: 600px;
        max-height: 800px;
        position: relative;
        overflow: hidden;
    }

    #heroCarousel {
        height: 100%;
    }

    .carousel-inner {
        height: 100%;
    }

    .hero-slide {
        height: 100%;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-attachment: fixed;
        position: relative;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6); /* Overlay plus sombre pour meilleure lisibilité */
        z-index: 1;
    }

    .carousel-content {
        position: relative;
        z-index: 2;
        animation: fadeInUp 0.8s ease-out;
    }

    .carousel-indicators {
        bottom: 30px;
        z-index: 10;
    }

    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 6px;
        background-color: rgba(255, 255, 255, 0.5);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .carousel-indicators button.active {
        background-color: white;
        transform: scale(1.2);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        margin: 0 20px;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.6);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        #hero-carousel-section {
            height: 70vh;
            min-height: 500px;
            max-height: 600px;
            margin-top: -60px;
            padding-top: 60px;
        }

        .hero-slide {
            background-attachment: scroll; /* Désactive le parallaxe sur mobile */
        }

        .display-4 {
            font-size: 2rem !important;
        }

        .lead {
            font-size: 1rem !important;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem !important;
            font-size: 0.9rem !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            margin: 0 10px;
        }
    }

    @media (max-width: 576px) {
        #hero-carousel-section {
            height: 60vh;
            min-height: 400px;
        }

        .display-4 {
            font-size: 1.75rem !important;
        }

        .carousel-indicators {
            bottom: 20px;
        }
    }
</style>

@endsection
