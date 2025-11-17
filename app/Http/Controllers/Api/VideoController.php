<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Get videos for a specific course
     */
    public function index(Request $request, $courseId)
    {
        $user = $request->user();

        // Verify user has access to this course
        $course = $user->assignedCourses()
            ->where('COURSES.ID', $courseId)
            ->where('IS_ACTIVE', true)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Course not found or not assigned to you',
            ], 404);
        }

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
            'videos' => $videos,
        ]);
    }

    /**
     * Get a specific video
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $video = Video::where('ID', $id)
            ->where('IS_ACTIVE', true)
            ->first();

        if (!$video) {
            return response()->json([
                'message' => 'Video not found',
            ], 404);
        }

        // Verify user has access to the course this video belongs to
        $course = $user->assignedCourses()
            ->where('COURSES.ID', $video->COURSE_ID)
            ->where('IS_ACTIVE', true)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'You do not have access to this video',
            ], 403);
        }

        // Get user's progress for this video
        $progress = $user->videoProgress()
            ->where('VIDEO_ID', $video->ID)
            ->first();

        return response()->json([
            'video' => [
                'id' => $video->ID,
                'course_id' => $video->COURSE_ID,
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
            ],
        ]);
    }
}
