<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Get all courses assigned to the authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = $user->assignedCourses()
            ->where('IS_ACTIVE', true)
            ->orderBy('TITLE', 'asc')
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->ID,
                    'title' => $course->TITLE,
                    'description' => $course->DESCRIPTION,
                    'is_active' => (bool) $course->IS_ACTIVE,
                    'assigned_at' => $course->pivot->ASSIGNED_AT,
                    'completed_at' => $course->pivot->COMPLETED_AT,
                    'progress_percentage' => $course->pivot->PROGRESS_PERCENTAGE,
                ];
            });

        return response()->json([
            'courses' => $courses,
        ]);
    }

    /**
     * Get a specific course with its videos
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $course = $user->assignedCourses()
            ->where('COURSES.ID', $id)
            ->where('IS_ACTIVE', true)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Course not found or not assigned to you',
            ], 404);
        }

        // Get videos for this course
        $videos = $course->videos()
            ->where('IS_ACTIVE', true)
            ->orderBy('MODULE', 'asc')
            ->orderBy('ORDER', 'asc')
            ->get()
            ->map(function ($video) use ($user) {
                // Get user's progress for this video
                $progress = $user->videoProgress()
                    ->where('VIDEO_ID', $video->ID)
                    ->first();

                return [
                    'id' => $video->ID,
                    'title' => $video->TITLE,
                    'description' => $video->DESCRIPTION,
                    'duration' => $video->DURATION,
                    'module' => $video->MODULE,
                    'order' => $video->ORDER,
                    'required' => (bool) $video->REQUIRED,
                    'video_url' => $video->video_url,
                    'thumbnail_url' => $video->thumbnail_url,
                    'progress' => $progress ? [
                        'watched_duration' => $progress->WATCHED_DURATION,
                        'total_duration' => $progress->TOTAL_DURATION,
                        'completed' => (bool) $progress->COMPLETED,
                        'last_watched_at' => $progress->LAST_WATCHED_AT,
                    ] : null,
                ];
            });

        return response()->json([
            'course' => [
                'id' => $course->ID,
                'title' => $course->TITLE,
                'description' => $course->DESCRIPTION,
                'is_active' => (bool) $course->IS_ACTIVE,
                'assigned_at' => $course->pivot->ASSIGNED_AT,
                'completed_at' => $course->pivot->COMPLETED_AT,
                'progress_percentage' => $course->pivot->PROGRESS_PERCENTAGE,
            ],
            'videos' => $videos,
        ]);
    }
}
