<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Instruktur;
use App\Services\SupabaseService;

class InstrukturController extends Controller
{
    public function index(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }

        $q = trim((string)$request->get('q', ''));
        $query = Instruktur::where('id_kursus', $kursusId);
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'ilike', "%$q%")
                    ->orWhere('email', 'ilike', "%$q%")
                    ->orWhere('nomor_sim', 'ilike', "%$q%");
            });
        }
        // Sorting
        $sort = (string)$request->get('sort', 'terbaru');
        $dir = strtolower((string)$request->get('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $map = [
            'nama' => 'nama',
            'status' => 'status_aktif',
            'email' => 'email',
            'terbaru' => 'id_instruktur',
        ];
        $column = $map[$sort] ?? 'id_instruktur';
        $query->orderBy($column, $dir);

        $instrukturs = $query->paginate(10)->withQueryString();
        return view('instruktur', compact('instrukturs', 'q', 'sort', 'dir'));
    }

    public function create(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }
        return view('instruktur-create');
    }

    public function store(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:8',
            'nomor_sim' => 'nullable|string|max:50',
            'status_aktif' => 'nullable|boolean',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sertifikat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
        ]);

        $instruktur = new Instruktur();
        $instruktur->nama = $validated['nama'];
        $instruktur->email = $validated['email'] ?? null;
        $instruktur->password = isset($validated['password']) ? Hash::make($validated['password']) : null;
        $instruktur->nomor_sim = $validated['nomor_sim'] ?? null;
        $instruktur->status_aktif = $request->boolean('status_aktif', true);
        $instruktur->id_kursus = $kursusId;

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $supabase = new SupabaseService();
            $url = $supabase->uploadInstrukturDocument($request->file('foto_profil'), 'fotoinstruktur');
            if ($url) {
                $instruktur->foto_profil = $url;
            } else {
                $e = $supabase->getLastError();
                return back()->withErrors([
                    'foto_profil' => 'Gagal mengupload foto instruktur' . ($e ? ' (detail: ' . (($e['status'] ?? '') ?: ($e['error'] ?? '')) . ')' : ''),
                ])->withInput();
            }
        }

        // Upload sertifikat jika ada
        if ($request->hasFile('sertifikat')) {
            $supabase = isset($supabase) ? $supabase : new SupabaseService();
            $sertifUrl = $supabase->uploadInstrukturDocument($request->file('sertifikat'), 'sertifikat');
            if ($sertifUrl) {
                $instruktur->sertifikat = $sertifUrl;
            } else {
                $e = $supabase->getLastError();
                return back()->withErrors([
                    'sertifikat' => 'Gagal mengupload sertifikat instruktur' . ($e ? ' (detail: ' . (($e['status'] ?? '') ?: ($e['error'] ?? '')) . ')' : ''),
                ])->withInput();
            }
        }
        $instruktur->save();

        return redirect()->route('instruktur.index')->with('success', 'Instruktur berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $instruktur = Instruktur::where('id_kursus', $kursusId)->where('id_instruktur', $id)->firstOrFail();
        return view('instruktur-edit', compact('instruktur'));
    }

    public function update(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $instruktur = Instruktur::where('id_kursus', $kursusId)->where('id_instruktur', $id)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:8',
            'nomor_sim' => 'nullable|string|max:50',
            'status_aktif' => 'nullable|boolean',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sertifikat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
        ]);

        $instruktur->nama = $validated['nama'];
        $instruktur->email = $validated['email'] ?? null;
        if (!empty($validated['password'])) {
            $instruktur->password = Hash::make($validated['password']);
        }
        $instruktur->nomor_sim = $validated['nomor_sim'] ?? null;
        $instruktur->status_aktif = $request->boolean('status_aktif', true);

        if ($request->hasFile('foto_profil')) {
            $supabase = new SupabaseService();
            $url = $supabase->uploadInstrukturDocument($request->file('foto_profil'), 'fotoinstruktur');
            if ($url) { $instruktur->foto_profil = $url; }
            else {
                $e = $supabase->getLastError();
                return back()->withErrors(['foto_profil' => 'Gagal mengupload foto instruktur' . ($e ? ' (detail: ' . (($e['status'] ?? '') ?: ($e['error'] ?? '')) . ')' : '')])->withInput();
            }
        }

        if ($request->hasFile('sertifikat')) {
            $supabase = isset($supabase) ? $supabase : new SupabaseService();
            $sertifUrl = $supabase->uploadInstrukturDocument($request->file('sertifikat'), 'sertifikat');
            if ($sertifUrl) { $instruktur->sertifikat = $sertifUrl; }
            else {
                $e = $supabase->getLastError();
                return back()->withErrors(['sertifikat' => 'Gagal mengupload sertifikat instruktur' . ($e ? ' (detail: ' . (($e['status'] ?? '') ?: ($e['error'] ?? '')) . ')' : '')])->withInput();
            }
        }

        $instruktur->save();
        return redirect()->route('instruktur.index')->with('success', 'Instruktur berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $instruktur = Instruktur::where('id_kursus', $kursusId)->where('id_instruktur', $id)->firstOrFail();
        $instruktur->delete();
        return redirect()->route('instruktur.index')->with('success', 'Instruktur berhasil dihapus');
    }
}
