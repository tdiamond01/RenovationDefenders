@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create New Course</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.courses.store') }}" method="POST">
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
                <textarea class="form-control @error('DESCRIPTION') is-invalid @enderror" id="DESCRIPTION" name="DESCRIPTION" rows="4">{{ old('DESCRIPTION') }}</textarea>
                @error('DESCRIPTION')
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

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Course</button>
            </div>
        </form>
    </div>
</div>
@endsection
