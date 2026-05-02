<?php
// app/Console/Commands/UpdateStatusPlaylist.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Playlist;
use Carbon\Carbon;

class UpdateStatusPlaylist extends Command
{
    protected $signature = 'playlist:update-status';
    protected $description = 'Aktifkan atau nonaktifkan playlist berdasarkan tanggal jadwal';

    public function handle()
    {
        $today = Carbon::today();

        // Aktifkan yang jadwalnya tiba (kecuali yang sedang aktif diputar)
        $diaktifkan = Playlist::where('status', 'nonaktif')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->update(['status' => 'aktif']);

        // Nonaktifkan yang jadwalnya sudah lewat
        // KECUALI jika tanggal_selesai & tanggal_mulai NULL (diputar manual tanpa jadwal)
        $dinonaktifkan = Playlist::where('status', 'aktif')
            ->whereNotNull('tanggal_selesai')        // ← jangan sentuh yang tanpa jadwal
            ->where('tanggal_selesai', '<', $today)
            ->update(['status' => 'nonaktif']);

        $this->info("✅ Diaktifkan: {$diaktifkan} playlist");
        $this->info("🔴 Dinonaktifkan: {$dinonaktifkan} playlist");

        return 0;
    }
}