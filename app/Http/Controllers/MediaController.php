<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // tampilkan halaman upload
    public function index()
    {
        return view('admin.upload');
    }



    // proses upload file
    public function store(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:51200',
                'tipe' => 'required|in:gambar,video',
            ]);

            dd($request->all(), $request->file('file'));

            $file = $request->file('file');

            $path = $file->store('uploads', 'public');

            dd($path);

            Media::create([
                'nama_file' => $file->getClientOriginalName(),
                'path' => $path,
                'tipe' => $request->tipe,
            ]);

            return back()->with('success', 'File berhasil diupload!');

        } catch (\Exception $e) {

            dd($e->getMessage(), $e->getTraceAsString());

        }
    }
}
