<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeachingReport;

class ReportController extends Controller
{
    public function index()
    {
        $reports = TeachingReport::with('user', 'teachingSchedule.learningHome')->latest()->paginate(15);
        return view('admin.reports', compact('reports'));
    }

    public function destroy(TeachingReport $report)
    {
        \App\Models\ActivityLog::record('DELETE_REPORT', "Menghapus laporan ID {$report->id} oleh relawan {$report->user->name}");
        $report->delete();
        
        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function exportCsv()
    {
        $reports = TeachingReport::with(['user', 'teachingSchedule.learningHome'])->orderBy('created_at', 'desc')->get();

        $filename = "Laporan_Malang_Mengajar_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'Tanggal Laporan', 'Relawan', 'Rumah Belajar', 'Mata Pelajaran', 
            'Tgl Mengajar', 'Waktu', 'Jumlah Siswa', 'Materi', 'Hambatan', 'Evaluasi'
        ];

        $callback = function() use($reports, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reports as $report) {
                $schedule = $report->teachingSchedule;
                $home = $schedule ? $schedule->learningHome : null;

                $row = [
                    $report->id,
                    $report->created_at->format('Y-m-d H:i'),
                    $report->user->name ?? '-',
                    $home->name ?? '-',
                    $schedule->subject ?? '-',
                    $schedule->schedule_date ?? '-',
                    ($schedule->start_time ?? '') . ' - ' . ($schedule->end_time ?? ''),
                    $report->student_count,
                    $report->material_taught,
                    $report->obstacles,
                    $report->evaluation,
                ];

                fputcsv($file, $row);
            }
            fclose($file);
        };

        \App\Models\ActivityLog::record('EXPORT_REPORTS', "Mengekspor seluruh data laporan mengajar ke format CSV");

        return response()->stream($callback, 200, $headers);
    }
}
