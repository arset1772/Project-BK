<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gurus')->updateOrInsert(
            ['username' => 'gurubk'],
            [
                'nama'       => 'Ahmad Julio Fikri',
                'username'   => 'gurubk',
                'password'   => 'BK-756', // password plain text sesuai permintaan
                'no_telepon' => '0819-5249-9521',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
