@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create New User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="NAME" class="form-label">Name</label>
                <input type="text" class="form-control @error('NAME') is-invalid @enderror" id="NAME" name="NAME" value="{{ old('NAME') }}" required>
                @error('NAME')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="EMAIL" class="form-label">Email</label>
                <input type="email" class="form-control @error('EMAIL') is-invalid @enderror" id="EMAIL" name="EMAIL" value="{{ old('EMAIL') }}" required>
                @error('EMAIL')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="PASSWORD" class="form-label">Password</label>
                <input type="password" class="form-control @error('PASSWORD') is-invalid @enderror" id="PASSWORD" name="PASSWORD" required>
                @error('PASSWORD')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="PASSWORD_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="PASSWORD_confirmation" name="PASSWORD_confirmation" required>
            </div>

            <div class="mb-3">
                <label for="ROLE" class="form-label">Role</label>
                <select class="form-select @error('ROLE') is-invalid @enderror" id="ROLE" name="ROLE" required>
                    <option value="user" {{ old('ROLE') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('ROLE') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('ROLE')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection
