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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Rfid $rfid)
    {
        //
    }

    public function edit(Rfid $rfid)
    {
        //
    }

    public function update(Request $request, Rfid $rfid)
    {
        //
    }

    public function destroy(Rfid $rfid)
    {
        //
    }
}
