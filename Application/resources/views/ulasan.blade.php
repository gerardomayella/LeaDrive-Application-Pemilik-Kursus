@extends('layouts.base', ['title' => 'Rating & Ulasan - LeadDrive'])

@push('styles')
<style>
    .shell { background:#121a22; border:1px solid #243243; border-radius:16px; padding:22px; }
    .title-wrap { text-align:center; margin-bottom:16px; }
    .title { margin:4px 0 6px; font-size:26px; color:#ffb255; }
    .subtitle { margin:0; color:#b9c3cd; }

    .filters { display:flex; gap:10px; flex-wrap:wrap; background:#0f1720; border:1px solid #253347; padding:12px; border-radius:12px; margin-bottom:14px; }
    .input, .select { background:#1a2430; border:1px solid #2a3a4b; color:#e6e6e6; border-radius:10px; padding:10px 12px; }
    .btn { display:inline-flex; align-items:center; gap:8px; border:0; cursor:pointer; background:#1b2733; color:#e6e6e6; padding:10px 14px; border-radius:10px; border:1px solid #263646; text-decoration:none; font-weight:600; }
    .btn:hover { background:#213142; }
    .btn-primary { background:#2962ff; border-color:#3d73ff; }

    .summary { display:flex; gap:12px; overflow:auto; padding-bottom:6px; margin:14px 0 10px; }
    .chip { min-width:180px; background:#141e29; border:1px solid #2a3a4b; border-radius:12px; padding:12px; }
    .chip .label { color:#c5d0db; font-size:13px; }
    .chip .value { font-weight:800; font-size:22px; margin-top:6px; color:#57b7ff; }

    table { width:100%; border-collapse:separate; border-spacing:0; }
    th, td { text-align:left; padding:10px 12px; border-bottom:1px solid #243243; }
    th { color:#c5d0db; font-weight:700; background:#101820; position:sticky; top:0; }

    .stars { color:#ffcc66; }
</style>
@endpush

@section('content')
<div class="shell">
    <div class="title-wrap">
        <div style="font-size:28px">⭐</div>
        <h1 class="title">Rating & Ulasan</h1>
        <p class="subtitle">Lihat umpan balik peserta untuk kursus dan instruktur</p>
    </div>

    <form method="GET" class="filters">
        <input class="input" type="text" name="q" placeholder="Cari peserta (nama/email/HP)" value="{{ $filters['q'] ?? '' }}">
        <select class="select" name="instruktur">
            <option value="">Semua Instruktur</option>
            @foreach ($instrukturs as $ins)
                <option value="{{ $ins->id_instruktur }}" {{ ($filters['instruktur'] ?? '') == $ins->id_instruktur ? 'selected' : '' }}>{{ $ins->nama }}</option>
            @endforeach
        </select>
        <input class="input" type="number" name="min_rating" placeholder="Rating min" min="1" max="5" value="{{ $filters['min_rating'] ?? '' }}">
        <input class="input" type="number" name="max_rating" placeholder="Rating max" min="1" max="5" value="{{ $filters['max_rating'] ?? '' }}">
        <input class="input" type="date" name="from" value="{{ $filters['from'] ?? '' }}">
        <input class="input" type="date" name="to" value="{{ $filters['to'] ?? '' }}">
        <button class="btn btn-primary" type="submit">Terapkan</button>
    </form>

    <div class="summary">
        <div class="chip"><div class="label">Jumlah Ulasan</div><div class="value">{{ $stats['count'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">Rata-rata</div><div class="value">{{ $stats['avg'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">5 ⭐</div><div class="value">{{ $stats['five'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">4 ⭐</div><div class="value">{{ $stats['four'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">3 ⭐</div><div class="value">{{ $stats['three'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">2 ⭐</div><div class="value">{{ $stats['two'] ?? 0 }}</div></div>
        <div class="chip"><div class="label">1 ⭐</div><div class="value">{{ $stats['one'] ?? 0 }}</div></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Peserta</th>
                <th>Instruktur</th>
                <th>Rating</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $it)
                <tr>
                    <td>{{ $it->tanggal ?? '-' }}</td>
                    <td>{{ $it->user->name ?? '-' }}<br><span style="color:#9fb0bf; font-size:12px;">{{ $it->user->email ?? '-' }}</span></td>
                    <td>{{ $it->instruktur->nama ?? '-' }}</td>
                    <td class="stars">{{ str_repeat('★', (int) $it->rating) }}<span style="color:#4a6075;">{{ str_repeat('☆', max(0, 5- (int)$it->rating)) }}</span></td>
                    <td>{{ $it->komentar ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="opacity:.8;">Belum ada ulasan</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</div>
@endsection
