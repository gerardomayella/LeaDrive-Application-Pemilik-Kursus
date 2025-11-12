<aside class="sidebar">
    <a class="sb-link" href="{{ route('dashboard') }}" title="Dashboard">🏠</a>
    <a class="sb-link" href="{{ route('orders.index') }}" title="Pesanan">🧾</a>
    <a class="sb-link" href="{{ route('paket.index') }}" title="Paket">📦</a>
    <a class="sb-link" href="{{ route('instruktur.index') }}" title="Instruktur">👨‍🏫</a>
    <a class="sb-link" href="{{ route('mobil.index') }}" title="Kendaraan">🚗</a>
    @if(Route::has('ulasan.index'))
    <a class="sb-link" href="{{ route('ulasan.index') }}" title="Ulasan">⭐</a>
    @endif
    <div class="sb-bottom"></div>
</aside>
