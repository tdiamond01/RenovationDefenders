<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Renovation Defenders') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon-192.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            .top-ribbon {
                font-size: 0.85rem;
            }
            .top-ribbon a:hover {
                text-decoration: underline !important;
            }
        </style>
    </head>
    <body>
        <!-- Top Ribbon -->
        <div class="top-ribbon bg-dark bg-opacity-50 text-white py-1">
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('about') }}" class="text-white text-decoration-none small">
                            <i class="bi bi-info-circle me-1"></i> About Us
                        </a>
                        <a href="{{ route('services') }}" class="text-white text-decoration-none small">
                            <i class="bi bi-briefcase me-1"></i> Services & Pricing
                        </a>
                    </div>
                    <div class="d-none d-md-flex align-items-center gap-3">
                        <span class="small">
                            <i class="bi bi-envelope me-1"></i> info@renovationdefenders.com
                        </span>
                        <span class="small">
                            <i class="bi bi-telephone me-1"></i> (555) 123-4567
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-section">
            <!-- Navigation -->
            <nav class="container-fluid px-4 py-3" style="position: relative; z-index: 1000;">
                <div class="d-flex justify-content-end gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-light">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-outline-light">
                            Log in
                        </a>
                        <a href="{{ url('/register') }}" class="btn btn-light">
                            Register
                        </a>
                    @endauth
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="container">
                <div class="row align-items-center justify-content-center" style="min-height: 70vh; margin-top: -80px;">
                    <div class="col-lg-10">
                        <div class="text-center">
                            <!-- Logo -->
                            <div class="mb-4">
                                <img src="{{ asset('images/rdlogo.png') }}"
                                     alt="Renovation Defenders"
                                     style="max-height: 300px; filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.3));"
                                     class="img-fluid mx-auto d-block">
                            </div>

                            <!-- Hero Text -->
                            <h1 class="display-3 fw-bold text-white mb-4">
                                Welcome to Renovation Defenders
                            </h1>
                            <p class="lead text-white mb-5" style="font-size: 1.5rem; max-width: 800px; margin: 0 auto;">
                                Your trusted partner in home renovation
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center pb-4">
                <p class="text-white mb-0" style="text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                    &copy; {{ date('Y') }} Renovation Defenders. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
