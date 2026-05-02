<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Playlist;
use Carbon\Carbon;

class CheckActivePlaylist
{
    public function handle($request, Closure $next)
    {
        // Cek playlist aktif dari database (bukan session)
        $today = Carbon::today();
        
        $activePlaylist = Playlist::where('status', 'aktif')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        if ($activePlaylist) {
            session(['last_playlist_id' => $activePlaylist->id]);
        } else {
            session()->forget('last_playlist_id');
        }
        
        return $next($request);
    }
}