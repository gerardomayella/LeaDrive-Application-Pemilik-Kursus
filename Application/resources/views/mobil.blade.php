<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kendaraan - LeadDrive</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#0f141a; color:#e6e6e6; }
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
        .item { background:#0f1923; border:1px solid #2b3a49; border-radius:10px; padding:14px 16px; display:flex; justify-content:space-between; align-items:center; }
        .name { font-weight:800; color:#ffcc8a }
        .muted { opacity:.85 }
        .row-actions { display:flex; gap:8px; align-items:center; }
        .pill { padding:6px 10px; border-radius:8px; border:1px solid #2b3a49; background:#1a2430; color:#e6e6e6; text-decoration:none; font-size:13px; }
        .pill:hover { background:#203041; }
        .pill-danger { background:#8b2f28; border-color:#b9453c; color:#fff; }
        .search { display:flex; gap:8px; }
        .input { background:#0f1923; color:#e6e6e6; border:1px solid #2b3a49; border-radius:10px; padding:10px 12px; outline:none; }
        .alert { background:#10311f; border:1px solid #275a3c; color:#b9f5c6; padding:10px 12px; border-radius:10px; margin-bottom:12px; }
        .pagination { display:flex; gap:8px; margin-top:14px; flex-wrap:wrap; }
        .pagination a, .pagination span { padding:6px 10px; border:1px solid #2b3a49; border-radius:8px; text-decoration:none; color:#e6e6e6; }
        .pagination .active span { background:#ff8a00; color:#111; border-color:#ff9f33; }
        .sortbar { display:flex; align-items:center; gap:8px; }
        .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,.5); display:none; align-items:center; justify-content:center; padding:20px; }
        .modal { background:#121a22; border:1px solid #243243; border-radius:12px; padding:18px; max-width:420px; width:100%; box-shadow:0 10px 30px rgba(0,0,0,.45); }
        .modal h4 { margin:0 0 10px; color:#ffb255; }
        .modal .actions { justify-content:flex-end; }
    </style>
</head>
<body>
    <main class="container">
        <div class="shell">
            <div class="title-wrap">
                <div class="icon">🚗</div>
                <h1 class="title">Kelola Kendaraan</h1>
                <p class="subtitle">Kelola kendaraan yang digunakan untuk kursus mengemudi</p>
            </div>

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <div class="actions" style="justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <form method="GET" class="search" action="{{ route('mobil.index') }}">
                    <input class="input" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari merk, transmisi, atau STNK...">
                    <button class="btn" type="submit">Cari</button>
                </form>
                <div class="sortbar">
                    @php
                        function sortLinkM($key, $label, $q, $sort, $dir){
                            $params = ['q'=>$q,'sort'=>$key,'dir'=>($sort===$key && $dir==='asc')?'desc':'asc'];
                            $url = route('mobil.index',$params);
                            $arrow = $sort===$key ? ($dir==='asc'?'↑':'↓') : '';
                            return '<a class="pill" href="'.$url.'">'.$label.' '.$arrow.'</a>';
                        }
                    @endphp
                    {!! sortLinkM('terbaru','Terbaru',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkM('merk','Merk',$q??'', $sort??'terbaru', $dir??'desc') !!}
                    {!! sortLinkM('transmisi','Transmisi',$q??'', $sort??'terbaru', $dir??'desc') !!}
                </div>
                <a class="link" href="{{ route('mobil.create') }}">＋ Tambah Kendaraan Baru</a>
            </div>

            @if(isset($mobils) && $mobils->count())
                <div style="display:grid; gap:12px;">
                    @foreach($mobils as $m)
                        <div class="item">
                            <div>
                                <div class="name">{{ $m->merk }}</div>
                                <div class="muted">Transmisi: {{ $m->transmisi ?? '-' }} @if($m->stnk) · STNK: {{ $m->stnk }} @endif</div>
                            </div>
                            <div class="row-actions">
                                <a class="pill" href="{{ route('mobil.edit',$m->id_mobil) }}">Edit</a>
                                <button class="pill pill-danger" data-delete="{{ route('mobil.destroy',$m->id_mobil) }}" data-name="{{ $m->merk }}">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $mobils->links() }}
                </div>
            @else
                <section class="empty">
                    <div class="icon">🚗</div>
                    <h3 class="title">Belum Ada Kendaraan</h3>
                    <p class="desc">Tambahkan kendaraan pertama untuk mulai operasional kursus</p>
                    <a class="link" href="{{ route('mobil.create') }}">＋ Tambah Kendaraan Pertama</a>
                </section>
            @endif

            <div style="margin-top:22px;">
                <a class="btn" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>
    </main>

    <div id="confirm" class="modal-backdrop">
        <div class="modal">
            <h4>Hapus Kendaraan</h4>
            <p id="confirm-text" style="margin:0 0 12px;">Anda yakin ingin menghapus?</p>
            <form id="confirm-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="actions">
                    <button type="button" class="btn" id="cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('confirm');
        const form = document.getElementById('confirm-form');
        const text = document.getElementById('confirm-text');
        const cancelBtn = document.getElementById('cancel');
        document.querySelectorAll('[data-delete]').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                form.action = btn.dataset.delete;
                text.textContent = `Hapus kendaraan "${btn.dataset.name}"?`;
                modal.style.display = 'flex';
            });
        });
        cancelBtn.addEventListener('click', ()=>{ modal.style.display = 'none'; });
        modal.addEventListener('click', (e)=>{ if(e.target===modal) modal.style.display='none'; });
    </script>
</body>
</html>
