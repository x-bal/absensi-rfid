<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class AbsensiController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            if (request('kelas') == 'all' || request('kelas') == '') {
                $data = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->get();
            } else {
                $data = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->whereHas('siswa', function ($query) {
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
                    return $row->device->nama . ' ' . '(' . $row->device->id . ')';
                })
                ->editColumn('rfid', function ($row) {
                    return $row->siswa->rfid;
                })
                ->editColumn('nama', function ($row) {
                    return $row->siswa->nama . ' ' . '(' . $row->siswa->nisn . ')';
                })
                ->editColumn('kelas', function ($row) {
                    return $row->siswa->kelas->nama;
                })
                ->editColumn('waktu_masuk', function ($row) {
                    return Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s');
                })
                ->editColumn('waktu_keluar', function ($row) {
                    return Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    if ($row->edited_by == 0) {
                        return ' <a href="' . route('absensi.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                    } else {
                        return '<p>Silahkan hubungi Super Admin</p>';
                    }
                })
                ->rawColumns(['device', 'rfid', 'waktu_masuk', 'waktu_keluar', 'nama', 'kelas', 'action'])
                ->make(true);
        }

        $kelas = Kelas::get();
        return view('absensi.index', compact('kelas'));
    }

    public function export()
    {
        $title = 'Data Absensi Siswa ';

        if (request('kelas')) {
            $title .= 'Kelas ' . Kelas::find(request('kelas'))->nama;
        } else {
            $title .= 'Semua Kelas ';
        }

        if (request('mulai') && request('sampai')) {
            $title .= ' Tanggal ' . Carbon::parse(request('mulai'))->format('d-m-Y') . ' - ' . Carbon::parse(request('sampai'))->format('d-m-Y');
        } else {
            $title .= 'Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new AbsensiExport(request('mulai'), request('sampai'), request('kelas')), $title);
    }

    public function edit(Absensi $absensi)
    {
        if ($absensi->edited_by == 0) {
            $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa'];
            return view('absensi.edit', compact('absensi', 'status'));
        } else {
            return back();
        }
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate(['status_hadir' => 'required']);

        try {
            DB::beginTransaction();

            $absensi->update([
                'status_hadir' => $request->status_hadir,
                'edited_by' => auth()->user()->id
            ]);

            DB::commit();

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('erorr', $th->getMessage());
        }
    }
}
