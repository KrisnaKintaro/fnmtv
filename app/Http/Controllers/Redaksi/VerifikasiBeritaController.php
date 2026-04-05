<?php

namespace App\Http\Controllers\Redaksi;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class VerifikasiBeritaController extends Controller
{
    // List berita yang masuk (status Pending)
    public function index()
    {
        $data = Berita::where('status_berita', 'Pending')
                ->with(['user:id,username', 'kategori:id,nama_kategori'])
                ->get();
        return response()->json($data);
    }

    // Proses Verifikasi (ACC/Tolak)
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status_berita' => 'required|in:Published,Rejected',
        ]);

        $berita = Berita::findOrFail($id);
        
        $updateData = [
            'status_berita' => $request->status_berita
        ];

        // Jika dipublish, isi waktu publikasi
        if($request->status_berita == 'Published') {
            $updateData['waktu_publikasi'] = now();
        }

        $berita->update($updateData);

        return response()->json([
            'message' => 'Berita berhasil di ' . ($request->status_berita == 'Published' ? 'Terbitkan' : 'Tolak')
        ]);
    }
}