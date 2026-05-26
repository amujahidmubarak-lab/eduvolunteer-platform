<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningHome;
use App\Models\TeachingReport;
use App\Models\TeachingSchedule;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Calculate Total Impact Hours from completed schedules
        $completedSchedules = TeachingSchedule::where('status', 'completed')->get();
        $totalImpactHours = 0;
        foreach ($completedSchedules as $schedule) {
            $start = strtotime($schedule->start_time);
            $end = strtotime($schedule->end_time);
            if ($start && $end && $end > $start) {
                $totalImpactHours += ($end - $start) / 3600; // in hours
            }
        }

        $stats = [
            'active_volunteers' => User::where('role', 'volunteer')->where('status', 'approved')->count(),
            'learning_homes' => LearningHome::count(),
            'teaching_schedules' => TeachingSchedule::count(),
            'impact_hours' => round($totalImpactHours),
        ];

        // 2. Trend Activity Chart Data (Last 7 Days of Reports)
        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendLabels[] = now()->subDays($i)->translatedFormat('d M');
            $trendData[] = TeachingReport::whereDate('created_at', $date)->count();
        }

        // 3. Student Distribution Data
        $learningHomes = LearningHome::select('name', 'student_count')->get();
        $distributionLabels = $learningHomes->pluck('name')->toArray();
        $distributionData = $learningHomes->pluck('student_count')->toArray();

        $chartData = [
            'trend' => [
                'labels' => $trendLabels,
                'data' => $trendData,
            ],
            'distribution' => [
                'labels' => $distributionLabels,
                'data' => $distributionData,
            ]
        ];

        $pendingVolunteers = User::where('role', 'volunteer')->where('status', 'pending')->with('volunteerProfile')->latest()->take(5)->get();
        $recentReports = TeachingReport::with('user', 'teachingSchedule.learningHome')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingVolunteers', 'recentReports', 'chartData'));
    }
}
