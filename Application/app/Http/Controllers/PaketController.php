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
        $q = trim((string)$request->get('q', ''));
        $query = PaketKursus::where('id_kursus', $kursusId);
        if ($q !== '') {
            $query->where(function($sub) use ($q){
                $sub->where('nama_paket', 'ilike', "%$q%")
                    ->orWhere('deskripsi', 'ilike', "%$q%")
                    ->orWhere('jenis_kendaraan', 'ilike', "%$q%");
            });
        }
        // Sorting
        $sort = (string)$request->get('sort', 'terbaru');
        $dir = strtolower((string)$request->get('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $map = [
            'nama' => 'nama_paket',
            'harga' => 'harga',
            'durasi' => 'durasi_jam',
            'jenis' => 'jenis_kendaraan',
            'terbaru' => 'created_at',
        ];
        $column = $map[$sort] ?? 'created_at';
        $query->orderBy($column, $dir);

        $pakets = $query->paginate(10)->withQueryString();
        return view('paket', compact('pakets','q','sort','dir'));
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
        try {
            $paket->save();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors([
                'general' => 'Server database sedang sibuk atau tidak dapat diakses. Silakan coba lagi beberapa saat.',
            ])->withInput();
        }

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dibuat');
    }

    public function edit(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $paket = PaketKursus::where('id_kursus', $kursusId)->where('id_paket', $id)->firstOrFail();
        return view('paket-edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $paket = PaketKursus::where('id_kursus', $kursusId)->where('id_paket', $id)->firstOrFail();

        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'durasi_jam' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'jenis_kendaraan' => 'required|in:manual,matic',
        ]);

        $paket->nama_paket = $validated['nama_paket'];
        $paket->harga = $validated['harga'];
        $paket->durasi_jam = $validated['durasi_jam'];
        $paket->deskripsi = $validated['deskripsi'] ?? null;
        $paket->jenis_kendaraan = $validated['jenis_kendaraan'];
        try {
            $paket->save();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors([
                'general' => 'Server database sedang sibuk atau tidak dapat diakses. Silakan coba lagi beberapa saat.',
            ])->withInput();
        }

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $paket = PaketKursus::where('id_kursus', $kursusId)->where('id_paket', $id)->firstOrFail();
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus');
    }
}
