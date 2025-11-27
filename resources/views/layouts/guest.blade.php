<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @isset($title)
            {{ trim($title) }}
        @else
            @yield('title', 'KdTech - Authentification')
        @endisset
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:600,700,800" rel="stylesheet" />

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --gradient-start: #667eea;
            --gradient-end: #764ba2;
            --dark: #1a1a2e;
            --light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-container {
            position: relative;
            z-index: 2;
        }

        .logo-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .auth-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .auth-subtitle {
            font-weight: 500;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary);
        }

        .btn-auth {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        }

        .auth-links {
            text-align: center;
            margin-top: 2rem;
        }

        .auth-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-link:hover {
            color: var(--primary);
            transform: translateX(5px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #64748b;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider-text {
            padding: 0 1rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .social-auth {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-social {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-weight: 600;
            background: white;
            color: var(--primary);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-social:hover {
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .floating-tech {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.1;
            animation: float-tech 8s ease-in-out infinite;
        }

        @keyframes float-tech {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -10px) rotate(5deg); }
            50% { transform: translate(-5px, 5px) rotate(-5deg); }
            75% { transform: translate(-10px, -5px) rotate(3deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-card {
                margin: 1rem;
            }

            .auth-header {
                padding: 2rem 1.5rem;
            }

            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }

            .social-auth {
                grid-template-columns: 1fr;
            }
        }

        /* Loading animation */
        .loading-dots {
            display: inline-flex;
            gap: 4px;
        }

        .loading-dots span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            animation: loading-bounce 1.4s ease-in-out infinite both;
        }

        .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
        .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes loading-bounce {
            0%, 80%, 100% {
                transform: scale(0);
            }
            40% {
                transform: scale(1);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Elements flottants technologiques -->
    <i class="floating-tech fas fa-microchip" style="top: 10%; left: 5%; animation-delay: 0s;"></i>
    <i class="floating-tech fas fa-laptop-code" style="top: 20%; right: 8%; animation-delay: 1s;"></i>
    <i class="floating-tech fas fa-mobile-alt" style="bottom: 30%; left: 7%; animation-delay: 2s;"></i>
    <i class="floating-tech fas fa-wifi" style="bottom: 20%; right: 10%; animation-delay: 3s;"></i>
    <i class="floating-tech fas fa-cog" style="top: 40%; left: 10%; animation-delay: 4s;"></i>
    <i class="floating-tech fas fa-bolt" style="top: 60%; right: 5%; animation-delay: 5s;"></i>

    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="auth-card">
                        <div class="auth-header">
                            <div class="logo-container">
                                <div class="logo-icon">
                                    <i class="fas fa-laptop-code"></i>
                                </div>
                                <h1 class="auth-title">KdTech</h1>
                                <p class="auth-subtitle">
                                    @isset($authSubtitle)
                                        {{ trim($authSubtitle) }}
                                    @else
                                        @yield('auth-subtitle', 'Électronique & Réparations')
                                    @endisset
                                </p>
                            </div>
                        </div>

                        <div class="auth-body">
                            {{ $slot }}
                        </div>
                    </div>

                    <!-- Liens supplémentaires -->
                    <div class="text-center mt-4">
                        <p class="text-white" style="opacity: 0.9; font-weight: 500;">
                            © 2024 KdTech. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Animation pour les boutons de soumission
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<span class="loading-dots"><span></span><span></span><span></span></span>';
                        submitBtn.disabled = true;
                    }
                });
            });

            // Animation d'entrée pour les éléments de formulaire
            const formElements = document.querySelectorAll('.form-floating');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
