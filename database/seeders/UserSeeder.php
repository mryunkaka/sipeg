<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ===============================
        // Owner
        // ===============================
        DB::table('users')->updateOrInsert(
            ['email' => 'owner@example.com'], // unique key
            [
                'name'              => 'John Doe',
                'password'          => Hash::make('password123'),
                'role'              => 'owner',
                'no_hp'             => '081234567890',
                'alamat'            => 'Jl. Raya Batulicin, Kp. Baru, Kec. Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72271',
                'foto'              => null,
                'tanggal_lahir'     => '1980-01-01',
                'tempat_lahir'      => 'Batulicin',
                'jenis_kelamin'     => 'Laki-laki',
                'agama'             => 'Islam',
                'status_perkawinan' => 'Menikah',
                'nik'               => '1234567890123456',
                'npwp'              => '1234567890',
                'jabatan'           => 'Owner',
                'unit_id'           => 1, // fixed
                'tanggal_bergabung' => '2020-01-01',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        );

        // ===============================
        // Admin / Personalia
        // ===============================
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password123'),
                'role'              => 'owner', // ubah jika perlu
                'no_hp'             => '081234567891',
                'alamat'            => 'Jl. Raya Batulicin, Kp. Baru, Kec. Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72271',
                'foto'              => null,
                'tanggal_lahir'     => '1990-05-10',
                'tempat_lahir'      => 'Kotabaru',
                'jenis_kelamin'     => 'Perempuan',
                'agama'             => 'Kristen',
                'status_perkawinan' => 'Belum Menikah',
                'nik'               => '1234567890123457',
                'npwp'              => '1234567891',
                'jabatan'           => 'Personalia',
                'unit_id'           => 1, // fixed
                'tanggal_bergabung' => '2021-03-15',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        );
    }
}
