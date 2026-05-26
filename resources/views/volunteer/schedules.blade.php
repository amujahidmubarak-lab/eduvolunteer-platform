@extends('layouts.dashboard')

@section('title', 'Jadwal Mengajar - Malang Mengajar')
@section('dashboard_title', 'Jadwal Mengajar')

@section('dashboard_content')
<div x-data="{ view: 'calendar' }" class="space-y-8">
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Daftar Seluruh Jadwal Kegiatan</h3>
            <p class="text-sm text-gray-600">Lihat lokasi rumah belajar, mata pelajaran, jam kegiatan, serta pengajar lain dalam jadwal.</p>
        </div>
        <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-100 text-xs font-semibold text-gray-600">
            <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white shadow-sm text-blue-600">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span>Jadwal Saya</span>
            </span>
            <span class="flex items-center gap-1.5 px-3 py-1.5">
                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                <span>Volunteer Lain</span>
            </span>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex items-center gap-4 border-b border-gray-100">
        <button @click="view = 'calendar'" :class="view === 'calendar' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-4 py-3 font-semibold text-sm border-b-2 transition-colors flex items-center gap-2">
            <i data-lucide="calendar" class="w-4 h-4"></i> Kalender
        </button>
        <button @click="view = 'list'" :class="view === 'list' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-4 py-3 font-semibold text-sm border-b-2 transition-colors flex items-center gap-2">
            <i data-lucide="list" class="w-4 h-4"></i> Daftar Jadwal
        </button>
    </div>

    <!-- Calendar View -->
    <div x-show="view === 'calendar'" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div id="calendar" class="min-h-[600px]"></div>
    </div>

    <div x-show="view === 'list'" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" x-cloak>
        @forelse($schedules as $schedule)
            @php
                $isMySchedule = in_array($schedule->id, $myScheduleIds);
            @endphp
            <div class="bg-white rounded-3xl border {{ $isMySchedule ? 'border-2 border-blue-500 shadow-md shadow-blue-500/10' : 'border-gray-100 shadow-sm' }} p-6 flex flex-col justify-between gap-6 hover:shadow-lg transition-all group relative overflow-hidden">
                @if($isMySchedule)
                    <div class="absolute top-0 right-0 bg-blue-600 text-white text-[10px] font-poppins font-bold px-4 py-1 rounded-bl-xl uppercase tracking-wider shadow-sm">
                        Jadwal Saya
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Header Badge & Status -->
                    <div class="flex items-center justify-between gap-2 pt-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            {{ $schedule->subject }}
                        </span>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold border 
                            @if($schedule->status === 'completed') bg-green-50 border-green-200 text-green-700 
                            @elseif($schedule->status === 'scheduled') bg-yellow-50 border-yellow-200 text-yellow-700 
                            @else bg-red-50 border-red-200 text-red-700 @endif">
                            {{ $schedule->status === 'completed' ? 'Selesai' : ($schedule->status === 'scheduled' ? 'Terjadwal' : 'Batal') }}
                        </span>
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
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-medium {{ $vol->id === auth()->id() ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'bg-gray-100 text-gray-700' }}">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    <span>{{ $vol->name }}</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer CTA -->
                @if($isMySchedule && $schedule->status === 'completed')
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ url('/volunteer/reports/create?schedule_id=' . $schedule->id) }}" class="w-full text-center bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-poppins font-bold text-xs py-3 px-4 rounded-xl shadow-md transition-all block">
                            Isi Laporan Mengajar
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="calendar-off" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Jadwal Mengajar</p>
                <p class="text-xs text-gray-400 mt-1">Jadwal kegiatan akan segera dirilis oleh tim Admin Sosma.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($calendarEvents);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            themeSystem: 'standard',
            events: events,
            eventClick: function(info) {
                // Could open a modal or alert
            },
            height: 'auto',
        });

        // Initialize calendar when Alpine renders it
        let initialized = false;
        document.addEventListener('alpine:initialized', () => {
            const el = document.querySelector('[x-data]');
            if (el) {
                Alpine.effect(() => {
                    const view = Alpine.$data(el).view;
                    if (view === 'calendar' && !initialized) {
                        setTimeout(() => {
                            calendar.render();
                            initialized = true;
                        }, 50);
                    } else if (view === 'calendar' && initialized) {
                        setTimeout(() => {
                            calendar.updateSize();
                        }, 50);
                    }
                });
            }
        });
    });
</script>
@endpush
