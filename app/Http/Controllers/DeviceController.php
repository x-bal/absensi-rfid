<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::get();

        return view('device.index', compact('devices'));
    }

    public function create()
    {
        $device = new Device();

        return view('device.create', compact('device'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);

        try {
            DB::beginTransaction();

            Device::create(['nama' => $request->nama]);

            DB::commit();

            return redirect()->route('device.index')->with('success', 'Device berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('device.index')->with('error', $th->getMessage());
        }
    }

    public function show(Device $device)
    {
        //
    }

    public function edit(Device $device)
    {
        return view('device.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate(['nama' => 'required']);

        try {
            DB::beginTransaction();

            $device->update(['nama' => $request->nama]);

            DB::commit();

            return redirect()->route('device.index')->with('success', 'Device berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('device.index')->with('error', $th->getMessage());
        }
    }

    public function destroy(Device $device)
    {
        try {
            DB::beginTransaction();

            $device->delete();

            DB::commit();

            return redirect()->route('device.index')->with('success', 'Device berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('device.index')->with('error', $th->getMessage());
        }
    }
}
