@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Course Assignments for {{ $user->NAME }}</h1>
        <p class="text-muted mb-0">{{ $user->EMAIL }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Assigned Courses</h5>
            </div>
            <div class="card-body">
                @if($assignments->isEmpty())
                    <p class="text-muted text-center py-4">No courses assigned to this user yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Course</th>
                                    <th>Assigned Date</th>
                                    <th>Progress</th>
                                    <th>Videos Completed</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                <tr>
                                    <td>
                                        <strong>{{ $assignment->course->TITLE }}</strong>
                                    </td>
                                    <td>{{ $assignment->ASSIGNED_AT->format('M d, Y') }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $assignment->PROGRESS_PERCENTAGE }}%;"
                                                aria-valuenow="{{ $assignment->PROGRESS_PERCENTAGE }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $assignment->PROGRESS_PERCENTAGE }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $assignment->completed_videos }} / {{ $assignment->total_videos }}</td>
                                    <td>
                                        @if($assignment->isCompleted())
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($assignment->PROGRESS_PERCENTAGE > 0)
                                            <span class="badge bg-warning text-dark">In Progress</span>
                                        @else
                                            <span class="badge bg-secondary">Not Started</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.unassign-course', [$user->ID, $assignment->COURSE_ID]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to unassign this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Unassign</button>
                                        </form>
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Assign New Course</h5>
            </div>
            <div class="card-body">
                @if($availableCourses->isEmpty())
                    <p class="text-muted">All active courses have been assigned to this user.</p>
                @else
                    <form action="{{ route('admin.users.assign-course', $user->ID) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="COURSE_ID" class="form-label">Select Course</label>
                            <select name="COURSE_ID" id="COURSE_ID" class="form-select @error('COURSE_ID') is-invalid @enderror" required>
                                <option value="">Choose a course...</option>
                                @foreach($availableCourses as $course)
                                    <option value="{{ $course->ID }}">{{ $course->TITLE }}</option>
                                @endforeach
                            </select>
                            @error('COURSE_ID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign Course</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
