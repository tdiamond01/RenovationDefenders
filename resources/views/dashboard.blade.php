<x-app-layout>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center position-relative">
            <h1 class="display-4 fw-bold mb-4">Renovation Defenders</h1>
            <p class="lead mb-4">Welcome back, {{ Auth::user()->NAME }}!</p>
            <button class="btn btn-primary btn-lg">Resume Course</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Start Here Section -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title fw-bold mb-4">Start Here</h3>
                        @php
                            $introVideo = $videos->where('ORDER', 0)->first();
                        @endphp
                        @if($introVideo)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $introVideo->TITLE }}</h5>
                                <p class="text-muted">{{ $introVideo->DESCRIPTION }}</p>
                                <video width="100%" controls>
                                    <source src="{{ route('videos.stream', $introVideo->ID) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <small class="text-muted mt-2 d-block">Duration: {{ $introVideo->DURATION }} seconds</small>
                            </div>
                        </div>
                        @endif

                        <div class="mt-4">
                            <h4 class="fw-bold mb-3">Course Modules</h4>
                            @foreach($videos->where('ORDER', '>', 0) as $video)
                            <div class="mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $video->MODULE }}: {{ $video->TITLE }}</h5>
                                        <p class="text-muted">{{ $video->DESCRIPTION }}</p>
                                        <video width="100%" controls>
                                            <source src="{{ route('videos.stream', $video->ID) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <small class="text-muted mt-2 d-block">Duration: {{ $video->DURATION }} seconds</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Progress</h5>
                        <p class="mb-2">4 of 5 Lessons Completed</p>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: 80%; background-color: #17a2b8;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                80%
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Instructor</h5>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/stephen-headshot.jpg') }}" alt="Stephen Selby" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">Stephen Selby</h6>
                                <small class="text-muted">Founder, Renovation Defenders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
