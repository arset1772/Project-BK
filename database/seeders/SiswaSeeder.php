<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Seed data siswa contoh untuk testing.
     */
    public function run(): void
    {
        $data = [
            [
                'nama'             => 'Andi Pratama',
                'nisn'             => '0012345678',
                'kelas'            => 'XI-IPA-1',
                'kluster'          => 'Sains & Teknologi',
                'pilihan_terkunci' => 'Teknik Informatika & Robotik',
                'status'           => 'Terverifikasi',
            ],
            [
                'nama'             => 'Siti Rahayu',
                'nisn'             => '0023456789',
                'kelas'            => 'XI-IPS-1',
                'kluster'          => 'Sosial & Bisnis',
                'pilihan_terkunci' => 'Psikologi & Manajemen Bisnis',
                'status'           => 'Terverifikasi',
            ],
            [
                'nama'             => 'Budi Santoso',
                'nisn'             => '0034567890',
                'kelas'            => 'X-1',
                'kluster'          => null,
                'pilihan_terkunci' => null,
                'status'           => 'Belum Asesmen',
            ],
            [
                'nama'             => 'Dewi Anggraini',
                'nisn'             => '0045678901',
                'kelas'            => 'XII-IPA-1',
                'kluster'          => 'Seni & Kreatif',
                'pilihan_terkunci' => 'Desain Komunikasi Visual (DKV) & Seni',
                'status'           => 'Terverifikasi',
            ],
            [
                'nama'             => 'Fajar Nugroho',
                'nisn'             => '0056789012',
                'kelas'            => 'X-2',
                'kluster'          => null,
                'pilihan_terkunci' => null,
                'status'           => 'Belum Asesmen',
            ],
        ];

        foreach ($data as $row) {
            Siswa::firstOrCreate(['nisn' => $row['nisn']], $row);
        }
    }
}
