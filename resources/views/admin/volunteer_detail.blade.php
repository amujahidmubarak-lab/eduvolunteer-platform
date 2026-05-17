@extends('layouts.dashboard')

@section('title', 'Detail Volunteer - Malang Mengajar')
@section('dashboard_title', 'Detail Calon Relawan Pengajar')

@section('dashboard_content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="bg-white p-8 sm:p-12 rounded-3xl border border-gray-100 shadow-sm space-y-8">
        <!-- Header Profile & Actions -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 border-b border-gray-100 pb-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-2xl font-poppins font-bold shadow-lg shadow-blue-500/30">
                    {{ substr($volunteer->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h3 class="font-poppins font-bold text-gray-900 text-2xl">{{ $volunteer->name }}</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border 
                            @if($volunteer->status === 'approved') bg-green-50 border-green-200 text-green-700 
                            @elseif($volunteer->status === 'pending') bg-yellow-50 border-yellow-200 text-yellow-700 
                            @else bg-red-50 border-red-200 text-red-700 @endif">
                            {{ $volunteer->status }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $volunteer->email }} | Terdaftar pada {{ $volunteer->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 w-full sm:w-auto shrink-0 border-t sm:border-t-0 pt-4 sm:pt-0 border-gray-100">
                @if($volunteer->status !== 'approved')
                    <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-xs py-3 px-5 rounded-2xl shadow-md transition-all">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Setujui Akun</span>
                        </button>
                    </form>
                @endif

                @if($volunteer->status !== 'rejected')
                    <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs py-3 px-5 rounded-2xl shadow-md transition-all">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                            <span>Tolak Pendaftaran</span>
                        </button>
                    </form>
                @endif
                
                <a href="{{ url('/admin/volunteers') }}" class="py-3 px-5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-2xl transition-all text-center">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Detail Grid -->
        <div class="grid md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <h4 class="font-poppins font-bold text-gray-900 text-lg mb-4">Informasi Akademik & Kontak</h4>
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-4 text-sm">
                        <div class="flex justify-between border-b border-gray-200/60 pb-2">
                            <span class="text-gray-500 font-medium">Nomor WhatsApp:</span>
                            <span class="font-semibold text-gray-900">{{ $volunteer->volunteerProfile->whatsapp ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200/60 pb-2">
                            <span class="text-gray-500 font-medium">Kampus & Jurusan:</span>
                            <span class="font-semibold text-gray-900">{{ $volunteer->volunteerProfile->campus_major ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200/60 pb-2">
                            <span class="text-gray-500 font-medium">Domisili Malang:</span>
                            <span class="font-semibold text-gray-900">{{ $volunteer->volunteerProfile->domicile ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200/60 pb-2">
                            <span class="text-gray-500 font-medium">Pilihan Mata Pelajaran:</span>
                            <span class="font-semibold text-blue-600">{{ $volunteer->volunteerProfile->interested_subjects ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Ketersediaan Waktu:</span>
                            <span class="font-semibold text-gray-900">{{ $volunteer->volunteerProfile->availability ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Motivasi Mengajar</h4>
                    <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 text-sm text-gray-700 leading-relaxed italic">
                        "{{ $volunteer->volunteerProfile->motivation ?? 'Belum mencantumkan motivasi.' }}"
                    </div>
                </div>
            </div>

            <!-- KTM Photo -->
            <div>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-4">Foto KTM / Identitas Diri</h4>
                @if(isset($volunteer->volunteerProfile->ktm_photo))
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 shadow-inner flex items-center justify-center overflow-hidden">
                        <img src="{{ url($volunteer->volunteerProfile->ktm_photo) }}" alt="KTM {{ $volunteer->name }}" class="w-full h-auto max-h-96 object-contain rounded-xl shadow-sm">
                    </div>
                @else
                    <div class="py-12 text-center text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-2 text-gray-300"></i>
                        <p class="text-sm font-medium">Foto KTM tidak tersedia.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Teaching Reports History -->
        <div class="pt-8 border-t border-gray-100 space-y-6">
            <h4 class="font-poppins font-bold text-gray-900 text-lg">Riwayat Mengajar & Laporan Kegiatan ({{ $volunteer->teachingReports->count() }})</h4>
            
            <div class="space-y-4">
                @forelse($volunteer->teachingReports as $report)
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700">
                                    {{ $report->teachingSchedule->subject ?? '-' }}
                                </span>
                                <span class="text-xs font-semibold text-gray-900">
                                    {{ $report->teachingSchedule->learningHome->name ?? '-' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $report->material_taught }}</p>
                            <p class="text-[11px] text-gray-400 flex items-center gap-1 pt-1">
                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                <span>{{ $report->teachingSchedule->schedule_date->translatedFormat('l, d F Y') }}</span>
                            </p>
                        </div>
                        <span class="px-3 py-1 bg-white rounded-xl border border-gray-200 text-xs font-bold text-gray-800 shadow-sm shrink-0">
                            {{ $report->student_count }} Siswa Hadir
                        </span>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="file-x" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                        <p class="text-sm font-medium">Volunteer ini belum memiliki riwayat laporan mengajar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
