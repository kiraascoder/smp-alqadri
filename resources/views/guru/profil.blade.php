@extends('components.admin')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="bg-gray-100 min-h-screen p-6" x-data="{ openModal: false }">

        <div class="max-w-2xl mx-auto space-y-6">
            <div class="bg-white shadow-md rounded-2xl p-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Profil Guru</h2>

                <div class="flex flex-col items-center mb-6">
                    <img src="{{ Auth::user()->avatar ?? asset('default-avatar.png') }}" alt="Avatar"
                        class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg mb-4">
                    <p class="text-xl font-semibold text-gray-700">{{ $guru->user->name }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span class="font-medium">Email</span>
                        <span>{{ $guru->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Nomor HP</span>
                        <span>{{ $guru->user->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">NIP</span>
                        <span>{{ $guru->nip }}</span>
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button @click="openModal = true"
                        class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2 rounded-xl hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Edit Profil
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openModal" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 transition"
            x-transition.opacity>
            <div @click.away="openModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 p-6 relative"
                x-transition.scale>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Edit Profil</h3>

                <form action="{{ route('guru.edit') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $guru->user->name) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $guru->user->email) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $guru->user->no_hp) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('no_hp')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nisn" class="block text-sm font-medium">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('nip')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 text-sm">
                            Batal
                        </button>

                        <button type="submit"
                            class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
