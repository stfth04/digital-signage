<?php
// app/Models/Playlist.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_playlist',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function contents()
    {
        return $this->belongsToMany(
            Content::class,
            'playlist_content',
            'playlist_id',
            'content_id'
        )
            ->using(PlaylistContent::class)
            ->withPivot(['order', 'duration'])
            ->orderByPivot('order');
    }

    // Scope: hanya playlist yang sedang aktif hari ini
    public function scopeAktifHariIni($query)
    {
        $today = Carbon::today();
        return $query->where('status', 'aktif')
                     ->where('tanggal_mulai', '<=', $today)
                     ->where('tanggal_selesai', '>=', $today);
    }
}