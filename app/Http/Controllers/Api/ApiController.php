<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Device;
use App\Models\History;
use App\Models\Rfid;
use App\Models\SecretKey;
use App\Models\Siswa;
use App\Models\WaktuOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                            'rfid' => $request->rfid
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
                                    'ket' => 'berhasil tambah rfid card'
                                ];
                                echo json_encode($response);
                            } else {
                                $response = [
                                    'status' => 'failed',
                                    'ket' => 'terjadi kesalahan'
                                ];
                                echo json_encode($response);
                            }
                        }
                    } else {
                        $response = [
                            'status' => 'failed',
                            'ket' => 'device tidak ditemukan'
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
                $rfid = Siswa::where('rfid', $request->rfid)->first();

                if ($device) {
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
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu'
                            ];
                            echo json_encode($response);
                        }

                        if ($now >= $startMasuk && $now <= $endMasuk) {
                            $absen = true;
                            $ket = "masuk";
                            $status = 1;
                            $respon = "*masuk-tepat-waktu*";
                        }

                        if ($now > $endMasuk && $now <= Carbon::parse($endMasuk)->addHour()->format('His')) {
                            //3600 = 1 jam
                            $absen = true;
                            $ket = "masuk";
                            $status = 1;
                            $respon = "*telat-masuk*";
                        }

                        if ($now > Carbon::parse($endMasuk)->addHour()->format('His') && $now < $startKeluar) {
                            //3600 = 1 jam
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu masuk dan keluar'
                            ];
                            echo json_encode($response);
                        }

                        if ($now >= $startKeluar && $now <= Carbon::parse($endKeluar)->addHour()->format('His')) {
                            $absen = true;
                            $ket = "keluar";
                            $status = 1;
                            $respon = "*keluar*";
                        }

                        if ($now > Carbon::parse($endKeluar)->addHour()->format('His')) {
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu'
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
                                        'alpa' => $ket == 'masuk' ? 0 : $status,
                                        'hadir' => $ket == 'masuk' ? $status : 0,
                                        'masuk' => $ket == 'masuk' ? $status : 0
                                    ]);

                                    History::create([
                                        'device_id' => $device->id,
                                        'rfid' => $rfid->rfid,
                                        'keterangan' => $ket
                                    ]);

                                    $response = [
                                        'status' => 'success',
                                        'ket' => $respon
                                    ];
                                    echo json_encode($response);
                                } catch (\Throwable $th) {
                                    $response = [
                                        'status' => 'failed',
                                        'ket' => 'gagal insert absensi'
                                    ];
                                    echo json_encode($response);
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


                                    $response = [
                                        'status' => 'success',
                                        'ket' => $respon
                                    ];
                                    echo json_encode($response);
                                } catch (\Throwable $th) {
                                    $response = [
                                        'status' => 'failed',
                                        'ket' => 'gagal insert absensi'
                                    ];
                                    echo json_encode($response);
                                }
                            } else {
                                $notif = array('status' => 'failed', 'ket' => 'sudah absensi');
                                echo json_encode($notif);
                            }
                        } else {
                            $notif = array('status' => 'failed', 'ket' => 'error waktu operasional');
                            echo json_encode($notif);
                        }
                    } else {
                        $notif = array('status' => 'failed', 'ket' => 'rfid tidak ditemukan');
                        echo json_encode($notif);
                    }
                } else {
                    $notif = array('status' => 'failed', 'ket' => 'id device tidak ditemukan');
                    echo json_encode($notif);
                }
            } else {
                $notif = array('status' => 'failed', 'ket' => 'salah secret key');
                echo json_encode($notif);
            }
        } else {
            $notif = array('status' => 'failed', 'ket' => 'salah parameter');
            echo json_encode($notif);
        }
    }
}
