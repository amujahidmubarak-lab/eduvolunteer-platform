<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\LearningHome;
use App\Models\TeachingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'volunteers' => User::where('role', 'volunteer')->where('status', 'approved')->count(),
            'students' => LearningHome::sum('student_count'),
            'learning_homes' => LearningHome::count(),
            'teaching_schedules' => TeachingSchedule::count(),
        ];

        $galleries = Gallery::where('is_active', true)->latest()->take(6)->get();
        $announcements = Announcement::where('is_active', true)->latest()->take(3)->get();

        return view('landing.index', compact('stats', 'galleries', 'announcements'));
    }
}
