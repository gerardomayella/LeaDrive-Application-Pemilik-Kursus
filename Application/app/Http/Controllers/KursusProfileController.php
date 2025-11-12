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
            'lokasi' => 'nullable|string|max:255',
            'jam_buka' => 'nullable|string|max:50',
            'jam_tutup' => 'nullable|string|max:50',
            'nama_pemilik' => 'nullable|string|max:255',
            'email' => 'required|email',
            'foto_profil' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $kursus->nama_kursus = $validated['nama_kursus'];
        $kursus->lokasi = $validated['lokasi'] ?? null;
        $kursus->jam_buka = $validated['jam_buka'] ?? null;
        $kursus->jam_tutup = $validated['jam_tutup'] ?? null;
        $kursus->nama_pemilik = $validated['nama_pemilik'] ?? null;
        $kursus->email = $validated['email'];

        if ($request->hasFile('foto_profil')) {
            $supabase = new SupabaseService();
            $url = $supabase->uploadKursusDocument($request->file('foto_profil'), 'fotokursus');
            if ($url) {
                $kursus->foto_profil = $url;
            }
        }

        try {
            $kursus->save();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors([
                'general' => 'Server database sedang sibuk atau tidak dapat diakses. Silakan coba lagi beberapa saat.',
            ])->withInput();
        }

        return redirect()->route('profile.show')->with('success', 'Profil kursus berhasil diperbarui');
    }
}
