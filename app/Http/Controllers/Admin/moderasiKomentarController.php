<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;

class moderasiKomentarController extends Controller
{
    public function getDaftarKomentar(Request $request)
    {
        $query = Komentar::with('berita', 'user')->latest();

        if ($request->has('status')) {
            $query->where('status_moderasi', $request->status);
        }

        $komentar = $query->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar komentar',
            'data' => $komentar
        ]);
    }

    public function ubahStatusModerasi(Request $request, $id_komentar)
    {
        $komentar = Komentar::find($id_komentar);

        if (!$komentar) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komentar tidak ditemukan!'
            ], 404);
        }

        $request->validate([
            'status_moderasi' => 'required|in:Pending,Approved,Spam'
        ], [
            'status_moderasi.required' => 'Status moderasi wajib diisi cuy!',
            'status_moderasi.in' => 'Status tidak valid! Hanya boleh Pending, Approved, atau Spam.'
        ]);

        $komentar->status_moderasi = $request->status_moderasi;
        $komentar->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Mantap, status komentar berhasil diubah menjadi ' . $request->status_moderasi,
            'data' => $komentar
        ]);
    }

    public function hapusKomentar($id_komentar)
    {
        $komentar = Komentar::find($id_komentar);

        if (!$komentar) {
            return response()->json([
                'status' => 'error',
                'message' => 'Komentar gagal dihapus karena tidak ditemukan!'
            ], 404);
        }

        $komentar->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Komentar pelanggaran/spam berhasil dihapus permanen!'
        ]);
    }
}
