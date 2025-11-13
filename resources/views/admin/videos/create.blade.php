@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Upload New Video</h1>
    <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                    <label for="COURSE_ID" class="form-label">Course</label>
                    <select class="form-select @error('COURSE_ID') is-invalid @enderror" id="COURSE_ID" name="COURSE_ID">
                        <option value="">Select a course (optional)</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->ID }}" {{ (old('COURSE_ID') ?? request('course_id')) == $course->ID ? 'selected' : '' }}>
                                {{ $course->TITLE }}
                            </option>
                        @endforeach
                    </select>
                    @error('COURSE_ID')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="MODULE" class="form-label">Module</label>
                    <input type="text" class="form-control @error('MODULE') is-invalid @enderror" id="MODULE" name="MODULE" value="{{ old('MODULE') }}">
                    @error('MODULE')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ORDER" class="form-label">Order</label>
                    <input type="number" class="form-control @error('ORDER') is-invalid @enderror" id="ORDER" name="ORDER" value="{{ old('ORDER', 0) }}" min="0" required>
                    @error('ORDER')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="DURATION" class="form-label">Duration (seconds)</label>
                    <input type="number" class="form-control @error('DURATION') is-invalid @enderror" id="DURATION" name="DURATION" value="{{ old('DURATION') }}" min="0" required>
                    @error('DURATION')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="video_file" class="form-label">Video File</label>
                <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file" accept="video/mp4,video/mpeg,video/quicktime" required>
                <div class="form-text">Accepted formats: MP4, MPEG, MOV. Max size: 500MB</div>
                @error('video_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="IS_ACTIVE" value="0">
                        <input class="form-check-input" type="checkbox" name="IS_ACTIVE" value="1" id="IS_ACTIVE" {{ old('IS_ACTIVE', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="IS_ACTIVE">
                            Active
                        </label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="hidden" name="REQUIRED" value="0">
                        <input class="form-check-input" type="checkbox" name="REQUIRED" value="1" id="REQUIRED" {{ old('REQUIRED', false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="REQUIRED">
                            Required (must complete before next video)
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Upload Video</button>
            </div>
        </form>
    </div>
</div>
@endsection
