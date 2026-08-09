@extends('components.admin')
@section('title', 'Data Guru')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Data Guru</h1>
            <p class="text-slate-500 mt-1">Kelola akun guru yang dapat membuat dan melihat skorsing miliknya sendiri.</p>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 p-4 text-emerald-700">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 p-4 text-red-700">{{ $errors->first() }}</div>
        @endif

        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Tambah Guru</h2>
            <form method="POST" action="{{ route('admin-guru.tambah') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input name="name" value="{{ old('name') }}" required class="border rounded-xl px-4 py-3"
                    placeholder="Nama guru">
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="border rounded-xl px-4 py-3" placeholder="Email">
                <input name="no_hp" value="{{ old('no_hp') }}" class="border rounded-xl px-4 py-3" placeholder="No. HP">
                <select name="jenis_kelamin" class="border rounded-xl px-4 py-3">
                    <option value="">Jenis kelamin</option>
                    <option value="Laki-Laki" @selected(old('jenis_kelamin') === 'Laki-Laki')>Laki-Laki</option>
                    <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
                </select>
                <input type="password" name="password" required class="border rounded-xl px-4 py-3"
                    placeholder="Password minimal 8 karakter">
                <input type="password" name="password_confirmation" required class="border rounded-xl px-4 py-3"
                    placeholder="Konfirmasi password">
                <button class="md:col-span-2 rounded-xl bg-blue-700 py-3 font-semibold text-white hover:bg-blue-800">Tambah
                    Guru</button>
            </form>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-4 text-left">Nama</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">No. HP</th>
                            <th class="p-4 text-left">Jenis Kelamin</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                            <tr class="border-t border-slate-100">
                                <td class="p-4 font-medium">{{ $guru->user?->name ?? '-' }}</td>
                                <td class="p-4">{{ $guru->user?->email ?? '-' }}</td>
                                <td class="p-4">{{ $guru->user?->no_hp ?? '-' }}</td>
                                <td class="p-4">{{ $guru->user?->jenis_kelamin ?? '-' }}</td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2" x-data="{ edit: false }">
                                        <button type="button" @click="edit=true" class="text-blue-700">Edit</button>
                                        <form method="POST" action="{{ route('admin.guru.delete', $guru->id) }}"
                                            onsubmit="return confirm('Hapus guru ini?')">@csrf @method('DELETE')<button
                                                class="text-red-600">Hapus</button></form>
                                        <div x-show="edit" x-cloak
                                            class="fixed inset-0 z-[70] flex items-center justify-center bg-black/40 p-4">
                                            <div @click.outside="edit=false"
                                                class="w-full max-w-lg rounded-2xl bg-white p-6 text-left shadow-xl">
                                                <div class="flex justify-between items-center mb-5">
                                                    <h3 class="font-semibold text-lg">Edit Guru</h3><button
                                                        @click="edit=false" type="button">✕</button>
                                                </div>
                                                <form method="POST" action="{{ route('admin-guru.edit', $guru->id) }}"
                                                    class="space-y-4">@csrf @method('PUT')
                                                    <input name="name" value="{{ $guru->user?->name }}" required
                                                        class="w-full border rounded-xl px-4 py-3">
                                                    <input type="email" name="email" value="{{ $guru->user?->email }}"
                                                        required class="w-full border rounded-xl px-4 py-3">
                                                    <input name="no_hp" value="{{ $guru->user?->no_hp }}"
                                                        class="w-full border rounded-xl px-4 py-3">
                                                    <select name="jenis_kelamin" class="w-full border rounded-xl px-4 py-3">
                                                        <option value="">Jenis kelamin</option>
                                                        <option value="Laki-Laki" @selected($guru->user?->jenis_kelamin === 'Laki-Laki')>Laki-Laki
                                                        </option>
                                                        <option value="Perempuan" @selected($guru->user?->jenis_kelamin === 'Perempuan')>Perempuan
                                                        </option>
                                                    </select>
                                                    <button class="w-full bg-blue-700 text-white rounded-xl py-3">Simpan
                                                        Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">Belum ada guru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $gurus->links() }}</div>
        </section>
    </div>
@endsection
