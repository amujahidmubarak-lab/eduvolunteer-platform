@extends('layouts.dashboard')

@section('title', 'Manajemen Volunteer - Malang Mengajar')
@section('dashboard_title', 'Daftar Volunteer')

@section('dashboard_content')
<div class="space-y-8">
    <!-- Header & Filter -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Manajemen Data Volunteer</h3>
            <p class="text-sm text-gray-600">Verifikasi pendaftar baru, tinjau profil, dan kelola status persetujuan relawan pengajar.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-100 overflow-x-auto w-full sm:w-auto shrink-0">
            <a href="{{ url('/admin/volunteers?status=all') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $currentStatus === 'all' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                Semua ({{ \App\Models\User::where('role', 'volunteer')->count() }})
            </a>
            <a href="{{ url('/admin/volunteers?status=pending') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $currentStatus === 'pending' ? 'bg-white text-yellow-600 shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                Pending ({{ \App\Models\User::where('role', 'volunteer')->where('status', 'pending')->count() }})
            </a>
            <a href="{{ url('/admin/volunteers?status=approved') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $currentStatus === 'approved' ? 'bg-white text-green-600 shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                Disetujui
            </a>
            <a href="{{ url('/admin/volunteers?status=rejected') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $currentStatus === 'rejected' ? 'bg-white text-red-600 shadow-sm font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                Ditolak
            </a>
        </div>
    </div>

    <!-- Volunteers Grid / Table -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($volunteers as $volunteer)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between gap-6 hover:shadow-md transition-all group">
                <div class="space-y-4">
                    <!-- Top Info & Status -->
                    <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold font-poppins shrink-0">
                                {{ substr($volunteer->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-poppins font-bold text-gray-900 text-base truncate group-hover:text-blue-600 transition-colors">
                                    {{ $volunteer->name }}
                                </h4>
                                <p class="text-xs text-gray-500 truncate">{{ $volunteer->email }}</p>
                            </div>
                        </div>

                        <!-- Badge -->
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border shrink-0
                            @if($volunteer->status === 'approved') bg-green-50 border-green-200 text-green-700 
                            @elseif($volunteer->status === 'pending') bg-yellow-50 border-yellow-200 text-yellow-700 
                            @else bg-red-50 border-red-200 text-red-700 @endif">
                            {{ $volunteer->status }}
                        </span>
                    </div>

                    <!-- Profile Details -->
                    <div class="space-y-2 text-xs">
                        <div class="flex items-start gap-2 text-gray-600">
                            <i data-lucide="graduation-cap" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed"><strong class="text-gray-700">Kampus:</strong> {{ $volunteer->volunteerProfile->campus_major ?? '-' }}</span>
                        </div>
                        <div class="flex items-start gap-2 text-gray-600">
                            <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed"><strong class="text-gray-700">Domisili:</strong> {{ $volunteer->volunteerProfile->domicile ?? '-' }}</span>
                        </div>
                        <div class="flex items-start gap-2 text-gray-600">
                            <i data-lucide="book-open" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed"><strong class="text-gray-700">Minat Mapel:</strong> {{ $volunteer->volunteerProfile->interested_subjects ?? '-' }}</span>
                        </div>
                        <div class="flex items-start gap-2 text-gray-600">
                            <i data-lucide="calendar" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed"><strong class="text-gray-700">Jadwal Kosong:</strong> {{ $volunteer->volunteerProfile->availability ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                    <a href="{{ url('/admin/volunteers/' . $volunteer->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs py-2.5 px-3 rounded-xl transition-colors">
                        Lihat Detail
                    </a>

                    @if($volunteer->status === 'pending')
                        <div class="flex items-center gap-1.5 shrink-0">
                            <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" title="Setujui" class="p-2.5 bg-green-100 hover:bg-green-600 text-green-700 hover:text-white rounded-xl transition-colors shadow-sm">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" title="Tolak" class="p-2.5 bg-red-100 hover:bg-red-600 text-red-700 hover:text-white rounded-xl transition-colors shadow-sm">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    @elseif($volunteer->status === 'approved')
                        <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST" class="shrink-0">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" title="Batalkan Persetujuan (Tolak)" class="p-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-colors border border-red-200">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST" class="shrink-0">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" title="Setujui Kembali" class="p-2.5 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white rounded-xl transition-colors border border-green-200">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="users" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Tidak Ada Volunteer Ditemukan</p>
                <p class="text-xs text-gray-400 mt-1">Belum ada data pendaftar yang sesuai dengan filter saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

