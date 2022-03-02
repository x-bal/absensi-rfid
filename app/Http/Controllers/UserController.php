<?php

namespace App\Http\Controllers;

use App\Imports\StaffImport;
use App\Models\Rfid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        auth()->user()->can('user-access') ? true : abort(403);

        if (auth()->user()->id == 1) {
            $users = User::where('status', 1)->get();
        } else {
            $users = User::where('id', '!=', 1)->where('status', 1)->get();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        auth()->user()->can('user-create') ? true : abort(403);

        $user = new User();
        $roles = Role::get();
        $jabatan = ['Kepala Sekolah TK', 'Wakasek', 'Kepala Sekolah SD', 'Admin', 'Koordinator', 'School Assistant', 'Guru'];

        return view('users.create', compact('user', 'roles', 'jabatan'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('user-create') ? true : abort(403);

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
        auth()->user()->can('user-edit') ? true : abort(403);

        $roles = Role::get();
        $jabatan = ['Kepala Sekolah TK', 'Wakasek', 'Kepala Sekolah SD', 'Admin', 'Koordinator', 'School Assistant', 'Guru'];

        return view('users.edit', compact('user', 'roles', 'jabatan'));
    }

    public function update(Request $request, User $user)
    {
        auth()->user()->can('user-edit') ? true : abort(403);

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
                move_uploaded_file($foto->getClientOriginalName(), asset('strg/images/user'));
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

            if ($request->password) {
                $password = bcrypt('password');
            } else {
                $password = $user->password;
            }

            $user->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'password' => $password,
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
        auth()->user()->can('user-delete') ? true : abort(403);

        try {
            DB::beginTransaction();

            // Storage::delete($user->foto);
            $user->update(['status' => 0]);

            DB::commit();

            return redirect()->route('user.index')->with('success', 'User berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', $th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'file.*' => 'mimes:xlsx, xls, csv'
        ]);

        try {
            DB::beginTransaction();

            Excel::import(new StaffImport, $request->file('file'));

            DB::commit();

            return redirect()->route('user.index')->with('success', 'Data berhasil diimport');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')->with('error', $th->getMessage());
        }
    }

    public function dump()
    {
        auth()->user()->can('user-access') ? true : abort(403);

        if (auth()->user()->id == 1) {
            $users = User::where('status', 0)->get();
        } else {
            $users = User::where('id', '!=', 1)->where('status', 0)->get();
        }

        return view('users.dump', compact('users'));
    }

    public function status(User $user)
    {
        try {
            DB::beginTransaction();

            $user->update(['status' => 1]);

            DB::commit();

            return back()->with('success', 'User berhasil diaktifkan kembali');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function download()
    {
        return Response::download('excel/example-format-staff.xlsx');
    }
}
