@extends('components.admin')
@section('title', 'Orang Tua')
@section('content')
    <div class="py-8 space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Data Orang Tua</h1>
            <p class="text-gray-500">Satu akun orang tua dapat mengawasi beberapa siswa.</p>
        </div>
        @if (session('success'))
            <div class="p-4 bg-green-50 text-green-700 rounded-xl">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-50 text-red-700 rounded-xl">{{ $errors->first() }}</div>
        @endif
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="font-semibold text-lg mb-4">Tambah Orang Tua</h2>
            <form method="POST" action="{{ route('admin.orang.register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input name="name" required class="border rounded-xl px-4 py-3" placeholder="Nama orang tua"><input
                    type="email" name="email" required class="border rounded-xl px-4 py-3" placeholder="Email">
                <input name="no_hp" class="border rounded-xl px-4 py-3" placeholder="No. HP"><select name="jenis_kelamin"
                    class="border rounded-xl px-4 py-3">
                    <option value="">Jenis kelamin</option>
                    <option>Laki-Laki</option>
                    <option>Perempuan</option>
                </select>
                <input type="password" name="password" required class="border rounded-xl px-4 py-3"
                    placeholder="Password minimal 8 karakter"><input type="password" name="password_confirmation" required
                    class="border rounded-xl px-4 py-3" placeholder="Konfirmasi password">
                <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Tautkan anak
                        (opsional)</label><select name="anak[]" multiple
                        class="w-full border rounded-xl px-4 py-3 min-h-36">
                        @foreach ($siswaList as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nama }} — {{ $siswa->kelas?->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Gunakan Ctrl/Command untuk memilih beberapa anak.</p>
                </div>
                <button class="md:col-span-2 bg-blue-700 text-white rounded-xl py-3 font-semibold">Buat Akun Orang
                    Tua</button>
            </form>
        </div>
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left">Nama</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">No HP</th>
                            <th class="p-4 text-left">Anak</th>
                            <th class="p-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ortu as $item)
                            <tr class="border-t">
                                <td class="p-4 font-medium">{{ $item->user?->name }}</td>
                                <td class="p-4">{{ $item->user?->email }}</td>
                                <td class="p-4">{{ $item->user?->no_hp ?? '-' }}</td>
                                <td class="p-4">
                                    @forelse($item->siswa as $anak)
                                        <span
                                        class="inline-block bg-blue-50 text-blue-700 rounded-full px-3 py-1 mr-1 mb-1">{{ $anak->nama }}</span>@empty
                                        -
                                    @endforelse
                                </td>
                                <td class="p-4 text-center">
                                    <form method="POST" action="{{ route('admin.orang.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus akun orang tua ini?')">@csrf
                                        @method('DELETE')<button class="text-red-600">Hapus</button></form>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">Belum ada orang tua.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $ortu->links() }}</div>
        </div>
    </div>
@endsection
