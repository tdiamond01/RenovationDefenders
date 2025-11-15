@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Courses Management</h1>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Add New Course</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Videos</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.courses.edit', $course->ID) }}';">
                        <td>{{ $course->ID }}</td>
                        <td>{{ $course->TITLE }}</td>
                        <td>
                            <span class="badge bg-info">{{ $course->videos_count }} videos</span>
                        </td>
                        <td>
                            <span class="badge {{ $course->IS_ACTIVE ? 'bg-success' : 'bg-secondary' }}" style="background-color: {{ $course->IS_ACTIVE ? '#198754' : '#6c757d' }} !important; color: white;">
                                {{ $course->IS_ACTIVE ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $course->created_at ? $course->created_at->format('M d, Y') : '-' }}</td>
                        <td onclick="event.stopPropagation();">
                            <a href="{{ route('admin.courses.videos', $course->ID) }}" class="btn btn-outline-primary btn-sm">Videos</a>
                            <form action="{{ route('admin.courses.destroy', $course->ID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No courses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $courses->links() }}
</div>
@endsection
