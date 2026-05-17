@extends('layouts.dashboard')

@section('title', 'Dashboard Volunteer - Malang Mengajar')
@section('dashboard_title', 'Dashboard Volunteer')

@section('dashboard_content')
<div class="space-y-8">
    <!-- Status Banner if Pending / Rejected -->
    @if(auth()->user()->status === 'pending')
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0 mt-0.5">
                    <i data-lucide="clock" class="w-7 h-7 animate-spin" style="animation-duration: 10s;"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-yellow-900 text-xl mb-1">Akun Anda Sedang Dalam Verifikasi Admin</h3>
                    <p class="text-sm text-yellow-700 leading-relaxed max-w-2xl">
                        Terima kasih telah mendaftar di Malang Mengajar! Tim admin Sosma sedang meninjau formulir dan KTM Anda. Setelah disetujui, Anda akan segera mendapatkan alokasi jadwal mengajar.
                    </p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold text-sm px-6 py-3 rounded-2xl shadow-lg shadow-yellow-500/25 transition-all shrink-0 flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4"></i>
                <span>Hubungi Admin</span>
            </a>
        </div>
    @elseif(auth()->user()->status === 'rejected')
        <div class="bg-red-50 border-2 border-red-200 rounded-3xl p-6 sm:p-8 shadow-sm flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-red-600 shrink-0 mt-0.5">
                <i data-lucide="x-circle" class="w-7 h-7"></i>
            </div>
            <div>
                <h3 class="font-poppins font-bold text-red-900 text-xl mb-1">Pendaftaran Belum Dapat Diterima</h3>
                <p class="text-sm text-red-700 leading-relaxed max-w-2xl">
                    Mohon maaf, pendaftaran volunteer Anda belum dapat kami terima untuk periode ini. Tetap semangat dan nantikan pembukaan batch berikutnya!
                </p>
            </div>
        </div>
    @endif

    <!-- Pending Reports Prompt -->
    @if($pendingReports->count() > 0)
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-2xl z-0 pointer-events-none"></div>
            <div class="relative z-10 flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-yellow-300 shrink-0 mt-0.5 border border-white/20">
                    <i data-lucide="alert-circle" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-white text-xl mb-1">Ada Kegiatan Mengajar yang Belum Dilaporkan!</h3>
                    <p class="text-sm text-blue-100 leading-relaxed max-w-xl">
                        Anda memiliki {{ $pendingReports->count() }} kegiatan mengajar yang telah selesai namun belum mengisi laporan. Yuk segera isi laporan agar kontribusi Anda tercatat di sistem.
                    </p>
                </div>
            </div>
            <a href="{{ url('/volunteer/reports') }}" class="relative z-10 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-poppins font-bold text-sm px-6 py-3.5 rounded-2xl shadow-lg shadow-yellow-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 shrink-0 flex items-center gap-2">
                <span>Isi Laporan Sekarang</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    @endif

    <!-- Welcome & Quick Stats -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jadwal Terdekat</p>
                <h4 class="font-poppins font-bold text-gray-900 text-2xl mb-1">
                    {{ $upcomingSchedules->count() > 0 ? $upcomingSchedules->first()->schedule_date->translatedFormat('d F Y') : 'Belum Ada' }}
                </h4>
                <p class="text-xs text-gray-500">
                    {{ $upcomingSchedules->count() > 0 ? $upcomingSchedules->first()->learningHome->name : 'Menunggu alokasi admin' }}
                </p>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                <i data-lucide="award" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Kontribusi</p>
                <h4 class="font-poppins font-bold text-gray-900 text-2xl mb-1">{{ $contributionCount }} Kali</h4>
                <p class="text-xs text-gray-500">Laporan kegiatan terkirim</p>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-6 sm:col-span-2 lg:col-span-1">
            <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                <i data-lucide="book-open" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mata Pelajaran</p>
                <h4 class="font-poppins font-bold text-gray-900 text-xl mb-1 truncate">{{ $user->volunteerProfile->interested_subjects ?? '-' }}</h4>
                <p class="text-xs text-gray-500">Pilihan pengabdian Anda</p>
            </div>
        </div>
    </div>

    <!-- Main Grid: Upcoming Schedules & Announcements -->
    <div class="grid lg:grid-cols-12 gap-8 items-start">
        <!-- Upcoming Schedules -->
        <div class="lg:col-span-7 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Jadwal Mengajar Terdekat</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar kegiatan di mana Anda ditugaskan</p>
                </div>
                <a href="{{ url('/volunteer/schedules') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($upcomingSchedules as $schedule)
                    <div class="p-6 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 group border-l-4 border-l-blue-500">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $schedule->subject }}
                                </span>
                                <span class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                    <span>{{ $schedule->start_time }} - {{ $schedule->end_time }} WIB</span>
                                </span>
                            </div>
                            <h4 class="font-poppins font-bold text-gray-900 text-base group-hover:text-blue-600 transition-colors">
                                {{ $schedule->learningHome->name }}
                            </h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-400"></i>
                                <span class="truncate">{{ $schedule->learningHome->address }}</span>
                            </p>
                        </div>

                        <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                            <span class="text-xs font-bold text-gray-900 bg-gray-100 px-3 py-1.5 rounded-xl text-center sm:text-right">
                                {{ $schedule->schedule_date->translatedFormat('l, d F Y') }}
                            </span>
                            <div class="flex items-center gap-1 text-[11px] text-gray-500">
                                <span>{{ $schedule->volunteers->count() }} Pengajar</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="calendar-off" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                        <p class="text-base font-medium">Belum ada jadwal mengajar terdekat untuk Anda.</p>
                        <p class="text-xs text-gray-400 mt-1">Admin akan segera mengalokasikan jadwal ke akun Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Latest Announcements -->
        <div class="lg:col-span-5 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Pengumuman Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Informasi resmi dari pengurus Sosma</p>
                </div>
                <a href="{{ url('/volunteer/announcements') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Semua</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($announcements as $announcement)
                    <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all space-y-2 group">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="font-poppins font-bold text-gray-900 text-sm group-hover:text-blue-600 transition-colors line-clamp-1">
                                {{ $announcement->title }}
                            </h4>
                            <span class="text-[10px] font-semibold text-gray-400 shrink-0">
                                {{ $announcement->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                            {{ $announcement->content }}
                        </p>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="bell-off" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                        <p class="text-base font-medium">Belum ada pengumuman terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
