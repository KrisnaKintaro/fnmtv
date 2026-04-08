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
            // Kalau di-acc, bersihin catatan penolakan lama biar gak nyangkut
            $updateData['catatan_penolakan'] = null;
        } else if ($request->status_berita == 'Rejected') {
            // Nah, ini kuncinya! Ambil dari request AJAX tadi
            $updateData['catatan_penolakan'] = $request->catatan_penolakan;
            $updateData['waktu_publikasi'] = null;
        }

        $berita->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Status berita berhasil diperbarui menjadi ' . $request->status_berita,
            'data' => [
                'id' => $berita->id,
                'status_berita' => $berita->status_berita,
                'waktu_publikasi' => $berita->waktu_publikasi,
                'catatan_penolakan' => $berita->catatan_penolakan // Balikin juga datanya biar JS bisa baca
            ]
        ], 200);
    }

    public function getNotifikasi()
    {
        // Cari semua berita yang statusnya masih 'Pending'
        // Kita join (with) relasi user biar bisa nampilin nama Editornya
        $beritaPending = Berita::with('user')
            ->where('status_berita', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Format datanya biar sesuai sama ekspektasi SmartNotif.js
        $notifData = $beritaPending->map(function ($berita) {
            return [
                'id' => $berita->id,
                'type' => 'pending',
                'icon' => '📋',
                'title' => 'Perlu Ditinjau: ' . ($berita->user->username ?? 'Editor'),
                'message' => 'Artikel "' . $berita->judul_berita . '" menunggu persetujuan.',
                'time' => $berita->created_at->diffForHumans(), // Pake Carbon biar jadi "5 menit lalu"
            ];
        });

        // Return dalam bentuk JSON
        return response()->json([
            'status' => 'success',
            'data' => $notifData
        ]);
    }
}
