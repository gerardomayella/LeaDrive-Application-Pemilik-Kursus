<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\PaketKursus;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $statusPesanan = $request->input('status_pesanan');
        $statusKursus = $request->input('status_kursus');
        $paketId = $request->input('paket');
        $q = $request->input('q');

        $base = Pemesanan::with([
            'user',
            'paket',
            'latestPembayaran',
            'latestPembayaran',
            'jadwal.instruktur',
        ]);

        if ($statusPesanan) {
            if ($statusPesanan === 'belum membayar') {
                $base->whereDoesntHave('latestPembayaran', function ($sq) {
                    $sq->where('status', 'sudah membayar');
                });
            } elseif ($statusPesanan === 'sudah membayar') {
                $base->whereHas('latestPembayaran', function ($sq) {
                    $sq->where('status', 'sudah membayar');
                });
            }
        }

        if ($statusKursus) {
            $base->where('status_pemesanan', $statusKursus);
        }

        if ($paketId) {
            $base->where('id_paket', $paketId);
        }

        if ($q) {
            $base->whereHas('user', function ($uq) use ($q) {
                $uq->where('name', 'ilike', "%$q%")
                   ->orWhere('nomor_hp', 'ilike', "%$q%")
                   ->orWhere('email', 'ilike', "%$q%");
            });
        }

        $orders = $base->orderByDesc('id_pemesanan')->paginate(10)->withQueryString();

        $counts = [
            'belum_membayar' => Pemesanan::doesntHave('latestPembayaran', 'and', function ($sq) {
                $sq->where('status', 'sudah membayar');
            })->count(),
            'sudah_membayar' => Pemesanan::whereHas('latestPembayaran', function ($sq) {
                $sq->where('status', 'sudah membayar');
            })->count(),
            'on_going' => Pemesanan::where('status_pemesanan', 'on going')->count(),
            'finish' => Pemesanan::where('status_pemesanan', 'finish')->count(),
            'total' => Pemesanan::count(),
        ];

        $pakets = PaketKursus::orderBy('nama_paket')->get();

        return view('pesanan', [
            'orders' => $orders,
            'counts' => $counts,
            'pakets' => $pakets,
            'filters' => [
                'status_pesanan' => $statusPesanan,
                'status_kursus' => $statusKursus,
                'paket' => $paketId,
                'q' => $q,
            ],
        ]);
    }
}
