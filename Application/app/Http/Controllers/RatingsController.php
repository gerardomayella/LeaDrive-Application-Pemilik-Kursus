<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RatingUlasan;
use App\Models\Instruktur;

class RatingsController extends Controller
{
    public function index(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }
        $q = $request->input('q');
        $instrukturId = $request->input('instruktur');
        $minRating = $request->input('min_rating');
        $maxRating = $request->input('max_rating');
        $dateFrom = $request->input('from');
        $dateTo = $request->input('to');

        $base = RatingUlasan::with([
            'user:id,name,email',
            'instruktur:id_instruktur,nama',
        ])->where('id_kursus', $kursusId);

        if ($q) {
            $base->whereHas('user', function ($uq) use ($q) {
                $uq->where('name', 'ilike', "%$q%")
                   ->orWhere('email', 'ilike', "%$q%");
            });
        }

        if ($instrukturId) {
            $base->where('id_instruktur', $instrukturId);
        }

        if (strlen($minRating ?? '') > 0) {
            $base->where('rating', '>=', (int)$minRating);
        }
        if (strlen($maxRating ?? '') > 0) {
            $base->where('rating', '<=', (int)$maxRating);
        }

        if ($dateFrom) {
            $base->whereDate('tanggal', '>=', $dateFrom);
        }
        if ($dateTo) {
            $base->whereDate('tanggal', '<=', $dateTo);
        }

        $ulasan = $base->orderByDesc('id_ulasan')->paginate(10)->withQueryString();

        $agg = RatingUlasan::where('id_kursus', $kursusId)
            ->selectRaw('COUNT(*) as count, AVG(rating)::numeric(10,2) as avg,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one')
            ->first();
        $stats = [
            'count' => (int) ($agg->count ?? 0),
            'avg' => $agg && $agg->avg !== null ? (float) $agg->avg : 0.0,
            'five' => (int) ($agg->five ?? 0),
            'four' => (int) ($agg->four ?? 0),
            'three' => (int) ($agg->three ?? 0),
            'two' => (int) ($agg->two ?? 0),
            'one' => (int) ($agg->one ?? 0),
        ];

        $instrukturs = Instruktur::where('id_kursus', $kursusId)->orderBy('nama')->get();

        return view('ulasan', [
            'items' => $ulasan,
            'stats' => $stats,
            'instrukturs' => $instrukturs,
            'filters' => [
                'q' => $q,
                'instruktur' => $instrukturId,
                'min_rating' => $minRating,
                'max_rating' => $maxRating,
                'from' => $dateFrom,
                'to' => $dateTo,
            ],
        ]);
    }
}
