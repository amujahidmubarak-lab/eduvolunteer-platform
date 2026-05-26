@extends('layouts.dashboard')

@section('title', 'Verifikasi Kehadiran - Malang Mengajar')
@section('dashboard_title', 'Presensi Kehadiran')

@section('dashboard_content')
<div class="max-w-md mx-auto">
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-gray-100 shadow-sm text-center space-y-6">
        
        <!-- Status Icon / Loading -->
        <div class="relative flex justify-center py-4">
            <div id="loader-ring" class="absolute w-24 h-24 rounded-full border-4 border-blue-100 border-t-blue-600 animate-spin"></div>
            <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center relative z-10">
                <i id="status-icon" data-lucide="map-pin" class="w-10 h-10 text-blue-600 animate-pulse"></i>
            </div>
        </div>

        <div class="space-y-2">
            <h3 class="font-poppins font-bold text-gray-900 text-xl">Memverifikasi Lokasi Anda</h3>
            <p id="status-text" class="text-sm text-gray-500 leading-relaxed px-4">
                Mohon izinkan akses GPS (lokasi) di browser Anda untuk memastikan kehadiran Anda di Rumah Belajar.
            </p>
        </div>

        <!-- Info Schedule Card -->
        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-left space-y-4">
            <div>
                <span class="text-[10px] uppercase font-bold text-blue-600 tracking-wider">Mata Pelajaran</span>
                <p class="font-semibold text-gray-900 text-base">{{ $schedule->subject }}</p>
            </div>
            <div>
                <span class="text-[10px] uppercase font-bold text-blue-600 tracking-wider">Rumah Belajar</span>
                <p class="font-bold font-poppins text-gray-900 text-lg">{{ $schedule->learningHome->name ?? '-' }}</p>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $schedule->learningHome->address ?? '-' }}</p>
            </div>
        </div>

        <!-- Fallback Retry Button (Hidden by default) -->
        <button id="retry-btn" onclick="getLocation()" class="hidden w-full items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3.5 px-6 rounded-2xl shadow-md transition-all">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
            <span>Coba Deteksi Lokasi Lagi</span>
        </button>

        <!-- Hidden Form -->
        <form id="attend-form" action="{{ route('volunteer.attend.process', [$schedule->id, $token]) }}" method="POST">
            @csrf
            <input type="hidden" name="latitude" id="lat">
            <input type="hidden" name="longitude" id="lon">
        </form>
    </div>
</div>

@push('scripts')
<script>
    function getLocation() {
        // Reset view states
        document.getElementById('loader-ring').classList.remove('hidden');
        document.getElementById('retry-btn').classList.add('hidden');
        document.getElementById('status-icon').setAttribute('data-lucide', 'map-pin');
        document.getElementById('status-icon').className = 'w-10 h-10 text-blue-600 animate-pulse';
        document.getElementById('status-text').innerText = 'Mohon izinkan akses GPS (lokasi) di browser Anda untuk memastikan kehadiran Anda di Rumah Belajar.';
        lucide.createIcons();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lon').value = position.coords.longitude;
                    document.getElementById('status-text').innerText = 'Lokasi terdeteksi! Memproses presensi Anda...';
                    document.getElementById('attend-form').submit();
                },
                (error) => {
                    let msg = 'Gagal mendeteksi lokasi.';
                    if (error.code === error.PERMISSION_DENIED) {
                        msg = 'Akses lokasi ditolak. Silakan aktifkan izin lokasi/GPS pada pengaturan browser Anda dan coba lagi.';
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        msg = 'Informasi lokasi tidak tersedia. Pastikan sinyal GPS Anda kuat.';
                    } else if (error.code === error.TIMEOUT) {
                        msg = 'Waktu deteksi lokasi habis. Silakan coba lagi.';
                    }
                    
                    document.getElementById('loader-ring').classList.add('hidden');
                    document.getElementById('status-icon').setAttribute('data-lucide', 'map-pin-off');
                    document.getElementById('status-icon').className = 'w-10 h-10 text-red-500';
                    lucide.createIcons();
                    document.getElementById('status-text').innerText = msg;
                    document.getElementById('retry-btn').classList.remove('hidden');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            document.getElementById('loader-ring').classList.add('hidden');
            document.getElementById('status-text').innerText = 'Browser Anda tidak mendukung deteksi lokasi (GPS).';
        }
    }

    // Run automatically on load
    document.addEventListener('DOMContentLoaded', () => {
        getLocation();
    });
</script>
@endpush
@endsection
