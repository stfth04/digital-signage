<div id="kelola" class="tab-content d-none">
    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-bordered table-sm text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Konten</th>
                        <th>Jenis Konten</th>
                        <th>Resolusi</th>
                        <th>Orientasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($konten as $item)
                        <tr>
                            <td class="fw-bold text-secondary">{{ $loop->iteration }}</td>
                            <td class="text-start">
                                <div class="d-flex align-items-center gap-3">
                                    @php
                                        $ext = strtolower(pathinfo($item->file ?? '', PATHINFO_EXTENSION));
                                    @endphp
                                    @if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']))
                                        <video src="{{ asset('storage/' . $item->file) }}" 
                                               class="content-video {{ strtolower($item->orientasi) == 'portrait' ? 'is-portrait' : '' }}"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $item->file) }}" 
                                             class="content-thumbnail {{ strtolower($item->orientasi) == 'portrait' ? 'is-portrait' : '' }}">
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->nama_file }}</div>
                                        <small class="text-muted">{{ basename($item->file) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-kind {{ $item->jenis == 'Video' ? 'badge-video' : 'badge-image' }}">
                                    {{ $item->jenis }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-kind badge-res">{{ $item->resolusi ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge-kind badge-orient">{{ $item->orientasi ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                            onclick="window.selectedKontenId={{ $item->id }}; openPopupPlaylist();">
                                        + Playlist
                                    </button>
                                    <form action="{{ route('contents.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus konten ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>