@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Course</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.courses.update', $course->ID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="TITLE" class="form-label">Title</label>
                <input type="text" class="form-control @error('TITLE') is-invalid @enderror" id="TITLE" name="TITLE" value="{{ old('TITLE', $course->TITLE) }}" required>
                @error('TITLE')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="DESCRIPTION" class="form-label">Description</label>
                <textarea class="form-control @error('DESCRIPTION') is-invalid @enderror" id="DESCRIPTION" name="DESCRIPTION" rows="4">{{ old('DESCRIPTION', $course->DESCRIPTION) }}</textarea>
                @error('DESCRIPTION')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="hidden" name="IS_ACTIVE" value="0">
                    <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', $course->IS_ACTIVE) ? 'checked' : '' }}>
                    <label class="form-check-label" for="IS_ACTIVE">
                        Active
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Course</button>
            </div>
        </form>
    </div>
</div>

<!-- Videos Subgrid -->
<div class="card mt-4">
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
                            <form action="{{ route('admin.videos.destroy', $video->ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this video?');">
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
        <div class="text-center text-muted py-4">
            <p>No videos in this course yet.</p>
            <a href="{{ route('admin.videos.create') }}?course_id={{ $course->ID }}" class="btn btn-sm btn-primary">Add First Video</a>
        </div>
        @endif
    </div>
</div>
@endsection
