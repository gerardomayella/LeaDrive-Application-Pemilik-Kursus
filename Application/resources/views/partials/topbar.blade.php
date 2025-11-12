<header class="topbar">
    <div class="brand">
        <a href="{{ route('dashboard') }}" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:10px">
            <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive">
            LeadDrive
        </a>
    </div>
    <div class="right">
        @php
            $kid = session('kursus_id');
            $pf = null;
            if ($kid) { $pf = \App\Models\Kursus::where('id_kursus', $kid)->value('foto_profil'); }
        @endphp
        <a href="{{ route('profile.show') }}" title="Profil" style="display:inline-flex;align-items:center;gap:10px;margin-right:12px;text-decoration:none">
            <img src="{{ $pf ?: asset('images/logo.jpg') }}" alt="Profil" style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:1px solid rgba(255,255,255,0.2)">
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="btn btn-danger">Keluar</button>
        </form>
    </div>
</header>
