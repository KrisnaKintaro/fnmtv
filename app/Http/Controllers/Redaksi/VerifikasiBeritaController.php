<?php

namespace App\Http\Controllers\Redaksi;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class VerifikasiBeritaController extends Controller
{
    // List berita yang masuk (status Pending)
    public function getBeritaMasuk()
    {
        $data = Berita::where('status_berita', 'Pending')
                ->with(['user:id,username', 'kategori:id,nama_kategori'])
                ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar antrean verifikasi berita.',
            'data' => $data
        ], 200);
    }

    // Proses Verifikasi (ACC/Tolak)
    public function verifikasiBerita(Request $request, $id)
    {
        $request->validate([
            'status_berita' => 'required|in:Published,Rejected',
        ]);

        $berita = Berita::findOrFail($id);

        // --- LOGIKA OTOMATISASI PENDAPATAN (Revisi Krisna) ---
        if ($request->status_berita === 'Published') {
            // Skenario 1: Redaksi ACC Berita -> Buat Tagihan Otomatis
            Pendapatan::firstOrCreate(
                ['berita_id' => $berita->id], 
                [
                    'user_id' => $berita->user_id, // Editor yang punya berita
                    'nominal_pendapatan' => 0,     
                    'status_pembayaran' => 'Unpaid' 
                ]
            );
        } else {
            // Skenario 2: Redaksi Nolak Berita (Atau batalin Publish)
            $pendapatan = Pendapatan::where('berita_id', $berita->id)->first();

            if ($pendapatan) {
                if ($pendapatan->status_pembayaran === 'Paid') {
                    // Mencegah Redaksi mereject berita yang sudah cair duitnya
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Berita ini sudah lunas dibayar oleh Admin, tidak bisa di-reject atau ditarik!'
                    ], 403);
                } else {
                    // Kalau masih Unpaid, hapus tagihannya
                    $pendapatan->delete();
                }
            }
        }
        // --- END LOGIKA PENDAPATAN ---

        $updateData = [
            'status_berita' => $request->status_berita
        ];

        if ($request->status_berita == 'Published') {
            $updateData['waktu_publikasi'] = now();
        }

        $berita->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Status berita berhasil diperbarui menjadi ' . $request->status_berita,
            'data' => [
                'id' => $berita->id,
                'status_berita' => $berita->status_berita,
                'waktu_publikasi' => $berita->waktu_publikasi
            ]
        ], 200);
    }
}