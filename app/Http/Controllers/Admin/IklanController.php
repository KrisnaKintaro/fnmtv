<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class IklanController extends Controller
{
    /**
     * Ambil semua data iklan untuk tabel admin
     */
    public function getDaftarIklan()
    {
        $data = Iklan::with('user')->latest()->get();
        return response()->json($data);
    }

    /**
     * Tambah Iklan Baru
     */
    public function tambahIklan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'posisi' => 'required|in:horizontal_728x90,sidebar_300x250',
            'link_tujuan' => 'nullable|url',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Proses Upload Gambar
        $path = $request->file('gambar')->store('iklan', 'public');

        $iklan = Iklan::create([
            'dibuat_oleh' => Auth::id(),
            'judul' => $request->judul,
            'gambar' => $path,
            'posisi' => $request->posisi,
            'link_tujuan' => $request->link_tujuan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => true,
        ]);

        return response()->json(['message' => 'Iklan berhasil ditambahkan!', 'data' => $iklan]);
    }

    /**
     * Update Data Iklan
     */
    public function ubahIklan(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'posisi' => 'required|in:horizontal_728x90,sidebar_300x250',
            'link_tujuan' => 'nullable|url',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            Storage::disk('public')->delete($iklan->gambar);
            // Simpan gambar baru
            $iklan->gambar = $request->file('gambar')->store('iklan', 'public');
        }

        $iklan->update([
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'link_tujuan' => $request->link_tujuan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return response()->json(['message' => 'Iklan berhasil diperbarui!']);
    }

    /**
     * Hapus Iklan
     */
    public function hapusIklan($id)
    {
        $iklan = Iklan::findOrFail($id);
        
        // Hapus file gambarnya juga agar tidak memenuhi storage
        Storage::disk('public')->delete($iklan->gambar);
        $iklan->delete();

        return response()->json(['message' => 'Iklan telah dihapus!']);
    }

    /**
     * Toggle Status Aktif/Nonaktif (Quick Action)
     */
    public function ubahStatusIklan($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->is_active = !$iklan->is_active;
        $iklan->save();

        return response()->json(['message' => 'Status iklan berhasil diubah!']);
    }

    /**
     * Ambil iklan aktif untuk ditampilkan di frontend viewers
     * Format dikelompokkan per posisi agar JS bisa baca langsung
     */
    public function getIklanAktif()
    {
        $now = now()->toDateString();

        $data = Iklan::where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_mulai')
                    ->orWhere('tanggal_mulai', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $now);
            })
            ->get();

        // Kelompokkan per posisi agar JS bisa langsung akses per slot
        $grouped = $data->groupBy('posisi');

        return response()->json([
            'status' => 'success',
            'data'   => [
                'horizontal_728x90' => $grouped->get('horizontal_728x90', collect())->values(),
                'sidebar_300x250'   => $grouped->get('sidebar_300x250', collect())->values(),
            ]
        ]);
    }
}