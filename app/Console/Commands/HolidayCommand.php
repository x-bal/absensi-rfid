<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Holiday;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HolidayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:holiday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sunday = 'Sunday';
        $holidays = Holiday::get();
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $siswa = Siswa::get();

        if (Carbon::now('Asia/Jakarta')->format('l') == $sunday) {
            foreach ($siswa as $sw) {
                Absensi::create([
                    'device_id' => 1,
                    'siswa_id' => $sw->id,
                    'masuk' => 1,
                    'waktu_masuk' => date('Y-m-d H:i:s'),
                    'keluar' => 1,
                    'waktu_keluar' => date('Y-m-d H:i:s'),
                    'status_hadir' => 'Libur Hari Minggu'
                ]);
            }
        }

        foreach ($holidays as $holiday) {
            if ($now == $holiday->waktu) {
                foreach ($siswa as $sw) {
                    Absensi::create([
                        'device_id' => 1,
                        'siswa_id' => $sw->id,
                        'masuk' => 1,
                        'waktu_masuk' => date('Y-m-d H:i:s'),
                        'keluar' => 1,
                        'waktu_keluar' => date('Y-m-d H:i:s'),
                        'status_hadir' => 'Libur' . $holiday->nama
                    ]);
                }
            }
        }
    }
}
