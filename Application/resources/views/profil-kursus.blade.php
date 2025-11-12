@extends('layouts.base')

@section('content')
<div class="container">
    <h1 style="margin:0 0 16px 0;font-size:20px;font-weight:600;color:#e5e7eb">Profil Kursus</h1>

    @if ($errors->any())
        <div style="background:#432;color:#fca5a5;padding:12px 14px;border-radius:8px;margin-bottom:12px">
            <ul style="margin:0;padding-left:16px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="background:#16321f;color:#86efac;padding:12px 14px;border-radius:8px;margin-bottom:12px">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display:grid;gap:14px;max-width:720px">
        @csrf
        @method('PUT')

        <div style="display:flex;gap:16px;align-items:center">
            <div>
                @php $pf = $kursus->foto_profil ?? null; @endphp
                <img src="{{ $pf ?: asset('images/logo.jpg') }}" alt="Foto Profil" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:1px solid rgba(255,255,255,0.2)">
            </div>
            <div style="flex:1">
                <label for="foto_profil" style="display:block;margin-bottom:6px;color:#9ca3af">Foto Profil</label>
                <input type="file" id="foto_profil" name="foto_profil" accept="image/*" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
        </div>

        <div>
            <label for="nama_kursus" style="display:block;margin-bottom:6px;color:#9ca3af">Nama Kursus</label>
            <input type="text" id="nama_kursus" name="nama_kursus" value="{{ old('nama_kursus', $kursus->nama_kursus) }}" required style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div>
            <label for="lokasi" style="display:block;margin-bottom:6px;color:#9ca3af">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $kursus->lokasi) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div>
                <label for="jam_buka" style="display:block;margin-bottom:6px;color:#9ca3af">Jam Buka</label>
                <input type="text" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', $kursus->jam_buka) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
            <div>
                <label for="jam_tutup" style="display:block;margin-bottom:6px;color:#9ca3af">Jam Tutup</label>
                <input type="text" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', $kursus->jam_tutup) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
        </div>

        <div>
            <label for="nama_pemilik" style="display:block;margin-bottom:6px;color:#9ca3af">Nama Pemilik</label>
            <input type="text" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $kursus->nama_pemilik) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div>
            <label for="email" style="display:block;margin-bottom:6px;color:#9ca3af">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $kursus->email) }}" required style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px">
            <a href="{{ route('dashboard') }}" style="background:#1f2937;color:#e5e7eb;border:1px solid #374151;border-radius:8px;padding:10px 14px;text-decoration:none">Batal</a>
            <button type="submit" style="background:#2563eb;color:#fff;border:0;border-radius:8px;padding:10px 16px;cursor:pointer">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
