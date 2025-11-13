@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ $course->TITLE }}</h1>
    <div>
        <a href="{{ route('admin.courses.edit', $course->ID) }}" class="btn btn-primary">Edit Course</a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</div>

<!-- Course Details -->
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Course Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Title:</strong>
                <p>{{ $course->TITLE }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <strong>Status:</strong>
                <p>
                    <span class="badge {{ $course->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}" style="background-color: {{ $course->IS_ACTIVE ? '#198754' : '#6c757d' }} !important; color: white;">
                        {{ $course->IS_ACTIVE ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <strong>Description:</strong>
                <p>{{ $course->DESCRIPTION ?? 'No description provided.' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Created:</strong>
                <p>{{ $course->created_at ? $course->created_at->format('F d, Y g:i A') : '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Last Updated:</strong>
                <p>{{ $course->updated_at ? $course->updated_at->format('F d, Y g:i A') : '-' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Videos Table -->
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Course Videos ({{ $course->videos->count() }})</h5>
        <a href="{{ route('admin.videos.create') }}?course_id={{ $course->ID }}" class="btn btn-sm btn-primary">Add Video</a>
    </div>
    <div class="card-body">
        @if($course->videos->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Module</th>
                        <th>Duration</th>
                        <th>Required</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->videos->sortBy('ORDER') as $video)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.videos.edit', $video->ID) }}';">
                        <td>{{ $video->ORDER }}</td>
                        <td>{{ $video->TITLE }}</td>
                        <td>{{ $video->MODULE ?? '-' }}</td>
                        <td>{{ $video->DURATION }}s</td>
                        <td>
                            @if($video->REQUIRED)
                                <span class="badge bg-warning" style="background-color: #ffc107 !important; color: #000;">Required</span>
                            @else
                                <span class="text-muted">Optional</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $video->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}" style="background-color: {{ $video->IS_ACTIVE ? '#198754' : '#6c757d' }} !important; color: white;">
                                {{ $video->IS_ACTIVE ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td onclick="event.stopPropagation();">
                            <form action="{{ route('admin.videos.destroy', $video->ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this video?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <i class="bi bi-camera-video-off" style="font-size: 3rem;"></i>
            <p class="mt-3">No videos in this course yet.</p>
            <a href="{{ route('admin.videos.create') }}?course_id={{ $course->ID }}" class="btn btn-primary">Add First Video</a>
        </div>
        @endif
    </div>
</div>
@endsection
