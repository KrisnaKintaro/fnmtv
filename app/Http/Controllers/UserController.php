<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getDataUser(){
        $dataUsers = User::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data User Berhasil Diambil',
            'data' => $dataUsers
        ]);
    }

    public function insertDataUser(Request $request)
    {
        // Validasi standar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $userBaru = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'viewer'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User baru berhasil dibuat!',
            'data' => $userBaru
        ]);
    }

    public function updateDataUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User yang mau di-update nggak ada!'
            ], 404);
        }

        // Cek kalau ada request password, berarti mau ganti password juga
        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        // Update data lainnya
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->role = $request->role ?? $user->role;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Mantap, data user berhasil di-update!',
            'data' => $user
        ]);
    }

    // 5. DELETE (Hapus data)
    public function hapusDataUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User nggak ketemu, gagal dihapus!'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data user sukses dihapus selamanya!'
        ]);
    }
}
