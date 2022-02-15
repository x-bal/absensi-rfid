<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('nama', 'ASC')->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $kela = new Kelas();

        return view('kelas.create', compact('kela'));
    }

    public function store(Request $request)
    {
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
        //
    }

    public function edit(Kelas $kela)
    {
        return view('kelas.edit', compact('kela'));
    }

    public function update(Request $request, Kelas $kela)
    {
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
        dd($kela);
        try {
            DB::beginTransaction();

            $kela->delete();

            DB::commit();

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kelas.index')->with('error', $th->getMessage());
        }
    }
}
