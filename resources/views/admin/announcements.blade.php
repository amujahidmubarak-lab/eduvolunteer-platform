@extends('layouts.dashboard')

@section('title', 'Pengumuman - Malang Mengajar')
@section('dashboard_title', 'Manajemen Pengumuman')

@section('dashboard_content')
<div x-data="{ showModal: false, editModal: false, activeAnn: null }" class="space-y-8">
    <!-- Header & Action Button -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Pusat Informasi & Pengumuman Sosma</h3>
            <p class="text-sm text-gray-600">Buat dan kelola pengumuman resmi yang akan disiarkan ke dashboard seluruh volunteer.</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-poppins font-bold text-xs py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2 shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Buat Pengumuman Baru</span>
        </button>
    </div>

    <!-- Modal Form Tambah -->
    <div x-show="showModal" x-transition.opacity x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div @click.away="showModal = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-2xl w-full p-8 sm:p-10 my-8 space-y-6 relative">
            <button @click="showModal = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="bell-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Buat Pengumuman Baru</h3>
                    <p class="text-xs text-gray-500">Tulis informasi penting untuk seluruh relawan pengajar.</p>
                </div>
            </div>

            <form action="{{ url('/admin/announcements') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <!-- Judul Pengumuman -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                        <input id="title" name="title" type="text" required
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                               placeholder="Contoh: Rapat Koordinasi Kurikulum SD...">
                    </div>

                    <!-- Isi Pengumuman -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                        <textarea id="content" name="content" rows="6" required
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                                  placeholder="Tuliskan detail pengumuman secara lengkap di sini..."></textarea>
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" checked class="text-blue-600 rounded focus:ring-blue-500 w-5 h-5">
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Langsung Tayangkan</span>
                                <span class="text-xs text-gray-500">Pengumuman akan langsung terlihat di dashboard volunteer.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <span>Simpan Pengumuman</span>
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </button>
                    <button type="button" @click="showModal = false" class="px-8 py-4 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-2xl transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Edit -->
    <div x-show="editModal" x-transition.opacity x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div @click.away="editModal = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-2xl w-full p-8 sm:p-10 my-8 space-y-6 relative">
            <button @click="editModal = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Edit Pengumuman</h3>
                    <p class="text-xs text-gray-500">Perbarui informasi pengumuman sosma.</p>
                </div>
            </div>

            <form :action="'{{ url('/admin/announcements') }}/' + activeAnn?.id" method="POST" class="space-y-6">
                @csrf @method('PUT')

                <div class="space-y-4">
                    <!-- Judul Pengumuman -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                        <input name="title" type="text" required :value="activeAnn?.title"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Isi Pengumuman -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="6" required :value="activeAnn?.content"
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" :checked="activeAnn?.is_active" class="text-blue-600 rounded focus:ring-blue-500 w-5 h-5">
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Status Tayang</span>
                                <span class="text-xs text-gray-500">Centang untuk menayangkan di dashboard volunteer.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-yellow-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <span>Simpan Perubahan</span>
                        <i data-lucide="check" class="w-5 h-5"></i>
                    </button>
                    <button type="button" @click="editModal = false" class="px-8 py-4 border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-2xl transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Announcements Grid -->
    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4 hover:shadow-md transition-shadow group">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $announcement->is_active ? 'bg-green-50 border-green-200 text-green-700' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                                {{ $announcement->is_active ? 'Aktif Tayang' : 'Disembunyikan' }}
                            </span>
                            <span class="text-xs text-gray-500 font-medium">{{ $announcement->created_at->translatedFormat('l, d F Y, H:i') }} WIB</span>
                        </div>
                        <h4 class="font-poppins font-bold text-gray-900 text-xl group-hover:text-blue-600 transition-colors">
                            {{ $announcement->title }}
                        </h4>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 shrink-0">
                        <button @click="activeAnn = {{ json_encode($announcement) }}; editModal = true" title="Edit" class="p-2.5 bg-yellow-50 hover:bg-yellow-600 text-yellow-600 hover:text-white rounded-xl transition-colors border border-yellow-200">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>

                        <form action="{{ url('/admin/announcements/' . $announcement->id) }}" method="POST" class="shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus" class="p-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-colors border border-red-200">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="prose max-w-none text-sm text-gray-700 leading-relaxed space-y-2 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
            </div>
        @empty
            <div class="py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="bell-off" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Pengumuman</p>
                <p class="text-xs text-gray-400 mt-1">Gunakan tombol 'Buat Pengumuman Baru' di atas untuk menyiarkan informasi.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection


