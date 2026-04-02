<?php

namespace App\Http\Controllers\Admin\AdministrasiFinansial;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanFinansialController extends Controller
{
    public function getLaporan(Request $request)
    {
        $query = Pendapatan::with(['berita:id,judul_berita', 'user:id,username'])
            ->where('status_pembayaran', 'Paid');

        if ($request->filter === 'semua') {

        } elseif ($request->filled('tahun') && !$request->filled('bulan')) {
            $query->whereYear('waktu_pembayaran', $request->tahun);

        } elseif ($request->filled('tahun') && $request->filled('bulan')) {
            $query->whereYear('waktu_pembayaran', $request->tahun)
                  ->whereMonth('waktu_pembayaran', $request->bulan);

        } else {
            $query->whereYear('waktu_pembayaran', Carbon::now()->year)
                  ->whereMonth('waktu_pembayaran', Carbon::now()->month);
        }

        $laporan = $query->latest('waktu_pembayaran')->get();

        $totalPendapatan = $laporan->sum('nominal_pendapatan');

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data laporan finansial',
            'data' => [
                'total_pendapatan' => $totalPendapatan, 
                'rincian_data' => $laporan
            ]
        ]);
    }
}
