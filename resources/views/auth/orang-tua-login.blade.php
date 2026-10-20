<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Orang Tua - SMP Al-Qadri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-emerald-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <div class="p-8 sm:p-10">

                <div class="text-center">

                    <div
                        class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-2xl bg-slate-50 ring-1 ring-slate-200">

                        <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri"
                            class="h-20 w-20 object-contain">

                    </div>

                    <p class="text-sm font-semibold text-emerald-600">
                        SMP AL-QADRI ISLAMIC SCHOOL
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                        Login Orang Tua
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Masuk menggunakan nomor WhatsApp yang telah terdaftar pada data sekolah.
                    </p>

                </div>


                {{-- Error --}}

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                        <div class="font-semibold">
                            Login tidak dapat dilanjutkan
                        </div>

                        <div class="mt-1">
                            {{ $errors->first() }}
                        </div>

                    </div>
                @endif


                {{-- Success --}}

                @if (session('success'))
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">

                        <div class="font-semibold">
                            Berhasil
                        </div>

                        <div class="mt-1">
                            {{ session('success') }}
                        </div>

                    </div>
                @endif


                {{-- Form Login --}}

                <form method="POST" action="{{ route('orang-tua.otp.send') }}" class="mt-7 space-y-5">
                    @csrf

                    {{-- Nomor WhatsApp --}}

                    <div>

                        <label for="no_hp" class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor WhatsApp
                        </label>


                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-slate-500">
                                +62
                            </div>


                            <input id="no_hp" type="tel" name="no_hp" value="{{ old('no_hp') }}"
                                inputmode="tel" autocomplete="tel" required autofocus placeholder="812xxxxxxxx"
                                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3.5 pl-14 text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">

                        </div>


                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            Contoh: 081234567890 atau 6281234567890
                        </p>

                    </div>


                    {{-- Button --}}

                    <button type="submit"
                        class="w-full rounded-2xl bg-emerald-600 py-3.5 font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                        Kirim Kode OTP WhatsApp
                    </button>

                </form>


                {{-- Informasi --}}

                <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-4">

                    <div class="flex gap-3">

                        <div
                            class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-600">
                            i
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-blue-900">
                                Login tanpa password
                            </p>

                            <p class="mt-1 text-xs leading-5 text-blue-700">
                                Sistem akan mengirimkan kode OTP 6 digit ke nomor WhatsApp yang terdaftar pada data
                                sekolah.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Kembali --}}

                <div class="mt-7 text-center">

                    <a href="{{ route('home') }}"
                        class="text-sm font-semibold text-slate-500 transition hover:text-slate-800">
                        ← Kembali ke halaman utama
                    </a>

                </div>

            </div>

        </div>


        <p class="mt-5 text-center text-xs text-white/60">
            © {{ date('Y') }} SMP Al-Qadri Islamic School
        </p>

    </div>

</body>

</html>
