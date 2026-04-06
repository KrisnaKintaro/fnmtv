<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // Tampilkan berita milik editor yang login
    public function index()
    {
        $data = Berita::where('user_id', Auth::id())->get();
        return response()->json($data);
    }

    // Tambah Berita Baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_berita' => 'required|string|max:255',
            'isi_berita' => 'required',
            'foto_thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Upload Foto Thumbnail
        $file = $request->file('foto_thumbnail');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('uploads/thumbnail'), $nama_file);

        $berita = Berita::create([
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'judul_berita' => $request->judul_berita,
            'slug' => Str::slug($request->judul_berita) . '-' . time(),
            'isi_berita' => $request->isi_berita,
            'foto_thumbnail' => $nama_file,
            'status_berita' => 'Draft',
            'jumlah_view' => 0
        ]);

        return response()->json(['message' => 'Berita berhasil disimpan sebagai Draft', 'data' => $berita]);
    }

    // Update Berita (Hanya jika status Draft atau Rejected)
    public function update(Request $request, $id)
    {
        $berita = Berita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (!in_array($berita->status_berita, ['Draft', 'Rejected'])) {
            return response()->json(['message' => 'Berita yang sudah diproses tidak bisa diubah'], 403);
        }

        $berita->update([
            'judul_berita' => $request->judul_berita ?? $berita->judul_berita,
            'isi_berita' => $request->isi_berita ?? $berita->isi_berita,
            'kategori_id' => $request->kategori_id ?? $berita->kategori_id,
            'slug' => $request->judul_berita ? Str::slug($request->judul_berita) . '-' . time() : $berita->slug
        ]);

        return response()->json(['message' => 'Berita berhasil diupdate', 'data' => $berita]);
    }

    // Kirim ke Redaksi
    public function ajukan($id)
    {
        $berita = Berita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $berita->update(['status_berita' => 'Pending']);

        return response()->json(['message' => 'Berita berhasil diajukan ke Redaksi']);
    }
}