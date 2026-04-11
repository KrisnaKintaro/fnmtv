<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // buat modifikasi validasi unique

class KategoriController extends Controller
{
    public function getDaftarKategori()
    {
        // Pake withCount('berita') biar dapet field 'berita_count' otomatis
        $kategori = Kategori::withCount('berita')->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar kategori',
            'data' => $kategori
        ]);
    }

    public function tambahKategoriBaru(Request $request)
    {
        // Ubah aturan unique biar cuma ngecek data yang masih aktif (deleted_at = null)
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                Rule::unique('kategoris', 'nama_kategori')->whereNull('deleted_at')
            ]
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi cuy!',
            'nama_kategori.unique' => 'Kategori ini udah ada dan masih aktif, bikin yang lain dong.'
        ]);

        // Cari kategori di "tong sampah" (Soft Deleted)
        $kategoriTerhapus = Kategori::onlyTrashed()
                            ->where('nama_kategori', $request->nama_kategori)
                            ->first();

        // Kalau ternyata ada di tong sampah, kita Edo Tensei (bangkitkan)!
        if ($kategoriTerhapus) {
            $kategoriTerhapus->restore();

            // Jaga-jaga kalau admin nginput huruf besar-kecilnya beda, kita update slug-nya juga
            $kategoriTerhapus->update([
                'slug' => Str::slug($request->nama_kategori)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori lama yang sempat dihapus berhasil diaktifkan kembali!',
                'data' => $kategoriTerhapus
            ]);
        }

        // Kalau beneran data murni baru, eksekusi seperti biasa
        $slugOtomatis = Str::slug($request->nama_kategori);

        $kategoriBaru = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => $slugOtomatis
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mantap, Kategori baru berhasil ditambahkan!',
            'data' => $kategoriBaru
        ]);
    }

    public function ubahDataKategori(Request $request, $id_kategori)
    {
        $kategori = Kategori::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori tidak ditemukan!'
            ], 404);
        }

        // Biar pas di-edit nggak tabrakan sama yang di tong sampah
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                Rule::unique('kategoris', 'nama_kategori')
                    ->ignore($id_kategori)
                    ->whereNull('deleted_at')
            ]
        ]);

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->slug = Str::slug($request->nama_kategori);
        $kategori->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil diubah!',
            'data' => $kategori
        ]);
    }

    public function hapusKategori($id_kategori)
    {
        $kategori = Kategori::find($id_kategori);

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kategori gagal dihapus karena tidak ditemukan!'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus!'
        ]);
    }
}
