<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Pengajuan;

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
        // Kode aslimu untuk Pagination Bootstrap
        Paginator::useBootstrapFive();

        // KODE BARU: Mengirim data jumlah antrean penyaluran ke seluruh Sidebar Admin
        View::composer('*', function ($view) {
            $jumlahAntrean = Pengajuan::where('status_verifikasi_admin', 'Layak')
                                      ->whereDoesntHave('penyaluran')
                                      ->count();

            $view->with('jumlahAntreanPenyaluran', $jumlahAntrean);
        });
    }
}