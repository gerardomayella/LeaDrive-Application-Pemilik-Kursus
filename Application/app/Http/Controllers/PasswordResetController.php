<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kursus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

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
            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\PasswordResetOtp($code));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Error: ' . $e->getMessage()])->withInput();
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

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
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

        // OTP Valid, store in session to allow password reset
        session([
            'otp_verified_email' => $email,
            'otp_verified_code' => $otpInput // Optional, just to double check
        ]);

        return redirect()->route('password.reset.show');
    }

    public function showResetForm()
    {
        if (!session('otp_verified_email')) {
            return redirect()->route('password.verify.show')->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('password-reset');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('otp_verified_email');
        if (!$email) {
            return redirect()->route('password.verify.show')->withErrors(['email' => 'Sesi habis. Silakan verifikasi ulang.']);
        }

        $kursus = Kursus::where('email', $email)->first();
        if (!$kursus) {
            return redirect()->route('password.forgot.show')->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $kursus->password = Hash::make($validated['password']);
        $kursus->save();

        // Clear OTP and Session
        Cache::forget('otp:'.$email);
        session()->forget(['otp_verified_email', 'otp_verified_code', 'email_prefill']);

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}
