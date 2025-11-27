@extends('layouts.app')

@section('title', $product->name . ' — KdTech')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produits</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Gallery -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="ratio ratio-4x3 mb-3" style="background:#f8f9fa;">
                            <img id="mainProductImage" src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit:contain;" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                        </div>

                        @if(!empty($product->image_urls) && count($product->image_urls) > 0)
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($product->image_urls as $idx => $img)
                            <button type="button" class="btn p-0 border-0 bg-transparent thumb-btn" data-src="{{ $img }}" aria-label="Voir image {{ $idx+1 }}">
                                <img src="{{ $img }}" alt="thumb-{{ $idx }}" style="width:72px; height:72px; object-fit:cover; border-radius:6px;" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                            </button>
                            @endforeach
                        </div>
                        @endif

                    </div>
                </div>

                <!-- Tabs: Description / Caractéristiques / Avis -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="productTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Caractéristiques</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Avis</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-3">
                            <div class="tab-pane fade show active" id="desc" role="tabpanel">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                            <div class="tab-pane fade" id="specs" role="tabpanel">
                                @if(!empty($product->features) && count($product->features) > 0)
                                <ul class="list-unstyled">
                                    @foreach($product->features as $feature)
                                    <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                                @else
                                <p class="text-muted">Aucune caractéristique détaillée.</p>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                @if(isset($reviews) && $reviews->count())
                                @foreach($reviews as $review)
                                <div class="border-bottom py-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $review->user->name ?? 'Client' }}</strong>
                                            <div class="small text-muted">{{ $review->created_at->format('d M Y') }}</div>
                                        </div>
                                        <div class="text-warning">
                                            {!! str_repeat('<i class="fas fa-star"></i>', intval($review->rating)) !!}
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">{{ $review->comment }}</p>
                                </div>
                                @endforeach
                                @else
                                <p class="text-muted">Aucun avis pour le moment.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info & Actions -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="h4 fw-bold mb-1">{{ $product->name }}</h2>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                                @if($product->brand)
                                <span class="badge bg-secondary">{{ $product->brand }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-end">
                            @if($product->has_discount)
                            <div class="h4 text-primary fw-bold mb-0">{{ number_format($product->price, 0, ',', ' ') }} FCFA</div>
                            <div class="small text-muted text-decoration-line-through">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</div>
                            @else
                            <div class="h4 text-primary fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</div>
                            @endif
                        </div>
                    </div>

                    <p class="text-muted mt-3">{{ Str::limit($product->short_description ?? $product->description, 160) }}</p>

                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                @if($product->stock > 0)
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>En stock</span>
                                <small class="text-muted">{{ $product->stock }} disponible(s)</small>
                                @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Rupture</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <small class="text-muted">Livraison 24-72h • Garantie 6 mois</small>
                        </div>
                    </div>

                    <!-- Quantity + CTA -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3" id="addToCartForm">
                        @csrf
                        <div class="d-flex gap-2 align-items-center">
                            <div class="input-group" style="width:140px;">
                                <button type="button" class="btn btn-outline-secondary" id="decQty">-</button>
                                <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ max(1, $product->stock) }}" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary" id="incQty">+</button>
                            </div>

                            @if($product->stock > 0)
                            <button type="submit" class="btn btn-primary btn-lg ms-2"><i class="fas fa-cart-plus me-2"></i>Ajouter au panier</button>
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-lg ms-2"><i class="fas fa-bolt me-2"></i>Acheter maintenant</a>
                            @else
                            <button class="btn btn-secondary btn-lg ms-2" disabled>Rupture de stock</button>
                            @endif
                        </div>
                    </form>

                    <!-- Social + Wishlist -->
                    <div class="d-flex gap-3 mt-3">
                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-secondary" title="Ajouter aux favoris"><i class="fas fa-heart me-1"></i> Favoris</button>
                        </form>

                        <div class="ms-auto d-flex gap-2">
                            <a href="#" class="text-muted" title="Partager"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-muted"><i class="fab fa-whatsapp fa-lg"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Related products -->
                @if($relatedProducts->count())
                <div class="card border-0 shadow-sm mt-4 p-3">
                    <h5 class="fw-semibold mb-3">Vous aimerez aussi</h5>
                    <div class="d-flex overflow-auto gap-3 pb-2">
                        @foreach($relatedProducts as $rp)
                        <div style="min-width:170px; max-width:170px;">
                            <div class="card h-100 border-0">
                                <img src="{{ $rp->main_image }}" alt="{{ $rp->name }}" style="height:110px; object-fit:cover;" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                                <div class="card-body py-2 px-0">
                                    <a href="{{ route('products.show', $rp->id) }}" class="text-decoration-none text-dark small fw-semibold">{{ Str::limit($rp->name, 40) }}</a>
                                    <div class="small text-primary mt-1">{{ number_format($rp->price, 0, ',', ' ') }} FCFA</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

<style>
.thumb-btn { border-radius: 6px; overflow: hidden; }
.thumb-btn img { transition: transform .25s ease; }
.thumb-btn:hover img { transform: scale(1.08); }
</style>

<script>
// Thumbnail click -> swap main image
document.querySelectorAll('.thumb-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const src = this.getAttribute('data-src');
        const main = document.getElementById('mainProductImage');
        if(main) main.src = src;
    });
});

// Quantity controls
const dec = document.getElementById('decQty');
const inc = document.getElementById('incQty');
const qty = document.getElementById('qtyInput');
if(dec && inc && qty) {
    dec.addEventListener('click', () => { let v = parseInt(qty.value) || 1; if(v>1) qty.value = v-1; });
    inc.addEventListener('click', () => { let v = parseInt(qty.value) || 1; const max = parseInt(qty.getAttribute('max')) || 9999; if(v<max) qty.value = v+1; });
}
</script>

@endsection
