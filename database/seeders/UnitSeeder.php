<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('units')->insert([
            [
                // 'id' => Str::uuid(),
                'nama_unit' => 'HOTEL HARMONY',
                'alamat_unit' => 'Jl. Raya Batulicin, Kp. Baru, Kec. Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72271',
                'no_hp_unit' => '087878987654',
                'logo_unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => Str::uuid(),
                'nama_unit' => 'GUESTHOUSE RUMA',
                'alamat_unit' => 'Jl. Suryagandamana, Kotabaru Tengah, Kec. Pulau Laut Utara, Kab. Kotabaru, Kalimantan Selatan 72111',
                'no_hp_unit' => '087877521992',
                'logo_unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => Str::uuid(),
                'nama_unit' => 'HOTEL GALERY',
                'alamat_unit' => 'Jl. Pangeran Hidayat No.26, Sebatung, Kec. Pulau Laut Utara, Kab. Kotabaru, Kalimantan Selatan 72113',
                'no_hp_unit' => '085821791234',
                'logo_unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => Str::uuid(),
                'nama_unit' => 'HOTEL KARTIKA',
                'alamat_unit' => 'Jl. Veteran No.2, Dirgahayu, Kec. Pulau Laut Utara, Kab. Kotabaru, Kalimantan Selatan 72116',
                'no_hp_unit' => '082150924567',
                'logo_unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => Str::uuid(),
                'nama_unit' => 'HOTEL LAVENDER',
                'alamat_unit' => 'Jl. Raya provinsi No No.km 163, Sungai Cuka, sungai danau, Kabupaten Tanah Bumbu, Kalimantan Selatan',
                'no_hp_unit' => '085289987654',
                'logo_unit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
