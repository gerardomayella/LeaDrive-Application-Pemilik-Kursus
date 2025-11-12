<header class="topbar">
    <div class="brand">
        <a href="{{ route('dashboard') }}" style="text-decoration:none; color:inherit; display:flex; align-items:center; gap:10px">
            <img src="{{ asset('images/logo.jpg') }}" alt="LeadDrive">
            LeadDrive
        </a>
    </div>
    <div class="right">
        <a class="btn" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="btn" href="{{ route('orders.index') }}">Pesanan</a>
        <a class="btn" href="{{ route('paket.index') }}">Paket</a>
        <a class="btn" href="{{ route('instruktur.index') }}">Instruktur</a>
        <a class="btn" href="{{ route('mobil.index') }}">Kendaraan</a>
        @if(Route::has('ulasan.index'))
        <a class="btn" href="{{ route('ulasan.index') }}">Ulasan</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="btn btn-danger">Keluar</button>
        </form>
    </div>
</header>
