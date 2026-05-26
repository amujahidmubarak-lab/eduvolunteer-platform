<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Malang Mengajar - Platform Pengabdian Pendidikan')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js & Lucide Icons -->
    <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@0.460.0"></script>
    
    <!-- Vite -->
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
            color: #1F2937;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col selection:bg-blue-500 selection:text-white">

    <!-- Toast Notifications -->
    @if(session('success') || session('error') || $errors->any())
        <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-md w-full px-4 pointer-events-none">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                     class="pointer-events-auto bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-lg flex items-start gap-3">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-500 shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-green-800">Berhasil!</p>
                        <p class="text-xs text-green-600 mt-0.5">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-400 hover:text-green-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
                     class="pointer-events-auto bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-lg flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-500 shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-800">Gagal!</p>
                        <p class="text-xs text-red-600 mt-0.5">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" x-transition
                     class="pointer-events-auto bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-lg flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-500 shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-800">Terdapat Kesalahan Input</p>
                        <ul class="text-xs text-red-600 mt-1 list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
        @yield('content')
    </main>

    <!-- Init Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
