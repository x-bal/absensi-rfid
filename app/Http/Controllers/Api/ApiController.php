<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiStaff;
use App\Models\Device;
use App\Models\History;
use App\Models\Jadwal;
use App\Models\Rfid;
use App\Models\SecretKey;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaktuOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;

date_default_timezone_set("asia/jakarta");

class ApiController extends Controller
{
    public function index()
    {
        return 'REST API for Device';
    }

    public function getMode(Request $request)
    {
        if ($request->key && $request->iddev) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $device = Device::find($request->iddev);

                if ($device) {
                    echo '*' . $device->mode . '*';
                } else {
                    echo "*id-device-tidak-ditemukan*";
                }
            } else {
                echo "*salah-secret-key*";
            }
        } else {
            echo "*salah-param*";
        }
    }

    public function addCard(Request $request)
    {
        if ($request->key && $request->iddev && $request->rfid) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $checkRfid = Rfid::where('rfid', $request->rfid)->first();

                if ($checkRfid) {
                    echo "*RFID-sudah-terdaftar*";
                } else {
                    $device = Device::find($request->iddev);

                    if ($device) {
                        $rfid = Rfid::find(1);

                        $newRfid = $rfid->update([
                            'device_id' => $device->id,
                            'rfid' => $request->rfid
                        ]);

                        if ($newRfid) {
                            $history = History::create([
                                'device_id' => $request->iddev,
                                'rfid' => $request->rfid,
                                'keterangan' => 'ADD RFID CARD'
                            ]);

                            if ($history) {
                                echo "*berhasil-tambah-rfid-card*";
                            } else {
                                echo "*terjadi-kesalahan*";
                            }
                        }
                    } else {
                        echo "*id-device-tidak-ditemukan*";
                    }
                }
            } else {
                echo "*salah-secret-key*";
            }
        } else {
            echo "*salah-param*";
        }
    }

    public function getModeJson(Request $request)
    {
        if ($request->key && $request->iddev) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $device = Device::find($request->iddev);

                if ($device) {
                    $response = [
                        'status' => 'success',
                        'mode' => $device->mode,
                        'ket' => 'berhasil'
                    ];
                    echo json_encode($response);
                } else {
                    $response = [
                        'status' => 'warning',
                        'mode' => '-',
                        'ket' => 'id device tidak ditemukan'
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = [
                    'status' => 'failed',
                    'ket' => 'salah secret key'
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                'status' => 'failed',
                'ket' => 'salah parameter'
            ];
            echo json_encode($response);
        }
    }

    public function addCardJson(Request $request)
    {
        if ($request->key && $request->iddev && $request->rfid) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $checkRfid = Rfid::where('rfid', $request->rfid)->first();

                if ($checkRfid) {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'RFID sudah terdaftar'
                    ];
                    echo json_encode($response);
                } else {
                    $device = Device::find($request->iddev);

                    if ($device) {
                        $rfid = Rfid::find(1);

                        $newRfid = $rfid->update([
                            'device_id' => $device->id,
                            'rfid' => $request->rfid,
                            'status' => 1
                        ]);

                        if ($newRfid) {
                            $history = History::create([
                                'device_id' => $request->iddev,
                                'rfid' => $request->rfid,
                                'keterangan' => 'ADD RFID CARD'
                            ]);

                            if ($history) {
                                $response = [
                                    'status' => 'success',
                                    'ket' => 'Rfid berhasil ditambahkan'
                                ];
                                echo json_encode($response);
                            } else {
                                $response = [
                                    'status' => 'failed',
                                    'ket' => 'Terjadi Kesalahan'
                                ];
                                echo json_encode($response);
                            }
                        }
                    } else {
                        $response = [
                            'status' => 'failed',
                            'ket' => 'Device tidak ditemukan'
                        ];
                        echo json_encode($response);
                    }
                }
            } else {
                $response = [
                    'status' => 'failed',
                    'ket' => 'salah secret key'
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                'status' => 'failed',
                'ket' => 'salah param'
            ];
            echo json_encode($response);
        }
    }

    public function absensi(Request $request)
    {
        if ($request->key && $request->iddev && $request->rfid) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $device = Device::find($request->iddev);
                $rfid = Siswa::where('rfid', $request->rfid)->first();

                if ($rfid) {
                    $waktu = WaktuOperasional::find(1);

                    $masuk = explode(' - ', $waktu->waktu_masuk);
                    $keluar = explode(' - ', $waktu->waktu_keluar);

                    $startMasuk = Carbon::parse($masuk[0])->format('His');
                    $endMasuk = Carbon::parse($masuk[1])->format('His');
                    $startKeluar = Carbon::parse($keluar[0])->format('His');
                    $endKeluar = Carbon::parse($keluar[1])->format('His');

                    $absen = false;
                    $now = Carbon::now()->format('His');

                    if ($now < $startMasuk) {
                        echo "*absensi-diluar-waktu*";
                    }

                    if ($now >= $startMasuk && $now <= $endMasuk) {
                        $absen = true;
                        $ket = "masuk";
                        $status = 1;
                        $respon = "*masuk-tepat-waktu*";
                    }

                    if ($now > $endMasuk && $now <= $endMasuk + 3600) {
                        //3600 = 1 jam
                        $absen = true;
                        $ket = "masuk";
                        $status = 1;
                        $respon = "*telat-masuk*";
                    }

                    if ($now > $endMasuk + 3600 && $now < $startKeluar) {
                        //3600 = 1 jam
                        echo "*absensi-diluar-waktu-masuk-dan-keluar*";
                    }

                    if ($now >= $startKeluar && $now <= $endKeluar + 3600) {
                        $absen = true;
                        $ket = "keluar";
                        $status = 1;
                        $respon = "*keluar*";
                    }

                    if ($now > $endKeluar + 3600) {
                        echo "*absensi-diluar-waktu*";
                    }

                    if ($absen == true) {
                        $today = Carbon::now()->format('Y-m-d');
                        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

                        $absensi = Absensi::where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();

                        if (!$absensi) {
                            try {
                                Absensi::create([
                                    'device_id' => $device->id,
                                    'siswa_id' => $rfid->id,
                                    'hadir' => 1,
                                    'alpa' => 0,
                                    'masuk' => $status
                                ]);

                                History::create([
                                    'device_id' => $device->id,
                                    'rfid' => $rfid->rfid,
                                    'keterangan' => $ket
                                ]);

                                echo $respon;
                            } catch (\Throwable $th) {
                                echo "*gagal-insert-absensi*";
                            }
                        } else if ($absensi && $absensi->masuk == 1 && $absensi->keluar == 0) {
                            try {
                                $absensi->update([
                                    'keluar' => $status
                                ]);

                                History::create([
                                    'device_id' => $device->id,
                                    'rfid' => $rfid->rfid,
                                    'keterangan' => $ket
                                ]);

                                echo $respon;
                            } catch (\Throwable $th) {
                                echo "*gagal-insert-absensi*";
                            }
                        } else {
                            echo "*sudah-absensi*";
                        }
                    } else {
                        echo "*error-waktu-operasional*";
                    }
                } else {
                    echo "*rfid-tidak-ditemukan*";
                }
            } else {
                echo "*salah-secret-key*";
            }
        } else {
            echo "*salah-param*";
        }
    }

    public function absensiJson(Request $request)
    {
        if ($request->key && $request->iddev && $request->rfid) {
            $cekKey = SecretKey::find(1);

            if ($cekKey->key == $request->key) {
                $device = Device::find($request->iddev);

                if ($device) {
                    $rfid = Siswa::where('rfid', $request->rfid)->where('is_active', 1)->first() ?? User::where('rfid', $request->rfid)->where('is_active', 1)->first();

                    if ($rfid) {
                        if ($rfid->status_pelajar == 'Siswa') {

                            $waktu = WaktuOperasional::find(1);
                            $this->absensiSiswa($waktu, $rfid, $device);
                        } else if (isset($rfid->jabatan)) {

                            $jadwal = Jadwal::where('user_id', $rfid->id)->first();
                            $now = Carbon::now()->format('l');
                            $weekday = WaktuOperasional::find(2);
                            $saturday = WaktuOperasional::find(3);

                            if ($jadwal) {

                                if ($now == 'Monday') {
                                    if ($jadwal->monday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($weekday, $rfid, $device);
                                    }
                                }

                                if ($now == 'Tuesday') {
                                    if ($jadwal->tuesday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($weekday, $rfid, $device);
                                    }
                                }

                                if ($now == 'Wednesday') {
                                    if ($jadwal->wednesday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($weekday, $rfid, $device);
                                    }
                                }

                                if ($now == 'Thursday') {
                                    if ($jadwal->thursday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($weekday, $rfid, $device);
                                    }
                                }

                                if ($now == 'Friday') {
                                    if ($jadwal->friday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($weekday, $rfid, $device);
                                    }
                                }

                                if ($now == 'Saturday') {
                                    if ($jadwal->saturday == 0) {
                                        $notif = array('status' => 'failed', 'ket' => 'Tidak Ada Jadwal Hari Ini');
                                        echo json_encode($notif);
                                    } else {
                                        $this->absenStaff($saturday, $rfid, $device);
                                    }
                                }
                            } else {
                                $notif = array('status' => 'failed', 'ket' => 'Jadwal Belum Dibuat');
                                echo json_encode($notif);
                            }
                        }
                    } else {
                        $notif = array('status' => 'failed', 'ket' => 'RFID Tidak Ditemukan');
                        echo json_encode($notif);
                    }
                } else {
                    $notif = array('status' => 'failed', 'ket' => 'ID Device Tidak Ditemukan');
                    echo json_encode($notif);
                }
            } else {
                $notif = array('status' => 'failed', 'ket' => 'Salah Secret Key');
                echo json_encode($notif);
            }
        } else {
            $notif = array('status' => 'failed', 'ket' => 'Salah Parameter');
            echo json_encode($notif);
        }
    }

    public function absenStaff($waktu, $rfid, $device)
    {
        $masuk = explode(' - ', $waktu->waktu_masuk);
        $keluar = explode(' - ', $waktu->waktu_keluar);

        $startMasuk = Carbon::parse($masuk[0])->subMinute(10)->format('His');
        $endMasuk = Carbon::parse($masuk[1])->format('His');
        $startKeluar = Carbon::parse($keluar[1])->format('His');
        $endKeluar = Carbon::parse($keluar[1])->format('His');

        $absen = false;
        $today = Carbon::now()->format('His');

        if ($today < $startMasuk) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu'
            ];
            echo json_encode($response);
        }

        if ($today >= $startMasuk && $today <= $endMasuk) {
            $absen = true;
            $ket = "Masuk";
            $status = 1;
            $respon = "Masuk Tepat Waktu";
        }

        if ($today > $endMasuk && $today <= Carbon::parse($endMasuk)->format('His')) {
            $absen = true;
            $ket = "Telat Masuk";
            $status = 1;
            $respon = "Telat Masuk";
        }

        if ($today > Carbon::parse($endMasuk)->format('His') && $today < $startKeluar) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu Masuk dan Keluar'
            ];
            echo json_encode($response);
        }

        if ($today >= $startKeluar && $today <= Carbon::parse($endKeluar)->format('His')) {
            $absen = true;
            $ket = "Keluar";
            $status = 1;
            $respon = "Keluar";
        }

        if ($today > Carbon::parse($endKeluar)->format('His')) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu'
            ];
            echo json_encode($response);
        }

        if ($absen) {
            $today = Carbon::now()->format('Y-m-d');
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');

            $absensi = AbsensiStaff::where('user_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();


            if (!$absensi) {
                try {
                    AbsensiStaff::create([
                        'device_id' => $device->id,
                        'user_id' => $rfid->id,
                        'masuk' => $ket == 'Masuk' || $ket == 'Telat Masuk' ? $status : 0,
                        'waktu_masuk' => Carbon::now()->format('Y-m-d H:i:s'),
                        'status_hadir' => 'Hadir',
                        'ket' => $ket,
                    ]);

                    History::create([
                        'device_id' => $device->id,
                        'rfid' => $rfid->rfid,
                        'keterangan' => $ket
                    ]);

                    $response = [
                        'status' => 'success',
                        'ket' => $respon,
                        'flag' => 'staff',
                        'nama' => $rfid->nama,
                        'jabatan' => $rfid->jabatan,
                        'waktu' => date('d/m/Y H:i:s'),
                        'absensi' => 'Masuk'
                    ];
                    echo json_encode($response);
                } catch (\Throwable $th) {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'gagal insert absensi'
                    ];
                    echo json_encode($response);
                }
            } else if ($absensi && $absensi->masuk == 1 && $today <= $startKeluar) {
                $response = [
                    'status' => 'failed',
                    'ket' => 'Sudah Absensi'
                ];
                echo json_encode($response);
            } else if ($absensi && $absensi->masuk == 1 && $absensi->keluar == 0 && $today >= $startKeluar) {
                try {
                    $absensi->update([
                        'keluar' => $ket == 'Keluar' ? $status : 0,
                        'waktu_keluar' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    History::create([
                        'device_id' => $device->id,
                        'rfid' => $rfid->rfid,
                        'keterangan' => $ket
                    ]);


                    $response = [
                        'status' => 'success',
                        'ket' => $respon,
                        'flag' => 'staff',
                        'nama' => $rfid->nama,
                        'jabatan' => $rfid->jabatan,
                        'waktu' => date('d/m/Y H:i:s'),
                        'absensi' => 'Keluar'
                    ];
                    echo json_encode($response);
                } catch (\Throwable $th) {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'Gagal Insert Absensi'
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = array('status' => 'failed', 'ket' => 'Sudah Absensi');
                echo json_encode($response);
            }
        }
    }

    public function absensiSiswa($waktu, $rfid, $device)
    {
        $masuk = explode(' - ', $waktu->waktu_masuk);
        $keluar = explode(' - ', $waktu->waktu_keluar);

        $startMasuk = Carbon::parse($masuk[0])->format('His');
        $endMasuk = Carbon::parse($masuk[1])->format('His');
        $startKeluar = Carbon::parse($keluar[0])->format('His');
        $endKeluar = Carbon::parse($keluar[1])->format('His');

        $absen = false;
        $today = Carbon::now()->format('His');

        if ($today < $startMasuk) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu'
            ];
            echo json_encode($response);
        }

        if ($today >= $startMasuk && $today <= $endMasuk) {
            $absen = true;
            $ket = "Masuk";
            $status = 1;
            $respon = "Masuk Tepat Waktu";
        }

        if ($today > $endMasuk && $today <= Carbon::parse($endMasuk)->format('His')) {
            $absen = true;
            $ket = "Telat Masuk";
            $status = 1;
            $respon = "Telat Masuk";
        }

        if ($today > Carbon::parse($endMasuk)->format('His') && $today < $startKeluar) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu Masuk dan Keluar'
            ];
            echo json_encode($response);
        }

        if ($today >= $startKeluar && $today <= Carbon::parse($endKeluar)->format('His')) {
            $absen = true;
            $ket = "Keluar";
            $status = 1;
            $respon = "Keluar";
        }

        if ($today > Carbon::parse($endKeluar)->format('His')) {
            $response = [
                'status' => 'failed',
                'ket' => 'Absensi Diluar Waktu'
            ];
            echo json_encode($response);
        }

        if ($absen) {
            $today = Carbon::now()->format('Y-m-d');
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');

            $absensi = Absensi::where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();


            if (!$absensi) {
                try {
                    Absensi::create([
                        'device_id' => $device->id,
                        'siswa_id' => $rfid->id,
                        'masuk' => $ket == 'Masuk' || $ket == 'Telat Masuk' ? $status : 0,
                        'waktu_masuk' => Carbon::now()->format('Y-m-d H:i:s'),
                        'status_hadir' => 'Hadir',
                        'ket' => $ket
                    ]);

                    History::create([
                        'device_id' => $device->id,
                        'rfid' => $rfid->rfid,
                        'keterangan' => $ket
                    ]);

                    $response = [
                        'status' => 'success',
                        'ket' => $respon,
                        'flag' => 'siswa',
                        'nama' => $rfid->nama,
                        'kelas' => $rfid->kelas->nama,
                        'waktu' => date('d/m/Y H:i:s'),
                        'absensi' => 'Masuk'
                    ];
                    echo json_encode($response);
                } catch (\Throwable $th) {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'gagal insert absensi'
                    ];
                    echo json_encode($response);
                }
            } else if ($absensi->masuk == 1 && $today <= $startKeluar) {
                $response = [
                    'status' => 'failed',
                    'ket' => 'Sudah Absensi'
                ];
                echo json_encode($response);
            } else if ($absensi->masuk == 1 && $absensi->keluar == 0 && $today >= $startKeluar) {
                try {
                    $absensi->update([
                        'keluar' => $ket == 'Keluar' ? $status : 0,
                        'waktu_keluar' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    History::create([
                        'device_id' => $device->id,
                        'rfid' => $rfid->rfid,
                        'keterangan' => $ket
                    ]);


                    $response = [
                        'status' => 'success',
                        'ket' => $respon,
                        'flag' => 'siswa',
                        'nama' => $rfid->nama,
                        'kelas' => $rfid->kelas->nama,
                        'waktu' => date('d/m/Y H:i:s'),
                        'absensi' => 'Keluar'
                    ];
                    echo json_encode($response);
                } catch (\Throwable $th) {
                    $response = [
                        'status' => 'failed',
                        'ket' => 'Gagal Insert Absensi'
                    ];
                    echo json_encode($response);
                }
            } else {
                $response = array('status' => 'failed', 'ket' => 'Sudah Absensi');
                echo json_encode($response);
            }
        }
    }
}
