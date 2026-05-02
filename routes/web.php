<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PlaylistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [PlaylistController::class, 'root']);
Route::get('/play/{playlist}', [PlaylistController::class, 'play'])
    ->name('playlist.play');

// stop playlist diputar
Route::post('/stop-playlist', function () {
    $lastId = session('last_playlist_id');

    // Nonaktifkan playlist yang sedang diputar
    if ($lastId) {
        \Illuminate\Support\Facades\DB::table('playlists')
            ->where('id', $lastId)
            ->update(['status' => 'nonaktif', 'updated_at' => now()]);
    }

    session()->forget('last_playlist_id');
    return response()->json(['success' => true]);
});

// LOGIN
Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// HALAMAN ADMIN (WAJIB LOGIN)
Route::get('/admin', [ContentController::class, 'index'])
    ->middleware('auth')
    ->name('admin');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// UPLOAD KONTEN (dipanggil dari form di admin.blade)
Route::post('/upload', [ContentController::class, 'store'])->name('upload.store');

// HAPUS KONTEN
Route::delete('/contents/{id}', [ContentController::class, 'destroy'])
    ->name('contents.destroy');

// PLAYLIST: index (menampilkan halaman admin juga bisa pakai controller ini jika perlu)
Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');

// Buat playlist baru
Route::post('/playlist/store', [PlaylistController::class, 'store'])->name('playlist.store');

// API: ambil detail playlist (dipanggil oleh JS loadPlaylistDetail)
Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('playlist.show');

// Ajax update nama playlist
Route::post('/playlist/update-name', [PlaylistController::class, 'updateName'])->name('playlist.updateName');


Route::delete('/playlist/{id}', [PlaylistController::class, 'destroy'])->name('playlist.destroy');

Route::get('/admin/playlist/{id}/content', [PlaylistController::class, 'getContent']);

// Tambah konten ke playlist (form hidden)
Route::post('/playlist-content-add', [PlaylistController::class, 'addContent'])->name('playlist.addContent');

// Hapus konten dari playlist
Route::delete('/playlist-content/{id}', [PlaylistController::class, 'deleteContent'])
    ->name('playlist.content.delete');

// Update urutan dan durasi konten dalam playlist
Route::put(
    '/admin/playlist-content/{id}/duration',
    [PlaylistController::class, 'updateDuration']
);

Route::post('/playlist/set-jadwal', [PlaylistController::class, 'setJadwal']);

// API untuk mendapatkan playlist aktif
Route::get('/active-playlist', function () {

    $today = now()->toDateString();

    $activePlaylist = \App\Models\Playlist::where('status', 'aktif')
        ->whereDate('tanggal_mulai', '<=', $today)
        ->whereDate('tanggal_selesai', '>=', $today)
        ->first();

    return response()->json([
        'playlist_id' => $activePlaylist?->id,
        'playlist_name' => $activePlaylist?->nama_playlist
    ]);

});

