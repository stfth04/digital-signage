<div id="playlist" class="tab-content d-none">
    <div class="playlist-btn-wrapper">
        <button class="btn-add-playlist">+ Playlist</button>
    </div>

    <div id="playlistListMain" class="d-flex flex-wrap gap-3 mt-3">
        @foreach ($playlists as $playlist)
            <div class="playlist-card" data-id="{{ $playlist->id }}">
                <div class="playlist-thumb">
                    @if (!empty($playlist->thumb_auto))
                        <img src="{{ asset($playlist->thumb_auto) }}" alt="{{ $playlist->nama_playlist }}" class="playlist-thumb-img">
                    @else
                        <div class="playlist-thumb-empty">{{ strtoupper(substr($playlist->nama_playlist, 0, 1)) }}</div>
                    @endif
                </div>
                <div class="playlist-info">
                    <div class="playlist-title">{{ $playlist->nama_playlist }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="popupPlaylist" class="popup-playlist-overlay d-none">
        <div class="popup-playlist-box">
            <h3 class="popup-title">Beri nama playlist</h3>
            <input type="text" id="playlistTitle" class="popup-input" placeholder="Judul">
            <form action="{{ route('playlist.store') }}" method="POST" id="formPlaylist">
                @csrf
                <input type="hidden" id="judul_playlist" name="judul">
                <button type="button" class="btn-buat-playlist" onclick="closePopupAddPlaylist()">BATAL</button>
                <button type="submit" class="btn-buat-playlist">BUAT</button>
            </form>
        </div>
    </div>
</div>