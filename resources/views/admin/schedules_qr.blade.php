@extends('layouts.dashboard')

@section('title', 'QR Code Presensi - Admin Malang Mengajar')
@section('dashboard_title', 'QR Code Kehadiran')

@section('dashboard_content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.schedules') }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span class="text-sm font-medium">Kembali ke Daftar Jadwal</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 flex flex-col items-center text-center">
        
        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-6">
            <i data-lucide="scan" class="w-8 h-8"></i>
        </div>

        <h2 class="text-2xl font-bold font-poppins text-gray-900 mb-2">Scan untuk Presensi</h2>
        <p class="text-gray-500 text-sm mb-8">
            {{ $schedule->subject }} • {{ $schedule->learningHome->name }}<br>
            Tanggal: {{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('l, d F Y') }}<br>
            Pukul: {{ $schedule->start_time }} - {{ $schedule->end_time }}
        </p>

        @php
            $attendanceUrl = route('volunteer.attend', ['schedule' => $schedule->id, 'token' => $schedule->attendance_token]);
            // Using a reliable public API to generate QR code without NPM dependencies
            $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($attendanceUrl);
        @endphp

        <div class="p-4 bg-white border-4 border-gray-100 rounded-3xl shadow-sm mb-8 inline-block">
            <img src="{{ $qrApiUrl }}" alt="QR Code Presensi" class="w-64 h-64 object-contain" />
        </div>

        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl text-xs flex items-start gap-3 text-left w-full">
            <i data-lucide="info" class="w-5 h-5 shrink-0 text-yellow-600"></i>
            <p>
                <strong>Cara Penggunaan:</strong> Minta relawan untuk membuka kamera atau aplikasi Scanner di HP mereka, arahkan ke QR Code di atas. Pastikan relawan sudah <em>login</em> ke akun masing-masing untuk mencatat kehadiran.
            </p>
        </div>
        
    </div>
</div>
@endsection
