@extends('components.admin')

@section('title', 'Profil')

@section('content')

    <div class="py-8 space-y-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Profil Orang Tua
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola informasi akun dan keamanan akun Anda.
            </p>
        </div>


        @if (session('success'))
            <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        @if ($errors->any())
            <div class="p-4 rounded-xl border border-red-200 bg-red-50 text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="space-y-6">

            {{-- Profile Summary --}}
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="p-6 md:p-8">

                    <div class="flex flex-col md:flex-row md:items-center gap-6">

                        <div
                            class="w-24 h-24 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-4xl font-bold shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="flex-1 min-w-0">

                            <p class="text-sm font-medium text-blue-600 mb-1">
                                Profil Orang Tua
                            </p>

                            <h2 class="text-2xl font-bold text-slate-900 truncate">
                                {{ $user->name }}
                            </h2>

                            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-x-6 gap-y-2 mt-3 text-sm text-slate-500">

                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>

                                    <span class="break-all">
                                        {{ $user->email }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 011.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 11.28V15a2 2 0 01-2 2h-1C9.716 17 3 10.284 3 2V5z" />
                                    </svg>

                                    <span>
                                        {{ $user->no_hp ?: 'Nomor belum diisi' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>

                                    <span>
                                        {{ $user->jenis_kelamin ?: 'Jenis kelamin belum diisi' }}
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div
                            class="hidden lg:flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 text-slate-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.65 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                    </div>

                </div>

            </section>


            {{-- Forms --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                {{-- Data Pribadi --}}
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">
                                    Data Pribadi
                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Perbarui informasi akun Anda.
                                </p>
                            </div>

                        </div>
                    </div>


                    <form method="POST" action="{{ route('ortu.profil.update') }}" class="p-6 space-y-5">

                        @csrf
                        @method('PUT')


                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Lengkap
                            </label>

                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                required
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                            @error('name')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                                Email
                            </label>

                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                required
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                            @error('email')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-2">
                                Nomor WhatsApp
                            </label>

                            <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                required placeholder="Contoh: 08123456789"
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                            <p class="text-xs text-slate-500 mt-2">
                                Nomor ini digunakan untuk menerima OTP saat login.
                            </p>

                            @error('no_hp')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 mb-2">
                                Jenis Kelamin
                            </label>

                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">
                                    Pilih jenis kelamin
                                </option>

                                <option value="Laki-Laki" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-Laki')>
                                    Laki-Laki
                                </option>

                                <option value="Perempuan" @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan')>
                                    Perempuan
                                </option>
                            </select>

                            @error('jenis_kelamin')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="flex justify-end pt-4 border-t border-slate-100">

                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-semibold transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>

                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </section>


                {{-- Keamanan Akun --}}
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">
                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">
                                    Keamanan Akun
                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Perbarui password akun Anda.
                                </p>
                            </div>

                        </div>
                    </div>


                    <form method="POST" action="{{ route('ortu.password.update') }}" class="p-6 space-y-5">

                        @csrf
                        @method('PUT')


                        {{-- Password Baru --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                                Password Baru
                            </label>

                            <div class="relative">

                                <input type="password" id="password" name="password" required minlength="8"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full border border-slate-300 rounded-xl pl-4 pr-12 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                <button type="button"
                                    class="toggle-password absolute inset-y-0 right-0 flex items-center justify-center w-12 text-slate-400 hover:text-slate-600 transition"
                                    data-target="password" aria-label="Tampilkan password">
                                    <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <svg class="eye-closed hidden w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.584 10.587a2 2 0 002.829 2.828" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.88 4.24A9.77 9.77 0 0112 4c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.092 5.13M6.61 6.61A10.05 10.05 0 002.458 11C3.732 15.057 7.523 18 12 18c1.05 0 2.062-.17 3-.48" />
                                    </svg>
                                </button>

                            </div>

                            @error('password')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                                Konfirmasi Password Baru
                            </label>

                            <div class="relative">

                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    minlength="8" placeholder="Ulangi password baru"
                                    class="w-full border border-slate-300 rounded-xl pl-4 pr-12 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                                <button type="button"
                                    class="toggle-password absolute inset-y-0 right-0 flex items-center justify-center w-12 text-slate-400 hover:text-slate-600 transition"
                                    data-target="password_confirmation" aria-label="Tampilkan password">
                                    <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268 2.943-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <svg class="eye-closed hidden w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.584 10.587a2 2 0 002.829 2.828" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.88 4.24A9.77 9.77 0 0112 4c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.092 5.13M6.61 6.61A10.05 10.05 0 002.458 11C3.732 15.057 7.523 18 12 18c1.05 0 2.062-.17 3-.48" />
                                    </svg>
                                </button>

                            </div>
                        </div>


                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">

                            <div class="flex gap-3">

                                <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 110-20 10 10 0 010 20z" />
                                </svg>

                                <p class="text-sm text-blue-700 leading-relaxed">
                                    Login orang tua saat ini menggunakan OTP WhatsApp.
                                    Perubahan password tidak mengubah nomor WhatsApp yang digunakan untuk login.
                                </p>

                            </div>

                        </div>


                        <div class="flex justify-end pt-4 border-t border-slate-100">

                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl text-sm font-semibold transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>

                                Ubah Password
                            </button>

                        </div>

                    </form>

                </section>

            </div>

        </div>

    </div>
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const eyeOpen = this.querySelector('.eye-open');
                const eyeClosed = this.querySelector('.eye-closed');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                    this.setAttribute('aria-label', 'Sembunyikan password');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                    this.setAttribute('aria-label', 'Tampilkan password');
                }
            });
        });
    </script>
@endsection
