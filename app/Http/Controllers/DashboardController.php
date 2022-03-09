<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AbsensiStaff;
use App\Models\Kelas;
use App\Models\SecretKey;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaktuOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::where('id', '!=', 1)->where('is_active', 1)->count();
        $totalSiswa = Siswa::where('is_active', 1)->count();
        $totalKelas = Kelas::count();
        $totalPengguna = $totalUser + $totalSiswa;

        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d 00:00:00');
        $tomorrow = Carbon::tomorrow()->format('Y-m-d 00:00:00');

        $hadirStaff = AbsensiStaff::where('status_hadir', 'Hadir')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $zoomStaff = AbsensiStaff::where('status_hadir', 'Hadir Via Zoom')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $sakitStaff = AbsensiStaff::where('status_hadir', 'Sakit')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $ijinStaff = AbsensiStaff::where('status_hadir', 'Ijin')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $alpaStaff = AbsensiStaff::where('status_hadir', 'Alpa')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();

        $hadirSiswa = Absensi::where('status_hadir', 'Hadir')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $zoomSiswa = Absensi::where('status_hadir', 'Hadir Via Zoom')->where('created_at', $now)->where('created_at', '<=', $tomorrow)->count();
        $sakitSiswa = Absensi::where('status_hadir', 'Sakit')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $ijinSiswa = Absensi::where('status_hadir', 'Ijin')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();
        $alpaSiswa = Absensi::where('status_hadir', 'Alpa')->where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->count();

        $siswa = Absensi::where('created_at', '>=', $now)->where('created_at', '<=', $tomorrow)->where('masuk', 0)->where('keluar', 0)->get();

        return view('dashboard.index', compact('totalUser', 'totalSiswa', 'totalKelas', 'totalPengguna', 'hadirStaff', 'zoomStaff', 'sakitStaff', 'ijinStaff', 'alpaStaff', 'hadirSiswa', 'zoomSiswa', 'sakitSiswa', 'ijinSiswa', 'alpaSiswa', 'siswa'));
    }

    public function setting()
    {
        auth()->user()->can('setting-access') ? true : abort(403);

        $secretKey = SecretKey::find(1);

        $waktu = WaktuOperasional::find(1);
        $weekday = WaktuOperasional::find(2);
        $saturday = WaktuOperasional::find(3);

        $masuk = explode(' - ', $waktu->waktu_masuk);
        $keluar = explode(' - ', $waktu->waktu_keluar);
        $masukWeekday = explode(' - ', $weekday->waktu_masuk);
        $keluarWeekday = explode(' - ', $weekday->waktu_keluar);
        $masukSat = explode(' - ', $saturday->waktu_masuk);
        $keluarSat = explode(' - ', $saturday->waktu_keluar);

        return view('dashboard.setting', compact('waktu', 'weekday', 'saturday', 'masuk', 'keluar', 'masukWeekday', 'keluarWeekday', 'masukSat', 'keluarSat', 'secretKey'));
    }

    public function updateWaktu(Request $request, $id)
    {

        $request->validate([
            'waktu_awal_masuk' => 'required',
            'waktu_akhir_masuk' => 'required',
            'waktu_awal_keluar' => 'required',
            'waktu_akhir_keluar' => 'required',
            'waktu_awal_masuk_week' => 'required',
            'waktu_akhir_masuk_week' => 'required',
            'waktu_awal_keluar_week' => 'required',
            'waktu_akhir_keluar_week' => 'required',
            'waktu_awal_masuk_sat' => 'required',
            'waktu_akhir_masuk_sat' => 'required',
            'waktu_awal_keluar_sat' => 'required',
            'waktu_akhir_keluar_sat' => 'required',
            'telat_siswa' => 'required',
            'telat_staff' => 'required',
            'telat_sat' => 'required',
        ]);

        try {
            DB::beginTransaction();
            // Waktu Masuk Siswa
            $waktuOperasional = WaktuOperasional::find($id);

            $masuk = $request->waktu_awal_masuk . ' - ' . $request->waktu_akhir_masuk;
            $keluar = $request->waktu_awal_keluar . ' - ' . $request->waktu_akhir_keluar;

            $waktuOperasional->update([
                'waktu_masuk' => $masuk,
                'waktu_keluar' => $keluar,
                'telat' => $request->telat_siswa
            ]);

            // Waktu Masuk Staff (Mon - Fri)
            $weekday = WaktuOperasional::find(2);

            $masukWeek = $request->waktu_awal_masuk_week . ' - ' . $request->waktu_akhir_masuk_week;
            $keluarWeek = $request->waktu_awal_keluar_week . ' - ' . $request->waktu_akhir_keluar_week;

            $weekday->update([
                'waktu_masuk' => $masukWeek,
                'waktu_keluar' => $keluarWeek,
                'telat' => $request->telat_staff
            ]);

            // Waktu Masuk Saturday
            $saturday = WaktuOperasional::find(3);

            $masukSat = $request->waktu_awal_masuk_sat . ' - ' . $request->waktu_akhir_masuk_sat;
            $keluarSat = $request->waktu_awal_keluar_sat . ' - ' . $request->waktu_akhir_keluar_sat;

            $saturday->update([
                'waktu_masuk' => $masukSat,
                'waktu_keluar' => $keluarSat,
                'telat' => $request->telat_sat
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
            $user = User::find(auth()->user()->id);

            if ($request->password) {
                $password = bcrypt($request->password);
            } else {
                $password = auth()->user()->password;
            }

            if ($request->file('foto')) {
                Storage::delete($user->foto);
                $foto = $request->file('foto');
                $fotoUrl = $foto->storeAs('images/user', date('YmdHis') . '-' . Str::slug($request->nama) . '.' . $foto->extension());
            } else {
                $fotoUrl = $user->foto;
            }


            $user->update([
                'nama' => $request->nama,
                'gender' => $request->gender,
                'password' => $password,
                'foto' => $fotoUrl,
            ]);

            DB::commit();
            return back()->with('success', 'Profile berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
