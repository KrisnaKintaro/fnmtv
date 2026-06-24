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
            ->where('user_id', Auth::id())
            //->where('status_berita', '!=', 'Published')
            ->latest()
            ->get();
        return response()->json($data);
    }

    // Tambah Berita Baru
    public function tambahBeritaBaru(Request $request)
    {
        // Kalau ini gagal, kodingan di bawahnya nggak bakal dijalanin
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_berita' => 'required|string|max:255',
            'isi_berita' => 'required',
            'foto_thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'jenis_berita' => 'required|in:reguler,feature',
            'harga_berita' => 'required_if:jenis_berita,feature|nullable|numeric',
            'bukti_pembayaran' => 'required_if:jenis_berita,feature|nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ]);

       try {
            // Upload Foto Thumbnail
            $file = $request->file('foto_thumbnail');
            $nama_file = time() . "_" . $file->hashName();
            $file->move(public_path('uploads/thumbnail'), $nama_file);

            // --- UPLOAD BUKTI PEMBAYARAN (Jika Ada) ---
            $nama_bukti = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $fileBukti = $request->file('bukti_pembayaran');
                $nama_bukti = time() . "_bukti_" . $fileBukti->hashName();
                $fileBukti->move(public_path('uploads/bukti_pembayaran'), $nama_bukti);
            }

            $berita = Berita::create([
                'user_id' => Auth::id(),
                'kategori_id' => $request->kategori_id,
                'judul_berita' => $request->judul_berita,
                'slug' => $request->slug ?? Str::slug($request->judul_berita) . '-' . time(),
                'isi_berita' => clean($request->isi_berita),
                'foto_thumbnail' => $nama_file,
                'status_berita' => $request->status_berita ?? 'Draft',
                'jumlah_view' => 0,
                'jenis_berita' => $request->jenis_berita,
                'harga_berita' => $request->harga_berita,
                'bukti_pembayaran' => $nama_bukti
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
            $request->validate([
                'kategori_id' => 'nullable|exists:kategoris,id',
                'foto_thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                // --- VALIDASI BARU ---
                'jenis_berita' => 'nullable|in:reguler,feature',
                'harga_berita' => 'nullable|numeric',
                'bukti_pembayaran' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
            ]);

            $berita = Berita::where('id', $id_berita)->where('user_id', Auth::id())->firstOrFail();

            if (!in_array($berita->status_berita, ['Draft', 'Rejected'])) {
                return response()->json(['message' => 'Berita tidak bisa diubah'], 403);
            }

            $dataUpdate = [
                'judul_berita' => $request->judul_berita ?? $berita->judul_berita,
                'isi_berita'   => $request->isi_berita ?? clean($berita->isi_berita),
                'kategori_id'  => $request->kategori_id ?? $berita->kategori_id,
                'slug'         => $request->judul_berita ? Str::slug($request->judul_berita) . '-' . time() : $berita->slug,
                'status_berita' => $request->status_berita ?? $berita->status_berita,
                // --- UPDATE DATA BARU ---
                'jenis_berita' => $request->jenis_berita ?? $berita->jenis_berita,
                'harga_berita' => $request->has('harga_berita') ? $request->harga_berita : $berita->harga_berita,
            ];

            // Update Thumbnail
            if ($request->hasFile('foto_thumbnail')) {
                $pathFotoLama = public_path('uploads/thumbnail/' . $berita->foto_thumbnail);
                if (File::exists($pathFotoLama)) {
                    File::delete($pathFotoLama);
                }
                $file = $request->file('foto_thumbnail');
                $nama_file = time() . "_" . $file->hashName();
                $file->move(public_path('uploads/thumbnail'), $nama_file);
                $dataUpdate['foto_thumbnail'] = $nama_file;
            }

            // --- UPDATE BUKTI PEMBAYARAN ---
            if ($request->hasFile('bukti_pembayaran')) {
                if ($berita->bukti_pembayaran) {
                    $pathBuktiLama = public_path('uploads/bukti_pembayaran/' . $berita->bukti_pembayaran);
                    if (File::exists($pathBuktiLama)) {
                        File::delete($pathBuktiLama);
                    }
                }
                $fileBukti = $request->file('bukti_pembayaran');
                $nama_bukti = time() . "_bukti_" . $fileBukti->hashName();
                $fileBukti->move(public_path('uploads/bukti_pembayaran'), $nama_bukti);
                $dataUpdate['bukti_pembayaran'] = $nama_bukti;
            }

            $berita->update($dataUpdate);

            return response()->json(['message' => 'Data berita berhasil diperbarui.', 'data' => $berita]);

        } catch (\Exception $e) {
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
            $berita = Berita::where('id', $id_berita)->where('user_id', Auth::id())->firstOrFail();

            // 1. Hapus file fisik foto thumbnail jika ada
            // $pathFoto = public_path('uploads/thumbnail/' . $berita->foto_thumbnail);
            // if (File::exists($pathFoto)) {
            //     File::delete($pathFoto);
            // }

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

    public function ambilNotifikasi()
    {
        $userId = Auth::id(); // Ambil ID Editor yang login

        // 1. Ambil data REJECTED (Selama statusnya masih Rejected, tampilin terus)
        $rejectedNotif = Berita::where('user_id', $userId)
            ->where('status_berita', 'Rejected')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 2. Ambil data PUBLISHED (Maksimal 1 hari setelah updated_at/publish)
        $publishedNotif = Berita::where('user_id', $userId)
            ->where('status_berita', 'Published')
            ->where('updated_at', '>=', now()->subDay()) // Filter 24 jam terakhir
            ->orderBy('updated_at', 'desc')
            ->get();

        // Gabungin datanya
        $allNotif = $rejectedNotif->merge($publishedNotif)->sortByDesc('updated_at')->values();

        $data = $allNotif->map(function ($item) {
            $isRejected = $item->status_berita === 'Rejected';

            return [
                'id'      => $item->id,
                'type'    => $isRejected ? 'rejected' : 'published',
                'icon'    => $isRejected ? '⚠️' : '🎉',
                'title'   => $isRejected ? 'Artikel Ditolak' : 'Artikel Terbit',
                'message' => $isRejected
                    ? "Berita '<strong>{$item->judul_berita}</strong>' dikembalikan. Klik buat benerin cuy!"
                    : "Hore! Berita '<strong>{$item->judul_berita}</strong>' sudah tayang di publik.",
                'time'    => $item->updated_at->diffForHumans(),
                'status'  => $item->status_berita
            ];
        });

        return response()->json([
            'status' => 'success',
            'count'  => $data->count(),
            'data'   => $data
        ]);
    }
}
