<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function getDaftarKategori()
    {
        $kategori = Kategori::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar kategori',
            'data' => $kategori
        ]);
    }

    public function tambahKategoriBaru(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi cuy!',
            'nama_kategori.unique' => 'Kategori ini udah ada, bikin yang lain dong.'
        ]);

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

        $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori,' . $id_kategori
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
