<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\TeachingReport;
use App\Models\TeachingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user()->load('volunteerProfile');
        
        $upcomingSchedules = TeachingSchedule::whereHas('volunteers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->where('status', 'scheduled')
          ->where('schedule_date', '>=', now()->format('Y-m-d'))
          ->with('learningHome', 'volunteers')
          ->orderBy('schedule_date')
          ->take(3)
          ->get();

        $contributionCount = TeachingReport::where('user_id', $user->id)->count();

        $announcements = Announcement::where('is_active', true)->latest()->take(5)->get();

        // Check if there are completed schedules without reports
        $pendingReports = TeachingSchedule::whereHas('volunteers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->where('status', 'completed')
          ->whereDoesntHave('teachingReports', function ($q) use ($user) {
              $q->where('user_id', $user->id);
          })->with('learningHome')
          ->get();

        return view('volunteer.dashboard', compact('user', 'upcomingSchedules', 'contributionCount', 'announcements', 'pendingReports'));
    }

    public function schedules()
    {
        $schedules = TeachingSchedule::with('learningHome', 'volunteers')->orderBy('schedule_date', 'desc')->get();
        $myScheduleIds = Auth::user()->scheduleVolunteers()->pluck('teaching_schedule_id')->toArray();

        return view('volunteer.schedules', compact('schedules', 'myScheduleIds'));
    }

    public function reports()
    {
        $user = Auth::user();
        $reports = TeachingReport::where('user_id', $user->id)->with('teachingSchedule.learningHome')->latest()->get();

        $pendingSchedules = TeachingSchedule::whereHas('volunteers', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->where('status', 'completed')
          ->whereDoesntHave('teachingReports', function ($q) use ($user) {
              $q->where('user_id', $user->id);
          })->with('learningHome')
          ->get();

        return view('volunteer.reports', compact('reports', 'pendingSchedules'));
    }

    public function createReport(Request $request)
    {
        $schedule = TeachingSchedule::with('learningHome')->findOrFail($request->schedule_id);
        return view('volunteer.create_report', compact('schedule'));
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'teaching_schedule_id' => ['required', 'exists:teaching_schedules,id'],
            'material_taught' => ['required', 'string'],
            'student_count' => ['required', 'integer', 'min:1'],
            'obstacles' => ['nullable', 'string'],
            'evaluation' => ['nullable', 'string'],
            'documentation_photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('documentation_photo')) {
            $photoPath = $request->file('documentation_photo')->store('reports', 'public');
        } else {
            $photoPath = 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80';
        }

        TeachingReport::create([
            'teaching_schedule_id' => $request->teaching_schedule_id,
            'user_id' => Auth::id(),
            'material_taught' => $request->material_taught,
            'student_count' => $request->student_count,
            'obstacles' => $request->obstacles,
            'evaluation' => $request->evaluation,
            'photo_path' => $photoPath,
        ]);

        return redirect('/volunteer/reports')->with('success', 'Laporan mengajar berhasil dikirim! Terima kasih atas dedikasi Anda.');
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_active', true)->latest()->get();
        return view('volunteer.announcements', compact('announcements'));
    }

    public function profile()
    {
        $user = Auth::user()->load('volunteerProfile');
        return view('volunteer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'campus_major' => ['required', 'string', 'max:255'],
            'domicile' => ['required', 'string', 'max:255'],
            'interested_subjects' => ['required', 'string'],
            'availability' => ['required', 'string', 'max:255'],
            'motivation' => ['required', 'string'],
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        $user->volunteerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'whatsapp' => $request->whatsapp,
                'campus_major' => $request->campus_major,
                'domicile' => $request->domicile,
                'interested_subjects' => $request->interested_subjects,
                'availability' => $request->availability,
                'motivation' => $request->motivation,
            ]
        );

        return redirect('/volunteer/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
