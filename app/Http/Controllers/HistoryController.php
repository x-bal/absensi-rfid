<?php

namespace App\Http\Controllers;

use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class HistoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = History::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('device', function ($row) {
                    return $row->device->nama . ' ' . '(' . $row->device->id . ')';
                })
                ->editColumn('waktu', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->rawColumns(['device', 'waktu'])
                ->make(true);
        }

        return view('history.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        //
    }
}
