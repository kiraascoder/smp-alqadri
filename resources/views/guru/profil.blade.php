@extends('components.admin')

@section('title', 'Profil Guru')

@section('content')

    <div class="py-8 space-y-6" x-data="{ openModal: false, imagePreview: null }">


        {{-- HEADER --}}

        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Profil Guru
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola informasi akun dan profil Anda.
            </p>

        </div>



        {{-- PROFILE CARD --}}

        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">


            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">


                {{-- AVATAR --}}

                <div class="text-center">

                    <div class="relative">

                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                            class="w-32 h-32 rounded-full object-cover
border-4 border-blue-600 shadow">


                        <div class="absolute bottom-2 right-2
w-5 h-5 bg-green-500 rounded-full
border-2 border-white">
                        </div>


                    </div>


                    <h2 class="mt-4 text-xl font-bold text-slate-900">
                        {{ $guru->user->name }}
                    </h2>


                    <p class="text-sm text-slate-500">
                        Guru SMP Al-Qadri
                    </p>


                </div>




                {{-- DATA --}}

                <div class="flex-1 grid md:grid-cols-2 gap-4 w-full">


                    <div class="border rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Email
                        </p>

                        <p class="font-semibold text-slate-800 break-all">
                            {{ $guru->user->email }}
                        </p>

                    </div>



                    <div class="border rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Nomor HP
                        </p>

                        <p class="font-semibold text-slate-800">

                            {{ $guru->user->no_hp ?? '-' }}

                        </p>

                    </div>



                </div>


            </div>



            <div class="mt-6 flex justify-end">


                <button @click="openModal=true"
                    class="px-6 py-3 rounded-xl
bg-blue-700 hover:bg-blue-800
text-white font-semibold">

                    Edit Profil

                </button>


            </div>


        </section>





        {{-- MODAL EDIT --}}

        <div x-show="openModal" x-cloak class="fixed inset-0 z-50
bg-black/40 flex items-center justify-center p-4">


            <div @click.outside="openModal=false" class="bg-white w-full max-w-2xl
rounded-2xl shadow-xl p-6">


                <div class="flex justify-between mb-6">


                    <div>

                        <h2 class="text-xl font-bold">
                            Edit Profil
                        </h2>

                        <p class="text-sm text-slate-500">
                            Perbarui data akun Anda.
                        </p>


                    </div>


                    <button @click="openModal=false" class="text-slate-400">

                        ✕


                    </button>


                </div>




                <form method="POST" action="{{ route('guru.edit') }}" enctype="multipart/form-data">


                    @csrf
                    @method('PUT')



                    <div class="space-y-4">


                        <div>

                            <label class="text-sm font-semibold">
                                Nama Lengkap
                            </label>


                            <input name="name" value="{{ old('name', $guru->user->name) }}"
                                class="mt-1 w-full border rounded-xl px-4 py-3">


                        </div>



                        <div>

                            <label class="text-sm font-semibold">
                                Email
                            </label>


                            <input type="email" name="email" value="{{ old('email', $guru->user->email) }}"
                                class="mt-1 w-full border rounded-xl px-4 py-3">


                        </div>



                        <div>

                            <label class="text-sm font-semibold">
                                Nomor HP
                            </label>


                            <input name="no_hp" value="{{ old('no_hp', $guru->user->no_hp) }}"
                                class="mt-1 w-full border rounded-xl px-4 py-3">


                        </div>



                        <div>

                            <label class="text-sm font-semibold">
                                Foto Profil
                            </label>


                            <input type="file" name="avatar" class="mt-1 w-full border rounded-xl px-4 py-3">


                        </div>



                    </div>



                    <div class="flex justify-end gap-3 mt-6">


                        <button type="button" @click="openModal=false" class="px-5 py-3 border rounded-xl">

                            Batal

                        </button>



                        <button class="px-6 py-3
bg-blue-700 text-white
rounded-xl">

                            Simpan

                        </button>


                    </div>


                </form>


            </div>


        </div>



    </div>


@endsection
