<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningHome;
use App\Models\TeachingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = TeachingSchedule::with('learningHome', 'volunteers')->orderBy('schedule_date', 'desc')->paginate(15);
        $learningHomes = LearningHome::all();
        $volunteers = User::where('role', 'volunteer')->where('status', 'approved')->with('volunteerProfile')->get();

        return view('admin.schedules', compact('schedules', 'learningHomes', 'volunteers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'learning_home_id' => ['required', 'exists:learning_homes,id'],
            'subject' => ['required', 'string'],
            'schedule_date' => ['required', 'date'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'volunteer_ids' => ['required', 'array', 'min:1'],
            'volunteer_ids.*' => ['exists:users,id'],
        ]);

        $schedule = TeachingSchedule::create([
            'learning_home_id' => $request->learning_home_id,
            'subject' => $request->subject,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        // Attach volunteers and notify
        foreach ($request->volunteer_ids as $volunteerId) {
            $schedule->scheduleVolunteers()->create([
                'user_id' => $volunteerId,
            ]);

            $volunteer = User::find($volunteerId);
            if ($volunteer) {
                $volunteer->notify(new \App\Notifications\NewScheduleAssigned($schedule));
            }
        }

        \App\Models\ActivityLog::record('CREATE_SCHEDULE', "Membuat jadwal baru untuk mata pelajaran {$schedule->subject}");

        return redirect()->route('admin.schedules')->with('success', 'Jadwal mengajar berhasil dibuat dan volunteer telah ditugaskan.');
    }

    public function updateStatus(Request $request, TeachingSchedule $schedule)
    {
        $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $schedule->update(['status' => $request->status]);

        \App\Models\ActivityLog::record('UPDATE_SCHEDULE_STATUS', "Mengubah status jadwal ID {$schedule->id} menjadi {$request->status}");

        return back()->with('success', 'Status jadwal berhasil diperbarui.');
    }

    public function destroy(TeachingSchedule $schedule)
    {
        \App\Models\ActivityLog::record('DELETE_SCHEDULE', "Menghapus jadwal ID {$schedule->id}");
        $schedule->delete();
        
        return back()->with('success', 'Jadwal mengajar berhasil dihapus.');
    }

    public function showQrCode(TeachingSchedule $schedule)
    {
        // Pastikan token ada, jika tidak buatkan baru (untuk jadwal lama)
        if (empty($schedule->attendance_token)) {
            $schedule->update(['attendance_token' => \Illuminate\Support\Str::random(10)]);
        }

        return view('admin.schedules_qr', compact('schedule'));
    }
}
