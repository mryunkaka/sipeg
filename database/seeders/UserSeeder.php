<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================
        // Pastikan unitnya ADA dulu
        // ==========================

        // HOTEL HARMONY
        $unit_hotel_harmony_id = DB::table('units')
            ->where('nama_unit', 'HOTEL HARMONY')
            ->value('id');

        if (! $unit_hotel_harmony_id) {
            $unit_hotel_harmony_id = DB::table('units')->insertGetId([
                'nama_unit'   => 'HOTEL HARMONY',
                // isi kolom wajib lain kalau ada, misalnya:
                // 'kode_unit'  => 'HARMONY',
                // 'alamat'     => 'Jl. Raya Batulicin ...',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // GUESTHOUSE RUMA
        $unit_guesthouse_ruma_id = DB::table('units')
            ->where('nama_unit', 'GUESTHOUSE RUMA')
            ->value('id');

        if (! $unit_guesthouse_ruma_id) {
            $unit_guesthouse_ruma_id = DB::table('units')->insertGetId([
                'nama_unit'   => 'GUESTHOUSE RUMA',
                // kolom wajib lain di sini kalau ada
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // Kalau nanti mau dipakai:
        // $unit_hotel_gallery_id = DB::table('units')
        //     ->where('nama_unit', 'HOTEL GALERY')
        //     ->value('id');
        //
        // if (! $unit_hotel_gallery_id) {
        //     $unit_hotel_gallery_id = DB::table('units')->insertGetId([
        //         'nama_unit'   => 'HOTEL GALERY',
        //         'created_at'  => now(),
        //         'updated_at'  => now(),
        //     ]);
        // }

        $now = now();

        // ====================================================
        // 1. Owner – HOTEL HARMONY
        //    updateOrInsert → aman kalau seed diulang berkali-kali
        // ====================================================
        DB::table('users')->updateOrInsert(
            ['email' => 'owner@example.com'], // kunci unik
            [
                'name'              => 'John Doe',
                'password'          => Hash::make('password123'),
                'role'              => 'owner',
                'no_hp'             => '081234567890',
                'alamat'            => 'Jl. Raya Batulicin, Kp. Baru, Kec. Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72271',
                'foto'              => null,          // jangan "?"
                'tanggal_lahir'     => '1980-01-01',
                'tempat_lahir'      => 'Batulicin',
                'jenis_kelamin'     => 'Laki-laki',
                'agama'             => 'Islam',
                'status_perkawinan' => 'Menikah',
                'nik'               => '1234567890123456',
                'npwp'              => '1234567890',
                'jabatan'           => 'Owner',
                'unit_id'           => $unit_hotel_harmony_id,   // ⬅ selalu INT, tidak boleh ''
                'tanggal_bergabung' => '2020-01-01',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        );

        // ====================================================
        // 2. Personalia – GUESTHOUSE RUMA
        // ====================================================
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password123'),
                'role'              => 'owner', // kalau mau beda role, ganti di sini
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
                'unit_id'           => $unit_guesthouse_ruma_id, // ⬅ selalu INT
                'tanggal_bergabung' => '2021-03-15',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        );
    }
}
