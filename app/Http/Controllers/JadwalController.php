<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::get();

        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $jadwal = new Jadwal();
        $users = User::role(['Admin', 'Guru'])->get();

        return view('jadwal.create', compact('users', 'jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru' => 'required',
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required',
            'saturday' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $attr = $request->except('guru');
            $attr['user_id'] = $request->guru;

            Jadwal::create($attr);

            DB::commit();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('jadwal.index')->with('error', $th->getMessage());
        }
    }

    public function show(Jadwal $jadwal)
    {
        //
    }

    public function edit(Jadwal $jadwal)
    {
        $users = User::role(['Admin', 'Guru', 'Staff'])->where('is_active', 1)->get();

        return view('jadwal.edit', compact('users', 'jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'guru' => 'required',
            'monday' => 'required',
            'tuesday' => 'required',
            'wednesday' => 'required',
            'thursday' => 'required',
            'friday' => 'required',
            'saturday' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $attr = $request->except('guru');
            $attr['user_id'] = $request->guru;

            $jadwal->update($attr);

            DB::commit();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('jadwal.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        try {
            DB::beginTransaction();

            $jadwal->delete();

            DB::commit();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('jadwal.index')->with('error', $th->getMessage());
        }
    }

    public function set()
    {
        try {
            DB::beginTransaction();
            $jadwal = Jadwal::find(request('id'));
            $day = request('day');
            $jadwal->update([
                $day => $jadwal->$day == 1 ? 0 : 1
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Jadwal berhasil diupdate'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
