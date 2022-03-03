<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AbsensiKeluarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $siswa = Siswa::get();

        // if ($now == '09:00') {
        foreach ($siswa as $sw) {
            if ($sw->absensi->where('created_at', '>=', $today)->where('masuk', 1)->first()) {
                Absensi::create([
                    'device_id' => 1,
                    'siswa_id' => $sw->id,
                    'keluar' => 1,
                    'waktu_keluar' => $today,
                    'status_hadir' => 'Hadir'
                ]);
            }
        }
    }
}
