<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\DokumenKursus;
use App\Models\User;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Client\ConnectionException as HttpConnectionException;
use Illuminate\Http\Client\RequestException as HttpRequestException;
use Illuminate\Database\QueryException;
use PDOException;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccess;

class RegistrationController extends Controller
{
    /**
     * Show registration step 1 form
     */
    public function showStep1()
    {
        return view('register-step1');
    }

    /**
     * Handle step 1 submission
     */
    public function step1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required','string','email','max:255',
                Rule::unique('users','email'),
            ],
            'nomor_hp' => [
                'required', 'regex:/^[0-9]{8,20}$/',
                Rule::unique('users','nomor_hp'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_confirmation' => 'required|string|same:password',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.regex' => 'Format nomor HP tidak valid (hanya angka, 8-20 digit).',
            'nomor_hp.unique' => 'Nomor HP sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.string' => 'Konfirmasi password harus berupa teks.',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
        ]);

        // Store step 1 data in session
        $request->session()->put('registration.step1', $validated);

        return redirect()->route('register.step2.show');
    }

    /**
     * Show registration step 2 form
     */
    public function showStep2(Request $request)
    {
        if (!$request->session()->has('registration.step1')) {
            return redirect()->route('register.step1.show')->withErrors([
                'session' => 'Silakan lengkapi data akun dasar terlebih dahulu.',
            ]);
        }

        return view('register-step2');
    }

    /**
     * Handle step 2 submission
     */
    public function step2(Request $request)
    {
        if (!$request->session()->has('registration.step1')) {
            return redirect()->route('register.step1.show');
        }

        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
        ], [
            'nama_kursus.required' => 'Nama kursus wajib diisi.',
            'nama_kursus.string' => 'Nama kursus harus berupa teks.',
            'nama_kursus.max' => 'Nama kursus maksimal 255 karakter.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.string' => 'Lokasi harus berupa teks.',
            'latitude.required' => 'Silakan pilih lokasi di peta.',
            'longitude.required' => 'Silakan pilih lokasi di peta.',
            'latitude.numeric' => 'Koordinat lokasi tidak valid.',
            'longitude.numeric' => 'Koordinat lokasi tidak valid.',
            'latitude.between' => 'Koordinat lintang harus antara -90 dan 90 derajat.',
            'longitude.between' => 'Koordinat bujur harus antara -180 dan 180 derajat.',
            'jam_buka.required' => 'Jam buka wajib diisi.',
            'jam_buka.date_format' => 'Format jam buka tidak valid.',
            'jam_tutup.required' => 'Jam tutup wajib diisi.',
            'jam_tutup.date_format' => 'Format jam tutup tidak valid.',
            'jam_tutup.after' => 'Jam tutup harus setelah jam buka.',
        ]);

        // Store step 2 data in session
        $request->session()->put('registration.step2', $validated);

        return redirect()->route('register.step3.show');
    }

    /**
     * Show registration step 3 form
     */
    public function showStep3(Request $request)
    {
        if (!$request->session()->has('registration.step1') || !$request->session()->has('registration.step2')) {
            return redirect()->route('register.step1.show')->withErrors([
                'session' => 'Silakan lengkapi data sebelumnya terlebih dahulu.',
            ]);
        }

        return view('register-step3');
    }

    /**
     * Handle step 3 submission and complete registration
     */
    public function step3(Request $request)
    {
        // Per-request execution time to 5 minutes
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        if (!$request->session()->has('registration.step1') || !$request->session()->has('registration.step2')) {
            return redirect()->route('register.step1.show');
        }

        $validated = $request->validate([
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'izin_usaha' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'sertif_instruktur' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'dokumen_legal' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'ktp.required' => 'KTP pemilik kursus wajib diupload.',
            'ktp.file' => 'KTP harus berupa file.',
            'ktp.mimes' => 'Format KTP harus berupa: jpg, jpeg, png, pdf.',
            'ktp.max' => 'File KTP maksimal 5MB.',
            'izin_usaha.required' => 'Izin usaha/SIUP wajib diupload.',
            'izin_usaha.file' => 'Izin usaha harus berupa file.',
            'izin_usaha.mimes' => 'Format Izin Usaha harus berupa: jpg, jpeg, png, pdf.',
            'izin_usaha.max' => 'File Izin Usaha maksimal 5MB.',
            'sertif_instruktur.file' => 'Sertifikat Instruktur harus berupa file.',
            'sertif_instruktur.mimes' => 'Format Sertifikat Instruktur harus berupa: jpg, jpeg, png, pdf.',
            'sertif_instruktur.max' => 'File Sertifikat Instruktur maksimal 5MB.',
            'dokumen_legal.file' => 'Dokumen Legal harus berupa file.',
            'dokumen_legal.mimes' => 'Format Dokumen Legal harus berupa: jpg, jpeg, png, pdf.',
            'dokumen_legal.max' => 'File Dokumen Legal maksimal 5MB.',
        ]);

        try {
            $txStarted = false;

            // Get data from session
            $step1 = $request->session()->get('registration.step1');
            $step2 = $request->session()->get('registration.step2');


            // Initialize Supabase Service
            $supabaseService = new SupabaseService();

            // Upload documents to Supabase Storage
            $uploadedFiles = [];
            $errors = [];

            // Upload KTP
            $ktpUrl = $supabaseService->uploadKursusDocument($request->file('ktp'), 'ktp');
            if (!$ktpUrl) {
                $e = $supabaseService->getLastError();
                $detail = $e ? (' (detail: ' . (isset($e['status']) ? ('HTTP ' . $e['status'] . ' ') : '') . (isset($e['error']) ? $e['error'] : ($e['body'] ?? '')) . ')') : '';
                $errors[] = 'Gagal mengupload KTP ke Supabase.' . $detail;
            } else {
                $uploadedFiles['ktp'] = $ktpUrl;
            }

            // Upload Izin Usaha
            $izinUsahaUrl = $supabaseService->uploadKursusDocument($request->file('izin_usaha'), 'izin');
            if (!$izinUsahaUrl) {
                $e = $supabaseService->getLastError();
                $detail = $e ? (' (detail: ' . (isset($e['status']) ? ('HTTP ' . $e['status'] . ' ') : '') . (isset($e['error']) ? $e['error'] : ($e['body'] ?? '')) . ')') : '';
                $errors[] = 'Gagal mengupload Izin Usaha ke Supabase.' . $detail;
            } else {
                $uploadedFiles['izin_usaha'] = $izinUsahaUrl;
            }

            // Upload Sertifikat Instruktur (optional)
            $sertifUrl = null;
            if ($request->hasFile('sertif_instruktur')) {
                $sertifUrl = $supabaseService->uploadKursusDocument($request->file('sertif_instruktur'), 'dokumenlain');
                if ($sertifUrl) {
                    $uploadedFiles['sertif_instruktur'] = $sertifUrl;
                }
                // Tidak error jika optional file gagal upload
            }

            // Upload Dokumen Legal (optional)
            $dokumenLegalUrl = null;
            if ($request->hasFile('dokumen_legal')) {
                $dokumenLegalUrl = $supabaseService->uploadKursusDocument($request->file('dokumen_legal'), 'dokumenlain');
                if ($dokumenLegalUrl) {
                    $uploadedFiles['dokumen_legal'] = $dokumenLegalUrl;
                }
                // Tidak error jika optional file gagal upload
            }

            // Jika ada error pada required documents, batalkan tanpa transaksi DB
            if (!empty($errors)) {
                // Delete uploaded files from Supabase
                foreach ($uploadedFiles as $url) {
                    // Extract bucket and path from URL
                    $this->deleteSupabaseFile($supabaseService, $url);
                }

                return back()->withErrors([
                    'error' => implode(' ', $errors),
                ])->withInput();
            }

            // Mulai transaksi DB setelah upload berhasil
            DB::beginTransaction();
            $txStarted = true;

            // Buat akun user (tabel users) sesuai schema baru
            $user = User::create([
                'name' => $step1['name'],
                'email' => $step1['email'],
                'password' => Hash::make($step1['password']),
                'nomor_hp' => $step1['nomor_hp'],
                'status' => 'pending',
            ]);

            // Create request_akun sesuai schema baru: kolom id_request tidak auto-increment
            $nextRequestId = (DB::table('request_akun')->max('id_request') ?? 0) + 1;
            DB::table('request_akun')->insert([
                'id_request' => $nextRequestId,
                'waktu' => now(),
                'nama_kursus' => $step2['nama_kursus'],
                'lokasi' => $step2['lokasi'],
                'latitude' => $step2['latitude'],
                'longitude' => $step2['longitude'],
                'jam_buka' => $step2['jam_buka'],
                'jam_tutup' => $step2['jam_tutup'],
                // field baru sesuai skema
                'password' => Hash::make($step1['password']),
                'nama_pemilik' => $step1['name'],
                'email' => $step1['email'],
            ]);

            
            // Create dokumen_kursus: kolom id juga tidak auto-increment
            $nextDokumenId = (DB::table('dokumen_kursus')->max('id') ?? 0) + 1;
            DB::table('dokumen_kursus')->insert([
                'id' => $nextDokumenId,
                'ktp' => $ktpUrl,
                'izin_usaha' => $izinUsahaUrl,
                'sertif_instruktur' => $sertifUrl,
                'dokumen_legal' => $dokumenLegalUrl,
                'id_request' => $nextRequestId,
            ]);

            

            DB::commit();

            // Send success email
            try {
                Mail::to($step1['email'])->send(new RegistrationSuccess($step1['name']));
            } catch (\Exception $e) {
                // Log error but don't fail the registration
                \Log::error('Failed to send registration success email: ' . $e->getMessage());
            }

            // Clear registration session
            $request->session()->forget('registration');

            return redirect()->route('login')->with('success', 'Kursus sudah terkirim untuk Verifikasi oleh Admin, tunggu sekitar 24 jam setelah anda mengirimkan pengajuan Kursus.');

        } catch (\Exception $e) {
            if (isset($txStarted) && $txStarted) {
                DB::rollBack();
            }
            
            // Delete uploaded files from Supabase if any
            if (isset($supabaseService) && !empty($uploadedFiles)) {
                foreach ($uploadedFiles as $url) {
                    $this->deleteSupabaseFile($supabaseService, $url);
                }
            }

            $userMessage = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
            if ($e instanceof HttpConnectionException || $e instanceof HttpRequestException) {
                $userMessage = 'Layanan penyimpanan sedang tidak dapat diakses atau lambat (bad gateway/timeout). Silakan coba lagi beberapa saat.';
            } elseif ($e instanceof QueryException || $e instanceof PDOException) {
                $userMessage = 'Server database sedang sibuk/tidak dapat diakses karena traffic. Silakan coba lagi beberapa saat.';
            } else {
                $msg = $e->getMessage();
                if (stripos($msg, 'bad gateway') !== false || stripos($msg, '502') !== false || stripos($msg, '503') !== false || stripos($msg, 'service unavailable') !== false || stripos($msg, 'gateway') !== false) {
                    $userMessage = 'Terjadi gangguan jaringan (Bad Gateway/Service Unavailable). Silakan coba lagi beberapa saat.';
                }
            }

            return back()->withErrors([
                'error' => $userMessage,
            ])->withInput();
        }
    }

    /**
     * Go back to previous step
     */
    public function back(Request $request, $step)
    {
        if ($step == 2) {
            return redirect()->route('register.step1.show');
        } elseif ($step == 3) {
            return redirect()->route('register.step2.show');
        }

        return redirect()->route('register.step1.show');
    }

    /**
     * Delete file from Supabase using URL
     *
     * @param SupabaseService $supabaseService
     * @param string $url
     * @return void
     */
    private function deleteSupabaseFile(SupabaseService $supabaseService, string $url): void
    {
        try {
            // Extract bucket and path from Supabase URL
            // URL format: {storage_url}/object/public/{bucket}/{path}
            $urlParts = parse_url($url);
            $pathParts = explode('/object/public/', $url);
            
            if (isset($pathParts[1])) {
                $bucketAndPath = $pathParts[1];
                $parts = explode('/', $bucketAndPath, 2);
                
                if (count($parts) === 2) {
                    $bucket = $parts[0];
                    $filePath = $parts[1];
                    $supabaseService->deleteFile($bucket, $filePath);
                }
            }
        } catch (\Exception $e) {
            // Log error but don't throw
            \Log::error('Failed to delete file from Supabase during rollback', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

