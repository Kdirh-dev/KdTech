<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KdTech - Électronique & Réparations')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 100px 0;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .footer {
            background-color: var(--dark);
            color: white;
            padding: 50px 0 20px;
        }
    </style>
    @stack('styles')
    <!-- Global submit spinner styles -->
    <style>
        /* Spinner inside buttons */
        .button-spinner { display: inline-flex; align-items: center; gap: .6rem; }
        .button-spinner .spinner {
            width: 1rem; height: 1rem; border: 2px solid rgba(255,255,255,0.2); border-top-color: rgba(255,255,255,1); border-radius: 50%;
            animation: spin .8s linear infinite; display: inline-block;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Disabled look */
        .btn-disabled { pointer-events: none; opacity: .65; }
    </style>
</head>



<body>
    <!-- Navigation -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-laptop-code me-2"></i>KdTech
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navigation pour les visiteurs et clients -->
                @if(!auth()->check() || (auth()->check() && auth()->user()->isCustomer()))
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('repairs.index') }}">Réparations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                @endif

                <!-- Navigation pour les admins/managers -->
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isManager()))
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-boxes me-1"></i>Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.repairs.index') }}">
                            <i class="fas fa-tools me-1"></i>Réparations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog me-1"></i>Paramètres
                        </a>
                    </li>

                </ul>
                @endif

                <ul class="navbar-nav">
                    <!-- Panier (visible pour tous sauf admins en mode admin) -->
                    @if(!auth()->check() || (auth()->check() && auth()->user()->isCustomer()))
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i> Panier
                            @php $cartCount = count(session('cart', [])) @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    @endif

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->isCustomer())
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Tableau de Bord
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.orders') }}">
                                        <i class="fas fa-shopping-bag me-2"></i>Mes Commandes
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.repairs') }}">
                                        <i class="fas fa-tools me-2"></i>Mes Réparations
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-cog me-2"></i>Mon profil
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif

                                @if(Auth::user()->isAdmin() || Auth::user()->isManager())
                                    <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                        <i class="fas fa-store me-2"></i>Voir la Boutique
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <!-- Contenu Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>KdTech</h5>
                    <p>Votre partenaire de confiance pour l'électronique et les réparations à Lomé.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens Rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light">Accueil</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-light">Produits</a></li>
                        <li><a href="{{ route('repairs.index') }}" class="text-light">Réparations</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>
                        <i class="fas fa-map-marker-alt me-2"></i>Lomé, Togo<br>
                        <i class="fas fa-phone me-2"></i>+228 XX XX XX XX<br>
                        <i class="fas fa-envelope me-2"></i>contact@kdtech.tg
                    </p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2024 KdTech. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Global submit spinner script -->
        <script>
        (function () {
            var NO_DISABLE_ATTR = 'data-no-disable';
            var AJAX_ATTR = 'data-ajax';

            function createSpinnerNode() {
                var s = document.createElement('span');
                s.className = 'spinner';
                s.setAttribute('aria-hidden', 'true');
                return s;
            }

            function setButtonLoading(btn, text) {
                if (!btn) return function(){};
                if (!btn.dataset.origHtml) btn.dataset.origHtml = btn.innerHTML;
                btn.classList.add('button-spinner', 'btn-disabled');
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');

                // Clear and append spinner + label
                btn.innerHTML = '';
                var spinner = createSpinnerNode();
                btn.appendChild(spinner);
                var label = document.createElement('span');
                label.className = 'ms-2';
                label.textContent = text || btn.dataset.loadingText || 'En cours...';
                btn.appendChild(label);

                return function restore() {
                    if (btn.dataset.origHtml) {
                        btn.innerHTML = btn.dataset.origHtml;
                        delete btn.dataset.origHtml;
                    }
                    btn.disabled = false;
                    btn.removeAttribute('aria-busy');
                    btn.classList.remove('button-spinner', 'btn-disabled');
                };
            }

            document.addEventListener('submit', function (ev) {
                var form = ev.target;
                if (!(form instanceof HTMLFormElement)) return;

                // Opt-out per form
                if (form.hasAttribute(NO_DISABLE_ATTR) && form.getAttribute(NO_DISABLE_ATTR) !== 'false') return;

                // Prevent double handling
                if (form.dataset.submitting === '1') { ev.preventDefault(); return; }

                // Determine submit button
                var submitButton = null;
                try { submitButton = ev.submitter || form.querySelector('button[type="submit"], input[type="submit"]'); } catch(e) { submitButton = form.querySelector('button[type="submit"], input[type="submit"]'); }

                if (submitButton && submitButton.hasAttribute(NO_DISABLE_ATTR) && submitButton.getAttribute(NO_DISABLE_ATTR) !== 'false') {
                    return; // button opted out
                }

                form.dataset.submitting = '1';

                var buttons = Array.prototype.slice.call(form.querySelectorAll('button[type="submit"], input[type="submit"]'));
                var restores = [];
                buttons.forEach(function(btn){
                    if (btn.hasAttribute(NO_DISABLE_ATTR) && btn.getAttribute(NO_DISABLE_ATTR) !== 'false') return;
                    restores.push(setButtonLoading(btn, btn.dataset.loadingText || (btn.value || btn.innerText)));
                });

                function restoreAll() {
                    try { delete form.dataset.submitting; } catch(e) { form.dataset.submitting = '0'; }
                    restores.forEach(function(r){ try { r(); } catch(e){} });
                }

                // If form is AJAX-marked, handle via fetch and re-enable on completion
                if (form.dataset.ajax === 'true') {
                    ev.preventDefault();
                    var url = form.action;
                    var method = (form.method || 'POST').toUpperCase();
                    var fd = new FormData(form);
                    fetch(url, { method: method, body: fd, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function(resp){ return resp.json().catch(function(){ return resp.text(); }); })
                        .then(function(data){
                            document.dispatchEvent(new CustomEvent('form:submit:done', { detail: { form: form, data: data } }));
                            restoreAll();
                        })
                        .catch(function(err){
                            document.dispatchEvent(new CustomEvent('form:submit:done', { detail: { form: form, err: err } }));
                            restoreAll();
                        });
                } else {
                    // allow normal submit (page will reload and clear state)
                }

            }, true);

            // Expose helper
            window.__formSubmit = { restore: function(form){ document.dispatchEvent(new CustomEvent('form:submit:done', { detail: { form: form } })); } };
        })();
        </script>
    @stack('scripts')
</body>
</html>
