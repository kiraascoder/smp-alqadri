@extends('components.admin')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6" x-data="{
        openModal: false,
        imagePreview: null
    }">

        <!-- Header -->
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">Profil Guru</h1>
            <p class="text-white/80 text-lg">Kelola informasi profil Anda dengan mudah</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Main Profile Card -->
            <div class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl p-8 border border-white/20">

                <!-- Avatar Section -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative group">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                            alt="Avatar {{ $guru->user->name }}"
                            class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg mb-4 transition-all duration-300 group-hover:scale-105 group-hover:shadow-xl">
                        <div
                            class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white animate-pulse">
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $guru->user->name }}</h2>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

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
                                <p class="font-semibold text-gray-800 text-sm">{{ $guru->user->email }}</p>
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
                                <p class="font-semibold text-gray-800 text-sm">{{ $guru->user->no_hp ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Button (span full width) -->
                    <div class="md:col-span-2 text-center mt-4">
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

                    <!-- Form -->
                    <form action="{{ route('guru.edit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="md:flex md:items-start gap-6">
                                <!-- Avatar Upload -->
                                <div class="flex flex-col items-center md:items-start space-y-3 md:mr-6 w-full md:w-1/3">
                                    <label class="text-sm font-semibold text-gray-700">Foto Profil</label>
                                    <div class="relative">
                                        <img x-bind:src="imagePreview ? imagePreview :
                                            '{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}'"
                                            alt="Avatar Preview"
                                            class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500 shadow-lg">
                                        <div
                                            class="absolute bottom-0 right-0 w-6 h-6 bg-indigo-500 rounded-full border-2 border-white flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Upload Input -->
                                    <label for="avatar"
                                        class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400 transition-all duration-300 text-center">
                                        <div class="flex flex-col items-center justify-center pt-4 pb-4">
                                            <svg class="w-6 h-6 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-sm text-gray-500">
                                                <span class="font-semibold">Klik untuk upload</span><br>
                                                PNG, JPG (Maks. 2MB)
                                            </p>
                                        </div>
                                        <input type="file" name="avatar" id="avatar" class="hidden"
                                            accept="image/*"
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

                                    @error('avatar')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Form Input Fields -->
                                <div class="w-full md:w-2/3 space-y-6">
                                    <!-- Nama -->
                                    <div class="space-y-2">
                                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama
                                            Lengkap</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $guru->user->name) }}"
                                            class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                            required>
                                        @error('name')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label for="email"
                                            class="block text-sm font-semibold text-gray-700">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $guru->user->email) }}"
                                            class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all"
                                            required>
                                        @error('email')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- No HP -->
                                    <div class="space-y-2">
                                        <label for="no_hp" class="block text-sm font-semibold text-gray-700">Nomor
                                            HP</label>
                                        <input type="text" name="no_hp" id="no_hp"
                                            value="{{ old('no_hp', $guru->user->no_hp) }}"
                                            placeholder="Contoh: 08123456789"
                                            class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-gray-700 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all">
                                        @error('no_hp')
                                            <p class="text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
                            <button type="button" @click="openModal = false"
                                class="px-6 py-3 border-2 border-gray-300 rounded-xl hover:bg-gray-50 text-gray-700 font-medium transition-all duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-medium transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-300 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
