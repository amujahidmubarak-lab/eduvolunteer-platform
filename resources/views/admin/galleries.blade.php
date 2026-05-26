@extends('layouts.dashboard')

@section('title', 'Galeri Dokumentasi - Malang Mengajar')
@section('dashboard_title', 'Manajemen Galeri Landing Page')

@section('dashboard_content')
<div x-data="{ showModal: false, editModal: false, activeGal: null }" class="space-y-8">
    <!-- Header & Action Button -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Dokumentasi Kegiatan Pengabdian</h3>
            <p class="text-sm text-gray-600">Unggah dan kelola foto dokumentasi kegiatan yang akan ditampilkan pada halaman utama (Landing Page) Malang Mengajar.</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-poppins font-bold text-xs py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2 shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Tambah Dokumentasi</span>
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
                    <i data-lucide="image-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Tambah Galeri Dokumentasi</h3>
                    <p class="text-xs text-gray-500">Pilih foto, judul, dan deskripsi singkat kegiatan.</p>
                </div>
            </div>

            <form action="{{ url('/admin/galleries') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <!-- Judul Galeri -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumentasi <span class="text-red-500">*</span></label>
                        <input id="title" name="title" type="text" required
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                               placeholder="Contoh: Pendampingan Belajar Matematika SD Merjosari...">
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label for="image_file" class="block text-sm font-medium text-gray-700 mb-1">Upload File Foto (Opsional/Maks 5MB)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl bg-gray-50/50 hover:bg-white transition-all">
                            <div class="space-y-1 text-center">
                                <i data-lucide="upload-cloud" class="mx-auto w-12 h-12 text-gray-400"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Pilih file gambar</span>
                                        <input id="image_file" name="image_file" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- URL Gambar -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Atau Gunakan Link URL Gambar Unsplash</label>
                        <input id="image_url" name="image_url" type="url"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                               placeholder="https://images.unsplash.com/photo-...">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan (Opsional)</label>
                        <textarea id="description" name="description" rows="3"
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                                  placeholder="Ceritakan keseruan dan interaksi dalam kegiatan ini..."></textarea>
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" checked class="text-blue-600 rounded focus:ring-blue-500 w-5 h-5">
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Tampilkan di Landing Page</span>
                                <span class="text-xs text-gray-500">Centang agar foto muncul di grid galeri halaman utama.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <span>Simpan Galeri</span>
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
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Edit Galeri Dokumentasi</h3>
                    <p class="text-xs text-gray-500">Perbarui judul, deskripsi, dan status tayang.</p>
                </div>
            </div>

            <form :action="'{{ url('/admin/galleries') }}/' + activeGal?.id" method="POST" class="space-y-6">
                @csrf @method('PUT')

                <div class="space-y-4">
                    <!-- Judul Galeri -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumentasi <span class="text-red-500">*</span></label>
                        <input name="title" type="text" required :value="activeGal?.title"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan (Opsional)</label>
                        <textarea name="description" rows="3" :value="activeGal?.description"
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 bg-gray-50/50 hover:bg-white cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" :checked="activeGal?.is_active" class="text-blue-600 rounded focus:ring-blue-500 w-5 h-5">
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Tampilkan di Landing Page</span>
                                <span class="text-xs text-gray-500">Centang agar foto muncul di grid galeri halaman utama.</span>
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

    <!-- Galleries Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group">
                <div>
                    <!-- Image -->
                    <div class="relative h-56 bg-gray-100 overflow-hidden">
                        <img src="{{ $gallery->image_path }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border backdrop-blur-md {{ $gallery->is_active ? 'bg-green-500/80 border-green-400 text-white' : 'bg-gray-500/80 border-gray-400 text-white' }}">
                                {{ $gallery->is_active ? 'Aktif Landing' : 'Disembunyikan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-2 bg-white">
                        <h4 class="font-poppins font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">
                            {{ $gallery->title }}
                        </h4>
                        <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">{{ $gallery->description }}</p>
                        <div class="flex items-center gap-1 text-[11px] text-gray-400 pt-2">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            <span>Diunggah {{ $gallery->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-6 pt-0 flex items-center justify-end gap-2 bg-white">
                    <button @click="activeGal = {{ json_encode($gallery) }}; editModal = true" title="Edit" class="p-2.5 bg-yellow-50 hover:bg-yellow-600 text-yellow-600 hover:text-white rounded-xl transition-colors border border-yellow-200">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>

                    <form action="{{ url('/admin/galleries/' . $gallery->id) }}" method="POST" class="shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus" class="p-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-colors border border-red-200">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="image-off" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Galeri Dokumentasi</p>
                <p class="text-xs text-gray-400 mt-1">Gunakan tombol 'Tambah Dokumentasi' di atas untuk mengunggah foto kegiatan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

