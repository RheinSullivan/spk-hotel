<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        DB::table('users')->delete();
        DB::table('hotels')->delete();
        DB::table('kriteria')->delete();
        DB::table('bobot_kriteria')->delete();
        DB::table('penilaian')->delete();
        DB::table('hasil')->delete();

        // Admin User
        DB::table('users')->insert([
            [
                'nama' => 'Admin',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => Hash::make('1234'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'User Penilai',
                'email' => 'user@example.com',
                'username' => 'user1',
                'password' => Hash::make('1234'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Hotels
        DB::table('hotels')->insert([
            [
                'nama_hotel' => 'PD Hidayat (Persero) Tbk',
                'alamat' => 'Jalan Rumah Sakit No. 055, Padang Sidempuan',
                'rating' => 3.7,
                'fasilitas' => 'saepe, sunt, repellat, illo',
                'harga' => 755593.98,
                'deskripsi' => 'Porro ipsum esse beatae repudiandae. Velit ut quis dicta doloremque libero.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hotel' => 'CV Putra (Persero) Tbk',
                'alamat' => 'Gang Erlangga No. 3, Solok',
                'rating' => 3.6,
                'fasilitas' => 'quam, perspiciatis, minus, sunt',
                'harga' => 1420576.45,
                'deskripsi' => 'Cupiditate nesciunt modi iste voluptatibus impedit.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_hotel' => 'UD Widiastuti Tbk',
                'alamat' => 'Jalan Surapati No. 5, Tangerang Selatan',
                'rating' => 4.8,
                'fasilitas' => 'aperiam, quasi, fugiat, consectetur',
                'harga' => 718362.60,
                'deskripsi' => 'Reiciendis nam nihil debitis iste illum quaerat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Kriteria
        DB::table('kriteria')->insert([
            ['nama_kriteria' => 'Harga', 'sifat_kriteria' => 'cost', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Rating', 'sifat_kriteria' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kriteria' => 'Fasilitas', 'sifat_kriteria' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Bobot Kriteria
        DB::table('bobot_kriteria')->insert([
            ['id_kriteria' => 1, 'bobot' => 0.4, 'created_at' => now(), 'updated_at' => now()],
            ['id_kriteria' => 2, 'bobot' => 0.35, 'created_at' => now(), 'updated_at' => now()],
            ['id_kriteria' => 3, 'bobot' => 0.25, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
