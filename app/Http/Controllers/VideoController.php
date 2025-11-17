<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('IS_ACTIVE', true)
            ->orderBy('ORDER')
            ->get();

        return view('videos.index', compact('videos'));
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.show', compact('video'));
    }

    public function stream($id)
    {
        $video = Video::findOrFail($id);

        // For S3 videos, redirect to the S3 URL
        if ($video->STORAGE_DRIVER === 's3') {
            return redirect($video->video_url);
        }

        // For local videos, stream from local storage
        $path = storage_path('app/' . $video->FILE_PATH);

        if (!file_exists($path)) {
            abort(404, 'Video file not found');
        }

        $stream = function () use ($path) {
            $stream = fopen($path, 'r');
            fpassthru($stream);
            fclose($stream);
        };

        return response()->stream($stream, 200, [
            'Content-Type' => 'video/mp4',
            'Content-Length' => filesize($path),
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
