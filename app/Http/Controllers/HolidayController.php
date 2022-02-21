<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::get();

        return view('holiday.index', compact('holidays'));
    }

    public function create()
    {
        $holiday = new Holiday();

        return view('holiday.create', compact('holiday'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'waktu' => 'required',
        ]);

        try {
            DB::beginTransaction();

            Holiday::create($request->all());

            DB::commit();

            return redirect()->route('holiday.index')->with('success', 'Data holiday berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('holiday.index')->with('error', $th->getMessage());
        }
    }

    public function show(Holiday $holiday)
    {
        //
    }

    public function edit(Holiday $holiday)
    {
        return view('holiday.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'nama' => 'required',
            'waktu' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $holiday->update($request->all());

            DB::commit();

            return redirect()->route('holiday.index')->with('success', 'Data holiday berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('holiday.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Holiday $holiday)
    {
        try {
            DB::beginTransaction();

            $holiday->delete();

            DB::commit();

            return redirect()->route('holiday.index')->with('success', 'Data holiday berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('holiday.index')->with('error', $th->getMessage());
        }
    }
}
