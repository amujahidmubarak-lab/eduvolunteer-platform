@extends('layouts.app')

@section('title', 'Malang Mengajar - Platform Pengabdian Pendidikan Berbasis Volunteer')

@section('content')
<!-- Navbar -->
<header x-data="{ open: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm py-3' : 'bg-transparent py-5'" 
        class="fixed top-0 left-0 right-0 z-40 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-poppins font-bold text-xl leading-none text-gray-900 tracking-tight group-hover:text-blue-600 transition-colors">Malang Mengajar</span>
                <span class="text-xs text-blue-600 font-medium tracking-wide">Pendidikan & Pengabdian</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="#home" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Home</a>
            <a href="#tentang" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Tentang</a>
            <a href="#alur" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Alur Volunteer</a>
            <a href="#kegiatan" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Kegiatan</a>
            <a href="#kontak" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Kontak</a>
        </nav>

        <!-- CTA / Auth Buttons -->
        <div class="hidden md:flex items-center gap-4">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/volunteer/dashboard') }}" 
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Dashboard Saya</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 border border-red-200 hover:bg-red-50 text-red-600 font-medium text-sm px-5 py-2.5 rounded-xl transition-all hover:bg-red-100/50">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors px-3 py-2">Masuk</a>
                @if(\App\Models\Setting::getValue('registration_status', 'open') === 'open')
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:-translate-y-0.5">
                        Daftar Volunteer
                    </a>
                @else
                    <span class="bg-gray-100 text-gray-400 font-medium text-sm px-5 py-2.5 rounded-xl border border-gray-200 cursor-not-allowed select-none">
                        Pendaftaran Ditutup
                    </span>
                @endif
            @endauth
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="open = !open" class="md:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none">
            <i x-show="!open" data-lucide="menu" class="w-6 h-6"></i>
            <i x-show="open" data-lucide="x" class="w-6 h-6" x-cloak></i>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="open" x-transition.origin.top x-cloak class="md:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-100 shadow-lg py-4 px-6 flex flex-col gap-4">
        <a @click="open = false" href="#home" class="text-base font-medium text-gray-800 hover:text-blue-600">Home</a>
        <a @click="open = false" href="#tentang" class="text-base font-medium text-gray-800 hover:text-blue-600">Tentang</a>
        <a @click="open = false" href="#alur" class="text-base font-medium text-gray-800 hover:text-blue-600">Alur Volunteer</a>
        <a @click="open = false" href="#kegiatan" class="text-base font-medium text-gray-800 hover:text-blue-600">Kegiatan</a>
        <a @click="open = false" href="#kontak" class="text-base font-medium text-gray-800 hover:text-blue-600">Kontak</a>
        <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/volunteer/dashboard') }}" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl shadow-md">
                    Dashboard Saya
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-center border border-red-200 hover:bg-red-50 text-red-600 font-medium py-3 rounded-xl transition-all">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full text-center border border-gray-300 text-gray-700 font-medium py-3 rounded-xl hover:bg-gray-50">Masuk</a>
                @if(\App\Models\Setting::getValue('registration_status', 'open') === 'open')
                    <a href="{{ route('register') }}" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl shadow-md">Daftar Volunteer</a>
                @else
                    <span class="w-full text-center bg-gray-100 text-gray-400 font-medium py-3 rounded-xl border border-gray-200 select-none">Pendaftaran Ditutup</span>
                @endif
            @endauth
        </div>
    </div>
</header>

<!-- Hero Section -->
<section id="home" class="pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-gradient-to-b from-blue-50/50 via-white to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-12 gap-12 items-center">
            <!-- Hero Text -->
            <div class="md:col-span-7 flex flex-col items-start gap-6 text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100/80 border border-blue-200 text-blue-700 text-sm font-semibold animate-pulse">
                    <i data-lucide="sparkles" class="w-4 h-4 text-yellow-500 fill-yellow-500"></i>
                    <span>Gerakan Mahasiswa Mengajar Kota Malang</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-poppins text-gray-900 tracking-tight leading-[1.15]">
                    Menebar Ilmu, <br class="hidden sm:inline">
                    <span class="text-blue-600">Merajut Masa Depan</span> <br class="hidden sm:inline">
                    Pendidikan Anak Negeri.
                </h1>
                <p class="text-lg text-gray-600 max-w-xl leading-relaxed">
                    Malang Mengajar adalah platform pengabdian masyarakat berbasis relawan yang fokus pada peningkatan literasi dasar, khususnya Matematika dan Bahasa Inggris, bagi anak-anak SD di berbagai Rumah Belajar se-Malang Raya.
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-2 w-full sm:w-auto">
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : url('/volunteer/dashboard') }}" 
                           class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-base px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Buka Dashboard
                        </a>
                    @else
                        @if(\App\Models\Setting::getValue('registration_status', 'open') === 'open')
                            <a href="{{ route('register') }}" class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-base px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                                Daftar Volunteer Sekarang
                            </a>
                        @else
                            <span class="w-full sm:w-auto text-center bg-gray-100 text-gray-400 font-medium text-base px-8 py-4 rounded-2xl border border-gray-200 select-none cursor-not-allowed">
                                Pendaftaran Ditutup
                            </span>
                        @endif
                        <a href="#tentang" class="w-full sm:w-auto text-center bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-medium text-base px-8 py-4 rounded-2xl transition-all hover:shadow-sm">
                            Pelajari Program
                        </a>
                    @endauth
                </div>

                <!-- Highlight Cards -->
                <div class="grid grid-cols-2 gap-4 w-full pt-6 border-t border-gray-100 mt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                            <i data-lucide="calculator" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-poppins font-semibold text-gray-900 leading-snug">Matematika SD</h4>
                            <p class="text-xs text-gray-500">Logika & Numerasi Dasar</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                            <i data-lucide="languages" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h4 class="font-poppins font-semibold text-gray-900 leading-snug">Bahasa Inggris</h4>
                            <p class="text-xs text-gray-500">Fun Learning & Vocabulary</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="md:col-span-5 relative">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-yellow-400/20 rounded-full blur-2xl z-0"></div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-600/20 rounded-full blur-2xl z-0"></div>
                
                <div class="relative z-10 bg-white p-4 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&auto=format&fit=crop&q=80" 
                         alt="Kegiatan Mengajar Malang Mengajar" 
                         class="w-full h-[420px] object-cover rounded-2xl shadow-inner">
                    
                    <!-- Floating Badge 1 -->
                    <div class="absolute top-8 -left-6 bg-white py-3 px-5 rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 flex items-center gap-3 animate-bounce" style="animation-duration: 4s;">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                            <i data-lucide="heart-handshake" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Platform Sosial</p>
                            <p class="text-sm font-bold font-poppins text-gray-900">100% Volunteer</p>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="absolute bottom-8 -right-6 bg-white py-3 px-5 rounded-2xl shadow-lg shadow-gray-200/60 border border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i data-lucide="home" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Lokasi Pengabdian</p>
                            <p class="text-sm font-bold font-poppins text-gray-900">Rumah Belajar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Dampak -->
<section class="py-16 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
            <div class="bg-gray-50/80 p-8 rounded-3xl border border-gray-100/80 text-center shadow-sm hover:shadow-md transition-shadow group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-7 h-7"></i>
                </div>
                <h3 class="text-4xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['volunteers'] }}</h3>
                <p class="text-sm font-medium text-gray-600">Volunteer Aktif</p>
            </div>

            <div class="bg-gray-50/80 p-8 rounded-3xl border border-gray-100/80 text-center shadow-sm hover:shadow-md transition-shadow group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="graduation-cap" class="w-7 h-7"></i>
                </div>
                <h3 class="text-4xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['students'] }}</h3>
                <p class="text-sm font-medium text-gray-600">Siswa Binaan SD</p>
            </div>

            <div class="bg-gray-50/80 p-8 rounded-3xl border border-gray-100/80 text-center shadow-sm hover:shadow-md transition-shadow group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="home" class="w-7 h-7"></i>
                </div>
                <h3 class="text-4xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['learning_homes'] }}</h3>
                <p class="text-sm font-medium text-gray-600">Rumah Belajar</p>
            </div>

            <div class="bg-gray-50/80 p-8 rounded-3xl border border-gray-100/80 text-center shadow-sm hover:shadow-md transition-shadow group">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="calendar-check" class="w-7 h-7"></i>
                </div>
                <h3 class="text-4xl font-bold font-poppins text-gray-900 mb-1">{{ $stats['teaching_schedules'] }}</h3>
                <p class="text-sm font-medium text-gray-600">Total Kegiatan</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Program -->
<section id="tentang" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-12 gap-12 items-center">
            <!-- Left: Images -->
            <div class="md:col-span-6 grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80" 
                     alt="Tentang Kami 1" 
                     class="w-full h-64 object-cover rounded-3xl shadow-lg mt-8 group-hover:scale-105 transition-transform duration-500">
                <img src="https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=600&auto=format&fit=crop&q=80" 
                     alt="Tentang Kami 2" 
                     class="w-full h-64 object-cover rounded-3xl shadow-lg group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Right: Content -->
            <div class="md:col-span-6 flex flex-col items-start gap-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Tentang Malang Mengajar</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold font-poppins text-gray-900 tracking-tight leading-tight">
                    Dedikasi Mahasiswa untuk <span class="text-blue-600">Pendidikan Dasar</span> yang Berkualitas.
                </h2>
                <p class="text-base text-gray-600 leading-relaxed">
                    Malang Mengajar hadir sebagai solusi nyata atas ketimpangan literasi dasar di kalangan anak-anak sekolah dasar. Kami mengoordinasikan mahasiswa dari berbagai perguruan tinggi di Malang Raya untuk terjun langsung mengajarkan Matematika dan Bahasa Inggris secara sukarela.
                </p>

                <div class="grid sm:grid-cols-2 gap-6 w-full pt-4">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                            <i data-lucide="target" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-poppins font-bold text-gray-900 text-lg">Visi Program</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">Mewujudkan generasi muda Kota Malang yang cerdas, berlogika kuat, dan mampu berkomunikasi global melalui pendampingan belajar yang humanis.</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col gap-3">
                        <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-poppins font-bold text-gray-900 text-lg">Tujuan Pengabdian</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">Menyediakan akses bimbingan belajar gratis di rumah belajar komunitas serta menanamkan rasa kepedulian sosial yang tinggi bagi mahasiswa.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <div class="flex -space-x-4 overflow-hidden">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Relawan">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=100&auto=format&fit=crop&q=80" alt="Relawan">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" alt="Relawan">
                    </div>
                    <p class="text-sm font-medium text-gray-600">Bergabunglah bersama puluhan mahasiswa pengabdi lainnya!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Volunteer -->
<section id="alur" class="py-24 bg-gray-50/60 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-4">
            <i data-lucide="milestone" class="w-4 h-4"></i>
            <span>Alur Pengabdian</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-bold font-poppins text-gray-900 tracking-tight mb-4">
            Bagaimana Cara Kerja <span class="text-blue-600">Volunteer?</span>
        </h2>
        <p class="text-base text-gray-600 max-w-2xl mx-auto mb-16">
            Proses bergabung hingga mengajar dirancang dengan sistem digital yang sederhana, transparan, dan terstruktur untuk memudahkan koordinasi pengabdian Anda.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-8 relative">
            <!-- Step 1 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center relative group hover:shadow-md transition-all hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <span class="absolute top-6 right-6 font-poppins font-bold text-2xl text-gray-200 group-hover:text-blue-200 transition-colors">01</span>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Pendaftaran</h4>
                <p class="text-xs text-gray-600 leading-relaxed">Mengisi form registrasi online lengkap dengan upload KTM dan motivasi mengajar.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center relative group hover:shadow-md transition-all hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 mb-6 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                    <i data-lucide="user-check" class="w-7 h-7"></i>
                </div>
                <span class="absolute top-6 right-6 font-poppins font-bold text-2xl text-gray-200 group-hover:text-yellow-200 transition-colors">02</span>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Verifikasi Admin</h4>
                <p class="text-xs text-gray-600 leading-relaxed">Tim pengurus Sosma akan memverifikasi kesesuaian data, jadwal, dan ketersediaan Anda.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center relative group hover:shadow-md transition-all hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i data-lucide="calendar-clock" class="w-7 h-7"></i>
                </div>
                <span class="absolute top-6 right-6 font-poppins font-bold text-2xl text-gray-200 group-hover:text-green-200 transition-colors">03</span>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Penjadwalan</h4>
                <p class="text-xs text-gray-600 leading-relaxed">Admin mengalokasikan volunteer ke rumah belajar sesuai mata pelajaran dan waktu kosong.</p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center relative group hover:shadow-md transition-all hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i data-lucide="book-open" class="w-7 h-7"></i>
                </div>
                <span class="absolute top-6 right-6 font-poppins font-bold text-2xl text-gray-200 group-hover:text-purple-200 transition-colors">04</span>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Mengajar</h4>
                <p class="text-xs text-gray-600 leading-relaxed">Pelaksanaan pengajaran tatap muka di rumah belajar bersama volunteer pendamping lainnya.</p>
            </div>

            <!-- Step 5 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center relative group hover:shadow-md transition-all hover:-translate-y-1">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i data-lucide="file-check" class="w-7 h-7"></i>
                </div>
                <span class="absolute top-6 right-6 font-poppins font-bold text-2xl text-gray-200 group-hover:text-blue-200 transition-colors">05</span>
                <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2">Laporan Kegiatan</h4>
                <p class="text-xs text-gray-600 leading-relaxed">Volunteer mengisi laporan digital singkat mencakup materi, kendala, dan dokumentasi foto.</p>
            </div>
        </div>

        <div class="mt-16">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                <span>Mulai Pengabdian Anda Sekarang</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </div>
</section>

<!-- Dokumentasi Kegiatan -->
<section id="kegiatan" class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-4">
            <i data-lucide="image" class="w-4 h-4"></i>
            <span>Galeri & Dokumentasi</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-bold font-poppins text-gray-900 tracking-tight mb-4">
            Potret Nyata <span class="text-blue-600">Pengabdian Kami</span>
        </h2>
        <p class="text-base text-gray-600 max-w-2xl mx-auto mb-16">
            Senyum antusiasme anak-anak negeri dan semangat juang para relawan pengajar di berbagai sudut Rumah Belajar se-Malang Raya.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($galleries as $gallery)
                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col text-left">
                    <div class="relative overflow-hidden h-64 bg-gray-100">
                        <img src="{{ $gallery->image_path }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <span class="text-xs font-semibold text-white bg-blue-600 px-3 py-1 rounded-full shadow">Malang Mengajar</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-1 justify-between bg-white">
                        <div>
                            <h4 class="font-poppins font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600 transition-colors">{{ $gallery->title }}</h4>
                            <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">{{ $gallery->description }}</p>
                        </div>
                        <div class="flex items-center gap-2 pt-4 mt-4 border-t border-gray-100 text-xs text-gray-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>{{ $gallery->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-500 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                    <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                    <p class="text-base font-medium">Belum ada dokumentasi kegiatan yang diunggah.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="py-24 bg-gray-50/60 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-4">
            <i data-lucide="message-square-quote" class="w-4 h-4"></i>
            <span>Testimoni Program</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-bold font-poppins text-gray-900 tracking-tight mb-4">
            Apa Kata <span class="text-blue-600">Mereka?</span>
        </h2>
        <p class="text-base text-gray-600 max-w-2xl mx-auto mb-16">
            Kisah inspiratif dari para relawan pengajar, pengurus rumah belajar, dan peserta didik binaan Malang Mengajar.
        </p>

        <div class="grid md:grid-cols-3 gap-8 text-left">
            <!-- Card 1 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="flex items-center gap-1 text-yellow-400 mb-6">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed italic mb-6">
                        "Mengajar di Malang Mengajar memberi saya perspektif baru tentang arti bersyukur dan berbagi. Senyum adik-adik saat berhasil menjawab soal matematika adalah bayaran terindah yang tidak ternilai."
                    </p>
                </div>
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Budi" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h5 class="font-poppins font-bold text-gray-900 text-sm leading-snug">Budi Santoso</h5>
                        <p class="text-xs text-blue-600 font-medium">Volunteer Matematika</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="flex items-center gap-1 text-yellow-400 mb-6">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed italic mb-6">
                        "Kehadiran kakak-kakak mahasiswa sangat membantu anak-anak di kampung kami. Mereka jadi lebih semangat belajar, terutama bahasa Inggris yang biasanya dianggap sulit sekarang jadi sangat menyenangkan."
                    </p>
                </div>
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80" alt="Bu Ningsih" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h5 class="font-poppins font-bold text-gray-900 text-sm leading-snug">Bu Ningsih</h5>
                        <p class="text-xs text-blue-600 font-medium">PIC RB Kedungkandang</p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="flex items-center gap-1 text-yellow-400 mb-6">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed italic mb-6">
                        "Aku senang banget kalau hari Sabtu karena ada Kak Budi dan Kak Rahma. Belajarnya seru, banyak tebak-tebakannya dan dapet hadiah buku tulis kalau bisa jawab pertanyaan!"
                    </p>
                </div>
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" alt="Rani" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h5 class="font-poppins font-bold text-gray-900 text-sm leading-snug">Adik Rani</h5>
                        <p class="text-xs text-blue-600 font-medium">Siswa RB Merjosari (Kelas 4 SD)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-[3rem] p-12 sm:p-16 lg:p-20 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-500/20">
            <!-- Decorative Background Glows -->
            <div class="absolute -top-24 -left-24 w-80 h-80 bg-blue-500 rounded-full blur-3xl opacity-50 z-0"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-yellow-400 rounded-full blur-3xl opacity-30 z-0"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto flex flex-col items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-yellow-300 mb-2 border border-white/20 shadow-inner">
                    <i data-lucide="heart-handshake" class="w-8 h-8"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-poppins tracking-tight leading-tight">
                    Mari Berkontribusi Nyata untuk <span class="text-yellow-300">Pendidikan Anak Negeri!</span>
                </h2>
                <p class="text-blue-100 text-base sm:text-lg max-w-2xl leading-relaxed">
                    Jadilah bagian dari perubahan. Luangkan sedikit waktu Anda untuk menginspirasi, mengajar, dan membuka cakrawala masa depan anak-anak di Kota Malang.
                </p>
                <div class="pt-4 flex flex-wrap justify-center gap-4 w-full sm:w-auto">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-poppins font-bold text-base px-8 py-4 rounded-2xl shadow-xl shadow-yellow-500/30 transition-all hover:shadow-2xl hover:-translate-y-0.5">
                        Daftar Sebagai Volunteer
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/30 text-white font-medium text-base px-8 py-4 rounded-2xl backdrop-blur-sm transition-all">
                        Login Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="kontak" class="bg-gray-900 text-white pt-20 pb-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-16 border-b border-gray-800">
            <!-- Brand -->
            <div class="md:col-span-5 flex flex-col items-start gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <span class="font-poppins font-bold text-xl leading-none text-white tracking-tight">Malang Mengajar</span>
                </div>
                <p class="text-sm text-gray-400 max-w-sm leading-relaxed">
                    Platform pengabdian pendidikan berbasis volunteer untuk mengelola kegiatan mengajar, koordinasi relawan, dan monitoring dampak sosial program di Kota Malang.
                </p>
                <!-- Sosmed -->
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-blue-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors shadow">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-blue-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors shadow">
                        <i data-lucide="youtube" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-blue-600 flex items-center justify-center text-gray-300 hover:text-white transition-colors shadow">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- Links -->
            <div class="md:col-span-3 flex flex-col gap-4">
                <h4 class="font-poppins font-bold text-white text-base tracking-wide">Navigasi Link</h4>
                <nav class="flex flex-col gap-3 text-sm text-gray-400 font-medium">
                    <a href="#home" class="hover:text-white transition-colors">Home Utama</a>
                    <a href="#tentang" class="hover:text-white transition-colors">Tentang Program</a>
                    <a href="#alur" class="hover:text-white transition-colors">Alur Pendaftaran</a>
                    <a href="#kegiatan" class="hover:text-white transition-colors">Galeri Dokumentasi</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition-colors">Login System</a>
                </nav>
            </div>

            <!-- Kontak & Alamat -->
            <div class="md:col-span-4 flex flex-col gap-4">
                <h4 class="font-poppins font-bold text-white text-base tracking-wide">Kontak Sekretariat</h4>
                <div class="flex flex-col gap-3 text-sm text-gray-400">
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-blue-500 shrink-0 mt-0.5"></i>
                        <span class="leading-relaxed">Gedung Sekretariat Bersama BEM se-Malang Raya, Jl. Veteran No. 10, Kota Malang, Jawa Timur</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-blue-500 shrink-0"></i>
                        <span>+62 812-3456-7890 (Admin Sosma)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-blue-500 shrink-0"></i>
                        <span>contact@malangmengajar.com</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-12 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 border-t border-gray-800">
            <p>&copy; {{ date('Y') }} Malang Mengajar. All rights reserved.</p>
            <div class="flex items-center gap-6 font-medium">
                <a href="#" class="hover:text-gray-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-400 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
@endsection
