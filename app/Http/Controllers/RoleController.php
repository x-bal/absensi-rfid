<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $role = new Role();
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.create', compact('role', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            $role->syncPermissions($request->permission);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('role.index')->with('error', $th->getMessage());
        }
    }

    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
            ]);

            $role->syncPermissions($request->permission);

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Role berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('role.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();

            $role->delete();

            DB::commit();

            return redirect()->route('role.index')->with('success', 'Role berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('role.index')->with('error', $th->getMessage());
        }
    }
}
