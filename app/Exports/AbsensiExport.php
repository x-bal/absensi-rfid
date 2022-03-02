<?php

namespace App\Exports;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    public function __construct($start = null, $end = null, $kelas = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->kelas = $kelas;
    }

    public function view(): View
    {
        if ($this->start == null && $this->end == null && $this->kelas == null) {
            return view('absensi.export', [
                'absensi' => Absensi::where('created_at', '>=', Carbon::now()->format('Y-m-d 00:00:00'))->get()
            ]);
        } else {
            return view('absensi.export', [
                'absensi' => Absensi::whereBetween('created_at', [$this->start, $this->end])->whereHas('siswa', function ($query) {
                    return $query->where('kelas_id', $this->kelas)->orderBy('nama', 'ASC');
                })->get()
            ]);
        }
    }
}
