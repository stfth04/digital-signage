// resources/js/admin.js

// ==================== UTILITY FUNCTIONS ====================

let activePlaylistId = null;
let previewIndex = 0;
let previewTimer = null;
let previewList = [];
let selectedPlaylistId = null;
let currentPcId = null;
let deleteId = null;

const VIDEO_EXT = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// ==================== TAB MANAGEMENT ====================

        // Tampilkan popup hapus
        function openHapus(id, name) {
            deleteId = id;

            document.getElementById("hapusText").innerText =
                `Yakin ingin menghapus playlist "${name}"?`;

            document.getElementById("popupHapus").classList.remove("d-none");
        }

        // Tutup popup hapus
        function closeHapus() {
            deleteId = null;
            document.getElementById("popupHapus").classList.add("d-none");
        }

        // Konfirmasi hapus
        function confirmHapus() {
            if (!deleteId) return;

            fetch(`/playlist/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(
                            `.playlist-card[data-id="${deleteId}"]`
                        );
                        if (card) card.remove();

                        closeHapus();
                        openTab('playlist');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err));
        }

        document
            .querySelector('#playlist')
            .addEventListener('click', function (e) {

                const card = e.target.closest('.playlist-card');
                if (!card) return;

                const playlistId = card.dataset.id;
                if (!playlistId) return;

                loadPlaylistDetail(playlistId);

                document.getElementById('playlist').classList.add('d-none');
                document.getElementById('playlistDetail').classList.remove('d-none');
            });

window.showTab = function (tabId, event) {
    if (event) event.preventDefault();

    // Sembunyikan semua tab
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));

    // Tampilkan tab yang dipilih
    const tab = document.getElementById(tabId);
    if (tab) tab.classList.remove('d-none');

    // Update active tab style
   // Update active tab style
document.querySelectorAll('.menu-link').forEach(a => {
    a.classList.remove(
        'fw-bold',
        'border-bottom',
        'border-3',
        'pb-1'
    );
});

if (event && event.target) {
    event.target.classList.add(
        'fw-bold',
        'border-bottom',
        'border-3',
        'pb-1'
    );
}

    // Khusus preview tab
    if (tabId === 'preview' && typeof window.loadActivePreview === 'function' && !window.skipAutoReload) {
        window.loadActivePreview();
    }

    console.log('Tab changed to:', tabId);
};

window.openTab = function (tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('d-none'));
    const tab = document.getElementById(tabId);
    if (tab) tab.classList.remove('d-none');
    console.log('Tab opened:', tabId);
};

// ==================== DATE TIME ====================

function updateDateTime() {
    const now = new Date();
    const utcHours = now.getUTCHours();
    const minutes = now.getUTCMinutes();
    const witaHours = (utcHours + 8) % 24;

    const hours = witaHours.toString().padStart(2, '0');
    const mins = minutes.toString().padStart(2, '0');

    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const dateString = now.toLocaleDateString('id-ID', options);

    const timeEl = document.getElementById('time');
    const dateEl = document.getElementById('date');
    if (timeEl) timeEl.textContent = `${hours}:${mins} WITA`;
    if (dateEl) dateEl.textContent = dateString;
}

// Jalankan update waktu
updateDateTime();
setInterval(updateDateTime, 1000);

// ==================== PLAYLIST MANAGEMENT ====================

window.loadPlaylistDetail = async function (playlistId) {
    activePlaylistId = playlistId;
    try {
        const res = await fetch(`/admin/playlist/${playlistId}/content`);
        if (!res.ok) throw new Error('Gagal mengambil data');

        const data = await res.json();
        const playlist = data.playlist;
        const items = data.contents;

        let rows = '';
        if (items.length === 0) {
            rows = `<p class="playlist-empty">Video atau Foto tidak ada</p>`;
        } else {
            rows = `
                <div class="table-container mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Urutan</th><th>Konten</th><th>Durasi</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            ${items.map((item, i) => {
                const isVideo = item.file && item.file.match(/\.(mp4|mov|avi|mkv|webm)$/i);
                const orientasi = (item.orientasi || 'Landscape').toLowerCase();
                const portraitClass = orientasi === 'portrait' ? 'is-portrait' : '';
                const preview = isVideo
                    ? `<video src="/storage/${item.file}" class="content-video ${portraitClass}"></video>`
                    : `<img src="/storage/${item.file}" class="content-thumbnail ${portraitClass}">`;

                return `
                                    <tr id="row-${item.pc_id}">
                                        <td>${i + 1}</td>
                                        <td>${preview}</td>
                                        <td>
                                            ${typeof item.duration === 'number' ? item.duration + 's' : '-'}
                                            ${item.jenis === 'Gambar' ? `
                                                <button class="btn-edit-duration"
                                                    onclick="openDurationModal(${item.pc_id}, ${item.duration ?? 5})">
                                                    ✎
                                                </button>
                                            ` : ''}
                                        </td>
                                        <td>
                                            <button class="btn-aksi text-danger" onclick="hapusKonten(${item.pc_id})">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                `;
            }).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        }

        const detailContent = document.getElementById('playlistDetailContent');
        if (detailContent) {
            // HAPUS event listener lama dengan membuat HTML baru
            detailContent.innerHTML = `
                <div class="playlist-header" style="position:relative;">
                    <img src="/logoback.png" class="btn-back" onclick="openTab('playlist')" />

<div class="playlist-text">
    <h2 class="playlisttitle">${escapeHtml(playlist.nama_playlist)}</h2>

    <div class="playlist-date">
        ${formatTanggalHtml(playlist)}
    </div>
</div>
                    <div class="item-box ms-auto">
                        <img src="/logotitik3.png" class="icon-more" onclick="toggleMenu(this)" />
                        <div class="more-menu d-none">
                            <div class="more-item" onclick="openJadwal(${playlist.id})">Jadwal</div>
                            <div class="more-item" onclick="openHapus(${playlist.id}, '${escapeHtml(playlist.nama_playlist)}')">
                                Hapus Playlist
                            </div>
                            <div class="more-item" onclick="openGanti(${playlist.id}, '${escapeHtml(playlist.nama_playlist)}')">
                                Ganti Nama
                            </div>
                        </div>
                    </div>
                </div>
                ${rows}
            `;
        }
    } catch (err) {
        console.error(err);
        alert('Gagal memuat playlist');
    }
};

function formatTanggalHtml(playlist) {
    if (playlist.tanggal_mulai && playlist.tanggal_selesai) {
        return `
            📅 <strong>${formatTanggal(playlist.tanggal_mulai)}</strong> &nbsp;—&nbsp; 
            <strong>${formatTanggal(playlist.tanggal_selesai)}</strong>
            <span style="margin-left:10px; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:600;
                background:${playlist.status === 'aktif' ? '#d4edda' : '#f8d7da'};
                color:${playlist.status === 'aktif' ? '#155724' : '#721c24'};">
                ${playlist.status === 'aktif' ? '● Aktif' : '● Nonaktif'}
            </span>
        `;
    }
    return `
        <span style="color:#aaa; font-style:italic;">Belum ada jadwal</span>
        <span style="margin-left:10px; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:600;
            background:${playlist.status === 'aktif' ? '#d4edda' : '#f8d7da'};
            color:${playlist.status === 'aktif' ? '#155724' : '#721c24'};">
            ${playlist.status === 'aktif' ? '● Aktif' : '● Nonaktif'}
        </span>
    `;
}

window.formatTanggal = function (dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
};

window.escapeHtml = function (unsafe) {
    if (!unsafe) return '';
    return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
};

// ==================== PLAYLIST CRUD ====================

window.openJadwal = function (playlistId) {
    const jadwalId = document.getElementById('jadwalPlaylistId');
    const tglMulai = document.getElementById('tglMulai');
    const tglSelesai = document.getElementById('tglSelesai');
    const popup = document.getElementById('popupJadwal');

    if (jadwalId) jadwalId.value = playlistId;
    if (tglMulai) tglMulai.value = '';
    if (tglSelesai) tglSelesai.value = '';
    if (popup) popup.classList.remove('d-none');
};

window.closeJadwal = function () {
    const popup = document.getElementById("popupJadwal");
    const jadwalId = document.getElementById('jadwalPlaylistId');
    const tglMulai = document.getElementById('tglMulai');
    const tglSelesai = document.getElementById('tglSelesai');

    if (popup) popup.classList.add("d-none");
    if (jadwalId) jadwalId.value = '';
    if (tglMulai) tglMulai.value = '';
    if (tglSelesai) tglSelesai.value = '';
};

window.saveJadwal = function () {
    const playlistId = document.getElementById('jadwalPlaylistId')?.value;
    const tanggalMulai = document.getElementById('tglMulai')?.value;
    const tanggalSelesai = document.getElementById('tglSelesai')?.value;

    if (!playlistId) {
        alert('Playlist tidak ditemukan!');
        return;
    }
    if (!tanggalMulai || !tanggalSelesai) {
        alert('Tanggal mulai dan selesai wajib diisi!');
        return;
    }

    fetch('/playlist/set-jadwal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ playlist_id: playlistId, tanggal_mulai: tanggalMulai, tanggal_selesai: tanggalSelesai })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Jadwal berhasil disimpan!');
                window.closeJadwal();
            } else {
                alert('Gagal: ' + (data.message ?? 'Unknown error'));
            }
        })
        .catch(() => alert('Terjadi kesalahan koneksi.'));
};

window.openGanti = function (id, nama) {
    console.log('openGanti dipanggil dengan id:', id, 'nama:', nama);

    // CEK apakah popup sudah terbuka
    const popup = document.getElementById("popupGanti");
    if (popup && !popup.classList.contains('d-none')) {
        console.log('Popup sudah terbuka, tidak membuka lagi');
        return;
    }

    activePlaylistId = id;
    const namaBaru = document.getElementById("namaBaru");

    if (namaBaru) {
        namaBaru.value = nama;
        console.log('Nama diisi:', nama);
    } else {
        console.error('Element namaBaru tidak ditemukan');
    }

    if (popup) {
        popup.classList.remove("d-none");
        console.log('Popup dibuka');
    } else {
        console.error('Element popupGanti tidak ditemukan');
    }
};

window.closeGanti = function () {
    console.log('closeGanti dipanggil');
    const popup = document.getElementById("popupGanti");
    const namaBaru = document.getElementById("namaBaru");
    if (popup) popup.classList.add("d-none");
    if (namaBaru) namaBaru.value = '';
    activePlaylistId = null;
};

window.saveGanti = function () {
    console.log('saveGanti dipanggil, activePlaylistId:', activePlaylistId);
    let nama = document.getElementById("namaBaru")?.value.trim();
    console.log('Nama baru:', nama);

    if (nama === "" || !activePlaylistId) {
        alert('Nama playlist tidak boleh kosong!');
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log('Mengirim request ke /playlist/update-name');

    fetch("/playlist/update-name", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({
            id: activePlaylistId,
            nama_playlist: nama
        })
    })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Nama playlist berhasil diubah!');
                // Reload ulang detail playlist
                if (activePlaylistId) {
                    window.loadPlaylistDetail(activePlaylistId);
                }
                window.closeGanti();
            } else {
                alert('Gagal mengubah nama: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan: ' + err.message);
        });
};

window.closeGanti = function () {
    const popup = document.getElementById("popupGanti");
    const namaBaru = document.getElementById("namaBaru");
    if (popup) popup.classList.add("d-none");
    if (namaBaru) namaBaru.value = '';
    activePlaylistId = null;
};

window.saveGanti = function () {
    let nama = document.getElementById("namaBaru")?.value.trim();
    if (nama === "" || !activePlaylistId) return;

    fetch("/playlist/update-name", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: activePlaylistId, nama_playlist: nama })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
            window.closeGanti();
        })
        .catch(err => console.error(err));
};

window.openHapus = function (id, name) {
    deleteId = id;
    const hapusText = document.getElementById("hapusText");
    const popup = document.getElementById("popupHapus");
    if (hapusText) hapusText.innerText = `Yakin ingin menghapus playlist "${name}"?`;
    if (popup) popup.classList.remove("d-none");
};

window.closeHapus = function () {
    const popup = document.getElementById("popupHapus");
    if (popup) popup.classList.add("d-none");
    deleteId = null;
};

window.confirmHapus = function () {
    if (!deleteId) return;

    fetch(`/playlist/${deleteId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const card = document.querySelector(`.playlist-card[data-id="${deleteId}"]`);
                if (card) card.remove();
                window.closeHapus();
                window.openTab('playlist');
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
};

// ==================== PREVIEW FUNCTIONS ====================

window.loadActivePreview = async function () {
    const previewPlayer = document.getElementById('previewPlayer');
    if (!previewPlayer) return;

    try {
        // UBAH dari '/api/active-playlist' menjadi '/active-playlist'
        const response = await fetch('/active-playlist');  // ← PERBAIKI INI
        const data = await response.json();
        const playlistId = data.playlist_id;

        if (!playlistId) {
            previewPlayer.innerHTML = '<span style="color:#aaa">Tidak ada playlist aktif</span>';
            return;
        }

        const res = await fetch(`/admin/playlist/${playlistId}/content`);
        const playlistData = await res.json();

        if (window.skipAutoReload) return;

        previewList = playlistData.contents || [];
        previewIndex = 0;

        if (!previewList.length) {
            previewPlayer.innerHTML = '<span style="color:#aaa">Playlist kosong</span>';
            return;
        }

        window.playPreview();
    } catch (error) {
        console.error('Gagal mengambil playlist aktif:', error);
        if (previewPlayer) {
            previewPlayer.innerHTML = '<span style="color:#aaa">Tidak ada playlist aktif</span>';
        }
    }
};

window.playPreview = function () {
    clearTimeout(previewTimer);
    if (!previewList.length) return;

    const item = previewList[previewIndex];
    const orientasi = (item.orientasi || 'Landscape').toLowerCase();
    const previewPlayer = document.getElementById('previewPlayer');

    if (previewPlayer) {
        previewPlayer.className = 'preview-player mode-' + orientasi + '-preview';
        previewPlayer.innerHTML = '';

        const file = `/storage/${item.file}`;
        const ext = file.split('.').pop().toLowerCase();

        if (VIDEO_EXT.includes(ext)) {
            const video = document.createElement('video');
            video.src = file;
            video.autoplay = true;
            video.muted = false;
            video.controls = true;
            video.style.maxWidth = '100%';
            video.style.maxHeight = '100%';
            video.onended = nextPreview;
            previewPlayer.appendChild(video);
            return;
        }

        if (IMAGE_EXT.includes(ext)) {
            const img = document.createElement('img');
            img.src = file;
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            previewPlayer.appendChild(img);

            const dur = item.duration && item.duration > 0 ? item.duration : 5;
            previewTimer = setTimeout(nextPreview, dur * 1000);
        }
    }
};

function nextPreview() {
    if (previewList.length === 0) return;
    previewIndex++;
    if (previewIndex >= previewList.length) previewIndex = 0;
    window.playPreview();
}

window.playSingleItem = function (filePath, orientasi) {
    window.skipAutoReload = true;
    window.showTab('preview', null);

    previewList = [{ file: filePath, orientasi: orientasi || 'Landscape', duration: 10 }];
    previewIndex = 0;
    window.playPreview();

    setTimeout(() => { window.skipAutoReload = false; }, 1000);
};

// ==================== DURATION MODAL ====================

window.openDurationModal = function (pcId, currentDuration) {
    currentPcId = pcId;
    const durationInput = document.getElementById('durationInput');
    const modal = document.getElementById('durationModal');
    if (durationInput) durationInput.value = currentDuration || 5;
    if (modal) modal.classList.remove('d-none');
};

window.closeDurationModal = function () {
    const modal = document.getElementById('durationModal');
    if (modal) modal.classList.add('d-none');
    currentPcId = null;
};

window.saveDuration = async function () {
    const duration = document.getElementById('durationInput')?.value;
    if (!duration || duration <= 0) {
        alert('Durasi tidak valid');
        return;
    }

    try {
        const res = await fetch(`/admin/playlist-content/${currentPcId}/duration`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ duration: parseInt(duration) })
        });

        if (!res.ok) throw new Error();

        window.closeDurationModal();
        if (activePlaylistId) window.loadPlaylistDetail(activePlaylistId);
    } catch {
        alert('Gagal menyimpan durasi');
    }
};

// ==================== PLAYLIST CONTENT MANAGEMENT ====================

window.hapusKonten = function (pc_id) {
    if (!confirm('Hapus konten ini dari playlist?')) return;

    fetch(`/playlist-content/${pc_id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                const row = document.getElementById(`row-${pc_id}`);
                if (row) row.remove();
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan');
            console.error(err);
        });
};

// ==================== POPUP PLAYLIST SELECT ====================

window.selectPlaylist = function (id, el) {
    selectedPlaylistId = id;
    document.querySelectorAll('#popupPilihPlaylist .playlist-card')
        .forEach(card => card.classList.remove('selected-playlist'));
    el.classList.add('selected-playlist');
    console.log('Playlist dipilih:', selectedPlaylistId);
};

window.openPopupPlaylist = function () {
    const popup = document.getElementById('popupPilihPlaylist');
    if (popup) popup.classList.remove('d-none');
};

window.closePopupPlaylist = function () {
    const popup = document.getElementById('popupPilihPlaylist');
    if (popup) {
        popup.style.animation = 'fadeIn 0.3s ease reverse';
        setTimeout(() => {
            popup.classList.add('d-none');
            popup.style.animation = '';
        }, 200);
    }
};

window.submitAddToPlaylist = function () {
    const playlistId = selectedPlaylistId;
    const kontenId = window.selectedKontenId;

    if (!playlistId || !kontenId) {
        alert("Silakan pilih playlist dan konten terlebih dahulu!");
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/playlist-content-add', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ playlist_id: playlistId, konten_id: kontenId })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Konten berhasil ditambahkan ke playlist!');
                window.closePopupPlaylist();
                if (activePlaylistId) window.loadPlaylistDetail(activePlaylistId);
            } else {
                alert(data.error || 'Gagal menambahkan konten');
            }
        })
        .catch(err => alert('Terjadi kesalahan: ' + err.message));
};

// ==================== UTILITIES ====================

window.toggleMenu = function (el) {
    document.querySelectorAll('.more-menu').forEach(menu => {
        if (menu !== el.parentElement.querySelector('.more-menu')) {
            menu.classList.add('d-none');
        }
    });
    const target = el.parentElement.querySelector('.more-menu');
    if (target) target.classList.toggle('d-none');
};

window.closePopupAddPlaylist = function () {
    const popup = document.getElementById('popupPlaylist');
    if (popup) popup.classList.add('d-none');
};

// ==================== EVENT LISTENERS ====================

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM loaded, initializing admin.js');

    // Update hidden input for playlist form
    const formPlaylist = document.getElementById('formPlaylist');
    if (formPlaylist) {
        formPlaylist.addEventListener('submit', function (e) {
            const title = document.getElementById('playlistTitle')?.value.trim();
            if (!title) {
                e.preventDefault();
                alert('Masukkan judul playlist.');
                return false;
            }
            const judulInput = document.getElementById('judul_playlist');
            if (judulInput) judulInput.value = title;
        });
    }

    // Upload area
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

    if (uploadArea && fileInput) {
        uploadArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const previewImg = document.getElementById('previewImage');
                const previewVid = document.getElementById('previewVideo');
                const textContainer = document.getElementById('uploadTextContainer');
                const iconArea = document.getElementById('iconArea');

                if (iconArea) iconArea.style.display = 'none';
                if (textContainer) textContainer.style.display = 'none';

                if (file.type.startsWith('image/')) {
                    if (previewVid) previewVid.style.display = 'none';
                    if (previewImg) {
                        previewImg.style.display = 'block';
                        previewImg.src = e.target.result;
                    }

                    const tempImg = new Image();
                    tempImg.src = e.target.result;
                    tempImg.onload = function () {
                        const resolusiInput = document.getElementById('resolusi');
                        if (resolusiInput) resolusiInput.value = this.width + 'x' + this.height;
                    };
                } else if (file.type.startsWith('video/')) {
                    if (previewImg) previewImg.style.display = 'none';
                    if (previewVid) {
                        previewVid.style.display = 'block';
                        previewVid.src = e.target.result;
                        previewVid.controls = true;
                        previewVid.onloadedmetadata = function () {
                            const resolusiInput = document.getElementById('resolusi');
                            if (resolusiInput) resolusiInput.value = this.videoWidth + 'x' + this.videoHeight;
                        };
                        previewVid.load();
                    }
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // Playlist card click
    const playlistContainer = document.getElementById('playlistListMain');
    if (playlistContainer) {
        playlistContainer.addEventListener('click', function (e) {
            const card = e.target.closest('.playlist-card');
            if (!card) return;
            const playlistId = card.dataset.id;
            if (playlistId) {
                window.loadPlaylistDetail(playlistId);
                const playlistTab = document.getElementById('playlist');
                const detailTab = document.getElementById('playlistDetail');
                if (playlistTab) playlistTab.classList.add('d-none');
                if (detailTab) detailTab.classList.remove('d-none');
            }
        });
    }

    // Add playlist button
    const btnAddPlaylist = document.querySelector('.btn-add-playlist');
    const popupPlaylist = document.getElementById('popupPlaylist');
    if (btnAddPlaylist && popupPlaylist) {
        btnAddPlaylist.addEventListener('click', () => popupPlaylist.classList.remove('d-none'));
    }

    // Close menus when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.item-box')) {
            document.querySelectorAll('.more-menu').forEach(menu => {
                menu.classList.add('d-none');
            });
        }
    });

    // Keyboard support for popup
    document.addEventListener('keydown', function (e) {
        const popup = document.getElementById('popupPilihPlaylist');
        if (popup && !popup.classList.contains('d-none')) {
            if (e.key === 'Escape') window.closePopupPlaylist();
            if (e.key === 'Enter' && document.querySelector('.selected-playlist')) {
                window.submitAddToPlaylist();
            }
        }
    });

    console.log('Admin.js initialized successfully');
});