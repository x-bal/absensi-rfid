<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiStaffExport;
use App\Exports\ReportAbsensiStaffExport;
use App\Models\AbsensiStaff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class AbsensiStaffController extends Controller
{
    public function index()
    {
        auth()->user()->can('absensi-staff-access') ? true : abort(403);

        if (request()->ajax()) {
            if (request('mulai') && request('sampai')) {
                $data = AbsensiStaff::whereBetween('created_at', [request('mulai'), Carbon::parse(request('sampai'))->addDay(1)->format('Y-m-d 00:00:00')])->get();
            } else {
                $data = AbsensiStaff::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->get();
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('device', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->device->nama . ' ' . '(' . $row->device->id . ')' . '</span>';
                })
                ->editColumn('rfid', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->staff->rfid . '</span>';
                })
                ->editColumn('nama', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->staff->nama . ' ' . '(' . $row->staff->nik . ')' . '</span>';
                })
                ->editColumn('jabatan', function ($row) {
                    return $row->ket == 'Telat Masuk' ? '<span class="text-warning">' : '<span>' . $row->staff->jabatan . '</span>';
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
                ->editColumn('action', function ($row) {
                    return ' <a href="' . route('absensi-staff.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu_masuk', 'waktu_keluar', 'nama', 'jabatan', 'ket', 'action'])
                ->make(true);
        }

        return view('absensi-staff.index');
    }

    public function export()
    {
        $title = 'Data Absensi Staff';
        $sampai = '';

        if (request('mulai') && request('sampai')) {
            $title .= ' Tanggal ' . Carbon::parse(request('mulai'))->format('d-m-Y') . ' s.d ' . Carbon::parse(request('sampai'))->format('d-m-Y');
            $sampai = Carbon::parse(request('sampai'))->addDay(1)->format('Y-m-d 00:00:00');
        } else {
            $title .= ' Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new AbsensiStaffExport(request('mulai'), $sampai), $title);
    }

    public function edit(AbsensiStaff $absensiStaff)
    {
        auth()->user()->can('absensi-staff-edit') ? true : abort(403);

        $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa'];
        return view('absensi-staff.edit', compact('absensiStaff', 'status'));
    }

    public function update(Request $request, AbsensiStaff $absensiStaff)
    {
        auth()->user()->can('absensi-staff-edit') ? true : abort(403);

        $request->validate(['status_hadir' => 'required']);

        try {
            DB::beginTransaction();

            $absensiStaff->update([
                'masuk' => 1,
                'keluar' => 1,
                'status_hadir' => $request->status_hadir,
                'ket' => $request->status_hadir,
            ]);

            DB::commit();

            return redirect()->route('absensi-staff.index')->with('success', 'Absensi Staff berhasil diupdate');
        } catch (\Throwable $th) {
            return back()->with('erorr', $th->getMessage());
        }
    }

    public function report(Request $request)
    {
        auth()->user()->can('report-staff-access') ? true : abort(403);

        $from = $request->from ?? '';
        $to = $request->to ?? '';
        $act = '';
        $staff = User::where('id', '!=', 1)->where('is_active', 1)->get();

        return view('absensi-staff.report', compact('staff', 'from', 'to', 'act'));
    }

    public function generate()
    {
        $title = 'Rekap Absensi Staff';

        if (request('from') && request('to')) {
            $title .= ' Tanggal ' . Carbon::parse(request('from'))->format('d-m-Y') . ' s.d ' . Carbon::parse(request('to'))->format('d-m-Y');
        } else {
            $title .= ' Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new ReportAbsensiStaffExport(request('from'), request('to'), request('act')), $title);
    }
}
