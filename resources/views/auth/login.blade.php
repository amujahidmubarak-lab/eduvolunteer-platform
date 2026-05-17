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
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                               placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="text-gray-600 font-medium">Ingat Saya</span>
                </label>
                <a href="#" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">Lupa Password?</a>
            </div>

            <div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                    <span>Masuk Dashboard</span>
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
