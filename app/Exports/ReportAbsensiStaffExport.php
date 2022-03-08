<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportAbsensiStaffExport implements FromView
{
    public function __construct($from = '', $to = '',  $act = '')
    {
        $this->from = $from;
        $this->to = $to;
        $this->act = $act;
    }

    public function view(): View
    {
        if ($this->from == '' && $this->to == '') {
            return view('absensi-staff.generate', [
                'staff' => User::where('id', '!=', 1)->where('is_active', 1)->get(),
                'from' => $this->from,
                'to' => $this->to,
                'act' => $this->act
            ]);
        } else {
            return view('absensi-staff.generate', [
                'staff' => User::where('id', '!=', 1)->where('is_active', 1)->get(),
                'from' => $this->from,
                'to' => $this->to,
                'act' => $this->act
            ]);
        }
    }
}
