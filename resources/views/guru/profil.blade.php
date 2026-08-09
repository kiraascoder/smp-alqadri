@extends('components.admin')

@section('title', 'Profil Guru')

@section('content')
@php
    $user = $guru?->user ?? auth()->user();
@endphp

<div class="py-8 space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-900">Profil Guru</h1>
        <p class="mt-1 text-slate-500">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Profil</h2>
            <p class="text-sm text-slate-500">Perbarui nama, email, nomor telepon, dan foto profil.</p>
        </div>

        <form method="POST" action="{{ route('guru.edit') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="h-24 w-24 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 shrink-0">
                    @if ($user?->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto profil" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-3xl font-bold text-slate-400">
                            {{ strtoupper(substr($user?->name ?? 'G', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <label for="avatar" class="block text-sm font-medium text-slate-700">Foto Profil</label>
                    <input id="avatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp"
                        class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:font-medium file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-slate-700">Nama</label>
                    <input id="name" name="name" value="{{ old('name', $user?->name) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user?->email) }}" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block mb-2 text-sm font-medium text-slate-700">Nomor HP</label>
                    <input id="no_hp" name="no_hp" value="{{ old('no_hp', $user?->no_hp) }}" placeholder="08xxxxxxxxxx"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Role</label>
                    <div class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-600">
                        Guru
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-xl bg-blue-700 px-6 py-3 font-medium text-white hover:bg-blue-800">
                    Simpan Profil
                </button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Keamanan Akun</h2>
            <p class="text-sm text-slate-500">Gunakan password yang kuat dan berbeda dari password lama.</p>
        </div>

        @if (session('success_password'))
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                {{ session('success_password') }}
            </div>
        @endif

        <form method="POST" action="{{ route('guru.password.update') }}" class="max-w-2xl space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block mb-2 text-sm font-medium text-slate-700">Password Saat Ini</label>
                <input id="current_password" type="password" name="current_password" required autocomplete="current-password"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-slate-700">Password Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-slate-700">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="rounded-xl bg-blue-700 px-6 py-3 font-medium text-white hover:bg-blue-800">
                    Ganti Password
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
