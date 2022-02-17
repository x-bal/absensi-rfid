<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Kelas;
use App\Models\Rfid;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::orderBy('nama', 'ASC')->get();

        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        $siswa = new Siswa();
        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('siswa.create', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
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
        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
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
        try {
            DB::beginTransaction();

            Storage::delete($siswa->foto);

            $siswa->delete();

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('siswa.index')->with('error', $th->getMessage());
        }
    }
}
