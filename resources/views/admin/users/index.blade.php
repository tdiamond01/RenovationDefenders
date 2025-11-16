@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Users Management</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.users.edit', $user->ID) }}';">
                        <td>{{ $user->ID }}</td>
                        <td>{{ $user->NAME }}</td>
                        <td>{{ $user->EMAIL }}</td>
                        <td>
                            <span class="badge {{ $user->ROLE === 'admin' ? 'bg-primary' : 'bg-secondary' }}" style="background-color: {{ $user->ROLE === 'admin' ? '#0d6efd' : '#6c757d' }} !important; color: white;">
                                {{ ucfirst($user->ROLE) }}
                            </span>
                        </td>
                        <td>{{ $user->CREATED_AT->format('M d, Y') }}</td>
                        <td onclick="event.stopPropagation();">
                            <a href="{{ route('admin.users.courses', $user->ID) }}" class="btn btn-outline-primary btn-sm">Courses</a>
                            <form action="{{ route('admin.users.destroy', $user->ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
