@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Videos Management</h1>
    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">Add New Video</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Module</th>
                        <th>Order</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.videos.edit', $video->ID) }}';">
                        <td>{{ $video->ID }}</td>
                        <td>{{ $video->TITLE }}</td>
                        <td>{{ $video->MODULE ?? '-' }}</td>
                        <td>{{ $video->ORDER }}</td>
                        <td>{{ $video->DURATION }}s</td>
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
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No videos found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $videos->links() }}
</div>
@endsection
