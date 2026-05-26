<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'volunteer')->with('volunteerProfile')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $volunteers = $query->paginate(15);
        $currentStatus = $request->status ?? 'all';

        return view('admin.volunteers', compact('volunteers', 'currentStatus'));
    }

    public function show(User $volunteer)
    {
        $volunteer->load('volunteerProfile', 'teachingReports.teachingSchedule.learningHome');
        return view('admin.volunteer_detail', compact('volunteer'));
    }

    public function updateStatus(Request $request, User $volunteer)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
        ]);

        $volunteer->update(['status' => $request->status]);

        // Kirim Notifikasi ke Volunteer
        $volunteer->notify(new \App\Notifications\VolunteerStatusUpdated($request->status));

        $statusText = $request->status === 'approved' ? 'disetujui' : ($request->status === 'rejected' ? 'ditolak' : 'dipending');
        
        // Catat aktivitas
        \App\Models\ActivityLog::record('UPDATE_VOLUNTEER_STATUS', "Mengubah status relawan {$volunteer->name} menjadi {$statusText}");

        return back()->with('success', "Status volunteer {$volunteer->name} berhasil diubah menjadi {$statusText}.");
    }

    public function destroy(User $volunteer)
    {
        $volunteerName = $volunteer->name;
        $volunteer->delete();

        // Catat aktivitas
        \App\Models\ActivityLog::record('DELETE_VOLUNTEER', "Menghapus akun relawan {$volunteerName} (Soft Delete)");

        return redirect()->route('admin.volunteers')->with('success', "Akun relawan {$volunteerName} berhasil dihapus.");
    }
}
