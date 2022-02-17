<?php

namespace App\Http\Controllers;

use App\Models\Rfid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        $roles = Role::get();

        return view('users.create', compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'nama' => 'required',
            'nik' => 'required',
            'jabatan' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'foto.*' => 'required|mimes:png, jpg, jpeg',
        ]);

        try {
            DB::beginTransaction();
            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('images/user', date('YmdHis') . '-' . Str::slug($request->nama) . '.' . $foto->extension());

            $user = User::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'password' => bcrypt($request->nik),
                'jabatan' => $request->jabatan,
                'foto' => $fotoUrl
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', $th->getMessage());
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama' => 'required',
            'nik' => 'required',
            'gender' => 'required',
            'jabatan' => 'required',
            'role' => 'required',
            'foto.*' => 'mimes:png, jpg, jpeg',
        ]);

        try {
            DB::beginTransaction();
            if ($request->file('foto')) {
                Storage::delete($user->foto);
                $foto = $request->file('foto');
                $fotoUrl = $foto->storeAs('images/user', date('YmdHis') . '-' . Str::slug($request->nama) . '.' . $foto->extension());
            } else {
                $fotoUrl = $user->foto;
            }

            if ($request->rfid) {
                $device = Rfid::where('rfid', $request->rfid)->first();
                $device->update(['status' => 0]);
                $device_id = $device->id;
            } else {
                $device_id = 0;
            }

            $user->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'password' => bcrypt($request->nik),
                'jabatan' => $request->jabatan,
                'rfid' => $request->rfid ?? '',
                'device_id' => $device_id,
                'foto' => $fotoUrl
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            Storage::delete($user->foto);
            $user->delete();

            DB::commit();

            return redirect()->route('user.index')->with('success', 'User berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', $th->getMessage());
        }
    }
}
