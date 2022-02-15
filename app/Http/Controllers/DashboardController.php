<?php

namespace App\Http\Controllers;

use App\Models\SecretKey;
use App\Models\WaktuOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function setting()
    {
        $waktu = WaktuOperasional::find(1);
        $secretKey = SecretKey::find(1);

        return view('dashboard.setting', compact('waktu', 'secretKey'));
    }

    public function updateWaktu(Request $request, $id)
    {

        $request->validate([
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $waktuOperasional = WaktuOperasional::find($id);

            $waktuOperasional->update([
                'waktu_masuk' => $request->waktu_masuk,
                'waktu_keluar' => $request->waktu_keluar,
            ]);
            DB::commit();

            return redirect()->route('setting')->with('success', 'Waktu Operasional berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('setting')->with('error', $th->getMessage());
        }
    }
}
