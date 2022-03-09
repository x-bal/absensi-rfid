<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Exports\ReportAbsensiExport;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class AbsensiController extends Controller
{
    public function index()
    {
        auth()->user()->can('absensi-siswa-access') ? true : abort(403);

        if (request()->ajax()) {
            if (request('kelas') == 'all' || request('kelas') == '') {
                $data = Absensi::where('created_at', '>=', Carbon::now('Asia/Jakarta')->format('Y-m-d 00:00:00'))->get();
            } else {
                $data = Absensi::where('created_at', '>=', Carbon::now('Asia/Jakarta')->format('Y-m-d 00:00:00'))->whereHas('siswa', function ($query) {
                    return $query->where('kelas_id', request('kelas'));
                })->get();

                if (request('mulai') != '' && request('sampai') != '') {
                    $data = Absensi::whereBetween('created_at', [request('mulai'), request('sampai')])->whereHas('siswa', function ($query) {
                        return $query->where('kelas_id', request('kelas'));
                    })->get();
                }
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('device', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->device->nama . ' ' . '(' . $row->device->id . ')' . '</span>';
                })
                ->editColumn('rfid', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->siswa->rfid . '</span>';
                })
                ->editColumn('nama', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' .  $row->siswa->nama . ' ' . '(' . $row->siswa->nisn . ')' . '</span>';
                })
                ->editColumn('kelas', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->siswa->kelas->nama . '</span>';
                })
                ->editColumn('waktu_masuk', function ($row) {
                    $masuk = $row->masuk == 1 ? Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s') : '-';
                    return  $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $masuk . '</span>';
                })
                ->editColumn('waktu_keluar', function ($row) {
                    $keluar = $row->keluar == 1 ? Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s') : '-';
                    return  $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $keluar . '</span>';
                })
                ->editColumn('ket', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' .  $row->ket . '</span>';
                })
                ->editColumn('edited', function ($row) {
                    return $row->edited_by != 0 ? $row->edited->nama : '';
                })
                ->editColumn('action', function ($row) {
                    if (auth()->user()->hasRole(['Me', 'Super Admin', 'Admin'])) {
                        return  '<a href="' . route('absensi.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                    }

                    if (auth()->user()->hasRole('Guru')) {
                        if ($row->edited_by == 0) {
                            return  '<a href="' . route('absensi.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                        } else {
                            return  '<p>Silahkan hubungi Admin</p>';
                        }
                    }
                })
                ->rawColumns(['device', 'rfid', 'waktu_masuk', 'waktu_keluar', 'nama', 'kelas', 'ket', 'edited', 'action'])
                ->make(true);
        }

        $kelas = Kelas::get();
        return view('absensi.index', compact('kelas'));
    }

    public function export()
    {
        $title = 'Data Absensi Siswa ';
        $sampai = '';

        if (request('kelas')) {
            $title .= 'Kelas ' . Kelas::find(request('kelas'))->nama;
        } else {
            $title .= 'Semua Kelas ';
        }

        if (request('mulai') && request('sampai')) {
            $title .= ' Tanggal ' . Carbon::parse(request('mulai'))->format('d-m-Y') . ' s.d ' . Carbon::parse(request('sampai'))->format('d-m-Y');
            $sampai = Carbon::parse(request('sampai'))->addDay(1)->format('Y-m-d 00:00:00');
        } else {
            $title .= ' Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new AbsensiExport(request('mulai'), $sampai, request('kelas')), $title);
    }

    public function edit(Absensi $absensi)
    {
        auth()->user()->can('absensi-siswa-edit') ? true : abort(403);

        if (auth()->user()->hasRole(['Me', 'Super Admin', 'Admin'])) {
            $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa'];
            return view('absensi.edit', compact('absensi', 'status'));
        }

        if (auth()->user()->hasRole('Guru')) {
            if ($absensi->edited_by == 0) {
                $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa'];
                return view('absensi.edit', compact('absensi', 'status'));
            } else {
                return back();
            }
        }
    }

    public function update(Request $request, Absensi $absensi)
    {
        auth()->user()->can('absensi-siswa-edit') ? true : abort(403);

        $request->validate(['status_hadir' => 'required']);

        try {
            DB::beginTransaction();

            $absensi->update([
                'masuk' => 1,
                'keluar' => 1,
                'status_hadir' => $request->status_hadir,
                'ket' => $request->status_hadir,
                'edited_by' => auth()->user()->id
            ]);

            DB::commit();

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('erorr', $th->getMessage());
        }
    }

    public function report(Request $request)
    {
        auth()->user()->can('report-siswa-access') ? true : abort(403);

        $kelas = Kelas::get();
        $siswa = '';
        $from = $request->from ?? '';
        $to = $request->to ?? '';
        $act = '';

        if ($request->kelas == 'all') {
            $siswa = Siswa::get();
        } else {
            $siswa = Siswa::where('is_active', 1)->where('kelas_id', $request->kelas)->get();
        }

        return view('absensi.report', compact('kelas', 'siswa', 'from', 'to', 'act'));
    }

    public function generate()
    {
        $title = 'Rekap Absensi Siswa ';

        if (request('kelas') != 'all') {
            $title .= 'Kelas ' . Kelas::find(request('kelas'))->nama;
        } else {
            $title .= 'Semua Kelas ';
        }

        if (request('from') && request('to')) {
            $title .= ' Tanggal ' . Carbon::parse(request('from'))->format('d-m-Y') . ' s.d ' . Carbon::parse(request('to'))->format('d-m-Y');
        } else {
            $title .= ' Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new ReportAbsensiExport(request('from'), request('to'), request('kelas'), request('act')), $title);
    }
}
