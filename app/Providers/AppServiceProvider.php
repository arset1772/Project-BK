<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use App\Models\Guru;

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
        // Paksa HTTPS di production / Railway agar terhindar dari mixed content & blokir Safari iOS/macOS
        if (app()->environment('production') || str_starts_with(config('app.url'), 'https://') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }

        // Bagikan data Guru BK untuk konsultasi ke semua view blade
        View::composer('*', function ($view) {
            $defaultNama = 'Ahmad Julio Fikri';
            $defaultTelepon = '0819-5249-9521';

            $guru = null;
            try {
                if (Schema::hasTable('gurus')) {
                    $guru = Guru::first();
                }
            } catch (\Throwable $e) {
                $guru = null;
            }

            $namaGuru = ($guru && !empty($guru->nama) && $guru->nama !== 'Guru BK') ? $guru->nama : $defaultNama;
            $teleponGuru = ($guru && !empty($guru->no_telepon)) ? $guru->no_telepon : $defaultTelepon;

            $rawNumber = preg_replace('/[^0-9]/', '', $teleponGuru);
            $waNumber = str_starts_with($rawNumber, '0') ? ('62' . substr($rawNumber, 1)) : $rawNumber;

            $view->with('guruKonsul', [
                'nama'       => $namaGuru,
                'telepon'    => $teleponGuru,
                'wa_number'  => $waNumber,
                'wa_link'    => "https://wa.me/{$waNumber}?text=" . urlencode("Halo Bapak {$namaGuru}, saya ingin berkonsultasi mengenai bimbingan konseling."),
            ]);
        });
    }
}
