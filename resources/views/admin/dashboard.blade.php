@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - Malang Mengajar')
@section('dashboard_title', 'Dashboard Admin Sosma')

@section('dashboard_content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 sm:p-12 text-white shadow-xl shadow-blue-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-2xl z-0 pointer-events-none"></div>
        <div class="relative z-10 space-y-2 max-w-2xl">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white border border-white/30 inline-block">
                Sistem Manajemen Pengabdian
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold font-poppins tracking-tight leading-tight">
                Selamat Datang, Pengurus Sosma!
            </h2>
            <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                Kelola pendaftaran relawan, alokasi jadwal mengajar di rumah belajar, serta pantau laporan kegiatan dan dampak sosial secara real-time.
            </p>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto shrink-0">
            @php
                $regOpen = \App\Models\Setting::getValue('registration_status', 'open') === 'open';
            @endphp
            <form action="{{ route('admin.settings.toggle-registration') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 font-poppins font-bold text-sm px-6 py-3.5 rounded-2xl transition-all border shadow-lg hover:-translate-y-0.5
                    {{ $regOpen 
                        ? 'bg-emerald-500 hover:bg-emerald-600 text-white border-emerald-400 shadow-emerald-500/20' 
                        : 'bg-rose-500 hover:bg-rose-600 text-white border-rose-400 shadow-rose-500/20' }}">
                    <i data-lucide="{{ $regOpen ? 'unlock' : 'lock' }}" class="w-5 h-5"></i>
                    <span>Pendaftaran: {{ $regOpen ? 'DIBUKA' : 'DITUTUP' }}</span>
                </button>
            </form>

            <a href="{{ url('/admin/schedules') }}" class="w-full sm:w-auto bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-poppins font-bold text-sm px-6 py-3.5 rounded-2xl shadow-lg shadow-yellow-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Buat Jadwal Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <div>
                <h4 class="text-3xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['active_volunteers'] }}</h4>
                <p class="text-xs font-medium text-gray-500">Volunteer Aktif</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="home" class="w-7 h-7"></i>
            </div>
            <div>
                <h4 class="text-3xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['learning_homes'] }}</h4>
                <p class="text-xs font-medium text-gray-500">Rumah Belajar</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="calendar-check" class="w-7 h-7"></i>
            </div>
            <div>
                <h4 class="text-3xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['teaching_schedules'] }}</h4>
                <p class="text-xs font-medium text-gray-500">Total Kegiatan</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 mb-4 group-hover:scale-110 transition-transform">
                <i data-lucide="file-check-2" class="w-7 h-7"></i>
            </div>
            <div>
                <h4 class="text-3xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['impact_hours'] }} <span class="text-lg text-gray-400 font-normal">Jam</span></h4>
                <p class="text-xs font-medium text-gray-500">Total Jam Dampak</p>
            </div>
        </div>
    </div>

    <!-- Impact Analytics Charts -->
    <div class="grid lg:grid-cols-2 gap-8" x-data="impactAnalytics({{ json_encode($chartData) }})">
        <!-- Line Chart -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Tren Aktivitas Mengajar</h3>
                    <p class="text-xs text-gray-500 mt-1">Jumlah laporan kegiatan dalam 7 hari terakhir</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative h-64 w-full">
                <canvas x-ref="trendChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm group hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Distribusi Siswa</h3>
                    <p class="text-xs text-gray-500 mt-1">Persebaran jumlah siswa per Rumah Belajar</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative h-64 w-full flex justify-center">
                <canvas x-ref="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Main Grid: Pending Volunteers & Recent Reports -->
    <div class="grid lg:grid-cols-12 gap-8 items-start">
        <!-- Pending Volunteers -->
        <div class="lg:col-span-6 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Verifikasi Volunteer Pending</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Pendaftar baru menunggu persetujuan Anda</p>
                </div>
                <a href="{{ url('/admin/volunteers?status=pending') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($pendingVolunteers as $volunteer)
                    <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all flex items-center justify-between gap-4 group">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 font-bold font-poppins shrink-0">
                                {{ substr($volunteer->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-poppins font-bold text-gray-900 text-sm truncate group-hover:text-blue-600 transition-colors">
                                    {{ $volunteer->name }}
                                </h4>
                                <p class="text-xs text-gray-500 truncate">{{ $volunteer->volunteerProfile->campus_major ?? '-' }}</p>
                                <p class="text-[11px] text-gray-400 truncate mt-0.5">Minat: {{ $volunteer->volunteerProfile->interested_subjects ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ url('/admin/volunteers/' . $volunteer->id . '/status') }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" title="Setujui" class="p-2.5 bg-green-100 hover:bg-green-600 text-green-700 hover:text-white rounded-xl transition-colors shadow-sm">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                            </form>
                            <a href="{{ url('/admin/volunteers/' . $volunteer->id) }}" title="Detail" class="p-2.5 bg-blue-100 hover:bg-blue-600 text-blue-700 hover:text-white rounded-xl transition-colors shadow-sm">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="user-check" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                        <p class="text-base font-medium">Tidak ada pendaftar pending saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="lg:col-span-6 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Laporan Kegiatan Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Catatan pengajaran dari para volunteer</p>
                </div>
                <a href="{{ url('/admin/reports') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Semua Laporan</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse($recentReports as $report)
                    <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all space-y-3 group">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 mb-1 inline-block">
                                    {{ $report->teachingSchedule->subject ?? '-' }}
                                </span>
                                <h4 class="font-poppins font-bold text-gray-900 text-sm group-hover:text-blue-600 transition-colors">
                                    {{ $report->teachingSchedule->learningHome->name ?? '-' }}
                                </h4>
                                <p class="text-xs text-gray-500">Pengajar: {{ $report->user->name ?? '-' }}</p>
                            </div>
                            <span class="text-xs font-bold text-gray-900 bg-white px-3 py-1 rounded-xl border border-gray-200 shadow-sm shrink-0">
                                {{ $report->student_count }} Siswa
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed bg-white p-3 rounded-xl border border-gray-100 line-clamp-2">
                            {{ $report->material_taught }}
                        </p>
                        <div class="flex items-center justify-between text-[10px] text-gray-400 pt-1">
                            <span>Dilaporkan {{ $report->created_at->diffForHumans() }}</span>
                            <a href="{{ url('/admin/reports') }}" class="font-semibold text-blue-600 hover:underline">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i data-lucide="file-x" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                        <p class="text-base font-medium">Belum ada laporan kegiatan yang masuk.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- E-Certificate Settings -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-poppins font-bold text-gray-900 text-xl flex items-center gap-2">
                    <i data-lucide="award" class="w-6 h-6 text-blue-600"></i>
                    <span>Pengaturan E-Sertifikat Relawan</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">Unggah desain template sertifikat (A4 Landscape) untuk di-overlay secara dinamis.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-12 gap-8 items-start">
            <!-- Form Upload -->
            <div class="md:col-span-5 space-y-4">
                <form action="{{ route('admin.settings.certificate-template') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Template (JPG/PNG)</label>
                        <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-blue-500 transition-colors bg-gray-50/50 relative group">
                            <input type="file" name="certificate_template" required accept="image/jpeg,image/png"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-2">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mx-auto group-hover:scale-110 transition-transform">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <div class="text-xs text-gray-600">
                                    <span class="font-semibold text-blue-600">Klik untuk upload</span> atau drag and drop
                                </div>
                                <p class="text-[10px] text-gray-400">Rasio A4 Landscape (Maks. 3MB)</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-poppins font-bold text-sm py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Template Baru</span>
                    </button>
                </form>
            </div>

            <!-- Preview Active Template -->
            <div class="md:col-span-7 space-y-2">
                <span class="block text-sm font-semibold text-gray-700">Preview Template Aktif</span>
                @php
                    $templatePath = \App\Models\Setting::getValue('certificate_template');
                @endphp
                @if($templatePath)
                    <div class="relative rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 aspect-[1.414/1] shadow-sm max-w-md mx-auto">
                        <img src="{{ url($templatePath) }}" alt="Template Sertifikat" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center border border-dashed border-gray-200 rounded-2xl p-12 bg-gray-50 aspect-[1.414/1] text-gray-400 max-w-md mx-auto">
                        <i data-lucide="image-off" class="w-12 h-12 mb-3 text-gray-300"></i>
                        <p class="text-xs font-semibold">Belum ada template kustom yang diunggah.</p>
                        <p class="text-[10px] text-gray-400 mt-1">Sistem akan menggunakan layout background default.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('impactAnalytics', (data) => ({
            init() {
                const trendCtx = this.$refs.trendChart.getContext('2d');
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: data.trend.labels,
                        datasets: [{
                            label: 'Laporan Kegiatan',
                            data: data.trend.data,
                            borderColor: '#2563eb', // blue-600
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#2563eb',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } }
                        }
                    }
                });

                const distCtx = this.$refs.distributionChart.getContext('2d');
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: data.distribution.labels,
                        datasets: [{
                            data: data.distribution.data,
                            backgroundColor: [
                                '#3b82f6', // blue-500
                                '#10b981', // emerald-500
                                '#f59e0b', // amber-500
                                '#8b5cf6', // violet-500
                                '#ec4899', // pink-500
                                '#06b6d4'  // cyan-500
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                        }
                    }
                });
            }
        }));
    });
</script>
@endsection
