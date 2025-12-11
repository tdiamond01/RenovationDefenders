<x-app-layout>
    <style>
        .sidebar {
            height: calc(100vh - 80px);
            overflow-y: auto;
            position: sticky;
            top: 80px;
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .course-item {
            border-bottom: 1px solid #dee2e6;
        }
        .course-header {
            padding: 1rem;
            cursor: pointer;
            background: #fff;
            transition: background-color 0.2s;
        }
        .course-header:hover:not(.active) {
            background: #e9ecef;
        }
        .course-header.active {
            background: #0d6efd;
            color: white;
        }
        .course-header.active .badge {
            color: #0d6efd !important;
            background-color: white !important;
        }
        .module-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .module-item {
            padding: 0.75rem 1rem 0.75rem 2rem;
            border-top: 1px solid #dee2e6;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .module-item:hover {
            background: #e9ecef;
        }
        .module-item.completed {
            background: #d1e7dd;
        }
        .module-item.active {
            background: #cfe2ff;
            font-weight: bold;
        }
        .progress-badge {
            font-size: 0.75rem;
        }
        .chevron-toggle {
            transition: transform 0.2s ease;
            display: inline-block;
            font-size: 1.2rem;
        }
        .course-header:not(.collapsed) .chevron-toggle {
            transform: rotate(180deg);
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center position-relative">
            <h1 class="display-4 fw-bold mb-2">Renovation Defenders</h1>
            <p class="mb-4" style="font-size: 1.1rem; color: white; font-style: italic;">We protect your renovation before it even start!</p>
            <p class="lead mb-4">Welcome back, {{ Auth::user()->NAME }}!</p>
            @if($currentAssignment)
                <h3 class="mb-4">{{ $currentAssignment->course->TITLE }}</h3>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid mt-4">
        @if($assignments->isEmpty())
            <div class="alert alert-info text-center">
                <h4>No Courses Assigned</h4>
                <p>You don't have any courses assigned yet. Please contact your administrator.</p>
            </div>
        @else
        <div class="row">
            <!-- Left Sidebar - Courses & Modules -->
            <div class="col-md-3 px-0">
                <div class="sidebar">
                    <div class="p-3 border-bottom">
                        <h5 class="mb-0">My Courses</h5>
                    </div>
                    @foreach($assignments as $assignment)
                        <div class="course-item">
                            <div class="course-header {{ $currentAssignment && $currentAssignment->COURSE_ID == $assignment->COURSE_ID ? 'active' : '' }} {{ $currentAssignment && $currentAssignment->COURSE_ID == $assignment->COURSE_ID ? '' : 'collapsed' }}"
                                 data-bs-toggle="collapse"
                                 data-bs-target="#course-{{ $assignment->COURSE_ID }}"
                                 aria-expanded="{{ $currentAssignment && $currentAssignment->COURSE_ID == $assignment->COURSE_ID ? 'true' : 'false' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $assignment->course->TITLE }}</strong>
                                        <div class="small mt-1">
                                            <span class="progress-badge badge {{ $assignment->PROGRESS_PERCENTAGE >= 100 ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $assignment->PROGRESS_PERCENTAGE }}% Complete
                                            </span>
                                        </div>
                                    </div>
                                    <span class="chevron-toggle">▼</span>
                                </div>
                            </div>
                            <div class="collapse {{ $currentAssignment && $currentAssignment->COURSE_ID == $assignment->COURSE_ID ? 'show' : '' }}"
                                 id="course-{{ $assignment->COURSE_ID }}">
                                <ul class="module-list">
                                    @foreach($assignment->course->videos as $video)
                                        <li class="module-item {{ isset($allVideoProgress[$video->ID]) && $allVideoProgress[$video->ID]->COMPLETED ? 'completed' : '' }}"
                                            onclick="window.location.href='{{ route('dashboard', ['course_id' => $assignment->COURSE_ID]) }}#video-{{ $video->ID }}'">
                                            <span>
                                                @if($video->MODULE)
                                                    <small class="text-muted">{{ $video->MODULE }}:</small><br>
                                                @endif
                                                {{ $video->TITLE }}
                                            </span>
                                            @if(isset($allVideoProgress[$video->ID]) && $allVideoProgress[$video->ID]->COMPLETED)
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9">
                <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="card-title fw-bold mb-4">Course Content</h3>
                                @php
                                    $introVideo = $videos->where('ORDER', 0)->first();
                                @endphp
                                @if($introVideo)
                                <div id="video-{{ $introVideo->ID }}" class="card mb-3 {{ isset($videoProgress[$introVideo->ID]) && $videoProgress[$introVideo->ID]->COMPLETED ? 'border-success' : '' }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="card-title">{{ $introVideo->TITLE }}</h5>
                                            @if(isset($videoProgress[$introVideo->ID]) && $videoProgress[$introVideo->ID]->COMPLETED)
                                                <span class="badge bg-success">Completed</span>
                                            @endif
                                        </div>
                                        <p class="text-muted">{{ $introVideo->DESCRIPTION }}</p>
                                        <video width="100%" controls>
                                            <source src="{{ $introVideo->video_url }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <small class="text-muted mt-2 d-block">Duration: {{ $introVideo->DURATION }} seconds</small>
                                    </div>
                                </div>
                                @endif

                                <div class="mt-4">
                                    <h4 class="fw-bold mb-3">Course Modules</h4>
                                    @foreach($videos->where('ORDER', '>', 0) as $video)
                                    <div id="video-{{ $video->ID }}" class="mb-3">
                                        <div class="card {{ isset($videoProgress[$video->ID]) && $videoProgress[$video->ID]->COMPLETED ? 'border-success' : '' }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="card-title">{{ $video->MODULE }}: {{ $video->TITLE }}</h5>
                                                    @if(isset($videoProgress[$video->ID]) && $videoProgress[$video->ID]->COMPLETED)
                                                        <span class="badge bg-success">Completed</span>
                                                    @endif
                                                </div>
                                                <p class="text-muted">{{ $video->DESCRIPTION }}</p>
                                                <video width="100%" controls>
                                                    <source src="{{ $video->video_url }}" type="video/mp4">
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
                    <div class="col-lg-4">
                        @if($progress)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Course Progress</h5>
                                <p class="mb-2">{{ $progress['completed'] }} of {{ $progress['total'] }} Videos Completed</p>
                                <div class="progress mb-3" style="height: 25px;">
                                    <div class="progress-bar {{ $progress['percentage'] >= 100 ? 'bg-success' : '' }}" role="progressbar" style="width: {{ $progress['percentage'] }}%; {{ $progress['percentage'] < 100 ? 'background-color: #17a2b8;' : '' }}" aria-valuenow="{{ $progress['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $progress['percentage'] }}%
                                    </div>
                                </div>
                                @if($progress['percentage'] >= 100)
                                    <div class="alert alert-success mb-0">
                                        <strong>Congratulations!</strong> You've completed this course!
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="card mb-4">
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

                        @if(Auth::user()->ROLE === 'user')
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0"><i class="bi bi-play-circle me-2"></i>Meet Stephen</h5>
                            </div>
                            <div class="card-body p-0">
                                <video class="w-100" controls preload="metadata">
                                    <source src="https://renovation-defenders-videos.s3.us-west-2.amazonaws.com/meet_stephen.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Smooth scroll to video when clicking from sidebar
        document.addEventListener('DOMContentLoaded', function() {
            // Handle hash navigation on page load
            if (window.location.hash) {
                setTimeout(function() {
                    const element = document.querySelector(window.location.hash);
                    if (element) {
                        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 500);
            }
        });
    </script>
</x-app-layout>
