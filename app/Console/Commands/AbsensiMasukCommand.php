<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Siswa;
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
        // $now = Carbon::now('Asia/Jakarta')->format('H:i');
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $siswa = Siswa::get();

        // if ($now == '09:00') {
        foreach ($siswa as $sw) {
            if (!$sw->absensi->where('created_at', '>=', $today)->first()) {
                Absensi::create([
                    'device_id' => 1,
                    'siswa_id' => $sw->id,
                    'masuk' => 0,
                    'keluar' => 0,
                    'status_hadir' => 'Alpa'
                ]);
            }
        }
        // }
    }
}
