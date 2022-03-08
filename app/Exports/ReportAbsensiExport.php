<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportAbsensiExport implements FromView
{
    public function __construct($from = '', $to = '', $kelas = '', $act = '')
    {
        $this->from = $from;
        $this->to = $to;
        $this->kelas = $kelas;
        $this->act = $act;
    }

    public function view(): View
    {
        if ($this->from == '' && $this->to == '' || $this->kelas == '' || $this->kelas == 'all') {
            return view('absensi.generate', [
                'siswa' => Siswa::where('is_active', 1)->get(),
                'from' => $this->from,
                'to' => $this->to,
                'act' => $this->act
            ]);
        } else {
            return view('absensi.generate', [
                'siswa' => Siswa::where('kelas_id', $this->kelas)->where('is_active', 1)->get(),
                'from' => $this->from,
                'to' => $this->to,
                'act' => $this->act
            ]);
        }
    }
}
