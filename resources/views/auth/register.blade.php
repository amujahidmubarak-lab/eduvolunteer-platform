@extends('layouts.app')

@section('title', 'Daftar Volunteer - Malang Mengajar')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-blue-50/50 via-white to-white">
    <div class="max-w-2xl w-full space-y-8 bg-white p-8 sm:p-12 rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 relative">
        <!-- Back button -->
        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-1 text-xs font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Beranda</span>
        </a>

        <div class="text-center pt-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 mx-auto flex items-center justify-center text-white shadow-lg shadow-blue-500/30 mb-4 group-hover:scale-105 transition-transform">
                <i data-lucide="user-plus" class="w-8 h-8"></i>
            </div>
            <h2 class="text-3xl font-bold font-poppins text-gray-900 tracking-tight">Bergabung Menjadi Volunteer</h2>
            <p class="mt-2 text-sm text-gray-600 max-w-md mx-auto">
                Silakan lengkapi formulir pendaftaran di bawah ini. Akun Anda akan diverifikasi oleh tim Admin sebelum dijadwalkan mengajar.
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Budi Santoso">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="budi@mahasiswa.ac.id">
                    </div>
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </div>
                        <input id="whatsapp" name="whatsapp" type="text" required value="{{ old('whatsapp') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="081234567890">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input id="password" name="password" type="password" required 
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Ulangi kata sandi">
                    </div>
                </div>

                <!-- Kampus / Jurusan -->
                <div>
                    <label for="campus_major" class="block text-sm font-medium text-gray-700 mb-1">Kampus & Jurusan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                        </div>
                        <input id="campus_major" name="campus_major" type="text" required value="{{ old('campus_major') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Univ. Brawijaya / Pend. Matematika">
                    </div>
                </div>

                <!-- Domisili -->
                <div>
                    <label for="domicile" class="block text-sm font-medium text-gray-700 mb-1">Domisili di Malang</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <input id="domicile" name="domicile" type="text" required value="{{ old('domicile') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Kec. Lowokwaru / Jl. Veteran">
                    </div>
                </div>

                <!-- Mata Pelajaran Diminati -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran yang Diminati</label>
                    <div class="grid sm:grid-cols-3 gap-4 pt-1">
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="radio" name="interested_subjects" value="Matematika" required class="text-blue-600 focus:ring-blue-500" {{ old('interested_subjects') == 'Matematika' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-800">Matematika SD</span>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="radio" name="interested_subjects" value="Bahasa Inggris" required class="text-blue-600 focus:ring-blue-500" {{ old('interested_subjects') == 'Bahasa Inggris' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-800">Bahasa Inggris</span>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="radio" name="interested_subjects" value="Matematika & Bahasa Inggris" required class="text-blue-600 focus:ring-blue-500" {{ old('interested_subjects') == 'Matematika & Bahasa Inggris' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-800">Keduanya</span>
                        </label>
                    </div>
                </div>

                <!-- Availability / Jadwal Kosong -->
                <div class="sm:col-span-2">
                    <label for="availability" class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan Jadwal Kosong</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </div>
                        <input id="availability" name="availability" type="text" required value="{{ old('availability') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="Contoh: Senin & Rabu (Sore), Sabtu (Pagi)">
                    </div>
                </div>

                <!-- Motivasi Bergabung -->
                <div class="sm:col-span-2">
                    <label for="motivation" class="block text-sm font-medium text-gray-700 mb-1">Motivasi Bergabung</label>
                    <textarea id="motivation" name="motivation" rows="3" required
                              class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                              placeholder="Ceritakan alasan dan motivasi Anda ingin berkontribusi di Malang Mengajar...">{{ old('motivation') }}</textarea>
                </div>

                <!-- Upload KTM / Foto -->
                <div class="sm:col-span-2">
                    <label for="ktm_photo" class="block text-sm font-medium text-gray-700 mb-1">Upload KTM / Foto Diri (Opsional/Maks 5MB)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl bg-gray-50/50 hover:bg-white transition-all">
                        <div class="space-y-1 text-center">
                            <i data-lucide="upload-cloud" class="mx-auto w-12 h-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="ktm_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    <span>Pilih file KTM</span>
                                    <input id="ktm_photo" name="ktm_photo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                    <span>Kirim Formulir Pendaftaran</span>
                    <i data-lucide="send" class="w-5 h-5"></i>
                </button>
            </div>

            <p class="text-center text-sm text-gray-600 pt-2">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
