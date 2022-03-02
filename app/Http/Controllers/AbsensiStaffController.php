<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiStaffExport;
use App\Models\AbsensiStaff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class AbsensiStaffController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (request('mulai') && request('sampai')) {
                $data = AbsensiStaff::whereBetween('created_at', [request('mulai'), request('sampai')])->get();
            } else {
                $data = AbsensiStaff::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->get();
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('device', function ($row) {
                    return $row->device->nama . ' ' . '(' . $row->device->id . ')';
                })
                ->editColumn('rfid', function ($row) {
                    return $row->staff->rfid;
                })
                ->editColumn('nama', function ($row) {
                    return $row->staff->nama . ' ' . '(' . $row->staff->nik . ')';
                })
                ->editColumn('jabatan', function ($row) {
                    return $row->staff->jabatan;
                })
                ->editColumn('waktu_masuk', function ($row) {
                    return Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s');
                })
                ->editColumn('waktu_keluar', function ($row) {
                    return Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    return ' <a href="' . route('absensi-staff.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu_masuk', 'waktu_keluar', 'nama', 'jabatan', 'action'])
                ->make(true);
        }

        return view('absensi-staff.index');
    }

    public function export()
    {
        $title = 'Data Absensi Staff';

        if (request('mulai') && request('sampai')) {
            $title .= ' Tanggal ' . Carbon::parse(request('mulai'))->format('d-m-Y') . ' - ' . Carbon::parse(request('sampai'))->format('d-m-Y');
        } else {
            $title .= ' Tanggal ' . Carbon::now()->format('d-m-Y');
        }

        $title .= '.xlsx';

        return Excel::download(new AbsensiStaffExport(request('mulai'), request('sampai')), $title);
    }
    public function show(AbsensiStaff $absensiStaff)
    {
        # code...
    }
    public function edit(AbsensiStaff $absensiStaff)
    {
        //
    }

    public function update(Request $request, AbsensiStaff $absensiStaff)
    {
        //
    }

    public function destroy(AbsensiStaff $absensiStaff)
    {
        //
    }
}
