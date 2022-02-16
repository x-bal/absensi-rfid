<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        $permission = new Permission();

        return view('permissions.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            DB::beginTransaction();

            Permission::create([
                'name' => Str::slug($request->name),
                'guard_name' => 'web'
            ]);
            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('permission.index')->with('error', $th->getMessage());
        }
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $permission->update([
                'name' => Str::slug($request->name),
            ]);
            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('permission.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            DB::beginTransaction();

            $permission->delete();
            DB::commit();

            return redirect()->route('permission.index')->with('success', 'Permission berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('permission.index')->with('error', $th->getMessage());
        }
    }
}
