<?php

namespace App\Http\Controllers;

use App\Models\Rfid;
use Illuminate\Http\Request;

class RfidController extends Controller
{
    public function index()
    {
        $rfids = Rfid::get();

        return view('rfid.index', compact('rfids'));
    }

    public function show($id)
    {
        $rfid = Rfid::where('id', $id)->where('status', 1)->first();

        return response()->json([
            'status' => 'Success',
            'rfid' => $rfid
        ]);
    }
}
