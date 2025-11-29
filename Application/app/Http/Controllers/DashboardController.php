<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\JadwalKursus;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return redirect()->route('login');
        }

        // Return view immediately, data will be fetched via AJAX
        return view('dashboard', [
            'stats' => [],
            'recent_orders' => []
        ]);
    }

    public function summary(Request $request)
    {
        $kursusId = $request->session()->get('kursus_id');
        if (!$kursusId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $pesananHariIni = Pemesanan::whereHas('paket', function ($q) use ($kursusId) {
            $q->where('id_kursus', $kursusId);
        })
            ->whereDate('tanggal_pemesanan', now())
            ->count();

        $totalPeserta = User::where('role', 'peserta')
            ->whereHas('pemesanan.paket', function ($q) use ($kursusId) {
                $q->where('id_kursus', $kursusId);
            })
            ->distinct('id')
            ->count();

        $jadwalAktif = JadwalKursus::whereHas('pemesanan.paket', function ($q) use ($kursusId) {
            $q->where('id_kursus', $kursusId);
        })
            ->where('status', 'belum dimulai')
            ->whereDate('tanggal', '>=', now())
            ->count();

        $recentOrders = Pemesanan::with(['user', 'paket', 'instruktur'])
            ->whereHas('paket', function ($q) use ($kursusId) {
                $q->where('id_kursus', $kursusId);
            })
            ->orderByDesc('id_pemesanan')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'user_name' => $order->user->name ?? 'Peserta',
                    'paket' => $order->paket->nama_paket ?? 'Paket Kursus',
                    'status' => $order->status_pemesanan,
                    'status_color' => $order->status_pemesanan === 'finish' ? '#10b981' : '#f59e0b',
                    'time_ago' => Carbon::parse($order->created_at)->diffForHumans(),
                ];
            });

        return response()->json([
            'stats' => [
                'pesanan_hari_ini' => $pesananHariIni,
                'total_peserta' => $totalPeserta,
                'jadwal_aktif' => $jadwalAktif,
            ],
            'recent_orders' => $recentOrders,
        ]);
    }
}
