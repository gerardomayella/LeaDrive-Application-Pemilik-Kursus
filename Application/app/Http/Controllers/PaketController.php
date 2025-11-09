<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketKursus;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }
        $pakets = PaketKursus::where('id_kursus', $kursusId)->orderByDesc('created_at')->get();
        return view('paket', compact('pakets'));
    }

    public function create(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }
        return view('paket-create');
    }

    public function store(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'durasi_jam' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'jenis_kendaraan' => 'required|in:manual,matic',
        ]);

        $paket = new PaketKursus();
        $paket->nama_paket = $validated['nama_paket'];
        $paket->harga = $validated['harga'];
        $paket->durasi_jam = $validated['durasi_jam'];
        $paket->deskripsi = $validated['deskripsi'] ?? null;
        $paket->jenis_kendaraan = $validated['jenis_kendaraan'];
        $paket->id_kursus = $kursusId;
        $paket->save();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dibuat');
    }
}
