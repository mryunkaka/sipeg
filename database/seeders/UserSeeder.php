<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Helper: pastikan unit ada, kalau belum akan dibuat.
        $hotelHarmony = Unit::firstOrCreate(
            ['nama_unit' => 'HOTEL HARMONY'],
            [
                // isi kolom wajib lain kalau ada, misal:
                // 'kode_unit' => 'HARMONY',
                // 'alamat'    => 'Jl. Raya Batulicin, ...',
            ]
        );

        $guesthouseRuma = Unit::firstOrCreate(
            ['nama_unit' => 'GUESTHOUSE RUMA'],
            [
                // 'kode_unit' => 'RUMA',
                // 'alamat'    => 'Jl. Raya Batulicin, ...',
            ]
        );

        // Kalau kamu punya unit "HOTEL GALERY" dan ingin dipakai, bisa tambahkan juga:
        // $hotelGallery = Unit::firstOrCreate(
        //     ['nama_unit' => 'HOTEL GALERY'],
        //     [
        //         // kolom wajib lain...
        //     ]
        // );

        // ===========================
        // 1. User Owner (HOTEL HARMONY)
        // ===========================
        User::updateOrCreate(
            ['email' => 'owner@example.com'], // kunci unik
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
                'unit_id'           => $hotelHarmony->id,   // ⬅ SELALU integer valid
                'tanggal_bergabung' => '2020-01-01',
            ]
        );

        // ===========================
        // 2. User Personalia (GUESTHOUSE RUMA)
        // ===========================
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password123'),
                'role'              => 'owner', // kalau mau dibedakan bisa ganti ke 'admin'
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
                'unit_id'           => $guesthouseRuma->id, // ⬅ SELALU integer valid
                'tanggal_bergabung' => '2021-03-15',
            ]
        );
    }
}
