<?php

namespace App\Http\Controllers;

use App\Models\UserCourseAssignment;
use App\Models\VideoProgress;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Redirect admins to admin panel
        if ($user->ROLE === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Get user's assigned courses with all videos
        $assignments = UserCourseAssignment::where('USER_ID', $user->ID)
            ->with(['course.videos' => function($query) {
                $query->where('IS_ACTIVE', true)->orderBy('ORDER');
            }])
            ->orderBy('ID')
            ->get();

        // Get all video progress for the user across all courses
        $allVideoProgress = VideoProgress::where('USER_ID', $user->ID)->get()->keyBy('VIDEO_ID');

        // If no courses assigned, show message
        if ($assignments->isEmpty()) {
            return view('dashboard', [
                'assignments' => $assignments,
                'currentAssignment' => null,
                'videos' => collect([]),
                'progress' => null,
                'videoProgress' => collect([]),
                'allVideoProgress' => collect([]),
            ]);
        }

        // Get current course from request or session, default to first assignment
        $courseId = $request->input('course_id', session('current_course_id', $assignments->first()->COURSE_ID));

        // Store in session
        session(['current_course_id' => $courseId]);

        // Get current assignment
        $currentAssignment = $assignments->firstWhere('COURSE_ID', $courseId);

        // If course not found in assignments, use first one
        if (!$currentAssignment) {
            $currentAssignment = $assignments->first();
            session(['current_course_id' => $currentAssignment->COURSE_ID]);
        }

        // Get videos for current course
        $videos = $currentAssignment->course->videos;

        // Calculate progress
        $totalVideos = $videos->count();
        $completedVideos = VideoProgress::where('USER_ID', $user->ID)
            ->whereIn('VIDEO_ID', $videos->pluck('ID'))
            ->where('COMPLETED', true)
            ->count();

        $progressPercentage = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;

        // Update assignment progress
        $currentAssignment->update([
            'PROGRESS_PERCENTAGE' => $progressPercentage,
            'COMPLETED_AT' => $progressPercentage >= 100 ? now() : null,
        ]);

        $progress = [
            'total' => $totalVideos,
            'completed' => $completedVideos,
            'percentage' => $progressPercentage,
        ];

        // Get video progress for current user
        $videoProgress = VideoProgress::where('USER_ID', $user->ID)
            ->whereIn('VIDEO_ID', $videos->pluck('ID'))
            ->get()
            ->keyBy('VIDEO_ID');

        return view('dashboard', compact('assignments', 'currentAssignment', 'videos', 'progress', 'videoProgress', 'allVideoProgress'));
    }

    public function switchCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:COURSES,ID',
        ]);

        session(['current_course_id' => $request->course_id]);

        return redirect()->route('dashboard');
    }
}
