@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex bg-gray-50/50">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden backdrop-blur-sm"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
           class="fixed top-0 left-0 bottom-0 z-50 w-72 bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 shadow-xl lg:shadow-none lg:static lg:z-auto">
        
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-poppins font-bold text-lg leading-none text-gray-900 tracking-tight group-hover:text-blue-600 transition-colors">Malang Mengajar</span>
                    <span class="text-[10px] text-blue-600 font-semibold uppercase tracking-wider mt-0.5">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Volunteer Portal' }}
                    </span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-xl text-gray-400 hover:bg-gray-100">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            @if(auth()->user()->role === 'admin')
                <!-- Admin Links -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard Admin</span>
                </a>
                <a href="{{ route('admin.volunteers') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/volunteers*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Daftar Volunteer</span>
                </a>
                <a href="{{ route('admin.schedules') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/schedules*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="calendar-days" class="w-5 h-5"></i>
                    <span>Jadwal Mengajar</span>
                </a>
                <a href="{{ route('admin.learning-homes') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/learning-homes*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    <span>Rumah Belajar</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/reports*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="file-check-2" class="w-5 h-5"></i>
                    <span>Laporan Kegiatan</span>
                </a>
                <a href="{{ route('admin.announcements') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/announcements*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span>Pengumuman</span>
                </a>
                <a href="{{ route('admin.galleries') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/galleries*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="image" class="w-5 h-5"></i>
                    <span>Galeri Dokumentasi</span>
                </a>
                <a href="{{ route('admin.activity-logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('admin/activity-logs*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span>Catatan Aktivitas</span>
                </a>
            @else
                <!-- Volunteer Links -->
                <a href="{{ route('volunteer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('volunteer/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('volunteer.schedules') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('volunteer/schedules*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    <span>Jadwal Saya</span>
                </a>
                <a href="{{ route('volunteer.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('volunteer/reports*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span>Laporan Mengajar</span>
                </a>
                <a href="{{ route('volunteer.announcements') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('volunteer/announcements*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span>Pengumuman</span>
                </a>
                <a href="{{ route('volunteer.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-medium transition-all {{ request()->is('volunteer/profile*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>Profil Saya</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar Footer / User Info -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50 m-4 rounded-3xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold font-poppins shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold font-poppins text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-2 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 shrink-0 sticky top-0 z-30 backdrop-blur-md bg-white/90">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h1 class="text-xl sm:text-2xl font-bold font-poppins text-gray-900 tracking-tight">
                    @yield('dashboard_title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <!-- Status Badge for Volunteer -->
                @if(auth()->user()->role === 'volunteer')
                    <div class="hidden sm:inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold border 
                        @if(auth()->user()->status === 'approved') bg-green-50 border-green-200 text-green-700 
                        @elseif(auth()->user()->status === 'pending') bg-yellow-50 border-yellow-200 text-yellow-700 
                        @else bg-red-50 border-red-200 text-red-700 @endif">
                        <span class="w-2 h-2 rounded-full @if(auth()->user()->status === 'approved') bg-green-500 @elseif(auth()->user()->status === 'pending') bg-yellow-500 @else bg-red-500 @endif animate-pulse"></span>
                        <span class="uppercase tracking-wider">Status: {{ auth()->user()->status }}</span>
                    </div>
                @endif

                <!-- Notification Dropdown -->
                <div x-data="{ openNotif: false }" class="relative">
                    <button @click="openNotif = !openNotif" @click.outside="openNotif = false" class="relative p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        @if($unreadNotifications->count() > 0)
                            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="openNotif" x-transition.origin.top.right x-cloak 
                         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden z-50">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <h3 class="font-bold text-gray-900 font-poppins text-sm">Notifikasi</h3>
                            @if($unreadNotifications->count() > 0)
                                <form action="{{ url('/notifications/mark-read') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Tandai semua dibaca</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse($unreadNotifications->take(5) as $notif)
                                <div class="p-4 border-b border-gray-50 hover:bg-blue-50/50 transition-colors flex gap-3">
                                    <div class="mt-0.5">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800 font-medium leading-snug">{{ $notif->data['title'] ?? 'Pemberitahuan Baru' }}</p>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $notif->data['message'] ?? '' }}</p>
                                        <span class="text-[10px] text-gray-400 font-medium block mt-1.5">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <i data-lucide="bell-off" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                                    <p class="text-sm font-medium">Belum ada notifikasi baru</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="p-3 bg-gray-50 text-center border-t border-gray-100">
                            <a href="#" class="text-xs font-semibold text-gray-500 hover:text-gray-900">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('landing') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-semibold text-gray-600 hover:text-blue-600 bg-gray-100 hover:bg-blue-50 px-4 py-2 rounded-xl transition-colors">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>Lihat Website</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline-flex">
                    @csrf
                    <!-- Desktop Logout Button -->
                    <button type="submit" class="hidden sm:inline-flex items-center gap-2 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100/80 px-4 py-2 rounded-xl transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Keluar</span>
                    </button>
                    <!-- Mobile Logout Button -->
                    <button type="submit" title="Logout" class="sm:hidden p-2 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-6 lg:p-10 max-w-7xl w-full mx-auto">
            @yield('dashboard_content')
        </main>
    </div>
</div>
@endsection

