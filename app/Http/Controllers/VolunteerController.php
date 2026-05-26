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

        $calendarEvents = $schedules->map(function ($schedule) use ($myScheduleIds) {
            $isMine = in_array($schedule->id, $myScheduleIds);
            return [
                'id' => $schedule->id,
                'title' => $schedule->subject . ' (' . $schedule->learningHome->name . ')',
                'start' => $schedule->schedule_date->format('Y-m-d') . 'T' . $schedule->start_time,
                'end' => $schedule->schedule_date->format('Y-m-d') . 'T' . $schedule->end_time,
                'color' => $isMine ? '#3B82F6' : '#9CA3AF', // Blue for mine, Gray for others
            ];
        });

        return view('volunteer.schedules', compact('schedules', 'myScheduleIds', 'calendarEvents'));
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
            'documentation_photo' => ['nullable', 'image', 'max:3072'], // max 3MB
        ]);

        $user = Auth::user();
        $schedule = TeachingSchedule::findOrFail($request->teaching_schedule_id);

        // Verify the volunteer is assigned to this schedule
        $isAssigned = $schedule->volunteers()->where('users.id', $user->id)->exists();
        if (!$isAssigned) {
            return back()->with('error', 'Anda tidak ditugaskan pada jadwal ini.');
        }

        // Verify the schedule is completed
        if ($schedule->status !== 'completed') {
            return back()->with('error', 'Laporan hanya dapat dikirim untuk jadwal yang sudah selesai.');
        }

        // Verify the volunteer hasn't already submitted a report
        $alreadyReported = TeachingReport::where('teaching_schedule_id', $schedule->id)
            ->where('user_id', $user->id)
            ->exists();
        if ($alreadyReported) {
            return back()->with('error', 'Anda sudah mengirim laporan untuk jadwal ini.');
        }

        $photoPath = null;
        if ($request->hasFile('documentation_photo')) {
            $photoPath = \App\Helpers\ImageHelper::compressAndResize($request->file('documentation_photo'), 'reports');
        } else {
            $photoPath = 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80';
        }

        $report = TeachingReport::create([
            'teaching_schedule_id' => $request->teaching_schedule_id,
            'user_id' => $user->id,
            'material_taught' => $request->material_taught,
            'student_count' => $request->student_count,
            'obstacles' => $request->obstacles,
            'evaluation' => $request->evaluation,
            'photo_path' => $photoPath,
        ]);

        // Notify all admins about the new report
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewReportSubmitted($report));

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
        
        $attendanceCount = \App\Models\ScheduleVolunteer::where('user_id', $user->id)
            ->where('attendance_status', 'present')
            ->count();

        $minAttendance = (int) \App\Models\Setting::getValue('certificate_min_attendance', 5);

        return view('volunteer.profile', compact('user', 'attendanceCount', 'minAttendance'));
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

    public function showAttend($scheduleId, $token)
    {
        $schedule = TeachingSchedule::with('learningHome')->findOrFail($scheduleId);

        if ($schedule->attendance_token !== $token) {
            abort(403, 'Token presensi tidak valid atau telah kedaluwarsa.');
        }

        $user = Auth::user();
        $pivot = \App\Models\ScheduleVolunteer::where('teaching_schedule_id', $schedule->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$pivot) {
            return redirect()->route('volunteer.schedules')->with('error', 'Anda tidak ditugaskan pada jadwal mengajar ini.');
        }

        if ($pivot->attendance_status === 'present') {
            return redirect()->route('volunteer.schedules')->with('info', 'Anda sudah melakukan presensi kehadiran sebelumnya.');
        }

        return view('volunteer.attend', compact('schedule', 'token'));
    }

    public function processAttend(Request $request, $scheduleId, $token)
    {
        $schedule = TeachingSchedule::with('learningHome')->findOrFail($scheduleId);

        if ($schedule->attendance_token !== $token) {
            abort(403, 'Token presensi tidak valid atau telah kedaluwarsa.');
        }

        $user = Auth::user();
        $pivot = \App\Models\ScheduleVolunteer::where('teaching_schedule_id', $schedule->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$pivot) {
            return redirect()->route('volunteer.schedules')->with('error', 'Anda tidak ditugaskan pada jadwal mengajar ini.');
        }

        if ($pivot->attendance_status === 'present') {
            return redirect()->route('volunteer.schedules')->with('info', 'Anda sudah melakukan presensi kehadiran sebelumnya.');
        }

        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $home = $schedule->learningHome;
        if (!$home || is_null($home->latitude) || is_null($home->longitude)) {
            return $this->markPresent($pivot, $user, $schedule);
        }

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $lat2 = $home->latitude;
        $lon2 = $home->longitude;

        // Haversine Formula (Meters)
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        if ($distance > 100) {
            return redirect()->route('volunteer.schedules')->with('error', 'Presensi gagal! Anda berada sekitar ' . round($distance) . ' meter dari lokasi Rumah Belajar. Jarak maksimal adalah 100 meter.');
        }

        return $this->markPresent($pivot, $user, $schedule);
    }

    private function markPresent($pivot, $user, $schedule)
    {
        $pivot->update(['attendance_status' => 'present']);
        \App\Models\ActivityLog::record('VOLUNTEER_ATTENDANCE', "Relawan {$user->name} hadir pada jadwal mengajar {$schedule->subject}");
        return redirect()->route('volunteer.schedules')->with('success', 'Presensi kehadiran berhasil dicatat!');
    }

    public function showCertificate()
    {
        $user = Auth::user();
        
        $attendanceCount = \App\Models\ScheduleVolunteer::where('user_id', $user->id)
            ->where('attendance_status', 'present')
            ->count();

        $minAttendance = (int) \App\Models\Setting::getValue('certificate_min_attendance', 5);

        if ($attendanceCount < $minAttendance) {
            return redirect('/volunteer/profile')->with('error', "Anda belum memenuhi kuota kehadiran untuk mengunduh sertifikat. Kehadiran saat ini: {$attendanceCount}/{$minAttendance} sesi.");
        }

        $templatePath = \App\Models\Setting::getValue('certificate_template');

        $verificationUrl = route('landing') . '/verify-certificate/' . $user->id . '/' . md5($user->email . 'MM_CERT_SALT');

        return view('volunteer.certificate', compact('user', 'templatePath', 'verificationUrl', 'attendanceCount'));
    }
}
