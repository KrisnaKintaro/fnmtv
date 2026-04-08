<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class TrackingPembayaranController extends Controller
{
    public function getDaftarPembayaran()
    {
        $pendapatan = Pendapatan::with(['berita:id,judul_berita', 'user:id,username'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data tracking pembayaran',
            'data' => $pendapatan
        ]);
    }

    public function updatePembayaran(Request $request, $berita_id)
    {
        $request->validate([
            'nominal_pendapatan' => 'required|numeric|min:0',
            'status_pembayaran'  => 'required|in:Paid,Unpaid'
        ], [
            'nominal_pendapatan.required' => 'Nominal pendapatan wajib diisi cuy!',
            'nominal_pendapatan.numeric'  => 'Nominal harus berupa angka!',
            'status_pembayaran.in'        => 'Status transaksi hanya boleh Paid atau Unpaid!'
        ]);

        $berita = Berita::find($berita_id);

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan!'
            ], 404);
        }

        $pendapatan = Pendapatan::updateOrCreate(
            ['berita_id' => $berita_id],
            [
                'user_id'            => $berita->user_id,
                'nominal_pendapatan' => $request->nominal_pendapatan,
                'status_pembayaran'  => $request->status_pembayaran,
                'waktu_pembayaran'   => $request->status_pembayaran === 'Paid' ? now() : null
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Tracking pembayaran berhasil diperbarui menjadi ' . $request->status_pembayaran,
            'data' => $pendapatan
        ]);
    }
}
