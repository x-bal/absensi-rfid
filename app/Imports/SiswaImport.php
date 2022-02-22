<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    private $kelas;

    public function __construct(int $kelas)
    {
        $this->kelas = $kelas;
    }

    public function model(array $row)
    {
        return new Siswa([
            // "nama" => 
        ]);
    }
}
