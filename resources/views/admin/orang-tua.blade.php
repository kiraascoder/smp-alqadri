@extends('components.admin')

@section('title', 'Orang Tua')

@section('content')

    <div class="py-8 space-y-6" x-data="{}">


        {{-- HEADER --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Data Orang Tua
            </h1>

            <p class="text-slate-500 mt-1">
                Satu akun orang tua dapat mengawasi beberapa siswa.
            </p>

        </div>




        {{-- ALERT --}}
        @if (session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100">

                {{ session('success') }}

            </div>
        @endif



        @if ($errors->any())
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-100">

                {{ $errors->first() }}

            </div>
        @endif






        {{-- TAMBAH ORANG TUA --}}
        <section class="
bg-white
rounded-2xl
border border-slate-200
shadow-sm
p-6">


            <div class="mb-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Tambah Orang Tua
                </h2>


                <p class="text-sm text-slate-500">
                    Buat akun orang tua dan hubungkan dengan siswa.
                </p>

            </div>




            <form method="POST" action="{{ route('admin.orang.register') }}"
                class="
grid
grid-cols-1
md:grid-cols-2
gap-4">


                @csrf



                {{-- Nama --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">

                        Nama Orang Tua

                    </label>


                    <input name="name" required placeholder="Nama orang tua"
                        class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3
focus:ring-2
focus:ring-blue-500">

                </div>





                {{-- Email --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">

                        Email

                    </label>


                    <input type="email" name="email" required placeholder="Email"
                        class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3">

                </div>





                {{-- HP --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">

                        No. HP

                    </label>


                    <input name="no_hp" placeholder="Nomor HP"
                        class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3">

                </div>





                {{-- Jenis Kelamin --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">

                        Jenis Kelamin

                    </label>


                    <select name="jenis_kelamin" class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3">


                        <option value="">
                            Jenis kelamin
                        </option>


                        <option value="Laki-Laki">
                            Laki-Laki
                        </option>


                        <option value="Perempuan">
                            Perempuan
                        </option>


                    </select>

                </div>






                {{-- PASSWORD --}}
                <div x-data="{ show: false }">


                    <label class="text-sm font-medium text-slate-700">

                        Password

                    </label>


                    <div class="relative">


                        <input :name="'password'" : type="show ? 'text':'password'" type="password" name="password"
                            required placeholder="Password minimal 8 karakter"
                            class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3
pr-12">



                        <button type="button" @click="show=!show"
                            class="
absolute
right-3
top-1/2
-translate-y-1/2
text-slate-500">


                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />


                            </svg>



                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.222-3.592M6.223 6.223A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.043 4.922M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3l7 7M3 3l18 18" />


                            </svg>


                        </button>


                    </div>


                </div>






                {{-- CONFIRM PASSWORD --}}
                <div x-data="{ show: false }">


                    <label class="text-sm font-medium text-slate-700">

                        Konfirmasi Password

                    </label>


                    <div class="relative">


                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                            placeholder="Ulangi password"
                            class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3
pr-12">



                        <button type="button" @click="show=!show"
                            class="
absolute
right-3
top-1/2
-translate-y-1/2
text-slate-500">


                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />


                            </svg>



                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">


                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.222-3.592M6.223 6.223A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.043 4.922M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3l7 7M3 3l18 18" />


                            </svg>


                        </button>


                    </div>


                </div>







                {{-- ANAK --}}
                <div class="md:col-span-2">


                    <label class="text-sm font-medium text-slate-700">

                        Tautkan Anak

                    </label>


                    <select name="anak[]" multiple
                        class="
mt-1
w-full
border border-slate-300
rounded-xl
px-4
py-3
min-h-40">


                        @foreach ($siswaList as $siswa)
                            <option value="{{ $siswa->id }}">

                                {{ $siswa->nama }}
                                -
                                {{ $siswa->kelas?->nama_kelas }}

                            </option>
                        @endforeach


                    </select>


                    <p class="text-xs text-slate-500 mt-2">

                        Gunakan Ctrl/Command untuk memilih beberapa anak.

                    </p>


                </div>





                <button
                    class="
md:col-span-2
bg-blue-700
hover:bg-blue-800
text-white
rounded-xl
py-3
font-semibold
transition">


                    Buat Akun Orang Tua


                </button>




            </form>



        </section>







        {{-- TABLE --}}
        <section class="
bg-white
rounded-2xl
border border-slate-200
shadow-sm
overflow-hidden">


            <div class="p-6 border-b">

                <h2 class="text-lg font-semibold">

                    Daftar Orang Tua

                </h2>


                <p class="text-sm text-slate-500">

                    Data akun orang tua yang terdaftar.

                </p>

            </div>





            <div class="overflow-x-auto">


                <table class="w-full text-sm">


                    <thead class="bg-slate-50">

                        <tr>


                            <th class="p-4 text-left">
                                Nama
                            </th>


                            <th class="p-4 text-left">
                                Email
                            </th>


                            <th class="p-4 text-left">
                                No HP
                            </th>


                            <th class="p-4 text-left">
                                Anak
                            </th>


                            <th class="p-4 text-center">
                                Aksi
                            </th>


                        </tr>


                    </thead>




                    <tbody>


                        @forelse($ortu as $item)


                            <tr class="border-t hover:bg-slate-50">


                                <td class="p-4 font-semibold">

                                    {{ $item->user?->name }}

                                </td>



                                <td class="p-4">

                                    {{ $item->user?->email }}

                                </td>



                                <td class="p-4">

                                    {{ $item->user?->no_hp ?? '-' }}

                                </td>




                                <td class="p-4">


                                    @forelse($item->siswa as $anak)
                                        <span
                                            class="
inline-flex
bg-blue-50
text-blue-700
rounded-full
px-3
py-1
mr-1
mb-1">


                                            {{ $anak->nama }}


                                        </span>


                                    @empty

                                        -
                                    @endforelse


                                </td>




                                <td class="p-4 text-center">


                                    <form method="POST" action="{{ route('admin.orang.delete', $item->id) }}"
                                        onsubmit="return confirm('Hapus akun orang tua ini?')">


                                        @csrf

                                        @method('DELETE')


                                        <button class="
text-red-600
hover:text-red-800
font-medium">


                                            Hapus


                                        </button>


                                    </form>


                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td colspan="5" class="p-10 text-center text-slate-500">

                                    Belum ada orang tua.

                                </td>

                            </tr>


                        @endforelse



                    </tbody>


                </table>


            </div>




            <div class="p-4">

                {{ $ortu->links() }}

            </div>



        </section>



    </div>

@endsection
