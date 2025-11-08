<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kursus;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }

        $kursus = Kursus::where('id_kursus', $kursusId)->first();

        // Minimal ringkasan kursus (sesuaikan dengan kolom yang tersedia di model)
        $summary = [
            'nama' => $kursus->nama_kursus ?? 'Kursus Anda',
            'email' => $kursus->email ?? '-',
            'telepon' => $kursus->no_hp ?? '-',
            'status' => (bool)($kursus->status ?? false) ? 'Aktif' : 'Non-aktif',
        ];

        return view('dashboard', [
            'kursus' => $kursus,
            'summary' => $summary,
        ]);
    }
}
