@extends('components.admin')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="w-full min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6" x-data="{ openModal: false, imagePreview: null }">

        <!-- Header -->
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">Profil Siswa</h1>
            <p class="text-white/80 text-lg">Kelola informasi profil Anda dengan mudah</p>
        </div>

        <div class="max-w-4xl mx-auto">

            <!-- Main Profile Card -->
            <div class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl p-8 border border-white/20">

                <!-- Avatar Section -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                            alt="Avatar"
                            class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg mb-4 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                        <div
                            class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white animate-pulse">
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $siswa->user->name }}</h2>
                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">Siswa
                        Aktif</span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <!-- Email -->
                    <div
                        class="group p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Email</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $siswa->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div
                        class="group p-4 rounded-xl border border-gray-200 hover:border-green-300 hover:shadow-md transition-all duration-300 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Nomor HP</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $siswa->user->no_hp ?? 'Belum diisi' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- NISN -->
                    <div
                        class="group p-4 rounded-xl border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all duration-300 hover:bg-gradient-to-r hover:from-purple-50 hover:to-violet-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">NISN</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $siswa->nisn }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Class -->
                    <div
                        class="group p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:shadow-md transition-all duration-300 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Kelas</p>
                                <p class="font-semibold text-gray-800 text-sm">
                                    {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Score BK Section -->
                <div class="bg-gradient-to-r from-pink-100 to-purple-100 rounded-2xl p-6 mb-8 border border-pink-200">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-full text-2xl font-bold mb-3 animate-pulse shadow-lg">
                            {{ $siswa->score_bk }}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Score BK</h3>
                        <p class="text-sm text-gray-600">Bimbingan Konseling</p>
                    </div>
                </div>

                <!-- Edit Button -->
                <div class="text-center">
                    <button @click="openModal = true"
                        class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openModal" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.away="openModal = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 p-8 relative max-h-[90vh] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-800">Edit Profil</h3>
                        <p class="text-gray-500 mt-1">Perbarui informasi profil Anda</p>
                    </div>
                    <button @click="openModal = false"
                        class="text-gray-400 hover:text-gray-600 transition-colors p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('siswa.edit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload Section -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">Foto Profil</label>

                        <!-- Current Avatar & Preview -->
                        <div class="flex items-center justify-center">
                            <div class="relative">
                                <img :src="imagePreview || '{{ Auth::user()->avatar ?? asset('default-avatar.png') }}'"
                                    alt="Avatar Preview"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500 shadow-lg">
                                <div
                                    class="absolute bottom-0 right-0 w-6 h-6 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- File Input -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-center w-full">
                                <label for="avatar"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400 transition-all duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Maks. 2MB)</p>
                                    </div>
                                    <input type="file" name="avatar" id="avatar" class="hidden"
                                        accept="image/png,image/jpg,image/jpeg"
                                        @change="
                                            const file = $event.target.files[0];
                                            if (file) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    imagePreview = e.target.result;
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        " />
                                </label>
                            </div>
                            @error('avatar')
                                <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $siswa->user->name) }}"
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $siswa->user->email) }}"
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="space-y-2">
                            <label for="no_hp" class="block text-sm font-semibold text-gray-700">Nomor HP</label>
                            <input type="text" name="no_hp" id="no_hp"
                                value="{{ old('no_hp', $siswa->user->no_hp) }}"
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all">
                            @error('no_hp')
                                <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- NISN Field -->
                        <div class="space-y-2">
                            <label for="nisn" class="block text-sm font-semibold text-gray-700">NISN</label>
                            <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                required>
                            @error('nisn')
                                <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Class Selection -->
                    <div class="space-y-2">
                        <label for="kelas_id" class="block text-sm font-semibold text-gray-700">Kelas</label>
                        <div class="relative">
                            <select name="kelas_id" id="kelas_id"
                                class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all appearance-none bg-white"
                                required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('kelas_id')
                            <p class="text-red-500 text-sm flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <button type="button" @click="openModal = false"
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl hover:bg-gray-50 text-gray-700 font-medium transition-all duration-200 hover:border-gray-400">
                            Batal
                        </button>

                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-medium transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center gap-2 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
