@extends('layouts.dashboard')

@section('title', 'Laporan Kegiatan - Malang Mengajar')
@section('dashboard_title', 'Laporan Kegiatan Mengajar')

@section('dashboard_content')
<div class="space-y-8">
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Rekapitulasi Laporan Mengajar Volunteer</h3>
            <p class="text-sm text-gray-600">Pantau materi yang diajarkan, jumlah siswa hadir, kendala lapangan, serta saran evaluasi dari para relawan.</p>
        </div>
        <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-2xl border border-blue-100 text-xs font-semibold shrink-0">
            Total: {{ $reports->count() }} Laporan
        </div>
    </div>

    <div class="space-y-6">
        @forelse($reports as $report)
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col lg:flex-row gap-8 items-start hover:shadow-md transition-shadow">
                <!-- Photo -->
                @if($report->photo_path)
                    <img src="{{ $report->photo_path }}" alt="Dokumentasi" class="w-full lg:w-64 h-64 lg:h-full object-cover rounded-2xl shadow-sm shrink-0 bg-gray-100">
                @endif

                <div class="flex-1 space-y-6 w-full">
                    <!-- Header Info -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $report->teachingSchedule->subject ?? '-' }}
                                </span>
                                <span class="text-xs text-gray-500 font-medium">
                                    {{ $report->teachingSchedule->schedule_date->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            <h4 class="font-poppins font-bold text-gray-900 text-xl mb-1">
                                {{ $report->teachingSchedule->learningHome->name ?? '-' }}
                            </h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                <i data-lucide="user" class="w-3.5 h-3.5 text-blue-600"></i>
                                <span>Dilaporkan oleh: <strong class="text-gray-800">{{ $report->user->name ?? '-' }}</strong></span>
                            </p>
                        </div>

                        <!-- Siswa Count Badge -->
                        <div class="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-2xl border border-gray-200 shadow-sm sm:self-start">
                            <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                            <span class="text-xs font-bold text-gray-900">{{ $report->student_count }} Siswa Hadir</span>
                        </div>
                    </div>

                    <!-- Content Grid -->
                    <div class="grid md:grid-cols-3 gap-6 text-xs">
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-2">
                            <span class="font-semibold text-blue-800 block flex items-center gap-1.5 text-sm">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                <span>Materi Diajarkan</span>
                            </span>
                            <p class="text-gray-700 leading-relaxed">{{ $report->material_taught }}</p>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-2">
                            <span class="font-semibold text-yellow-800 block flex items-center gap-1.5 text-sm">
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                <span>Kendala Lapangan</span>
                            </span>
                            <p class="text-gray-700 leading-relaxed">{{ $report->obstacles ?: 'Tidak ada kendala berarti.' }}</p>
                        </div>

                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-2">
                            <span class="font-semibold text-green-800 block flex items-center gap-1.5 text-sm">
                                <i data-lucide="check-square" class="w-4 h-4"></i>
                                <span>Evaluasi & Saran</span>
                            </span>
                            <p class="text-gray-700 leading-relaxed">{{ $report->evaluation ?: 'Kegiatan berjalan lancar dan interaktif.' }}</p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="text-[11px] text-gray-400 flex items-center justify-between pt-2 border-t border-gray-100">
                        <span class="flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span>Waktu Kirim: {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </span>
                        <a href="{{ url('/admin/volunteers/' . ($report->user->id ?? '')) }}" class="font-semibold text-blue-600 hover:underline">
                            Lihat Profil Volunteer
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="file-x" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Laporan Masuk</p>
                <p class="text-xs text-gray-400 mt-1">Laporan dari volunteer yang telah mengajar akan muncul di halaman ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
