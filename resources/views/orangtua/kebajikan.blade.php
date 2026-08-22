@extends('components.admin')

@section('title', 'Kebajikan Anak')

@section('content')

    <div class="py-8 space-y-6">

        <div>
            <h1 class="text-3xl font-bold">
                Kebajikan Anak
            </h1>

            <p class="text-gray-500">
                Riwayat poin kebajikan anak Anda.
            </p>
        </div>


        @foreach ($siswa as $anak)
            <div class="bg-white rounded-2xl shadow p-6">

                <div class="flex justify-between">

                    <div>
                        <h2 class="font-bold text-lg">
                            {{ $anak->nama }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ $anak->kelas?->nama_kelas }}
                        </p>
                    </div>


                    <div class="text-green-600 font-bold text-xl">

                        +{{ $anak->riwayatKebajikan->sum('poin') }}

                        Poin

                    </div>

                </div>


                <div class="mt-5 space-y-3">


                    @forelse($anak->riwayatKebajikan as $item)
                        <div class="border rounded-xl p-4">

                            <div class="font-semibold">
                                {{ $item->kebajikan?->nama }}
                            </div>


                            <div class="text-sm text-gray-500">

                                {{ $item->tanggal?->format('d/m/Y') }}

                            </div>


                            <div class="text-green-600 font-bold">

                                +{{ $item->poin }}

                            </div>


                        </div>


                    @empty

                        <p class="text-gray-500">
                            Belum ada kebajikan.
                        </p>
                    @endforelse


                </div>

            </div>
        @endforeach


    </div>

@endsection
