{{-- Popup Jadwal --}}
<div class="popup-jadwal d-none" id="popupJadwal">
    <div class="jadwal-box">
        <h3 class="jadwal-title">Jadwal</h3>
        <input type="hidden" id="jadwalPlaylistId">
        <div class="jadwal-row">
            <div class="jadwal-col">
                <label>Mulai</label>
                <div class="jadwal-input">
                    <input type="date" id="tglMulai" name="tanggal_mulai">
                </div>
            </div>
            <div class="jadwal-col">
                <label>Selesai</label>
                <div class="jadwal-input">
                    <input type="date" id="tglSelesai" name="tanggal_selesai">
                </div>
            </div>
        </div>
        <div class="jadwal-actions">
            <button class="btn-cancel" onclick="closeJadwal()">Batal</button>
            <button class="btn-save" onclick="saveJadwal()">Simpan</button>
        </div>
    </div>
</div>

{{-- Popup Hapus Playlist --}}
<div class="popup-hapus d-none" id="popupHapus">
    <div class="hapus-box">
        <h3 class="hapus-title">Hapus Playlist</h3>
        <p id="hapusText" class="hapus-text">Yakin ingin menghapus playlist?</p>
        <div class="hapus-actions">
            <button class="btn-hapus-cancel" onclick="closeHapus()">TIDAK</button>
            <button class="btn-hapus-yes" onclick="confirmHapus()">YA</button>
        </div>
    </div>
</div>

{{-- Popup Ganti Nama --}}
<div class="popup-ganti d-none" id="popupGanti">
    <div class="popup-box">
        <h3>Ganti Nama Playlist</h3>
        <input type="text" id="namaBaru" class="form-control" placeholder="Masukkan nama playlist">
        <div class="d-flex gap-2 mt-3">
            <button onclick="closeGanti()" class="btn btn-secondary w-100">Batal</button>
            <button onclick="saveGanti()" class="btn btn-primary w-100">Simpan</button>
        </div>
    </div>
</div>

{{-- Popup Pilih Playlist --}}
<div id="popupPilihPlaylist" class="d-none">
    <div class="popup-box">
        <h3>Pilih Playlist</h3>
        <div id="playlistList" class="d-flex flex-wrap gap-3 mt-3">
            @foreach ($playlists as $playlist)
                <div class="playlist-card" data-id="{{ $playlist->id }}" onclick="selectPlaylist({{ $playlist->id }}, this)">
                    <div class="playlist-thumb">
                        @if (isset($playlist->thumbnail) && $playlist->thumbnail)
                            <img src="{{ $playlist->thumbnail }}" alt="{{ $playlist->nama_playlist }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                        @else
                            {{ substr($playlist->nama_playlist, 0, 1) }}
                        @endif
                    </div>
                    <div class="playlist-info">
                        <p class="playlist-title">{{ $playlist->nama_playlist }}</p>
                        @if (isset($playlist->jumlah_content))
                            <small style="color:#7f8c8d;font-size:12px;">{{ $playlist->jumlah_content }} konten</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="popup-actions mt-3">
            <button onclick="submitAddToPlaylist()" id="submitBtn">TAMBAH KE PLAYLIST</button>
            <button onclick="closePopupPlaylist()">BATAL</button>
        </div>
    </div>
</div>

{{-- Modal Durasi --}}
<div id="durationModal" class="modal-custom d-none">
    <div class="modal-box">
        <div class="modal-header">
            <h4>Atur Durasi Konten</h4>
            <button class="modal-close" onclick="closeDurationModal()">×</button>
        </div>
        <div class="modal-body">
            <label class="label">Durasi (detik)</label>
            <input type="number" id="durationInput" min="1" class="input-duration" placeholder="Contoh: 10">
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDurationModal()">Batal</button>
            <button class="btn-save" onclick="saveDuration()">Simpan</button>
        </div>
    </div>
</div>