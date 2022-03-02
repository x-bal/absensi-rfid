<?php

namespace App\Http\Controllers;

use App\Models\SecretKey;
use App\Models\User;
use App\Models\WaktuOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->status == 0) {
            Auth::logout();
            return redirect('/');
        }
        return view('dashboard.index');
    }

    public function setting()
    {
        $waktu = WaktuOperasional::find(1);
        $secretKey = SecretKey::find(1);
        $masuk = explode(' - ', $waktu->waktu_masuk);
        $keluar = explode(' - ', $waktu->waktu_keluar);

        return view('dashboard.setting', compact('waktu', 'masuk', 'keluar', 'secretKey'));
    }

    public function updateWaktu(Request $request, $id)
    {

        $request->validate([
            'waktu_awal_masuk' => 'required',
            'waktu_akhir_masuk' => 'required',
            'waktu_awal_keluar' => 'required',
            'waktu_akhir_keluar' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $waktuOperasional = WaktuOperasional::find($id);

            $masuk = $request->waktu_awal_masuk . ' - ' . $request->waktu_akhir_masuk;
            $keluar = $request->waktu_awal_keluar . ' - ' . $request->waktu_akhir_keluar;

            $waktuOperasional->update([
                'waktu_masuk' => $masuk,
                'waktu_keluar' => $keluar,
            ]);
            DB::commit();

            return redirect()->route('setting')->with('success', 'Waktu Operasional berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('setting')->with('error', $th->getMessage());
        }
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gender' => 'required',
        ]);

        try {
            DB::beginTransaction();
            if ($request->password) {
                $password = bcrypt($request->password);
            } else {
                $password = auth()->user()->password;
            }

            $user = User::find(auth()->user()->id);

            $user->update([
                'nama' => $request->nama,
                'gender' => $request->gender,
                'password' => $password,
            ]);

            DB::commit();
            return back()->with('success', 'Profile berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
