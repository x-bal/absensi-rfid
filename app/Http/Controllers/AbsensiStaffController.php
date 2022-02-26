<?php

namespace App\Http\Controllers;

use App\Models\AbsensiStaff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AbsensiStaffController extends Controller
{
    public function index()
    {
        return view('absensi-staff.index');
    }

    public function masuk()
    {
        if (request()->ajax()) {
            if (request('mulai') && request('sampai')) {
                $data = AbsensiStaff::whereBetween('created_at', [request('masuk'), request('sampai')])->where('masuk', 1)->get();
            } else {
                $data = AbsensiStaff::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('masuk', 1)->get();
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
                ->editColumn('waktu', function ($row) {
                    return Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    return ' <a href="' . route('absensi-staff.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu', 'nama', 'jabatan', 'action'])
                ->make(true);
        }
    }

    public function keluar()
    {
        if (request()->ajax()) {
            if (request('mulai') && request('sampai')) {
                $data = AbsensiStaff::whereBetween('created_at', [request('masuk'), request('sampai')])->where('keluar', 1)->get();
            } else {
                $data = AbsensiStaff::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('keluar', 1)->get();
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
                    return $row->staff->nama . ' ' . '(' . $row->staff->nisn . ')';
                })
                ->editColumn('jabatan', function ($row) {
                    return $row->staff->jabatan;
                })
                ->editColumn('waktu', function ($row) {
                    return Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    return '<a href="' . route('absensi-staff.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu', 'nama', 'jabatan', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AbsensiStaff  $absensiStaff
     * @return \Illuminate\Http\Response
     */
    public function show(AbsensiStaff $absensiStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AbsensiStaff  $absensiStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(AbsensiStaff $absensiStaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AbsensiStaff  $absensiStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AbsensiStaff $absensiStaff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AbsensiStaff  $absensiStaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbsensiStaff $absensiStaff)
    {
        //
    }
}
