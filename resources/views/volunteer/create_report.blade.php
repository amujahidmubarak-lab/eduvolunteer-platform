@extends('layouts.dashboard')

@section('title', 'Isi Laporan Mengajar - Malang Mengajar')
@section('dashboard_title', 'Form Laporan Kegiatan')

@section('dashboard_content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Schedule Info Box -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-2xl z-0 pointer-events-none"></div>
        <div class="relative z-10 space-y-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/30">
                {{ $schedule->subject }}
            </span>
            <h3 class="font-poppins font-bold text-white text-2xl mb-1">{{ $schedule->learningHome->name }}</h3>
            <p class="text-xs text-blue-100 flex items-center gap-1.5">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>{{ $schedule->schedule_date->translatedFormat('l, d F Y') }} ({{ $schedule->start_time }} - {{ $schedule->end_time }} WIB)</span>
            </p>
        </div>
    </div>

    <!-- Report Form -->
    <div class="bg-white p-8 sm:p-12 rounded-3xl border border-gray-100 shadow-sm space-y-8">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Detail Laporan Mengajar</h3>
            <p class="text-xs text-gray-500">Silakan lengkapi data laporan di bawah ini dengan akurat sebagai bahan evaluasi dan dokumentasi Sosma.</p>
        </div>

        <form action="{{ url('/volunteer/reports') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="teaching_schedule_id" value="{{ $schedule->id }}">

            <!-- Materi Taught -->
            <div>
                <label for="material_taught" class="block text-sm font-medium text-gray-700 mb-1">Materi yang Diajarkan <span class="text-red-500">*</span></label>
                <textarea id="material_taught" name="material_taught" rows="3" required
                          class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                          placeholder="Contoh: Operasi hitung campuran pecahan dan latihan soal cerita matematika...">{{ old('material_taught') }}</textarea>
            </div>

            <!-- Jumlah Siswa Hadir -->
            <div>
                <label for="student_count" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Siswa yang Hadir <span class="text-red-500">*</span></label>
                <div class="relative max-w-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <input id="student_count" name="student_count" type="number" min="1" required value="{{ old('student_count', 10) }}"
                           class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Perkiraan jumlah anak SD yang mengikuti sesi belajar.</p>
            </div>

            <!-- Kendala -->
            <div>
                <label for="obstacles" class="block text-sm font-medium text-gray-700 mb-1">Kendala di Lapangan (Opsional)</label>
                <textarea id="obstacles" name="obstacles" rows="3"
                          class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                          placeholder="Contoh: Suasana kelas agak ramai karena ada beberapa siswa baru yang belum terbiasa...">{{ old('obstacles') }}</textarea>
            </div>

            <!-- Evaluasi -->
            <div>
                <label for="evaluation" class="block text-sm font-medium text-gray-700 mb-1">Evaluasi & Saran Kedepan (Opsional)</label>
                <textarea id="evaluation" name="evaluation" rows="3"
                          class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                          placeholder="Contoh: Sebaiknya disiapkan alat peraga matematika agar siswa lebih mudah memahami konsep...">{{ old('evaluation') }}</textarea>
            </div>

            <!-- Upload Foto -->
            <div>
                <label for="documentation_photo" class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Dokumentasi Kegiatan (Opsional/Maks 5MB)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl bg-gray-50/50 hover:bg-white transition-all">
                    <div class="space-y-1 text-center">
                        <i data-lucide="camera" class="mx-auto w-12 h-12 text-gray-400"></i>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="documentation_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Pilih foto kegiatan</span>
                                <input id="documentation_photo" name="documentation_photo" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-4">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                    <span>Kirim Laporan Mengajar</span>
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
                <a href="{{ url('/volunteer/reports') }}" class="px-8 py-4 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-2xl transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
