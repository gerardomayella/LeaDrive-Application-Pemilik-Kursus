<?php

namespace App\Providers;

use App\Models\Kursus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.topbar', function ($view) {
            $kursusId = session('kursus_id');
            $kursusNama = session('kursus_nama');
            $kursusFoto = session('kursus_foto');

            if ($kursusId && (!$kursusNama || !$kursusFoto)) {
                $kursus = Kursus::find($kursusId);
                if ($kursus) {
                    $kursusNama = $kursusNama ?: ($kursus->nama_kursus ?? 'Pemilik Kursus');
                    $kursusFoto = $kursusFoto ?: $kursus->foto_profil;
                    session()->put([
                        'kursus_nama' => $kursusNama,
                        'kursus_foto' => $kursusFoto,
                    ]);
                }
            }

            $view->with([
                'topbarNama' => $kursusNama ?? session('kursus_nama', 'Pemilik Kursus'),
                'topbarFoto' => $kursusFoto ?? session('kursus_foto'),
            ]);
        });
    }
}
