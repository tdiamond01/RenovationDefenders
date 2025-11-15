@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Manage Videos for {{ $course->TITLE }}</h1>
        <p class="text-muted mb-0">Add existing videos or create new ones</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Back to Courses</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Course Videos ({{ $course->videos->count() }})</h5>
            </div>
            <div class="card-body">
                @if($course->videos->isEmpty())
                    <p class="text-muted text-center py-4">No videos in this course yet.</p>
                @else
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
                                @foreach($course->videos as $video)
                                <tr>
                                    <td>{{ $video->ORDER }}</td>
                                    <td>
                                        <strong>{{ $video->TITLE }}</strong>
                                        @if($video->DESCRIPTION)
                                            <br><small class="text-muted">{{ Str::limit($video->DESCRIPTION, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $video->MODULE ?? '-' }}</td>
                                    <td>{{ $video->DURATION }}s</td>
                                    <td>
                                        @if($video->REQUIRED)
                                            <span class="badge bg-warning text-dark">Required</span>
                                        @else
                                            <span class="text-muted">Optional</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $video->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $video->IS_ACTIVE ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.videos.edit', $video->ID) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.courses.remove-video', [$course->ID, $video->ID]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Remove this video from the course? The video will not be deleted.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-warning btn-sm">Remove</button>
                                            </form>
                                            <form action="{{ route('admin.courses.delete-video', [$course->ID, $video->ID]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Permanently delete this video? This cannot be undone!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Add Existing Video -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Add Existing Video</h5>
            </div>
            <div class="card-body">
                @if($availableVideos->isEmpty())
                    <p class="text-muted">No available videos to add.</p>
                @else
                    <form action="{{ route('admin.courses.add-video', $course->ID) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="VIDEO_ID" class="form-label">Select Video</label>
                            <select name="VIDEO_ID" id="VIDEO_ID" class="form-select @error('VIDEO_ID') is-invalid @enderror" required>
                                <option value="">Choose a video...</option>
                                @foreach($availableVideos as $video)
                                    <option value="{{ $video->ID }}">
                                        {{ $video->TITLE }}
                                        @if($video->COURSE_ID)
                                            (Currently in: {{ $video->course->TITLE ?? 'Unknown' }})
                                        @else
                                            (Unassigned)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('VIDEO_ID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Video</button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Create New Video -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Video</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createVideoModal">
                    Create New Video
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create Video Modal -->
<div class="modal fade" id="createVideoModal" tabindex="-1" aria-labelledby="createVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.courses.create-video', $course->ID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createVideoModalLabel">Create New Video for {{ $course->TITLE }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="TITLE" class="form-label">Title</label>
                        <input type="text" class="form-control @error('TITLE') is-invalid @enderror" id="TITLE" name="TITLE" value="{{ old('TITLE') }}" required>
                        @error('TITLE')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="DESCRIPTION" class="form-label">Description</label>
                        <textarea class="form-control @error('DESCRIPTION') is-invalid @enderror" id="DESCRIPTION" name="DESCRIPTION" rows="3">{{ old('DESCRIPTION') }}</textarea>
                        @error('DESCRIPTION')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="MODULE" class="form-label">Module</label>
                            <input type="text" class="form-control @error('MODULE') is-invalid @enderror" id="MODULE" name="MODULE" value="{{ old('MODULE') }}">
                            @error('MODULE')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="ORDER" class="form-label">Order</label>
                            <input type="number" class="form-control @error('ORDER') is-invalid @enderror" id="ORDER" name="ORDER" value="{{ old('ORDER', $course->videos->max('ORDER') + 1 ?? 1) }}" required>
                            @error('ORDER')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="DURATION" class="form-label">Duration (s)</label>
                            <input type="number" class="form-control @error('DURATION') is-invalid @enderror" id="DURATION" name="DURATION" value="{{ old('DURATION') }}" required>
                            @error('DURATION')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="video_file" class="form-label">Video File</label>
                        <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file" accept="video/*" required>
                        <small class="text-muted">Max size: 500MB. Supported formats: MP4, MPEG, MOV</small>
                        @error('video_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="IS_ACTIVE" value="0">
                            <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="IS_ACTIVE">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="REQUIRED" value="0">
                            <input class="form-check-input" type="checkbox" name="REQUIRED" value="1" id="REQUIRED" {{ old('REQUIRED') ? 'checked' : '' }}>
                            <label class="form-check-label" for="REQUIRED">
                                Required
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Video</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('createVideoModal'));
        myModal.show();
    });
</script>
@endif
@endsection
