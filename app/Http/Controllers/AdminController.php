<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\LearningHome;
use App\Models\TeachingReport;
use App\Models\TeachingSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'active_volunteers' => User::where('role', 'volunteer')->where('status', 'approved')->count(),
            'learning_homes' => LearningHome::count(),
            'teaching_schedules' => TeachingSchedule::count(),
            'teaching_reports' => TeachingReport::count(),
        ];

        $pendingVolunteers = User::where('role', 'volunteer')->where('status', 'pending')->with('volunteerProfile')->latest()->take(5)->get();
        $recentReports = TeachingReport::with('user', 'teachingSchedule.learningHome')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingVolunteers', 'recentReports'));
    }

    public function volunteers(Request $request)
    {
        $query = User::where('role', 'volunteer')->with('volunteerProfile')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $volunteers = $query->get();
        $currentStatus = $request->status ?? 'all';

        return view('admin.volunteers', compact('volunteers', 'currentStatus'));
    }

    public function showVolunteer(User $volunteer)
    {
        $volunteer->load('volunteerProfile', 'teachingReports.teachingSchedule.learningHome');
        return view('admin.volunteer_detail', compact('volunteer'));
    }

    public function updateVolunteerStatus(Request $request, User $volunteer)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
        ]);

        $volunteer->update(['status' => $request->status]);

        $statusText = $request->status === 'approved' ? 'disetujui' : ($request->status === 'rejected' ? 'ditolak' : 'dipending');

        return back()->with('success', "Status volunteer {$volunteer->name} berhasil diubah menjadi {$statusText}.");
    }

    public function schedules()
    {
        $schedules = TeachingSchedule::with('learningHome', 'volunteers')->orderBy('schedule_date', 'desc')->get();
        $learningHomes = LearningHome::all();
        $volunteers = User::where('role', 'volunteer')->where('status', 'approved')->get();

        return view('admin.schedules', compact('schedules', 'learningHomes', 'volunteers'));
    }

    public function storeSchedule(Request $request)
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

        // Attach volunteers
        foreach ($request->volunteer_ids as $volunteerId) {
            $schedule->scheduleVolunteers()->create([
                'user_id' => $volunteerId,
            ]);
        }

        return redirect('/admin/schedules')->with('success', 'Jadwal mengajar berhasil dibuat dan volunteer telah ditugaskan.');
    }

    public function updateScheduleStatus(Request $request, TeachingSchedule $schedule)
    {
        $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $schedule->update(['status' => $request->status]);

        return back()->with('success', 'Status jadwal berhasil diperbarui.');
    }

    public function deleteSchedule(TeachingSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal mengajar berhasil dihapus.');
    }

    public function learningHomes()
    {
        $learningHomes = LearningHome::withCount('teachingSchedules')->latest()->get();
        return view('admin.learning_homes', compact('learningHomes'));
    }

    public function storeLearningHome(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'pic_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'student_count' => ['required', 'integer', 'min:0'],
        ]);

        LearningHome::create($request->all());

        return redirect('/admin/learning-homes')->with('success', 'Rumah belajar berhasil ditambahkan.');
    }

    public function updateLearningHome(Request $request, LearningHome $learningHome)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'pic_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'student_count' => ['required', 'integer', 'min:0'],
        ]);

        $learningHome->update($request->all());

        return redirect('/admin/learning-homes')->with('success', 'Data rumah belajar berhasil diperbarui.');
    }

    public function deleteLearningHome(LearningHome $learningHome)
    {
        $learningHome->delete();
        return redirect('/admin/learning-homes')->with('success', 'Rumah belajar berhasil dihapus.');
    }

    public function reports()
    {
        $reports = TeachingReport::with('user', 'teachingSchedule.learningHome')->latest()->get();
        return view('admin.reports', compact('reports'));
    }

    public function announcements()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect('/admin/announcements')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect('/admin/announcements')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return redirect('/admin/announcements')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function galleries()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries', compact('galleries'));
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'image_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('galleries', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        } else {
            $imagePath = 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80';
        }

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect('/admin/galleries')->with('success', 'Dokumentasi galeri berhasil ditambahkan.');
    }

    public function updateGallery(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect('/admin/galleries')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function deleteGallery(Gallery $gallery)
    {
        $gallery->delete();
        return redirect('/admin/galleries')->with('success', 'Galeri berhasil dihapus.');
    }
}
