<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }

        $q = trim((string)$request->get('q',''));
        $query = Mobil::where('id_kursus', $kursusId);
        if ($q !== '') {
            $query->where(function($sub) use ($q){
                $sub->where('merk','ilike',"%$q%")
                    ->orWhere('transmisi','ilike',"%$q%")
                    ->orWhere('stnk','ilike',"%$q%");
            });
        }
        $sort = (string)$request->get('sort','terbaru');
        $dir = strtolower((string)$request->get('dir','desc'))==='asc' ? 'asc':'desc';
        $map = [
            'terbaru' => 'id_mobil',
            'merk' => 'merk',
            'transmisi' => 'transmisi',
        ];
        $column = $map[$sort] ?? 'id_mobil';
        $query->orderBy($column, $dir);

        $mobils = $query->paginate(10)->withQueryString();
        return view('mobil', compact('mobils','q','sort','dir'));
    }

    public function create(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        return view('mobil-create');
    }

    public function store(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }

        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'transmisi' => 'nullable|in:manual,matic',
            'stnk' => 'nullable|string|max:255',
        ]);

        $m = new Mobil();
        $m->merk = $validated['merk'];
        $m->transmisi = $validated['transmisi'] ?? null;
        $m->stnk = $validated['stnk'] ?? null;
        $m->id_kursus = $kursusId;
        $m->save();

        return redirect()->route('mobil.index')->with('success','Kendaraan berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $mobil = Mobil::where('id_kursus', $kursusId)->where('id_mobil',$id)->firstOrFail();
        return view('mobil-edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $mobil = Mobil::where('id_kursus', $kursusId)->where('id_mobil',$id)->firstOrFail();

        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'transmisi' => 'nullable|in:manual,matic',
            'stnk' => 'nullable|string|max:255',
        ]);

        $mobil->merk = $validated['merk'];
        $mobil->transmisi = $validated['transmisi'] ?? null;
        $mobil->stnk = $validated['stnk'] ?? null;
        $mobil->save();

        return redirect()->route('mobil.index')->with('success','Kendaraan berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) { return redirect()->route('login'); }
        $mobil = Mobil::where('id_kursus', $kursusId)->where('id_mobil',$id)->firstOrFail();
        $mobil->delete();
        return redirect()->route('mobil.index')->with('success','Kendaraan berhasil dihapus');
    }
}
