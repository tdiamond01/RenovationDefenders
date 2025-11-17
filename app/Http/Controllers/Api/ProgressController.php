<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoProgress;
use App\Models\UserCourseAssignment;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Update video progress
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();

        $validated = $request->validate([
            'watched_duration' => 'required|integer|min:0',
            'total_duration' => 'required|integer|min:1',
            'completed' => 'boolean',
        ]);

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

        // Update or create progress record
        $progress = VideoProgress::updateOrCreate(
            [
                'USER_ID' => $user->ID,
                'VIDEO_ID' => $id,
            ],
            [
                'WATCHED_DURATION' => $validated['watched_duration'],
                'TOTAL_DURATION' => $validated['total_duration'],
                'COMPLETED' => $validated['completed'] ?? ($validated['watched_duration'] >= $validated['total_duration']),
                'LAST_WATCHED_AT' => now(),
            ]
        );

        // Update course progress
        $this->updateCourseProgress($user->ID, $video->COURSE_ID);

        return response()->json([
            'message' => 'Progress updated successfully',
            'progress' => [
                'watched_duration' => $progress->WATCHED_DURATION,
                'total_duration' => $progress->TOTAL_DURATION,
                'completed' => (bool) $progress->COMPLETED,
                'last_watched_at' => $progress->LAST_WATCHED_AT,
            ],
        ]);
    }

    /**
     * Get all progress for the authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $progress = $user->videoProgress()
            ->with('video:ID,COURSE_ID,TITLE')
            ->orderBy('LAST_WATCHED_AT', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'video_id' => $item->VIDEO_ID,
                    'video_title' => $item->video->TITLE ?? null,
                    'course_id' => $item->video->COURSE_ID ?? null,
                    'watched_duration' => $item->WATCHED_DURATION,
                    'total_duration' => $item->TOTAL_DURATION,
                    'completed' => (bool) $item->COMPLETED,
                    'last_watched_at' => $item->LAST_WATCHED_AT,
                ];
            });

        return response()->json([
            'progress' => $progress,
        ]);
    }

    /**
     * Get progress for a specific course
     */
    public function courseProgress(Request $request, $id)
    {
        $user = $request->user();

        // Verify user has access to this course
        $course = $user->assignedCourses()
            ->where('COURSES.ID', $id)
            ->where('IS_ACTIVE', true)
            ->first();

        if (!$course) {
            return response()->json([
                'message' => 'Course not found or not assigned to you',
            ], 404);
        }

        $videoIds = $course->videos()
            ->where('IS_ACTIVE', true)
            ->pluck('ID');

        $progress = $user->videoProgress()
            ->whereIn('VIDEO_ID', $videoIds)
            ->with('video:ID,TITLE,MODULE,ORDER')
            ->get()
            ->map(function ($item) {
                return [
                    'video_id' => $item->VIDEO_ID,
                    'video_title' => $item->video->TITLE ?? null,
                    'module' => $item->video->MODULE ?? null,
                    'order' => $item->video->ORDER ?? null,
                    'watched_duration' => $item->WATCHED_DURATION,
                    'total_duration' => $item->TOTAL_DURATION,
                    'completed' => (bool) $item->COMPLETED,
                    'last_watched_at' => $item->LAST_WATCHED_AT,
                ];
            });

        return response()->json([
            'course_id' => $id,
            'progress_percentage' => $course->pivot->PROGRESS_PERCENTAGE,
            'completed_at' => $course->pivot->COMPLETED_AT,
            'videos' => $progress,
        ]);
    }

    /**
     * Update course progress based on video completion
     */
    private function updateCourseProgress($userId, $courseId)
    {
        $assignment = UserCourseAssignment::where('USER_ID', $userId)
            ->where('COURSE_ID', $courseId)
            ->first();

        if (!$assignment) {
            return;
        }

        // Get all videos for this course
        $videos = Video::where('COURSE_ID', $courseId)
            ->where('IS_ACTIVE', true)
            ->get();

        if ($videos->isEmpty()) {
            return;
        }

        // Get completed videos count
        $completedCount = VideoProgress::where('USER_ID', $userId)
            ->whereIn('VIDEO_ID', $videos->pluck('ID'))
            ->where('COMPLETED', true)
            ->count();

        // Calculate progress percentage
        $progressPercentage = round(($completedCount / $videos->count()) * 100, 2);

        // Update assignment
        $assignment->PROGRESS_PERCENTAGE = $progressPercentage;

        // Mark course as completed if all videos are completed
        if ($progressPercentage >= 100 && !$assignment->COMPLETED_AT) {
            $assignment->COMPLETED_AT = now();
        }

        $assignment->save();
    }
}
