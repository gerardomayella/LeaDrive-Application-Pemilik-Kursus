<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('password-forgot');
    }

    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];

        $kursus = Kursus::where('email', $email)->first();
        if (!$kursus) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        $code = random_int(100000, 999999);
        Cache::put('otp:'.$email, [
            'code' => (string)$code,
            'attempts' => 0,
        ], now()->addMinutes(10));

        try {
            Mail::to($email)->send(new OtpMail($code));
        } catch (\Throwable $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Pastikan konfigurasi mail sudah benar.'])->withInput();
        }

        return redirect()->route('password.verify.show')->with([
            'email_prefill' => $email,
            'success' => 'Kode OTP telah dikirim ke email Anda.',
        ]);
    }

    public function showVerify(Request $request)
    {
        return view('password-verify', [
            'email' => session('email_prefill')
        ]);
    }

    public function verifyAndReset(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $validated['email'];
        $otpInput = (string)$validated['otp'];

        $cached = Cache::get('otp:'.$email);
        if (!$cached) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan atau sudah kadaluarsa.'])->withInput();
        }

        // Optional: limit attempts
        $attempts = (int)($cached['attempts'] ?? 0);
        if ($attempts >= 5) {
            Cache::forget('otp:'.$email);
            return back()->withErrors(['otp' => 'Terlalu banyak percobaan. Silakan minta OTP baru.']);
        }

        if ((string)$cached['code'] !== $otpInput) {
            // increment attempts
            Cache::put('otp:'.$email, [
                'code' => $cached['code'],
                'attempts' => $attempts + 1,
            ], now()->addMinutes(10));

            return back()->withErrors(['otp' => 'OTP salah.'])->withInput();
        }

        $kursus = Kursus::where('email', $email)->first();
        if (!$kursus) {
            Cache::forget('otp:'.$email);
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $kursus->password = Hash::make($validated['password']);
        $kursus->save();

        Cache::forget('otp:'.$email);

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}
