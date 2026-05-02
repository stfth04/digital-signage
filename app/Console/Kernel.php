<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Update status playlist setiap jam berdasarkan jadwal
        $schedule->call(function () {
            $today = \Carbon\Carbon::today();

            // Aktifkan playlist yang jadwalnya mulai hari ini
            \App\Models\Playlist::where('status', 'nonaktif')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->update(['status' => 'aktif']);

            // Nonaktifkan playlist yang jadwalnya sudah berakhir
            \App\Models\Playlist::where('status', 'aktif')
                ->where('tanggal_selesai', '<', $today)
                ->update(['status' => 'nonaktif']);
        })->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
