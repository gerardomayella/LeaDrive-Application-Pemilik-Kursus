<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kursus;
use App\Services\SupabaseService;

class KursusProfileController extends Controller
{
    public function show(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $kursus = Kursus::findOrFail($kursusId);
        return view('profil-kursus', compact('kursus'));
    }

    public function update(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $kursus = Kursus::findOrFail($kursusId);

        $validated = $request->validate([
            'nama_kursus' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'jam_buka' => 'nullable|string|max:50',
            'jam_tutup' => 'nullable|string|max:50',
            'nama_pemilik' => 'nullable|string|max:255',
            'email' => 'required|email',
            'foto_profil' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'nomor_hp' => 'nullable|string|max:255',
        ], [
            'latitude.required' => 'Silakan pilih lokasi di peta.',
            'longitude.required' => 'Silakan pilih lokasi di peta.',
            'latitude.numeric' => 'Koordinat lokasi tidak valid.',
            'longitude.numeric' => 'Koordinat lokasi tidak valid.',
            'latitude.between' => 'Koordinat lintang harus antara -90 dan 90 derajat.',
            'longitude.between' => 'Koordinat bujur harus antara -180 dan 180 derajat.'
        ]);

        $kursus->nama_kursus = $validated['nama_kursus'];
        $kursus->lokasi = $validated['lokasi'];
        $kursus->latitude = $validated['latitude'];
        $kursus->longitude = $validated['longitude'];
        $kursus->jam_buka = $validated['jam_buka'] ?? null;
        $kursus->jam_tutup = $validated['jam_tutup'] ?? null;
        $kursus->nama_pemilik = $validated['nama_pemilik'] ?? null;
        $kursus->email = $validated['email'];
        $kursus->nomor_hp = $validated['nomor_hp'] ?? null;
        
        if ($request->hasFile('foto_profil')) {
            $supabase = new SupabaseService();
            $url = $supabase->uploadKursusDocument($request->file('foto_profil'), 'fotokursus');
            if ($url) {
                $kursus->foto_profil = $url;
            }
        }

        try {
            $kursus->save();

            $request->session()->put('kursus_nama', $kursus->nama_kursus ?? 'Pemilik Kursus');
            if ($kursus->foto_profil) {
                $request->session()->put('kursus_foto', $kursus->foto_profil);
            }
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors([
                'general' => 'Server database sedang sibuk atau tidak dapat diakses. Silakan coba lagi beberapa saat.',
            ])->withInput();
        }

        return redirect()->route('profile.show')->with('success', 'Profil kursus berhasil diperbarui');
    }
}
