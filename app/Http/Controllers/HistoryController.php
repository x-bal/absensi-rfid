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
        auth()->user()->can('history-access') ? true : abort(403);

        if (request()->ajax()) {
            $data = History::where('created_at', '>=', Carbon::now('Asia/Jakarta')->format('Y-m-d 00:00:00'))->where('created_at', '<', Carbon::now('Asia/Jakarta')->addDay(1)->format('Y-m-d 00:00:00'))->latest()->get();
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
}
