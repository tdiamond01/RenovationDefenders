<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::with('course')->orderBy('ORDER')->paginate(20);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('IS_ACTIVE', true)->get();
        return view('admin.videos.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'COURSE_ID' => 'nullable|exists:COURSES,ID',
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
            $path = $request->file('video_file')->store('videos', 'local');
            $validated['FILE_PATH'] = $path;
        }

        unset($validated['video_file']);
        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = Video::with('course')->findOrFail($id);
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::findOrFail($id);
        $courses = Course::where('IS_ACTIVE', true)->get();
        return view('admin.videos.edit', compact('video', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::findOrFail($id);

        $validated = $request->validate([
            'COURSE_ID' => 'nullable|exists:COURSES,ID',
            'TITLE' => 'required|string|max:255',
            'DESCRIPTION' => 'nullable|string',
            'MODULE' => 'nullable|string|max:255',
            'ORDER' => 'required|integer|min:0',
            'DURATION' => 'required|integer|min:0',
            'IS_ACTIVE' => 'boolean',
            'REQUIRED' => 'boolean',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:512000',
        ]);

        if ($request->hasFile('video_file')) {
            // Delete old file
            if ($video->FILE_PATH && Storage::disk('local')->exists($video->FILE_PATH)) {
                Storage::disk('local')->delete($video->FILE_PATH);
            }

            $path = $request->file('video_file')->store('videos', 'local');
            $validated['FILE_PATH'] = $path;
        }

        unset($validated['video_file']);
        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::findOrFail($id);

        // Delete video file
        if ($video->FILE_PATH && Storage::disk('local')->exists($video->FILE_PATH)) {
            Storage::disk('local')->delete($video->FILE_PATH);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video deleted successfully.');
    }
}
