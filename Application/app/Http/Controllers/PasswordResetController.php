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
            $emailObj = (new MailtrapEmail())
                ->from(new Address('hello@demomailtrap.co', 'LeaDrive'))
                ->to(new Address($email))
                ->subject('Kode OTP Reset Password')
                ->category('Password Reset')
                ->text("Kode OTP Anda adalah: {$code}");

            $response = MailtrapClient::initSendingEmails(
                apiKey: '91371192f3243005143421361cf66841'
            )->send($emailObj);

            // Optional: Log response or handle specific errors if needed
            // var_dump(ResponseHelper::toArray($response)); 

        } catch (\Throwable $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Mailtrap Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan coba lagi nanti.'])->withInput();
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
