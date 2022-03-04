<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Rfid;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class SiswaController extends Controller
{
    public function index()
    {
        auth()->user()->can('siswa-access') ? true : abort(403);

        if (request()->ajax()) {
            $data = Siswa::where('is_active', 1)->orderBy('nama', 'ASC')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('foto', function ($row) {
                    return '<div class="avatar avatar-l">
                    <img src="' . asset('storage/' . $row->foto) . '" alt="" class="avatar-img rounded-circle">
                </div>';
                })
                ->editColumn('device', function ($row) {
                    return $row->device->nama ?? '-';
                })
                ->editColumn('kelas', function ($row) {
                    return $row->kelas->nama;
                })
                ->editColumn('action', function ($row) {
                    return '<div class="d-flex">
                    <a href="' . route("siswa.edit", $row->id) . '" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                    <form action="' . route("siswa.destroy", $row->id) . '" method="post" class="form-delete-' . $row->id . '">
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" id="' . $row->id . '"><i class="fas fa-trash"></i></button>
                    </form>
                </div>';
                })
                ->rawColumns(['device', 'foto', 'kelas', 'action'])
                ->make(true);
        }

        return view('siswa.index');
    }

    public function create()
    {
        auth()->user()->can('siswa-create') ? true : abort(403);

        $siswa = new Siswa();
        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('siswa.create', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('siswa-create') ? true : abort(403);

        $request->validate([
            'nisn' => 'required',
            'nama' => 'required',
            'gender' => 'required',
            'kelas' => 'required',
            'foto.*' => 'required|mimes: jpeg, jpg, png',
        ]);

        try {
            DB::beginTransaction();

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('images/siswa', date('YmdHis') . '-' . Str::slug($request->nama) . '.' . $foto->extension());

            Siswa::create([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'gender' => $request->gender,
                'kelas_id' => $request->kelas,
                'rfid' => $request->rfid ?? '',
                'foto' => $fotoUrl,
            ]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('siswa.index')->with('error', $th->getMessage());
        }
    }

    public function show(Siswa $siswa)
    {
        //
    }

    public function edit(Siswa $siswa)
    {
        auth()->user()->can('siswa-edit') ? true : abort(403);

        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        auth()->user()->can('siswa-edit') ? true : abort(403);

        $request->validate([
            'nisn' => 'required',
            'nama' => 'required',
            'gender' => 'required',
            'kelas' => 'required',
            'foto.*' => 'required|mimes: jpeg, jpg, png',
        ]);

        try {
            DB::beginTransaction();

            if ($request->file('foto')) {
                Storage::delete($siswa->foto);
                $foto = $request->file('foto');
                $fotoUrl = $foto->storeAs('images/siswa', date('YmdHis') . '-' . Str::slug($request->nama) . '.' . $foto->extension());
            } else {
                $fotoUrl = $siswa->foto;
            }

            if ($request->rfid) {
                $device = Rfid::where('rfid', $request->rfid)->first();
                $device->update(['status' => 0]);
                $device_id = $device->id;
            } else {
                $device_id = 0;
            }

            $siswa->update([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'gender' => $request->gender,
                'kelas_id' => $request->kelas,
                'device_id' => $device_id,
                'rfid' => $request->rfid ?? '',
                'foto' => $fotoUrl,
            ]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('siswa.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Siswa $siswa)
    {
        auth()->user()->can('siswa-delete') ? true : abort(403);

        try {
            DB::beginTransaction();

            // Storage::delete($siswa->foto);

            $siswa->update(['is_active' => 0]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('siswa.index')->with('error', $th->getMessage());
        }
    }

    public function dump()
    {
        auth()->user()->can('dump-siswa-access') ? true : abort(403);

        $siswa = Siswa::where('is_active', 0)->get();

        return view('siswa.dump', compact('siswa'));
    }

    public function activated(Siswa $siswa)
    {
        try {
            DB::beginTransaction();
            $siswa->update(['is_active' => 1]);
            DB::commit();

            return back()->with('success', 'Siswa berhasil diaktifasi kembali');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
