<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\AbsensiStaff;
use App\Models\Holiday;
use App\Models\Siswa;
use App\Models\User;
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
        $saturday = 'Saturday';
        $holidays = Holiday::get();
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $siswa = Siswa::where('is_active', 1)->get();
        $staff = User::where('is_active', 1)->where('id', '!=', 1)->get();

        $staffOnSaturday = User::with('jadwal')->where('is_active', 1)->where('id', '!=', 1)->whereHas('jadwal', function ($query) {
            $query->where('saturday', 1);
        })->get();

        $staffOffSaturday = User::with('jadwal')->where('is_active', 1)->where('id', '!=', 1)->whereHas('jadwal', function ($query) {
            $query->where('saturday', 0);
        })->get();

        if (Carbon::now('Asia/Jakarta')->format('H:i') == '07:00') {
            // Absensi Siswa
            if (Carbon::now('Asia/Jakarta')->format('l') == $sunday || Carbon::now('Asia/Jakarta')->format('l') == $saturday) {
                foreach ($siswa as $sw) {
                    Absensi::create([
                        'device_id' => 1,
                        'siswa_id' => $sw->id,
                        'masuk' => 1,
                        'waktu_masuk' => date('Y-m-d H:i:s'),
                        'keluar' => 1,
                        'waktu_keluar' => date('Y-m-d H:i:s'),
                        'status_hadir' => 'Libur',
                        'ket' => 'Libur',
                    ]);
                }
            }

            // Holiday Siswa
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
                            'status_hadir' => 'Libur',
                            'ket' => 'Libur' . $holiday->nama
                        ]);
                    }
                }
            }

            // Absensi Staff
            if (Carbon::now('Asia/Jakarta')->format('l') == $sunday) {
                foreach ($staff as $stf) {
                    AbsensiStaff::create([
                        'device_id' => 1,
                        'user_id' => $stf->id,
                        'masuk' => 1,
                        'waktu_masuk' => date('Y-m-d H:i:s'),
                        'keluar' => 1,
                        'waktu_keluar' => date('Y-m-d H:i:s'),
                        'status_hadir' => 'Libur',
                        'ket' => 'Libur'
                    ]);
                }
            }

            // Holiday Staff
            foreach ($holidays as $holiday) {
                if ($now == $holiday->waktu) {
                    foreach ($staff as $stf) {
                        AbsensiStaff::create([
                            'device_id' => 1,
                            'user_id' => $stf->id,
                            'masuk' => 1,
                            'waktu_masuk' => date('Y-m-d H:i:s'),
                            'keluar' => 1,
                            'waktu_keluar' => date('Y-m-d H:i:s'),
                            'status_hadir' => 'Libur',
                            'ket' => 'Libur' . $holiday->nama
                        ]);
                    }
                }
            }

            if (Carbon::now('Asia/Jakarta')->format('l') == $saturday) {
                foreach ($staffOffSaturday as $off) {
                    AbsensiStaff::create([
                        'device_id' => 1,
                        'user_id' => $off->id,
                        'masuk' => 1,
                        'waktu_masuk' => date('Y-m-d H:i:s'),
                        'keluar' => 1,
                        'waktu_keluar' => date('Y-m-d H:i:s'),
                        'status_hadir' => 'Libur',
                        'ket' => 'Libur'
                    ]);
                }
            }
        }

        if (Carbon::now('Asia/Jakarta')->format('l') == $saturday && Carbon::now('Asia/Jakarta')->format('H:i') == '09:00') {

            foreach ($staffOnSaturday as $on) {
                AbsensiStaff::create([
                    'device_id' => 1,
                    'user_id' => $on->id,
                    'masuk' => 1,
                    'waktu_masuk' => date('Y-m-d H:i:s'),
                    'keluar' => 1,
                    'waktu_keluar' => date('Y-m-d H:i:s'),
                    'status_hadir' => 'Alpa',
                    'ket' => 'Alpa'
                ]);
            }
        }
    }
}
