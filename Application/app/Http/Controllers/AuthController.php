<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $this->getCredentials($request->email_or_phone, $request->password);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is pending
            if ($user->status === 'pending') {
                Auth::logout();
                return back()->withErrors([
                    'email_or_phone' => 'Akun Anda masih menunggu persetujuan admin.',
                ]);
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->withErrors([
                    'email_or_phone' => 'Akun Anda telah ditolak. Silakan hubungi admin.',
                ]);
            }

            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email_or_phone' => ['Email/nomor HP atau password salah.'],
        ]);
    }

    /**
     * Get credentials for authentication
     */
    private function getCredentials($emailOrPhone, $password)
    {
        $field = filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'nomor_hp';
        
        return [
            $field => $emailOrPhone,
            'password' => $password,
        ];
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

