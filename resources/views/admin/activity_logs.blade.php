@extends('layouts.dashboard')

@section('title', 'Catatan Aktivitas - Admin Malang Mengajar')
@section('dashboard_title', 'Catatan Aktivitas')

@section('dashboard_content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <p class="text-gray-500">Merekam semua aktivitas penting yang dilakukan oleh Admin di dalam sistem.</p>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="p-4 sm:p-6 font-semibold text-gray-900">Waktu</th>
                        <th class="p-4 sm:p-6 font-semibold text-gray-900">Pelaku (Admin)</th>
                        <th class="p-4 sm:p-6 font-semibold text-gray-900">Aksi</th>
                        <th class="p-4 sm:p-6 font-semibold text-gray-900">Deskripsi Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 sm:p-6 text-sm text-gray-500 whitespace-nowrap">
                            {{ $log->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="p-4 sm:p-6 text-sm font-medium text-gray-900">
                            {{ $log->user ? $log->user->name : 'Sistem' }}
                        </td>
                        <td class="p-4 sm:p-6 text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="p-4 sm:p-6 text-sm text-gray-600">
                            {{ $log->description }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="history" class="w-12 h-12 text-gray-300 mb-3"></i>
                                <p class="text-base font-medium text-gray-900">Belum Ada Aktivitas</p>
                                <p class="text-sm mt-1">Belum ada aktivitas admin yang tercatat di sistem saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="p-4 sm:p-6 border-t border-gray-100 bg-gray-50/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
