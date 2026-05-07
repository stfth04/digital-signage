<div id="upload" class="tab-content">
    <div class="container mt-4">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-start">
                <div class="col-md-7 upload-section">
                    <h5 class="mb-4"><strong>Upload File</strong></h5>
                    <div class="upload-area d-flex flex-column align-items-center justify-content-center" id="uploadArea">
                        <div class="icon-upload" id="iconArea">
                            <img src="{{ asset('icon.png') }}" alt="Upload Icon" width="80" style="opacity: 0.6;">
                        </div>
                        <div id="uploadTextContainer">
                            <p id="uploadText" class="mb-1 font-weight-600">Klik atau seret file ke area ini</p>
                            <p class="text-muted small">Mendukung format Gambar dan Video</p>
                        </div>
                        <img id="previewImage" src="" alt="" style="display:none; max-width: 100%; max-height: 300px; object-fit: contain; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                        <video id="previewVideo" controls style="display:none; max-width: 100%; max-height: 300px; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></video>
                        <input type="file" name="file" id="fileInput" hidden accept="image/*,video/*">
                    </div>
                </div>

                <div class="col-md-5 ps-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h6 class="mb-4 text-primary"><strong>Properti Konten</strong></h6>
                        <div class="mb-3">
                            <label for="nama_file" class="form-label text-secondary small fw-bold">NAMA FILE</label>
                            <input type="text" id="nama_file" name="nama_file" class="form-control" placeholder="Masukkan judul konten" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="resolusi" class="form-label text-secondary small fw-bold">RESOLUSI</label>
                                <input type="text" id="resolusi" name="resolusi" class="form-control" placeholder="Otomatis terdeteksi" readonly>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="orientasi" class="form-label text-secondary small fw-bold">ORIENTASI</label>
                                <select id="orientasi" name="orientasi" class="form-select">
                                    <option>Landscape</option>
                                    <option>Portrait</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" onclick="window.location.href='?tab=kelola'" class="btn btn-custom flex-fill rounded-pill py-2 fw-bold shadow-sm">Batal</button>
                            <button type="submit" class="btn btn-custom flex-fill rounded-pill py-2 fw-bold shadow-sm">Simpan Konten</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>