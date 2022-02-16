<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensiMasuk = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('masuk', 1)->get();
        $absensiKeluar = Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->where('keluar', 1)->get();

        return view('absensi.index', compact('absensiMasuk', 'absensiKeluar'));
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
