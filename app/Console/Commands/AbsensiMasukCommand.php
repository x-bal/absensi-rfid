<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\AbsensiStaff;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AbsensiMasukCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:masuk';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta')->format('H:i');
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d 00:00:00');
        $tomorrow = Carbon::tomorrow('Asia/Jakarta')->format('Y-m-d 00:00:00');
        $siswa = Siswa::where('is_active', 1)->get();
        $staff = User::where('id', '!=', 1)->where('is_active', 1)->get();

        // Absensi Siswa
        if ($now == '11:00') {
            foreach ($siswa as $sw) {
                $absensi = Absensi::where('siswa_id',  $sw->id)->where('created_at', '>=', $today)->where('created_at', '<=', $tomorrow)->first();

                if (!$absensi) {
                    Absensi::create([
                        'device_id' => 1,
                        'siswa_id' => $sw->id,
                        'masuk' => 0,
                        'keluar' => 0,
                        'status_hadir' => 'Alpa'
                    ]);
                }
            }
        }

        // Absensi Staff
        if ($now == '11:00' && Carbon::now('Asia/Jakarta')->format('l') != 'Saturday' && Carbon::now('Asia/Jakarta')->format('l') != 'Sunday') {
            foreach ($staff as $stf) {
                $absensiStaff = AbsensiStaff::where('user_id',  $stf->id)->where('created_at', '>=', $today)->where('created_at', '<=', $tomorrow)->first();

                if (!$absensiStaff) {
                    AbsensiStaff::create([
                        'device_id' => 1,
                        'user_id' => $stf->id,
                        'masuk' => 0,
                        'keluar' => 0,
                        'status_hadir' => 'Alpa'
                    ]);
                }
            }
        }
    }
}
