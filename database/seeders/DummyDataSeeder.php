<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Pendapatan;
use App\Models\Reaksi;
use App\Models\User;
use App\Models\ViewLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ==========================================
        // 1. BIKIN USER (2 Admin, 2 Redaksi, 2 Editor)
        // ==========================================
        $users = [];
        $roles = ['Admin', 'Redaksi', 'Editor'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 2; $i++) {
                $users[] = User::create([
                    'username' => strtolower($role) . $i,
                    'email' => strtolower($role) . $i . '@fnmtv.com',
                    'password' => Hash::make('password123'),
                    'role' => $role,
                    'status' => 'Aktif',
                ]);
            }
        }
        $editorIds = collect($users)->where('role', 'Editor')->pluck('id')->toArray();
        $allUserIds = collect($users)->pluck('id')->toArray();

        // ==========================================
        // 2. BIKIN 10 KATEGORI
        // ==========================================
        $kategoriList = ['Politik', 'Ekonomi', 'Olahraga', 'Teknologi', 'Kesehatan', 'Hiburan', 'Otomotif', 'Pendidikan', 'Kuliner', 'Lifestyle'];
        $kategoriIds = [];

        foreach ($kategoriList as $namaKategori) {
            $kategori = Kategori::create([
                'nama_kategori' => $namaKategori,
                'slug' => Str::slug($namaKategori),
            ]);
            $kategoriIds[] = $kategori->id;
        }

        // ==========================================
        // 3. BIKIN BERITA (5 tiap status per Kategori)
        // ==========================================
        $statusBeritaList = ['Pending', 'Published', 'Rejected'];
        $statusModerasiList = ['Pending', 'Approved', 'Spam'];
        $jenisReaksiList = ['suka', 'cinta', 'kaget', 'sedih', 'marah'];

        foreach ($kategoriIds as $kategoriId) {
            foreach ($statusBeritaList as $statusBerita) {
                for ($i = 0; $i < 5; $i++) {

                    $judul = $faker->realText(50);

                    $berita = Berita::create([
                        'user_id' => $faker->randomElement($editorIds),
                        'kategori_id' => $kategoriId,
                        'judul_berita' => $judul,
                        'slug' => Str::slug($judul) . '-' . Str::random(5),
                        'isi_berita' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>',
                        'foto_thumbnail' => 'default.jpg',
                        'status_berita' => $statusBerita,
                        'jumlah_view' => $faker->numberBetween(0, 5000),
                        'catatan_penolakan' => ($statusBerita === 'Rejected') ? 'Judul terlalu clickbait, mohon diperbaiki.' : null,
                        'waktu_publikasi' => ($statusBerita === 'Published') ? now()->subDays($faker->numberBetween(1, 30)) : null,
                    ]);

                    // ==========================================
                    // 4. BIKIN KOMENTAR (Udah pake user_id)
                    // ==========================================
                    foreach ($statusModerasiList as $statusKomen) {
                        for ($k = 0; $k < 5; $k++) {
                            Komentar::create([
                                'berita_id' => $berita->id,
                                'user_id' => $faker->randomElement($allUserIds), // 🔴 FIX: Pake random user_id
                                'isi_komentar' => $faker->sentence(10),
                                'status_moderasi' => $statusKomen,
                            ]);
                        }
                    }

                    // ==========================================
                    // 5. BIKIN REAKSI
                    // ==========================================
                    foreach ($jenisReaksiList as $jenisReaksi) {
                        for ($r = 0; $r < 5; $r++) {
                            Reaksi::create([
                                'berita_id' => $berita->id,
                                'user_id' => $faker->randomElement($allUserIds),
                                'jenis_reaksi' => $jenisReaksi,
                            ]);
                        }
                    }

                    // ==========================================
                    // 6. BIKIN PENDAPATAN
                    // ==========================================
                    if ($statusBerita === 'Published' || $faker->boolean(30)) {
                        Pendapatan::create([
                            'berita_id' => $berita->id,
                            'user_id' => $berita->user_id,
                            'nominal_pendapatan' => $faker->randomElement([0, 50000, 100000, 150000]),
                            'status_pembayaran' => $faker->randomElement(['Unpaid', 'Paid']),
                        ]);
                    }

                    // ==========================================
                    // 7. BIKIN VIEW LOG (Hapus user_agent)
                    // ==========================================
                    for ($v = 0; $v < 10; $v++) {
                        ViewLog::create([
                            'berita_id' => $berita->id,
                            'ip_address' => $faker->ipv4, // 🔴 FIX: Cuma masukin IP Address
                        ]);
                    }

                }
            }
        }

        $this->command->info('Mantap cuy! Dummy data lengkap berhasil di-generate! 🔥');
    }
}
