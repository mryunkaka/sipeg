<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('units')->truncate();

        DB::table('units')->insert([
            [
                'nama_unit'   => 'HOTEL HARMONY',
                'alamat_unit' => 'Jl. Raya Batulicin, ...',
                'no_hp_unit'  => '087878987654',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'GUESTHOUSE RUMA',
                'alamat_unit' => 'Jl. Suryagandamana, ...',
                'no_hp_unit'  => '087877521992',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL GALERY',
                'alamat_unit' => 'Jl. Pangeran Hidayat No.26, ...',
                'no_hp_unit'  => '085827191234',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL KARTIKA',
                'alamat_unit' => 'Jl. Veteran No.2, ...',
                'no_hp_unit'  => '082150942567',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_unit'   => 'HOTEL LAVENDER',
                'alamat_unit' => 'Jl. Raya provinsi No. km 163, ...',
                'no_hp_unit'  => '085289987654',
                'logo_unit'   => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}
