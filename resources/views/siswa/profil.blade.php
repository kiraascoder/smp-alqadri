<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6" x-data="{ openModal: false }">
    <a href="{{ route('siswa.dashboard') }}">Dashboard</a>
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h2 class="text-2xl font-semibold mb-6 border-b border-gray-300 pb-2">Profil Siswa</h2>

        <div class="flex flex-col items-center mb-6">
            <img src="{{ Auth::user()->avatar ?? asset('default-avatar.png') }}" alt="Avatar"
                class="w-32 h-32 rounded-full object-cover mb-4 border-2 border-indigo-500" />
            <p class="text-lg font-semibold text-gray-700">{{ $siswa->user->name }}</p>
        </div>

        <div class="space-y-4 text-gray-700 mb-6">
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="font-medium">Email:</span>
                <span>{{ $siswa->user->email }}</span>
            </div>

            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="font-medium">Nomor HP:</span>
                <span>{{ $siswa->user->no_hp ?? '-' }}</span>
            </div>

            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="font-medium">NISN:</span>
                <span>{{ $siswa->nisn }}</span>
            </div>

            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="font-medium">Kelas:</span>
                <span>{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium">Score BK:</span>
                <span>{{ $siswa->score_bk }}</span>
            </div>
        </div>

        <button @click="openModal = true"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
            Edit Profil
        </button>
    </div>

    <!-- Modal -->
    <div x-show="openModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-transition.opacity>
        <div @click.away="openModal = false" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4"
            x-transition.scale>
            <h3 class="text-xl font-semibold mb-4">Edit Profil</h3>

            <form action="{{ route('siswa.edit') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block font-medium mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $siswa->user->name) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $siswa->user->email) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="no_hp" class="block font-medium mb-1">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $siswa->user->no_hp) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                    @error('no_hp')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nisn" class="block font-medium mb-1">NISN</label>
                    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        required />
                    @error('nisn')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kelas_id" class="block font-medium mb-1">Kelas</label>
                    <select name="kelas_id" id="kelas_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
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
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="openModal = false"
                        class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        Batal
                    </button>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
