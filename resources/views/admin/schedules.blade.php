@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar - Malang Mengajar')
@section('dashboard_title', 'Manajemen Jadwal Mengajar')

@section('dashboard_content')
<div x-data="{ showModal: false }" class="space-y-8">
    <!-- Header & Action Button -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Jadwal Pengabdian & Alokasi Volunteer</h3>
            <p class="text-sm text-gray-600">Buat jadwal mengajar di rumah belajar dan tugaskan volunteer yang telah disetujui.</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-poppins font-bold text-xs py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2 shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Buat Jadwal Baru</span>
        </button>
    </div>

    <!-- Modal Form Buat Jadwal -->
    <div x-show="showModal" x-transition.opacity x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div @click.away="showModal = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-2xl w-full p-8 sm:p-10 my-8 space-y-6 relative">
            <button @click="showModal = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="calendar-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Buat Jadwal Mengajar Baru</h3>
                    <p class="text-xs text-gray-500">Tentukan lokasi, mapel, waktu, dan tim volunteer pengajar.</p>
                </div>
            </div>

            <form action="{{ url('/admin/schedules') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid sm:grid-cols-2 gap-6">
                    <!-- Rumah Belajar -->
                    <div class="sm:col-span-2">
                        <label for="learning_home_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Rumah Belajar <span class="text-red-500">*</span></label>
                        <select id="learning_home_id" name="learning_home_id" required
                                class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                            <option value="">-- Pilih Rumah Belajar --</option>
                            @foreach($learningHomes as $home)
                                <option value="{{ $home->id }}">{{ $home->name }} ({{ $home->address }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select id="subject" name="subject" required
                                class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                            <option value="Matematika">Matematika SD</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label for="schedule_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                        <input id="schedule_date" name="schedule_date" type="date" required value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Jam Mulai -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                        <input id="start_time" name="start_time" type="text" required value="15:00" placeholder="15:00"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                        <input id="end_time" name="end_time" type="text" required value="17:00" placeholder="17:00"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Catatan -->
                    <div class="sm:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan / Fokus Materi (Opsional)</label>
                        <textarea id="notes" name="notes" rows="2"
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                                  placeholder="Contoh: Fokus pada perkalian dan pembagian dasar..."></textarea>
                    </div>

                    <!-- Pilih Volunteer -->
                    <div class="sm:col-span-2 space-y-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tugaskan Volunteer Pengajar <span class="text-red-500">*</span></label>
                        <div class="max-h-48 overflow-y-auto p-4 rounded-2xl border border-gray-200 bg-gray-50/50 space-y-2.5">
                            @forelse($volunteers as $vol)
                                <label class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white cursor-pointer transition-all border border-transparent hover:border-gray-200 hover:shadow-sm">
                                    <input type="checkbox" name="volunteer_ids[]" value="{{ $vol->id }}" class="text-blue-600 rounded focus:ring-blue-500 w-4 h-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $vol->name }}</p>
                                        <p class="text-[11px] text-gray-500 truncate">Minat: {{ $vol->volunteerProfile->interested_subjects ?? '-' }} | Jadwal: {{ $vol->volunteerProfile->availability ?? '-' }}</p>
                                    </div>
                                </label>
                            @empty
                                <p class="text-xs text-gray-500 text-center py-4">Belum ada volunteer dengan status disetujui (Approved).</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <span>Simpan Jadwal Mengajar</span>
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </button>
                    <button type="button" @click="showModal = false" class="px-8 py-4 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-2xl transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Schedules Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($schedules as $schedule)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between gap-6 hover:shadow-md transition-all group">
                <div class="space-y-4">
                    <!-- Header Badge & Status -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            {{ $schedule->subject }}
                        </span>

                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border 
                                @if($schedule->status === 'completed') bg-green-50 border-green-200 text-green-700 
                                @elseif($schedule->status === 'scheduled') bg-yellow-50 border-yellow-200 text-yellow-700 
                                @else bg-red-50 border-red-200 text-red-700 @endif">
                                {{ $schedule->status === 'completed' ? 'Selesai' : ($schedule->status === 'scheduled' ? 'Terjadwal' : 'Batal') }}
                            </span>
                        </div>
                    </div>

                    <!-- Rumah Belajar Info -->
                    <div>
                        <h4 class="font-poppins font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors mb-1">
                            {{ $schedule->learningHome->name }}
                        </h4>
                        <p class="text-xs text-gray-500 flex items-start gap-1.5 leading-relaxed">
                            <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span>{{ $schedule->learningHome->address }}</span>
                        </p>
                    </div>

                    <!-- Date & Time -->
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 space-y-2 text-xs">
                        <div class="flex items-center justify-between text-gray-700 font-semibold">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="calendar" class="w-4 h-4 text-blue-600"></i>
                                <span>Tanggal</span>
                            </span>
                            <span>{{ $schedule->schedule_date->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="clock" class="w-4 h-4 text-yellow-500"></i>
                                <span>Jam Kegiatan</span>
                            </span>
                            <span>{{ $schedule->start_time }} - {{ $schedule->end_time }} WIB</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($schedule->notes)
                        <div class="text-xs text-gray-600 bg-blue-50/50 p-3 rounded-xl border border-blue-100/50">
                            <span class="font-semibold text-blue-800 block mb-0.5">Catatan Materi:</span>
                            <p class="leading-relaxed">{{ $schedule->notes }}</p>
                        </div>
                    @endif

                    <!-- Assigned Volunteers List -->
                    <div class="space-y-2 pt-2 border-t border-gray-100">
                        <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Tim Pengajar ({{ $schedule->volunteers->count() }} Orang)</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($schedule->volunteers as $vol)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-medium bg-gray-100 text-gray-700">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    <span>{{ $vol->name }}</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                    @if($schedule->status === 'scheduled')
                        <form action="{{ url('/admin/schedules/' . $schedule->id . '/status') }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full text-center bg-green-100 hover:bg-green-600 text-green-700 hover:text-white font-semibold text-xs py-2.5 px-3 rounded-xl transition-colors">
                                Tandai Selesai
                            </button>
                        </form>
                        <form action="{{ url('/admin/schedules/' . $schedule->id . '/status') }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full text-center bg-yellow-100 hover:bg-yellow-600 text-yellow-700 hover:text-white font-semibold text-xs py-2.5 px-3 rounded-xl transition-colors">
                                Batalkan
                            </button>
                        </form>
                    @endif

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ url('/admin/schedules/' . $schedule->id . '/qr') }}" title="Tampilkan QR Presensi" target="_blank" class="p-2.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white rounded-xl transition-colors border border-indigo-200">
                            <i data-lucide="qr-code" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ url('/admin/schedules/' . $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus Jadwal" class="p-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-colors border border-red-200">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="calendar-off" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Jadwal Mengajar</p>
                <p class="text-xs text-gray-400 mt-1">Gunakan tombol 'Buat Jadwal Baru' di atas untuk memulai alokasi kegiatan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection


