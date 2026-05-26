@extends('layouts.app')

@section('title', 'Login - Malang Mengajar')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-blue-50/50 via-white to-white">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 relative">
        <!-- Back button -->
        <a href="{{ url('/') }}" class="absolute top-6 left-6 text-gray-400 hover:text-gray-600 transition-colors flex items-center gap-1 text-xs font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>

        <div class="text-center pt-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 mx-auto flex items-center justify-center text-white shadow-lg shadow-blue-500/30 mb-4 group-hover:scale-105 transition-transform">
                <i data-lucide="book-open" class="w-8 h-8"></i>
            </div>
            <h2 class="text-3xl font-bold font-poppins text-gray-900 tracking-tight">Masuk Akun</h2>
            <p class="mt-2 text-sm text-gray-600">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">Daftar Volunteer</a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="contoh@mahasiswa.ac.id">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-all" 
                           placeholder="nama@email.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    </div>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                           class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 focus:bg-white transition-all" 
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" x-bind:disabled="loading" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed">
                <template x-if="loading">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="loading ? 'Memproses...' : 'Masuk ke Akun'">Masuk ke Akun</span>
            </button>
        </form>
    </div>
</div>
@endsection
