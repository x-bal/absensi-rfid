<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $user = User::create([
            'username' => 'developer',
            'nama' => 'Muhammad Iqbal',
            'password' => bcrypt('password'),
            'device_id' => 0,
            'nik' => 123
        ]);

        $permissions = [
            'user-access', 'user-edit', 'user-create', 'user-delete',
            'permission-access', 'permission-edit', 'permission-create', 'permission-delete',
            'role-access', 'role-edit', 'role-create', 'role-delete',
        ];

        $perm = [];

        foreach ($permissions as $permission) {
            $perm[] =  Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Guru',
            'guard_name' => 'web'
        ]);

        $superAdmin->syncPermissions($perm);
        $user->assignRole('Super Admin');
    }
}
