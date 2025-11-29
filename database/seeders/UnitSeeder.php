<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $units = [
            [
                'nama_unit'   => 'HOTEL HARMONY',
                'alamat_unit' => 'Jl. Raya Batulicin, ...',
                'no_hp_unit'  => '087878987654',
            ],
            [
                'nama_unit'   => 'GUESTHOUSE RUMA',
                'alamat_unit' => 'Jl. Suryagandamana, ...',
                'no_hp_unit'  => '087877521992',
            ],
            [
                'nama_unit'   => 'HOTEL GALERY',
                'alamat_unit' => 'Jl. Pangeran Hidayat No.26, ...',
                'no_hp_unit'  => '085827191234',
            ],
            [
                'nama_unit'   => 'HOTEL KARTIKA',
                'alamat_unit' => 'Jl. Veteran No.2, ...',
                'no_hp_unit'  => '082150942567',
            ],
            [
                'nama_unit'   => 'HOTEL LAVENDER',
                'alamat_unit' => 'Jl. Raya provinsi No. km 163, ...',
                'no_hp_unit'  => '085289987654',
            ],
        ];

        foreach ($units as $unit) {
            DB::table('units')->updateOrInsert(
                ['nama_unit' => $unit['nama_unit']], // kunci unik
                [
                    'alamat_unit' => $unit['alamat_unit'],
                    'no_hp_unit'  => $unit['no_hp_unit'],
                    'logo_unit'   => null,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]
            );
        }
    }
}
