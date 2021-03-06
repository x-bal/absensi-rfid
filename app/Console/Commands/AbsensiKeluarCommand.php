<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AbsensiKeluarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:keluar';

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
        $siswa = Siswa::where('is_active', 1)->get();
        $staff = User::where('id', '!=', 1)->where('is_active', 1)->get();

        // Absensi Siswa
        if ($now == '18:00') {
            foreach ($siswa as $sw) {
                if ($sw->absensi->where('created_at', '>=', $today)->where('masuk', 1)->first()) {
                    $sw->absensi->update([
                        'device_id' => 1,
                        'siswa_id' => $sw->id,
                        'keluar' => 1,
                        'waktu_keluar' => $today,
                    ]);
                }
            }
        }

        // Absensi Staff
        if ($now == '18:00') {
            foreach ($staff as $stf) {
                if ($stf->absensiStaff->where('created_at', '>=', $today)->where('masuk', 1)->first()) {
                    $stf->absensiStaff->update([
                        'device_id' => 1,
                        'user_id' => $stf->id,
                        'keluar' => 1,
                        'waktu_keluar' => $today,
                    ]);
                }
            }
        }
    }
}
