@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->ID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="NAME" class="form-label">Name</label>
                <input type="text" class="form-control @error('NAME') is-invalid @enderror" id="NAME" name="NAME" value="{{ old('NAME', $user->NAME) }}" required>
                @error('NAME')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="EMAIL" class="form-label">Email</label>
                <input type="email" class="form-control @error('EMAIL') is-invalid @enderror" id="EMAIL" name="EMAIL" value="{{ old('EMAIL', $user->EMAIL) }}" required>
                @error('EMAIL')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="PASSWORD" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                <input type="password" class="form-control @error('PASSWORD') is-invalid @enderror" id="PASSWORD" name="PASSWORD">
                @error('PASSWORD')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="PASSWORD_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="PASSWORD_confirmation" name="PASSWORD_confirmation">
            </div>

            <div class="mb-3">
                <label for="ROLE" class="form-label">Role</label>
                <select class="form-select @error('ROLE') is-invalid @enderror" id="ROLE" name="ROLE" required>
                    <option value="user" {{ old('ROLE', $user->ROLE) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('ROLE', $user->ROLE) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('ROLE')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection
