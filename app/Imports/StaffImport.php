<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = new User([
            'nama' => $row['nama'],
            'username' => $row['westin'],
            'nik' => $row['westin'],
            'password' => bcrypt($row['westin']),
            'jabatan' => $row['jabatan']
        ]);

        return $user->assignRole('Guru');
    }
}
