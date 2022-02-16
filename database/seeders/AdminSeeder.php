<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Rfid;
use App\Models\SecretKey;
use App\Models\User;
use App\Models\WaktuOperasional;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $user->update([
            'username' => 'developer',
            'nama' => 'Muhammad Iqbal',
            'password' => Hash::make('admin'),
            'device_id' => 1,
            'nik' => 123
        ]);

        // $permissions = [
        //     'user-access', 'user-edit', 'user-create', 'user-delete',
        //     'permission-access', 'permission-edit', 'permission-create', 'permission-delete',
        //     'role-access', 'role-edit', 'role-create', 'role-delete',
        // ];

        // $perm = [];

        // foreach ($permissions as $permission) {
        //     $perm[] =  Permission::create([
        //         'name' => $permission,
        //         'guard_name' => 'web'
        //     ]);
        // }

        // $superAdmin = Role::create([
        //     'name' => 'Super Admin',
        //     'guard_name' => 'web'
        // ]);

        // Role::create([
        //     'name' => 'Admin',
        //     'guard_name' => 'web'
        // ]);

        // Role::create([
        //     'name' => 'Guru',
        //     'guard_name' => 'web'
        // ]);

        // $superAdmin->syncPermissions($perm);
        // $user->assignRole('Super Admin');

        // SecretKey::create([
        //     'key' => 'testabsensi123'
        // ]);

        // WaktuOperasional::create([
        //     'waktu_masuk' => '07:00 - 08:00',
        //     'waktu_keluar' => '15:00 - 16:00',
        // ]);

        // Device::create([
        //     'nama' => 'Absensi'
        // ]);

        // Rfid::create([
        //     'device_id' => 1,
        //     'rfid' => '123',
        //     'status' => 1
        // ]);
    }
}
