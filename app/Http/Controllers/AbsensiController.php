<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.index');
    }

    public function masuk()
    {
        if (request()->ajax()) {
            $data = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('masuk', 1)->get();

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
                ->editColumn('waktu', function ($row) {
                    return Carbon::parse($row->waktu_masuk)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    return ' <a href="' . route('absensi.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu', 'nama', 'kelas', 'action'])
                ->make(true);
        }
    }

    public function keluar()
    {
        if (request()->ajax()) {
            $data = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('keluar', 1)->get();

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
                ->editColumn('waktu', function ($row) {
                    return Carbon::parse($row->waktu_keluar)->format('d/m/Y H:i:s');
                })
                ->editColumn('action', function ($row) {
                    return '<a href="' . route('absensi.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['device', 'rfid', 'waktu', 'nama', 'kelas', 'action'])
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
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
