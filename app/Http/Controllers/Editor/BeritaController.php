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
        $data = Berita::with('kategori:id,nama_kategori')
            ->where('user_id', Auth::id() ?? 1)
            ->latest()
            ->get();
        return response()->json($data);
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
                'message' => 'Berita berhasil disimpan sebagai ' . $request->status_berita,
                'data' => $berita
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal simpan: ' . $e->getMessage()
            ], 500);
        }
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

            $berita = Berita::where('id', $id_berita)->where('user_id', Auth::id() ?? 1)->firstOrFail();

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

                $file = $request->file('foto_thumbnail');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('uploads/thumbnail'), $nama_file);

                $dataUpdate['foto_thumbnail'] = $nama_file;
            }

            $berita->update($dataUpdate);

            return response()->json(['message' => 'Data berita berhasil diperbarui.', 'data' => $berita]);
        } catch (\Exception $e) {
            // Balikin error asli biar lu bisa liat di Inspect Element -> Network
            return response()->json([
                'message' => 'Error Server: ' . $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function hapusDataBerita($id_berita)
    {
        try {
            // Cari berita milik user yang login (atau ID 1 buat testing)
            $berita = Berita::where('id', $id_berita)->where('user_id', Auth::id() ?? 1)->firstOrFail();

            // 1. Hapus file fisik foto thumbnail jika ada
            $pathFoto = public_path('uploads/thumbnail/' . $berita->foto_thumbnail);
            if (File::exists($pathFoto)) {
                File::delete($pathFoto);
            }

            // 2. Hapus data dari database (ini akan trigger SoftDeletes karena lu pake di Model)
            $berita->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berita berhasil dihapus permanen.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}

