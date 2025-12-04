<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        <style>
            .admin-sidebar {
                min-height: calc(100vh - 56px);
                background-color: #f8f9fa;
                border-right: 1px solid #dee2e6;
                position: sticky;
                top: 56px;
                padding: 0;
            }
            .admin-sidebar .nav-link {
                color: #495057;
                padding: 1rem 1.5rem;
                border-left: 3px solid transparent;
                transition: all 0.2s;
            }
            .admin-sidebar .nav-link:hover {
                background-color: #e9ecef;
                color: #3d3d6b;
            }
            .admin-sidebar .nav-link.active {
                background-color: #e7f1ff;
                color: #3d3d6b;
                border-left-color: #3d3d6b;
                font-weight: 600;
            }
            .admin-sidebar .nav-link i {
                width: 20px;
                margin-right: 10px;
            }
        </style>
    </head>
    <body>
        <div class="min-vh-100">
            @include('layouts.admin-navigation')

            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <nav class="col-md-2 col-lg-2 d-md-block admin-sidebar">
                        <div class="position-sticky">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-people"></i> Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                                        <i class="bi bi-book"></i> Courses
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}" href="{{ route('admin.videos.index') }}">
                                        <i class="bi bi-play-circle"></i> Videos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}" href="{{ route('admin.catalog.index') }}">
                                        <i class="bi bi-cart3"></i> Catalog
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <!-- Main Content -->
                    <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4 py-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
