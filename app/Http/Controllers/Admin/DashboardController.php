<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('ROLE', 'admin')->count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('IS_ACTIVE', true)->count(),
            'total_videos' => Video::count(),
            'active_videos' => Video::where('IS_ACTIVE', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
