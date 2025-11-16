<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-center mb-4">
                <a href="/">
                    <img src="{{ asset('images/rdlogo.png') }}" alt="Renovation Defenders Logo" style="max-height: 220px; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));" class="img-fluid">
                </a>
            </div>

            <div class="card auth-card shadow-lg" style="width: 100%; max-width: 450px; border: none; border-radius: 1rem;">
                <div class="card-body p-5">
                    {{ $slot }}
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="text-white mb-0" style="font-size: 0.875rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                    &copy; {{ date('Y') }} Renovation Defenders. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
