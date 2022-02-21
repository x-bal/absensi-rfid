<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = ['P1A', 'P1B', 'P1C', 'P2A', 'P2B', 'P2C', 'P2D', 'P3A', 'P3B', 'P3C', 'P4A', 'P4B', 'P4C', 'P4D', 'P5A', 'P5B', 'P6A', 'P6B', 'J1A', 'J1B', 'J2A', 'J2B', 'J3A', 'J3B', 'S1', 'S2', 'S3'];

        foreach ($kelas as $kls) {
            Kelas::create(['nama' => $kls]);
        }
    }
}
