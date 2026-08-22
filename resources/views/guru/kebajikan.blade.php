@extends('components.admin')

@section('title', 'Poin Kebajikan')

@section('content')
    <div class="py-8 space-y-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Poin Kebajikan
            </h1>

            <p class="text-slate-500">
                Berikan poin kebajikan kepada peserta didik.
            </p>
        </div>


        @if (session('success'))
            <div
                class="p-4 bg-emerald-50
                    border border-emerald-200
                    text-emerald-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="p-4 bg-red-50
                    border border-red-200
                    text-red-700 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif


        <section class="bg-white rounded-2xl
                    border border-slate-200
                    shadow-sm p-6">

            <form method="POST" action="{{ route('guru.kebajikan.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @csrf


                <select name="siswa_id" required class="border rounded-xl px-4 py-3">

                    <option value="">
                        Pilih siswa
                    </option>

                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}">

                            {{ $siswa->nama }}

                            —

                            {{ $siswa->kelas?->nama_kelas }}

                        </option>
                    @endforeach

                </select>


                <select name="kebajikan_id" required class="border rounded-xl px-4 py-3">

                    <option value="">
                        Pilih kebajikan
                    </option>

                    @foreach ($kebajikans as $item)
                        <option value="{{ $item->id }}">

                            {{ $item->deskripsi }}
                            (+{{ $item->skor }})
                        </option>
                    @endforeach

                </select>


                <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required
                    class="border rounded-xl px-4 py-3">


                <input type="text" name="keterangan" placeholder="Keterangan (opsional)"
                    class="border rounded-xl px-4 py-3">


                <button type="submit"
                    class="md:col-span-2
                       bg-emerald-600
                       hover:bg-emerald-700
                       text-white rounded-xl py-3">
                    Berikan Poin Kebajikan
                </button>

            </form>

        </section>


        <section
            class="bg-white rounded-2xl
                    border border-slate-200
                    shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>
                            <th class="p-4 text-left">
                                Tanggal
                            </th>

                            <th class="p-4 text-left">
                                Siswa
                            </th>

                            <th class="p-4 text-left">
                                Kebajikan
                            </th>

                            <th class="p-4 text-center">
                                Poin
                            </th>

                            <th class="p-4 text-center">
                                Aksi
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($riwayat as $item)
                            <tr class="border-t">

                                <td class="p-4">
                                    {{ $item->tanggal?->format('d/m/Y') }}
                                </td>


                                <td class="p-4">

                                    <div class="font-medium">
                                        {{ $item->siswa?->user?->nama }}
                                    </div>

                                    <div class="text-xs text-slate-500">
                                        {{ $item->siswa?->kelas?->nama_kelas }}
                                    </div>

                                </td>


                                <td class="p-4">
                                    {{ $item->kebajikan?->deskripsi }}
                                </td>


                                <td class="p-4 text-center">

                                    <span
                                        class="rounded-full
                                         bg-emerald-100
                                         px-3 py-1
                                         font-bold
                                         text-emerald-700">

                                        +{{ $item->skor }}

                                    </span>

                                </td>


                                <td class="p-4 text-center">

                                    <form method="POST" action="{{ route('guru.kebajikan.delete', $item) }}"
                                        onsubmit="return confirm(
                                    'Hapus poin kebajikan ini?'
                                )">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500">
                                    Belum ada poin kebajikan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($riwayat->hasPages())
                <div class="p-4 border-t">
                    {{ $riwayat->links() }}
                </div>
            @endif

        </section>

    </div>
@endsection
