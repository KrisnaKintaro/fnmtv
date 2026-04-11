<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getDaftarPengguna()
    {
        $pengguna = User::latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar pengguna',
            'data' => $pengguna
        ]);
    }

    public function tambahPenggunaBaru(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Redaksi,Editor,Viewer'
        ], [
            'email.unique' => 'Email ini sudah dipakai cuy, gunakan email lain.',
            'role.in'      => 'Role tidak valid!'
        ]);

        $penggunaBaru = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Akun ' . $request->role . ' berhasil dibuat!',
            'data' => $penggunaBaru
        ]);
    }

    public function ubahDataPengguna(Request $request, $id_user)
    {
        $pengguna = User::find($id_user);

        if (!$pengguna) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan!'], 404);
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id_user, // Boleh email sama asal punya dia sendiri
            'role'     => 'required|in:Admin,Redaksi,Editor,Viewer'
        ]);

        $pengguna->username = $request->username;
        $pengguna->email    = $request->email;
        $pengguna->role     = $request->role;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pengguna berhasil diubah!',
            'data' => $pengguna
        ]);
    }

    public function hapusPengguna($id_user)
    {
        $pengguna = User::find($id_user);

        if (!$pengguna) {
            return response()->json(['status' => 'error', 'message' => 'User gagal dihapus!'], 404);
        }

        if (Auth::id() == $id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lu gak bisa hapus akun lu sendiri cuy!'
            ], 403);
        }

        $pengguna->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil dihapus permanen!'
        ]);
    }

    public function ubahStatusUser(Request $request, $idUser)
    {
        $user = User::find($idUser);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User nggak ketemu cuy!'], 404);
        }

        // Lu gak boleh nonaktifin akun lu sendiri pas lagi login
        if (Auth::id() == $idUser && $request->status == 'Nonaktif') {
            return response()->json([
                'status' => 'error',
                'message' => 'Masa lu mau matiin akun sendiri? Gak bisa gitu cuy!'
            ], 403);
        }

        $user->status = $request->status; // 'Aktif' atau 'Nonaktif'
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status ' . $user->username . ' sekarang ' . $user->status . '!',
            'data' => $user
        ]);
    }
}
