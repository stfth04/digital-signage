<?php

namespace App\Http\Controllers;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Content; // pakai ini kalau mau model

class ContentController extends Controller
{
public function index()
{

    $konten = DB::table('contents')->orderBy('id','asc')->get();

    // ⬇️ Tambahan penting
    $playlists = DB::table('playlists')->orderBy('id','desc')->get();

    return view('admin.admin', compact('konten','playlists'));

}

public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:20480'
    ]);

    $file = $request->file('file');

    // Nama file dari input user (tanpa ekstensi)
    $nama_file = $request->nama_file;

    // Ambil ekstensi asli
    $extension = $file->getClientOriginalExtension();

    // Nama file yang akan disimpan ke STORAGE (pakai timestamp agar unik)
    $finalName = $nama_file . '_' . time() . '.' . $extension;

    // Simpan file
    $path = $file->storeAs('uploads', $finalName, 'public');

    // Tentukan jenis konten
    $mime = $file->getMimeType();
    $jenis = str_contains($mime, 'image') ? 'Gambar' : 'Video';

    // Simpan data ke database
    DB::table('contents')->insert([
        'file'       => $path,
        'nama_file'  => $nama_file, // nama yg ditampilkan
        'jenis'      => $jenis,
        'resolusi'   => $request->resolusi,
        'orientasi'  => $request->orientasi,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin')->with('success', 'Upload berhasil!');
}

    public function destroy($id)
{
    $item = Content::findOrFail($id);

    // Hapus file fisik hanya jika tidak ada konten lain yang menggunakan file yang sama
    $isUsedByOthers = Content::where('file', $item->file)->where('id', '!=', $item->id)->exists();

    if (!$isUsedByOthers && $item->file && Storage::disk('public')->exists($item->file)) {
        Storage::disk('public')->delete($item->file);
    }

    // Hapus database
    $item->delete();

    return back()
        ->with('success', 'Konten berhasil dihapus')
        ->with('show_tab', 'kelola');
}

}
