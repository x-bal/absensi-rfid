<?php

namespace App\Imports;

use App\Models\Jadwal;
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
        $user = User::create([
            'nama' => $row['nama'],
            'username' => $row['westin'],
            'nik' => $row['westin'],
            'password' => bcrypt($row['westin']),
            'jabatan' => $row['jabatan']
        ]);

        if ($user->jabatan == 'Guru') {
            $user->assignRole('Guru');
        }

        if ($user->jabatan == 'Koordinator') {
            $user->assignRole('Admin');
        }

        if ($user->jabatan != 'Guru' || $user->jabatan != 'Koordinator') {
            $user->assignRole('Staff');
        }

        return Jadwal::create(['user_id' => $user->id]);
    }
}
