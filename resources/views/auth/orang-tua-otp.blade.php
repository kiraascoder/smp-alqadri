<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SMP Al-Qadri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-950 via-blue-950 to-emerald-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8 sm:p-10">
                <div class="text-center">
                    <div
                        class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-2xl bg-emerald-50 ring-1 ring-emerald-100">
                        <img src="{{ asset('logo-baru.png') }}" alt="Logo SMP Al-Qadri"
                            class="h-20 w-20 object-contain">
                    </div>

                    <p class="text-sm font-semibold text-emerald-600">VERIFIKASI LOGIN</p>
                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Masukkan Kode OTP</h1>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Kode 6 digit telah dikirim melalui WhatsApp ke
                        <span class="font-semibold text-slate-700">{{ $phone }}</span>.
                    </p>
                </div>

                @if (session('success'))
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('orang-tua.otp.send') }}" class="mt-7 space-y-5" id="otpForm">
                    @csrf

                    <div>
                        <label for="otp" class="mb-2 block text-center text-sm font-semibold text-slate-700">
                            Kode OTP
                        </label>

                        <input id="otp" type="text" name="otp" inputmode="numeric"
                            autocomplete="one-time-code" maxlength="6" pattern="[0-9]{6}" required autofocus
                            class="w-full rounded-2xl border border-slate-300 px-4 py-4 text-center text-3xl font-bold tracking-[0.45em] text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                            placeholder="••••••">
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-slate-500">Kode berlaku selama 5 menit.</p>
                        <p id="countdown" class="mt-1 text-sm font-semibold text-emerald-600"></p>
                    </div>

                    <button id="verifyButton" type="submit"
                        class="w-full rounded-2xl bg-emerald-600 py-3.5 font-semibold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                        Verifikasi & Masuk
                    </button>
                </form>

                <div class="mt-6 border-t border-slate-200 pt-6">
                    <form method="POST" action="{{ route('orang-tua.login.send-otp') }}">
                        @csrf
                        <input type="hidden" name="no_hp" value="{{ $phone }}">

                        <button type="submit"
                            class="w-full rounded-2xl border border-slate-300 bg-white py-3 font-semibold text-slate-700 transition hover:bg-slate-50">
                            Kirim Ulang OTP
                        </button>
                    </form>

                    <a href="{{ route('orang-tua.login') }}"
                        class="mt-4 block text-center text-sm font-semibold text-slate-500 transition hover:text-slate-800">
                        ← Ganti nomor WhatsApp
                    </a>
                </div>

                <div class="mt-6 rounded-2xl border border-amber-100 bg-amber-50 p-4 text-xs leading-5 text-amber-800">
                    Jangan berikan kode OTP kepada siapa pun. Kode hanya digunakan untuk masuk ke akun orang tua.
                </div>
            </div>
        </div>

        <p class="mt-5 text-center text-xs text-white/60">
            © {{ date('Y') }} SMP Al-Qadri Islamic School
        </p>
    </div>

    <script>
        const otpInput = document.getElementById('otp');
        const otpForm = document.getElementById('otpForm');
        const verifyButton = document.getElementById('verifyButton');
        const countdown = document.getElementById('countdown');

        let remaining = {{ $remaining }};

        otpInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });

        function updateCountdown() {
            if (remaining <= 0) {
                countdown.textContent = 'Kode OTP sudah kedaluwarsa.';
                countdown.classList.remove('text-emerald-600');
                countdown.classList.add('text-red-600');
                verifyButton.disabled = true;
                verifyButton.classList.add('cursor-not-allowed', 'opacity-50');
                return;
            }

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;
            countdown.textContent = `Kedaluwarsa dalam ${minutes}:${String(seconds).padStart(2, '0')}`;
            remaining--;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        otpForm.addEventListener('submit', function(event) {
            if (otpInput.value.length !== 6) {
                event.preventDefault();
                otpInput.focus();
            }
        });
    </script>
</body>

</html>
