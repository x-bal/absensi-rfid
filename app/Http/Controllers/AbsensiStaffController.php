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
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->device->nama . ' ' . '(' . $row->device->id . ')' : '<p>' . $row->device->nama . ' ' . '(' . $row->device->id . ')' . '</p>';
                })
                ->editColumn('rfid', function ($row) {
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->staff->rfid : '<p>' . $row->staff->rfid . '</p>';
                })
                ->editColumn('nama', function ($row) {
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->staff->nama . ' ' . '(' . $row->staff->nik . ')' : '<p>' . $row->staff->nama . ' ' . '(' . $row->staff->nik . ')' . '</p>';
                })
                ->editColumn('jabatan', function ($row) {
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->staff->jabatan : '<p>' . $row->staff->jabatan . '</p>';
                })
                ->editColumn('waktu_masuk', function ($row) {
                    $masuk = $row->masuk == 1 ? Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s') : '-';
                    return  $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $masuk : '<p>' . $masuk . '</p>';
                })
                ->editColumn('waktu_keluar', function ($row) {
                    $keluar = $row->keluar == 1 ? Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s') : '-';
                    return  $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $keluar : '<p>' . $keluar . '</p>';
                })
                ->editColumn('status_hadir', function ($row) {
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->status_hadir : '<p>' .  $row->status_hadir . '</p>';
                })
                ->editColumn('ket', function ($row) {
                    return $row->status_hadir == 'Telat Masuk' ? '<p class="text-warning">' . $row->ket : '<p>' .  $row->ket . '</p>';
                })
                ->editColumn('keterangan', function ($row) {
                    $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa', 'Telat Masuk', 'Ijin Pulang Awal'];

                    $select = '<select name="keterangan" id="' . $row->id . '" class="form-control ket">
                    <option disabled selected>-- Select Keterangan --</option>';
                    foreach ($status as $stt) {
                        if ($row->ket == $stt) {
                            $select .= '<option selected value="' . $stt . '">' . $stt . '</option>';
                        } else {
                            $select .= '<option value="' . $stt . '">' . $stt . '</option>';
                        }
                    }
                    $select .= '</select>';
                    return $select;
                })
                ->editColumn('action', function ($row) {
                    return ' <a href="' . route('absensi-staff.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu_masuk', 'waktu_keluar', 'nama', 'jabatan', 'status_hadir', 'ket', 'keterangan', 'action'])
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

        $status = ['Hadir', 'Hadir Via Zoom', 'Sakit', 'Ijin', 'Alpa', 'Telat Masuk', 'Ijin Pulang Awal'];
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
                'ket' => $request->ket,
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

    public function change(AbsensiStaff $absensiStaff)
    {
        auth()->user()->can('absensi-staff-edit') ? true : abort(403);

        try {
            DB::beginTransaction();

            $absensiStaff->update([
                'status_hadir' => request('ket'),
                'ket' => request('ket'),
                'masuk' => 1,
                'keluar' => 1,
                'waktu_masuk' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Absensi berhasil di edit'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Absensi gagal di edit'
            ]);
        }
    }
}
