<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\UserCourseAssignment;
use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('ID')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:USERS,EMAIL',
            'PASSWORD' => 'required|string|min:8|confirmed',
            'ROLE' => ['required', Rule::in(['admin', 'user'])],
        ]);

        $validated['PASSWORD'] = Hash::make($validated['PASSWORD']);
        $validated['EMAIL_VERIFIED_AT'] = now();

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'EMAIL' => ['required', 'email', Rule::unique('USERS', 'EMAIL')->ignore($user->ID, 'ID')],
            'ROLE' => ['required', Rule::in(['admin', 'user'])],
            'PASSWORD' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['PASSWORD'])) {
            $validated['PASSWORD'] = Hash::make($validated['PASSWORD']);
        } else {
            unset($validated['PASSWORD']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Show course assignments for the user.
     */
    public function courses(string $id)
    {
        $user = User::findOrFail($id);
        $allCourses = Course::where('IS_ACTIVE', true)->orderBy('ID')->get();

        // Get assignments with course details and progress
        $assignments = UserCourseAssignment::where('USER_ID', $id)
            ->with(['course.videos'])
            ->orderBy('ID')
            ->get()
            ->map(function ($assignment) use ($id) {
                $course = $assignment->course;
                $totalVideos = $course->videos->count();
                $completedVideos = VideoProgress::where('USER_ID', $id)
                    ->whereIn('VIDEO_ID', $course->videos->pluck('ID'))
                    ->where('COMPLETED', true)
                    ->count();

                $assignment->total_videos = $totalVideos;
                $assignment->completed_videos = $completedVideos;

                return $assignment;
            });

        $assignedCourseIds = $assignments->pluck('COURSE_ID')->toArray();
        $availableCourses = $allCourses->whereNotIn('ID', $assignedCourseIds);

        return view('admin.users.courses', compact('user', 'assignments', 'availableCourses'));
    }

    /**
     * Assign a course to the user.
     */
    public function assignCourse(Request $request, string $id)
    {
        $request->validate([
            'COURSE_ID' => 'required|exists:COURSES,ID',
        ]);

        $user = User::findOrFail($id);

        // Check if already assigned
        $existingAssignment = UserCourseAssignment::where('USER_ID', $id)
            ->where('COURSE_ID', $request->COURSE_ID)
            ->first();

        if ($existingAssignment) {
            return redirect()->route('admin.users.courses', $id)
                ->with('error', 'Course is already assigned to this user.');
        }

        UserCourseAssignment::create([
            'USER_ID' => $id,
            'COURSE_ID' => $request->COURSE_ID,
            'ASSIGNED_AT' => now(),
            'PROGRESS_PERCENTAGE' => 0,
        ]);

        return redirect()->route('admin.users.courses', $id)
            ->with('success', 'Course assigned successfully.');
    }

    /**
     * Remove a course assignment from the user.
     */
    public function unassignCourse(string $userId, string $courseId)
    {
        $assignment = UserCourseAssignment::where('USER_ID', $userId)
            ->where('COURSE_ID', $courseId)
            ->firstOrFail();

        $assignment->delete();

        return redirect()->route('admin.users.courses', $userId)
            ->with('success', 'Course unassigned successfully.');
    }
}
