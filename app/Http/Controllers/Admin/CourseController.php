<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::withCount('videos')->orderBy('ID')->paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'IS_ACTIVE' => 'boolean',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with(['videos' => function($query) {
            $query->orderBy('ID');
        }])->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::with(['videos' => function($query) {
            $query->orderBy('ID');
        }])->findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'IS_ACTIVE' => 'boolean',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Show video management for the course.
     */
    public function videos(string $id)
    {
        $course = Course::with(['videos' => function($query) {
            $query->orderBy('ID');
        }])->findOrFail($id);

        // Get videos not assigned to this course (unassigned or in other courses)
        $availableVideos = Video::where(function($query) use ($id) {
            $query->whereNull('COURSE_ID')
                  ->orWhere('COURSE_ID', '!=', $id);
        })->orderBy('ID')->get();

        return view('admin.courses.videos', compact('course', 'availableVideos'));
    }

    /**
     * Add an existing video to the course.
     */
    public function addVideo(Request $request, string $id)
    {
        $request->validate([
            'VIDEO_ID' => 'required|exists:VIDEOS,ID',
        ]);

        $course = Course::findOrFail($id);
        $video = Video::findOrFail($request->VIDEO_ID);

        // Update video to belong to this course
        $video->update(['COURSE_ID' => $id]);

        return redirect()->route('admin.courses.videos', $id)
            ->with('success', 'Video added to course successfully.');
    }

    /**
     * Create a new video for the course.
     */
    public function createVideo(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'MODULE' => 'nullable|string|max:255',
            'ORDER' => 'required|integer|min:0',
            'DURATION' => 'required|integer|min:0',
            'IS_ACTIVE' => 'boolean',
            'REQUIRED' => 'boolean',
            'video_file' => 'required|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:512000',
        ]);

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 's3-videos');
            $validated['FILE_PATH'] = $path;
            $validated['STORAGE_DRIVER'] = 's3';
        }

        $validated['COURSE_ID'] = $id;
        unset($validated['video_file']);

        Video::create($validated);

        return redirect()->route('admin.courses.videos', $id)
            ->with('success', 'Video created and added to course successfully.');
    }

    /**
     * Remove a video from the course.
     */
    public function removeVideo(string $courseId, string $videoId)
    {
        $video = Video::where('ID', $videoId)
            ->where('COURSE_ID', $courseId)
            ->firstOrFail();

        // Just remove from course, don't delete the video
        $video->update(['COURSE_ID' => null]);

        return redirect()->route('admin.courses.videos', $courseId)
            ->with('success', 'Video removed from course.');
    }

    /**
     * Delete a video permanently.
     */
    public function deleteVideo(string $courseId, string $videoId)
    {
        $video = Video::where('ID', $videoId)
            ->where('COURSE_ID', $courseId)
            ->firstOrFail();

        // Delete video file
        if ($video->FILE_PATH && Storage::disk('local')->exists($video->FILE_PATH)) {
            Storage::disk('local')->delete($video->FILE_PATH);
        }

        $video->delete();

        return redirect()->route('admin.courses.videos', $courseId)
            ->with('success', 'Video deleted permanently.');
    }
}
