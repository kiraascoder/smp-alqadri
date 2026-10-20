<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class OrangTuaAuthController extends Controller
{
    private const OTP_EXPIRE_MINUTES = 5;
    private const OTP_MAX_ATTEMPTS = 5;
    private const OTP_RESEND_SECONDS = 60;
    private const OTP_MAX_SENDS_PER_HOUR = 5;

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.orang-tua-login');
    }

    public function sendOtp(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        $data = $request->validate([
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        $phone = $this->normalizePhone($data['no_hp']);

        if (! $phone) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Nomor WhatsApp tidak valid. Gunakan nomor Indonesia, contoh 08xxxxxxxxxx.',
                ]);
        }

        $rateLimitKey = 'orang-tua-otp:' . $phone;

        if (RateLimiter::tooManyAttempts($rateLimitKey, self::OTP_MAX_SENDS_PER_HOUR)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Terlalu banyak permintaan OTP. Silakan coba lagi dalam ' . $this->formatWaitTime($seconds) . '.',
                ]);
        }

        $otpSession = session('orang_tua_otp');
        $lastSentAt = (int) ($otpSession['last_sent_at'] ?? 0);

        if ($lastSentAt > 0) {
            $remaining = self::OTP_RESEND_SECONDS - (now()->timestamp - $lastSentAt);

            if ($remaining > 0) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'no_hp' => 'Kode OTP baru dapat diminta dalam ' . $remaining . ' detik.',
                    ]);
            }
        }

        $users = User::query()
            ->where('role', 'orang_tua')
            ->whereNotNull('no_hp')
            ->get();

        $matches = $users
            ->filter(fn (User $user) => $this->normalizePhone($user->no_hp) === $phone)
            ->values();

        if ($matches->count() > 1) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Nomor WhatsApp ini terhubung ke lebih dari satu akun orang tua. Silakan hubungi admin sekolah.',
                ]);
        }

        $user = $matches->first();

        if (! $user) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Nomor WhatsApp belum terdaftar sebagai akun orang tua. Silakan hubungi admin sekolah.',
                ]);
        }

        if (! OrangTua::where('user_id', $user->id)->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Data orang tua belum terhubung dengan profil sekolah. Silakan hubungi admin sekolah.',
                ]);
        }

        $token = config('services.fonnte.token');

        if (blank($token)) {
            Log::error('Fonnte token belum dikonfigurasi untuk login OTP orang tua.');

            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'Layanan OTP WhatsApp belum tersedia. Silakan hubungi admin sekolah.',
                ]);
        }

        $otp = (string) random_int(100000, 999999);

        try {
            $response = Http::timeout(15)
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->asForm()
                ->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => "SMP Al-Qadri Islamic School\n\nKode OTP login Anda: {$otp}\n\nKode berlaku selama " . self::OTP_EXPIRE_MINUTES . " menit. Jangan berikan kode ini kepada siapa pun.",
                    'countryCode' => '0',
                ]);
        } catch (Throwable $e) {
            Log::error('Gagal mengirim OTP WhatsApp orang tua.', [
                'user_id' => $user->id,
                'exception' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'OTP gagal dikirim. Silakan coba beberapa saat lagi.',
                ]);
        }

        $result = $response->json();

        if (! $response->successful() || ! ($result['status'] ?? false)) {
            Log::error('Fonnte menolak pengiriman OTP orang tua.', [
                'user_id' => $user->id,
                'http_status' => $response->status(),
                'reason' => $result['reason'] ?? $result['detail'] ?? 'unknown',
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'no_hp' => 'OTP gagal dikirim. Pastikan layanan WhatsApp sekolah aktif, lalu coba lagi.',
                ]);
        }

        RateLimiter::hit($rateLimitKey, 3600);

        session()->put('orang_tua_otp', [
            'user_id' => $user->id,
            'phone' => $phone,
            'hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRE_MINUTES)->timestamp,
            'attempts' => 0,
            'last_sent_at' => now()->timestamp,
        ]);

        return redirect()
            ->route('orang-tua.otp')
            ->with('success', 'Kode OTP telah dikirim ke WhatsApp ' . $this->maskPhone($phone) . '.');
    }

    public function showOtp()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        $otpSession = session('orang_tua_otp');

        if (! $otpSession || empty($otpSession['hash']) || empty($otpSession['user_id'])) {
            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'no_hp' => 'Silakan masukkan nomor WhatsApp terlebih dahulu.',
                ]);
        }

        $remaining = (int) ($otpSession['expires_at'] ?? 0) - now()->timestamp;

        if ($remaining <= 0) {
            session()->forget('orang_tua_otp');

            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'no_hp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.',
                ]);
        }

        return view('auth.orang-tua-otp', [
            'phone' => $otpSession['phone'],
            'remaining' => $remaining,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        $data = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $otpSession = session('orang_tua_otp');

        if (! $otpSession || empty($otpSession['hash']) || empty($otpSession['user_id'])) {
            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'otp' => 'Sesi OTP tidak ditemukan. Silakan minta kode baru.',
                ]);
        }

        $remaining = (int) ($otpSession['expires_at'] ?? 0) - now()->timestamp;

        if ($remaining <= 0) {
            session()->forget('orang_tua_otp');

            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.',
                ]);
        }

        $attempts = (int) ($otpSession['attempts'] ?? 0);

        if ($attempts >= self::OTP_MAX_ATTEMPTS) {
            session()->forget('orang_tua_otp');

            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'otp' => 'Batas percobaan OTP telah habis. Silakan minta kode baru.',
                ]);
        }

        if (! Hash::check($data['otp'], $otpSession['hash'])) {
            $attempts++;
            session()->put('orang_tua_otp.attempts', $attempts);

            if ($attempts >= self::OTP_MAX_ATTEMPTS) {
                session()->forget('orang_tua_otp');

                return redirect()
                    ->route('orang-tua.login')
                    ->withErrors([
                        'otp' => 'Kode OTP salah 5 kali. Silakan minta kode baru.',
                    ]);
            }

            return back()->withErrors([
                'otp' => 'Kode OTP salah. Sisa percobaan: ' . (self::OTP_MAX_ATTEMPTS - $attempts) . '.',
            ]);
        }

        $user = User::query()
            ->whereKey($otpSession['user_id'])
            ->where('role', 'orang_tua')
            ->first();

        if (! $user) {
            session()->forget('orang_tua_otp');

            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'otp' => 'Akun orang tua tidak ditemukan atau sudah tidak aktif.',
                ]);
        }

        if (! OrangTua::where('user_id', $user->id)->exists()) {
            session()->forget('orang_tua_otp');

            return redirect()
                ->route('orang-tua.login')
                ->withErrors([
                    'otp' => 'Profil orang tua belum tersedia. Silakan hubungi admin sekolah.',
                ]);
        }

        $phone = $otpSession['phone'];

        if ($user->no_hp !== $phone) {
            $user->no_hp = $phone;
            $user->save();
        }

        RateLimiter::clear('orang-tua-otp:' . $phone);
        session()->forget('orang_tua_otp');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('orangtua.dashboard');
    }

    private function redirectAuthenticatedUser()
    {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'orang_tua' => redirect()->route('orangtua.dashboard'),
            default => redirect()->route('home'),
        };
    }

    private function normalizePhone(?string $value): ?string
    {
        $phone = preg_replace('/\D+/', '', (string) $value) ?? '';

        if ($phone === '') {
            return null;
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        if (! preg_match('/^628\d{8,12}$/', $phone)) {
            return null;
        }

        return $phone;
    }

    private function maskPhone(string $phone): string
    {
        return '+62 ' . substr($phone, 2, 3) . ' •••• ' . substr($phone, -2);
    }

    private function formatWaitTime(int $seconds): string
    {
        if ($seconds >= 60) {
            return ceil($seconds / 60) . ' menit';
        }

        return $seconds . ' detik';
    }
}