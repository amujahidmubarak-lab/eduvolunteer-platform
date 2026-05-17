@extends('layouts.dashboard')

@section('title', 'Laporan Mengajar - Malang Mengajar')
@section('dashboard_title', 'Laporan Mengajar')

@section('dashboard_content')
<div class="space-y-12">
    <!-- Pending Schedules Prompt -->
    @if($pendingSchedules->count() > 0)
        <div class="bg-white p-8 rounded-3xl border-2 border-yellow-400 shadow-lg shadow-yellow-500/10 space-y-6">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl mb-0.5">Kegiatan Menunggu Laporan Anda</h3>
                    <p class="text-xs text-gray-500">Berikut adalah jadwal mengajar yang telah selesai namun belum memiliki laporan kegiatan.</p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pendingSchedules as $sched)
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 flex flex-col justify-between gap-4">
                        <div class="space-y-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ $sched->subject }}
                            </span>
                            <h4 class="font-poppins font-bold text-gray-900 text-base">{{ $sched->learningHome->name }}</h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-400"></i>
                                <span>{{ $sched->schedule_date->translatedFormat('l, d F Y') }}</span>
                            </p>
                        </div>
                        <a href="{{ url('/volunteer/reports/create?schedule_id=' . $sched->id) }}" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-poppins font-semibold text-xs py-3 px-4 rounded-xl shadow-md transition-all block">
                            Isi Laporan Sekarang
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Submitted Reports History -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-poppins font-bold text-gray-900 text-xl mb-0.5">Riwayat Laporan Mengajar Saya</h3>
                <p class="text-xs text-gray-500">Daftar laporan kegiatan pengabdian yang telah Anda kirimkan ke sistem.</p>
            </div>
            <span class="text-xs font-semibold px-4 py-2 bg-blue-50 text-blue-700 rounded-xl border border-blue-100">
                Total: {{ $reports->count() }} Laporan
            </span>
        </div>

        <div class="space-y-6">
            @forelse($reports as $report)
                <div class="bg-gray-50/80 p-6 rounded-2xl border border-gray-200/80 flex flex-col lg:flex-row gap-6 items-start">
                    <!-- Photo -->
                    @if($report->photo_path)
                        <img src="{{ $report->photo_path }}" alt="Dokumentasi" class="w-full lg:w-48 h-48 lg:h-full object-cover rounded-2xl shadow-sm shrink-0 bg-gray-200">
                    @endif

                    <div class="flex-1 space-y-4 w-full">
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-200 pb-3">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $report->teachingSchedule->subject }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium">
                                        {{ $report->teachingSchedule->schedule_date->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                                <h4 class="font-poppins font-bold text-gray-900 text-lg">
                                    {{ $report->teachingSchedule->learningHome->name }}
                                </h4>
                            </div>
                            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm sm:self-start">
                                <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                                <span class="text-xs font-bold text-gray-900">{{ $report->student_count }} Siswa Hadir</span>
                            </div>
                        </div>

                        <!-- Content Grid -->
                        <div class="grid md:grid-cols-3 gap-6 text-xs">
                            <div class="bg-white p-4 rounded-xl border border-gray-100 space-y-1 shadow-sm">
                                <span class="font-semibold text-blue-800 block flex items-center gap-1.5">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                                    <span>Materi Diajarkan:</span>
                                </span>
                                <p class="text-gray-700 leading-relaxed">{{ $report->material_taught }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-gray-100 space-y-1 shadow-sm">
                                <span class="font-semibold text-yellow-800 block flex items-center gap-1.5">
                                    <i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>
                                    <span>Kendala Kegiatan:</span>
                                </span>
                                <p class="text-gray-700 leading-relaxed">{{ $report->obstacles ?: 'Tidak ada kendala berarti.' }}</p>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-gray-100 space-y-1 shadow-sm">
                                <span class="font-semibold text-green-800 block flex items-center gap-1.5">
                                    <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                                    <span>Evaluasi & Saran:</span>
                                </span>
                                <p class="text-gray-700 leading-relaxed">{{ $report->evaluation ?: 'Kegiatan berjalan lancar dan interaktif.' }}</p>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="text-[11px] text-gray-400 flex items-center gap-1 pt-2 border-t border-gray-200/60">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span>Dilaporkan pada: {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <i data-lucide="file-x" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                    <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Laporan Terkirim</p>
                    <p class="text-xs text-gray-400 mt-1">Anda belum mengirimkan laporan kegiatan mengajar ke sistem.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
