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
                <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Profil Siswa</h2>

                <div class="flex flex-col items-center mb-6">
                    <img src="{{ Auth::user()->avatar ?? asset('default-avatar.png') }}" alt="Avatar"
                        class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 shadow-lg mb-4">
                    <p class="text-xl font-semibold text-gray-700">{{ $siswa->user->name }}</p>
                </div>

                <div class="grid grid-cols-1 gap-4 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span class="font-medium">Email</span>
                        <span>{{ $siswa->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Nomor HP</span>
                        <span>{{ $siswa->user->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">NISN</span>
                        <span>{{ $siswa->nisn }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Kelas</span>
                        <span>{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Score BK</span>
                        <span>{{ $siswa->score_bk }}</span>
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

                <form action="{{ route('siswa.edit') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $siswa->user->name) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siswa->user->email) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $siswa->user->no_hp) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('no_hp')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nisn" class="block text-sm font-medium">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                        @error('nisn')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-medium">Kelas</label>
                        <select name="kelas_id" id="kelas_id"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
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
