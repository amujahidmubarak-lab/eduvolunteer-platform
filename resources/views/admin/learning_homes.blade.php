@extends('layouts.dashboard')

@section('title', 'Rumah Belajar - Malang Mengajar')
@section('dashboard_title', 'Manajemen Rumah Belajar')

@section('dashboard_content')
<div x-data="{ showModal: false, editModal: false, activeHome: null }" class="space-y-8">
    <!-- Header & Action Button -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-poppins font-bold text-gray-900 text-xl mb-1">Daftar Rumah Belajar Mitra</h3>
            <p class="text-sm text-gray-600">Kelola lokasi pengabdian, PIC, kontak, serta estimasi jumlah siswa binaan di setiap rumah belajar.</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-poppins font-bold text-xs py-3.5 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2 shrink-0">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Tambah Rumah Belajar</span>
        </button>
    </div>

    <!-- Modal Form Tambah -->
    <div x-show="showModal" x-transition.opacity x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div @click.away="showModal = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-xl w-full p-8 sm:p-10 my-8 space-y-6 relative">
            <button @click="showModal = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="home" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Tambah Rumah Belajar Baru</h3>
                    <p class="text-xs text-gray-500">Lengkapi data lokasi dan pengelola rumah belajar.</p>
                </div>
            </div>

            <form action="{{ url('/admin/learning-homes') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <!-- Nama Rumah Belajar -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Rumah Belajar <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" required
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                               placeholder="Contoh: Rumah Belajar Merjosari">
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3" required
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-50 bg-gray-50/50 focus:bg-white transition-all placeholder:text-gray-400" 
                                  placeholder="Jl. Joyo Raharjo No. 15, Merjosari, Lowokwaru..."></textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <!-- Nama PIC -->
                        <div>
                            <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-1">Nama PIC / Pengelola <span class="text-red-500">*</span></label>
                            <input id="pic_name" name="pic_name" type="text" required
                                   class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                                   placeholder="Bu Ningsih">
                        </div>

                        <!-- Nomor Kontak -->
                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontak PIC <span class="text-red-500">*</span></label>
                            <input id="contact_number" name="contact_number" type="text" required
                                   class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all" 
                                   placeholder="081234567890">
                        </div>
                    </div>

                    <!-- Jumlah Siswa -->
                    <div>
                        <label for="student_count" class="block text-sm font-medium text-gray-700 mb-1">Estimasi Jumlah Siswa Binaan <span class="text-red-500">*</span></label>
                        <input id="student_count" name="student_count" type="number" min="0" required value="20"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
                        <span>Simpan Rumah Belajar</span>
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
        <div @click.away="editModal = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-xl w-full p-8 sm:p-10 my-8 space-y-6 relative">
            <button @click="editModal = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-poppins font-bold text-gray-900 text-xl">Edit Data Rumah Belajar</h3>
                    <p class="text-xs text-gray-500">Perbarui informasi lokasi dan kontak pengelola.</p>
                </div>
            </div>

            <form :action="'{{ url('/admin/learning-homes') }}/' + activeHome?.id" method="POST" class="space-y-6">
                @csrf @method('PUT')

                <div class="space-y-4">
                    <!-- Nama Rumah Belajar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Rumah Belajar <span class="text-red-500">*</span></label>
                        <input name="name" type="text" required :value="activeHome?.name"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" required :value="activeHome?.address"
                                  class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-50 bg-gray-50/50 focus:bg-white transition-all"></textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <!-- Nama PIC -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC / Pengelola <span class="text-red-500">*</span></label>
                            <input name="pic_name" type="text" required :value="activeHome?.pic_name"
                                   class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                        </div>

                        <!-- Nomor Kontak -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontak PIC <span class="text-red-500">*</span></label>
                            <input name="contact_number" type="text" required :value="activeHome?.contact_number"
                                   class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
                        </div>
                    </div>

                    <!-- Jumlah Siswa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Jumlah Siswa Binaan <span class="text-red-500">*</span></label>
                        <input name="student_count" type="number" min="0" required :value="activeHome?.student_count"
                               class="block w-full p-4 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50/50 focus:bg-white transition-all">
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

    <!-- Learning Homes Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($learningHomes as $home)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between gap-6 hover:shadow-md transition-all group">
                <div class="space-y-4">
                    <!-- Top Info -->
                    <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold font-poppins shrink-0">
                                <i data-lucide="home" class="w-6 h-6"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-poppins font-bold text-gray-900 text-base truncate group-hover:text-blue-600 transition-colors">
                                    {{ $home->name }}
                               </h4>
                                <p class="text-xs text-blue-600 font-semibold">{{ $home->student_count }} Siswa Binaan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address & Contact Details -->
                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-start gap-2 text-gray-600">
                            <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 shrink-0 mt-0.5"></i>
                            <span class="leading-relaxed"><strong class="text-gray-700">Alamat:</strong> {{ $home->address }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i data-lucide="user" class="w-4 h-4 text-gray-400 shrink-0"></i>
                            <span><strong class="text-gray-700">PIC:</strong> {{ $home->pic_name }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i data-lucide="phone" class="w-4 h-4 text-gray-400 shrink-0"></i>
                            <span><strong class="text-gray-700">Kontak:</strong> {{ $home->contact_number }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 pt-2 border-t border-gray-100">
                            <i data-lucide="calendar-check" class="w-4 h-4 text-blue-500 shrink-0"></i>
                            <span><strong class="text-gray-700">Total Kegiatan:</strong> {{ $home->teaching_schedules_count }} Kali</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button @click="activeHome = {{ json_encode($home) }}; editModal = true" title="Edit Rumah Belajar" class="p-2.5 bg-yellow-50 hover:bg-yellow-600 text-yellow-600 hover:text-white rounded-xl transition-colors border border-yellow-200">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>

                    <form action="{{ url('/admin/learning-homes/' . $home->id) }}" method="POST" class="shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rumah belajar ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus Rumah Belajar" class="p-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-colors border border-red-200">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
                <i data-lucide="home" class="w-16 h-16 mx-auto mb-3 text-gray-400"></i>
                <p class="text-lg font-poppins font-bold text-gray-700">Belum Ada Rumah Belajar Mitra</p>
                <p class="text-xs text-gray-400 mt-1">Gunakan tombol 'Tambah Rumah Belajar' di atas untuk mendaftarkan mitra baru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection


