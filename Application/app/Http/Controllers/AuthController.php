<?php

namespace App\Http\Controllers;

use App\Models\Kursus;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Cek koneksi ke Supabase Storage di awal
        $supabase = new SupabaseService();
        $health = $supabase->checkConnection();
        if (!(isset($health['ok']) && $health['ok'] === true)) {
            // Tampilkan pesan error di halaman login
            $message = 'Koneksi ke Supabase Storage bermasalah: ' . ($health['error'] ?? 'unknown error');
            session()->flash('error', $message);
        } else {
            session()->flash('success', 'Terhubung ke Supabase Storage.');
        }

        $ok = isset($health['ok']) && $health['ok'] === true;
        return view('login', [
            'supabase_ok' => $ok,
            'supabase_error' => $ok ? null : ($health['error'] ?? 'unknown error'),
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Cek koneksi sebelum proses login
        $supabase = new SupabaseService();
        $health = $supabase->checkConnection();
        if (!(isset($health['ok']) && $health['ok'] === true)) {
            return back()->withErrors([
                'email_or_phone' => 'Tidak dapat terhubung ke penyimpanan (Supabase): ' . ($health['error'] ?? 'unknown error') . '. Silakan coba lagi atau hubungi admin.',
            ])->withInput();
        }

        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->input('email_or_phone');

        // Login hanya menggunakan email pada tabel kursus
        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                'email_or_phone' => ['Gunakan email terdaftar untuk masuk.'],
            ]);
        }

        $kursus = Kursus::where('email', $identifier)->first();

        if (!$kursus) {
            throw ValidationException::withMessages([
                'email_or_phone' => ['Email atau password salah.'],
            ]);
        }

        $password = (string) $request->input('password');

        $passwordMatches = false;
        $needsRehash = false;
        if (!empty($kursus->password)) {
            $stored = (string) $kursus->password;
            $isHashed = str_starts_with($stored, '$');

            if ($isHashed) {
                // Verifikasi hash modern (bcrypt/argon) secara otomatis
                $passwordMatches = password_verify($password, $stored);

                if ($passwordMatches) {
                    $isBcrypt = preg_match('/^\$2[aby]\$/', $stored) === 1;
                    // Rehash jika bukan bcrypt, atau bcrypt tapi butuh rehash
                    if (!$isBcrypt || password_needs_rehash($stored, PASSWORD_BCRYPT)) {
                        $needsRehash = true;
                    }
                }
            } else {
                // Legacy plaintext
                $passwordMatches = hash_equals($stored, $password);
                if ($passwordMatches) {
                    $needsRehash = true;
                }
            }
        }

        if (!$passwordMatches) {
            throw ValidationException::withMessages([
                'email_or_phone' => ['Email atau password salah.'],
            ]);
        }

        if (!(bool) $kursus->status) {
            return back()->withErrors([
                'email_or_phone' => 'Akun kursus Anda belum disetujui admin.',
            ]);
        }

        // Upgrade hash jika diperlukan (normalisasi ke konfigurasi default, mis. bcrypt)
        if ($needsRehash) {
            $kursus->password = Hash::make($password);
            $kursus->save();
        }

        // Simpan data kursus di session untuk kebutuhan UI
        $request->session()->put([
            'kursus_id' => $kursus->id_kursus,
            'kursus_nama' => $kursus->nama_kursus ?? 'Pemilik Kursus',
            'kursus_foto' => $kursus->foto_profil,
        ]);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['kursus_id', 'kursus_nama', 'kursus_foto']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

