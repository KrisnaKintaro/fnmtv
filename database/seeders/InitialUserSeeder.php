<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data 3 akun utama dengan role berbeda
        $users = [
            [
                'username'          => 'admin_fnm',
                'email'             => 'admin@fnmtv.com',
                'password'          => Hash::make('password123'),
                'role'              => 'Admin',
                'status'            => 'Aktif',
                'email_verified_at' => now(),
            ],
            [
                'username'          => 'editor_fnm',
                'email'             => 'editor@fnmtv.com',
                'password'          => Hash::make('password123'),
                'role'              => 'Editor',
                'status'            => 'Aktif',
                'email_verified_at' => now(),
            ],
            [
                'username'          => 'redaksi_fnm',
                'email'             => 'redaksi@fnmtv.com',
                'password'          => Hash::make('password123'),
                'role'              => 'Redaksi',
                'status'            => 'Aktif',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            // Menggunakan updateOrCreatee berdasarkan email agar aman saat deploy berkali-kali
            User::updateOrCreate(
                ['email' => $userData['email']], // Kunci pengecekan unik
                $userData
            );
        }

        $this->command->info('Mantap cuy! 3 akun inti (Admin, Editor, Redaksi) berhasil di-init! 🚀');
    }
}
