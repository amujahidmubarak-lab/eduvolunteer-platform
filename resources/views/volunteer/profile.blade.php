@extends('layouts.dashboard')

@section('title', 'Profil Saya - Malang Mengajar')
@section('dashboard_title', 'Profil Volunteer')

@section('dashboard_content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-8 sm:p-12 rounded-3xl border border-gray-100 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 border-b border-gray-100 pb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-2xl font-poppins font-bold shadow-lg shadow-blue-500/30">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-2xl mb-1">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="px-4 py-2 rounded-2xl text-xs font-semibold border 
                @if($user->status === 'approved') bg-green-50 border-green-200 text-green-700 
                @elseif($user->status === 'pending') bg-yellow-50 border-yellow-200 text-yellow-700 
                @else bg-red-50 border-red-200 text-red-700 @endif flex items-center gap-2">
                <span class="w-2 h-2 rounded-full @if($user->status === 'approved') bg-green-500 @elseif($user->status === 'pending') bg-yellow-500 @else bg-red-500 @endif animate-pulse"></span>
                <span class="uppercase tracking-wider">Status: {{ $user->status }}</span>
            </div>
        </div>

        <form action="{{ url('/volunteer/profile') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input id="whatsapp" name="whatsapp" type="text" required value="{{ old('whatsapp', $user->volunteerProfile->whatsapp ?? '') }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>

                <!-- Kampus / Jurusan -->
                <div>
                    <label for="campus_major" class="block text-sm font-medium text-gray-700 mb-1">Kampus & Jurusan</label>
                    <input id="campus_major" name="campus_major" type="text" required value="{{ old('campus_major', $user->volunteerProfile->campus_major ?? '') }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>

                <!-- Domisili -->
                <div>
                    <label for="domicile" class="block text-sm font-medium text-gray-700 mb-1">Domisili di Malang</label>
                    <input id="domicile" name="domicile" type="text" required value="{{ old('domicile', $user->volunteerProfile->domicile ?? '') }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>

                <!-- Pilihan Mapel -->
                <div>
                    <label for="interested_subjects" class="block text-sm font-medium text-gray-700 mb-1">Pilihan Mata Pelajaran</label>
                    <select id="interested_subjects" name="interested_subjects" required
                            class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                        <option value="Matematika" {{ ($user->volunteerProfile->interested_subjects ?? '') == 'Matematika' ? 'selected' : '' }}>Matematika SD</option>
                        <option value="Bahasa Inggris" {{ ($user->volunteerProfile->interested_subjects ?? '') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                        <option value="Matematika & Bahasa Inggris" {{ ($user->volunteerProfile->interested_subjects ?? '') == 'Matematika & Bahasa Inggris' ? 'selected' : '' }}>Keduanya</option>
                    </select>
                </div>

                <!-- Availability -->
                <div class="sm:col-span-2">
                    <label for="availability" class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan Jadwal Kosong</label>
                    <input id="availability" name="availability" type="text" required value="{{ old('availability', $user->volunteerProfile->availability ?? '') }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                </div>

                <!-- Motivasi -->
                <div class="sm:col-span-2">
                    <label for="motivation" class="block text-sm font-medium text-gray-700 mb-1">Motivasi Mengajar</label>
                    <textarea id="motivation" name="motivation" rows="3" required
                              class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">{{ old('motivation', $user->volunteerProfile->motivation ?? '') }}</textarea>
                </div>

                <!-- KTM Photo Preview -->
                @if(isset($user->volunteerProfile->ktm_photo))
                    <div class="sm:col-span-2 pt-2 border-t border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTM / Identitas Diri</label>
                        <img src="{{ url($user->volunteerProfile->ktm_photo) }}" alt="KTM" class="max-w-xs h-auto rounded-2xl border border-gray-200 shadow-sm bg-gray-100 object-cover">
                    </div>
                @endif
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                    <span>Simpan Perubahan Profil</span>
                    <i data-lucide="save" class="w-5 h-5"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
