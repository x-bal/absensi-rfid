<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    public function index()
    {
        auth()->user()->can('kelas-access') ? true : abort(403);

        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        auth()->user()->can('kelas-create') ? true : abort(403);

        $kela = new Kelas();

        return view('kelas.create', compact('kela'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('kelas-create') ? true : abort(403);

        $request->validate(['nama' => 'required']);

        try {
            DB::beginTransaction();

            Kelas::create($request->all());

            DB::commit();

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', $th->getMessage());
        }
    }

    public function show(Kelas $kela)
    {
        auth()->user()->can('kelas-access') ? true : abort(403);

        $kelas = Kelas::get();

        return view('kelas.show', compact('kela', 'kelas',));
    }

    public function edit(Kelas $kela)
    {
        auth()->user()->can('kelas-edit') ? true : abort(403);

        return view('kelas.edit', compact('kela'));
    }

    public function update(Request $request, Kelas $kela)
    {
        auth()->user()->can('kelas-edit') ? true : abort(403);

        $request->validate(['nama' => 'required']);

        try {
            DB::beginTransaction();

            $kela->update($request->all());

            DB::commit();

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Kelas $kela)
    {
        auth()->user()->can('kelas-delete') ? true : abort(403);

        try {
            DB::beginTransaction();

            foreach ($kela->siswa as $sw) {
                $sw->delete();
            }

            $kela->delete();

            DB::commit();

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', $th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'file.*' => 'mimes:xlsx, xls, csv',
        ]);

        try {
            DB::beginTransaction();

            Excel::import(new SiswaImport($request->kelas_id), $request->file('file'));

            DB::commit();

            return redirect()->route('kelas.index')->with('success', 'Data Siswa berhasil diimport');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', $th->getMessage());
        }
    }

    public function download()
    {
        return Response::download('excel/example-format-siswa.xlsx');
    }

    public function getSiswa()
    {
        $siswas = Siswa::where('kelas_id', request('id'))->where('is_active', 1)->get();
        return response()->json([
            'siswas' => $siswas
        ], 200);
    }
}
