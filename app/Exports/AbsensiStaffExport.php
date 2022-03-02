<?php

namespace App\Exports;

use App\Models\AbsensiStaff;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiStaffExport implements FromView
{
    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function view(): View
    {
        if ($this->start == '' && $this->end == '') {
            return view('absensi-staff.export', [
                'absensi' => AbsensiStaff::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->get()
            ]);
        } else {
            return view('absensi-staff.export', [
                'absensi' => AbsensiStaff::whereBetween('created_at', [$this->start, $this->end])->get()
            ]);
        }
    }
}
