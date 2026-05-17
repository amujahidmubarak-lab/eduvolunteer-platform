@extends('layouts.dashboard')

@section('title', 'Pengumuman - Malang Mengajar')
@section('dashboard_title', 'Pengumuman Sosma')

@section('dashboard_content')
<div class="space-y-8">
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Pusat Informasi & Pengumuman</h3>
            <p class="text-sm text-gray-600">Dapatkan update informasi terbaru, jadwal koordinasi, dan pengumuman resmi dari pengurus Sosma.</p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
            <i data-lucide="bell" class="w-6 h-6"></i>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4 hover:shadow-md transition-shadow group">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <h4 class="font-poppins font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">
                        {{ $announcement->title }}
                    </h4>
                    <span class="text-xs font-semibold px-3 py-1 bg-gray-100 text-gray-600 rounded-xl sm:self-center self-start">
                        {{ $announcement->created_at->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <div class="prose max-w-none text-sm text-gray-700 leading-relaxed space-y-2">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
                <div class="flex items-center gap-1 text-[11px] text-gray-400 pt-2">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    <span>Diposting {{ $announcement->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="bell-off" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Pengumuman</p>
                <p class="text-xs text-gray-400 mt-1">Saat ini belum ada pengumuman resmi yang dirilis oleh tim Sosma.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
