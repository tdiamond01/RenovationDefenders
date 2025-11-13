@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Admin Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Users</h6>
                        <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                        <small class="text-muted">{{ $stats['total_admins'] }} admins</small>
                    </div>
                    <div class="text-primary" style="font-size: 3rem;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary bg-opacity-10">
                <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none small">
                    View all users <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Courses</h6>
                        <h2 class="mb-0">{{ $stats['total_courses'] }}</h2>
                        <small class="text-muted">{{ $stats['active_courses'] }} active</small>
                    </div>
                    <div class="text-success" style="font-size: 3rem;">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success bg-opacity-10">
                <a href="{{ route('admin.courses.index') }}" class="text-success text-decoration-none small">
                    View all courses <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Videos</h6>
                        <h2 class="mb-0">{{ $stats['total_videos'] }}</h2>
                        <small class="text-muted">{{ $stats['active_videos'] }} active</small>
                    </div>
                    <div class="text-info" style="font-size: 3rem;">
                        <i class="bi bi-play-circle"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info bg-opacity-10">
                <a href="{{ route('admin.videos.index') }}" class="text-info text-decoration-none small">
                    View all videos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-person-plus d-block mb-2" style="font-size: 2rem;"></i>
                            Add New User
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-book-half d-block mb-2" style="font-size: 2rem;"></i>
                            Add New Course
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.videos.create') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-camera-video d-block mb-2" style="font-size: 2rem;"></i>
                            Upload Video
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 py-3">
                            <i class="bi bi-eye d-block mb-2" style="font-size: 2rem;"></i>
                            Preview Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
