<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'contents';

    protected $fillable = [
        'nama_file',
        'file',
        'jenis',
        'resolusi',
        'orientasi'
    ];

    public function playlists()
    {
        return $this->belongsToMany(
            Playlist::class,
            'playlist_content',
            'content_id',
            'playlist_id'
        )
            ->using(PlaylistContent::class)
            ->withPivot(['order', 'duration']);
    }
}