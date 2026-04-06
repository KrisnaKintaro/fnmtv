<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // Tampilkan berita milik editor yang login
    public function getDaftarBerita()
    {
        $data = Berita::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar berita editor.',
            'data' => $data,
        ], 200);
    }

    // Tambah Berita Baru
    public function tambahBeritaBaru(Request $request)
    {
        // 1. Validasi di LUAR try-catch biar Laravel otomatis ngirim error 422 (Unprocessable Entity)
        // Kalau ini gagal, kodingan di bawahnya nggak bakal dijalanin
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_berita' => 'required|string|max:255',
            'isi_berita' => 'required',
            'foto_thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 2. Baru pake try-catch buat urusan database & file
        try {
            // Upload Foto Thumbnail
            $file = $request->file('foto_thumbnail');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnail'), $nama_file);

            $berita = Berita::create([
                'user_id' => Auth::id() ?? 1,
                'kategori_id' => $request->kategori_id,
                'judul_berita' => $request->judul_berita,
                'slug' => $request->slug ?? Str::slug($request->judul_berita) . '-' . time(),
                'isi_berita' => $request->isi_berita,
                'foto_thumbnail' => $nama_file,
                'status_berita' => $request->status_berita ?? 'Draft',
                'jumlah_view' => 0
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil disimpan sebagai Draft.',
            'data' => $berita,
        ], 201);
    }

    // Update Berita (Hanya jika status Draft atau Rejected)
    public function ubahDataBerita(Request $request, $id_berita)
    {
        try {
            // 1. Validasi ringan dulu
            $request->validate([
                'kategori_id' => 'nullable|exists:kategoris,id',
                'foto_thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);

        if (!in_array($berita->status_berita, ['Draft', 'Rejected'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita yang sudah diproses tidak bisa diubah.',
            ], 403);
        }

            if (!in_array($berita->status_berita, ['Draft', 'Rejected'])) {
                return response()->json(['message' => 'Berita tidak bisa diubah'], 403);
            }

            $dataUpdate = [
                'judul_berita' => $request->judul_berita ?? $berita->judul_berita,
                'isi_berita'   => $request->isi_berita ?? $berita->isi_berita,
                'kategori_id'  => $request->kategori_id ?? $berita->kategori_id,
                'slug'         => $request->judul_berita ? Str::slug($request->judul_berita) . '-' . time() : $berita->slug
            ];

            if ($request->hasFile('foto_thumbnail')) {
                $pathFotoLama = public_path('uploads/thumbnail/' . $berita->foto_thumbnail);
                if (File::exists($pathFotoLama)) {
                    File::delete($pathFotoLama);
                }

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil diupdate.',
            'data' => $berita,
        ], 200);
    }

    public function hapusDataBerita($id_berita)
    {
        try {
            // Cari berita milik user yang login (atau ID 1 buat testing)
            $berita = Berita::where('id', $id_berita)->where('user_id', Auth::id() ?? 1)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil diajukan ke Redaksi.',
            'data' => [
                'id' => $berita->id,
                'status_berita' => $berita->status_berita,
            ],
        ], 200);
    }
}
