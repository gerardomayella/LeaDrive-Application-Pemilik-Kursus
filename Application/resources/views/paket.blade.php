@extends('layouts.base', ['title' => 'Atur Paket Kursus - LeadDrive'])

@push('styles')
    <style>
        .container { max-width:1040px; margin:24px auto; padding:0 18px; }
        .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:28px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        .title-wrap { text-align:center; margin-bottom:22px; }
        .title { margin:6px 0 4px; font-size:26px; color:#ffb255; font-weight:800; }
        .subtitle { margin:0; color:#b9c3cd; }
        .actions { display:flex; align-items:center; gap:10px; margin:10px 0 22px; }
        .link { display:inline-flex; align-items:center; gap:8px; color:#ffcc8a; text-decoration:none; font-weight:700; }
        .link:hover { text-decoration:underline; }
        .empty { border:1px solid #3a4a5a; border-radius:12px; padding:38px 16px; text-align:center; background:#0f1923; }
        .empty .icon { font-size:40px; margin-bottom:12px; }
        .empty .title { color:#d7dee6; font-size:18px; margin:0 0 6px; }
        .empty .desc { color:#9fb0bf; margin:0 0 12px; }
        .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
        .btn:hover { background:#213142; }
        .btn-primary { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .btn-primary:hover { background:#ffa640; }
        .row { background:#0f1923; border:1px solid #2b3a49; border-radius:10px; padding:14px 16px; display:flex; justify-content:space-between; align-items:center; }
        .row-actions { display:flex; gap:8px; }
        .pill { padding:6px 10px; border-radius:8px; border:1px solid #2b3a49; background:#1a2430; color:#e6e6e6; text-decoration:none; font-size:13px; }
        .pill:hover { background:#203041; }
        .pill-danger { background:#8b2f28; border-color:#b9453c; color:#fff; }
        .search { display:flex; gap:8px; }
        .input { background:#0f1923; color:#e6e6e6; border:1px solid #2b3a49; border-radius:10px; padding:10px 12px; outline:none; }
        .alert { background:#10311f; border:1px solid #275a3c; color:#b9f5c6; padding:10px 12px; border-radius:10px; margin-bottom:12px; }
        .pagination { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; }
        .pagination a, .pagination span { padding:6px 10px; border:1px solid #2b3a49; border-radius:8px; text-decoration:none; color:#e6e6e6; }
        .pagination .active span { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .footer-actions { margin-top:22px; }
        .sortbar { display:flex; align-items:center; gap:8px; }
        .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,.5); display:none; align-items:center; justify-content:center; padding:20px; }
        .modal { background:#121a22; border:1px solid #243243; border-radius:12px; padding:18px; max-width:420px; width:100%; box-shadow:0 10px 30px rgba(0,0,0,.45); }
        .modal h4 { margin:0 0 10px; color:#ffb255; }
        .modal .actions { justify-content:flex-end; }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="shell">
            <div class="title-wrap">
                <div class="icon">📦</div>
                <h1 class="title">Atur Paket Kursus</h1>
                <p class="subtitle">Kelola paket kursus yang ditawarkan kepada peserta</p>
            </div>

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <div class="actions" style="justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <form method="GET" class="search" action="{{ route('paket.index') }}">
                    <input class="input" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama paket, deskripsi, atau jenis kendaraan...">
                    <button class="btn" type="submit">Cari</button>
                </form>
                <div class="sortbar">
                    @php
                        function sortLinkP($key, $label, $q, $sort, $dir){
                            $params = ['q'=>$q,'sort'=>$key,'dir'=>($sort===$key && $dir==='asc')?'desc':'asc'];
                            $url = route('paket.index',$params);
                            $arrow = $sort===$key ? ($dir==='asc'?'↑':'↓') : '';
                            return '<a class="pill" href="'.$url.'">'.$label.' '.$arrow.'</a>';
                        }
                    @endphp
                    {!! sortLinkP('terbaru','Terbaru',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkP('nama','Nama',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkP('harga','Harga',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkP('durasi','Durasi',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkP('jenis','Jenis Mobil',$q??'', $sort??'terbaru', $dir??'desc') !!}
                </div>
                <a class="link" href="{{ route('paket.create') }}">＋ Tambah Paket Baru</a>
            </div>

            @if(isset($pakets) && $pakets->count())
                <div style="display:grid; gap:12px;">
                    @foreach($pakets as $p)
                        <div class="row">
                            <div>
                                <div style="font-weight:800; color:#ffcc8a">{{ $p->nama_paket }}</div>
                                <div style="opacity:.85">Rp {{ number_format($p->harga,0,',','.') }} · {{ $p->durasi_jam }} jam</div>
                            </div>
                            <div class="row-actions">
                                <a class="pill" href="{{ route('paket.edit',$p->id_paket) }}">Edit</a>
                                <button class="pill pill-danger" data-delete="{{ route('paket.destroy',$p->id_paket) }}" data-name="{{ $p->nama_paket }}">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $pakets->links() }}
                </div>
            @else
                <section class="empty">
                    <div class="icon">📦</div>
                    <h3 class="title">Belum Ada Paket Kursus</h3>
                    <p class="desc">Buat paket kursus pertama Anda untuk mulai menerima peserta</p>
                    <a class="link" href="{{ route('paket.create') }}">＋ Buat Paket Pertama</a>
                </section>
            @endif

            <div class="footer-actions">
                <a class="btn" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <div id="confirmP" class="modal-backdrop">
        <div class="modal">
            <h4>Hapus Paket</h4>
            <p id="confirmP-text" style="margin:0 0 12px;">Anda yakin ingin menghapus paket ini?</p>
            <form id="confirmP-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="actions">
                    <button type="button" class="btn" id="cancelP">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const mP = document.getElementById('confirmP');
        const fP = document.getElementById('confirmP-form');
        const tP = document.getElementById('confirmP-text');
        const cP = document.getElementById('cancelP');
        document.querySelectorAll('[data-delete]').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                fP.action = btn.dataset.delete;
                tP.textContent = `Hapus paket "${btn.dataset.name}"?`;
                mP.style.display = 'flex';
            });
        });
        cP.addEventListener('click', ()=>{ mP.style.display = 'none'; });
        mP.addEventListener('click', (e)=>{ if(e.target===mP) mP.style.display='none'; });
    </script>
@endsection
