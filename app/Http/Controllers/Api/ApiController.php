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
                $checkRfid = Rfid::where('rfid', $request->rfid)->firstOrFail();

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
                                'device_id' => $newRfid->device_id,
                                'rfid' => $newRfid->rfid,
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
                $checkRfid = Rfid::where('rfid', $request->rfid)->firstOrFail();

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
                                'device_id' => $newRfid->device_id,
                                'rfid' => $newRfid->rfid,
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

                    $startMasuk = strtotime($masuk[0]);
                    $endMasuk = strtotime($masuk[1]);
                    $startKeluar = strtotime($keluar[0]);
                    $endKeluar = strtotime($keluar[1]);

                    $absen = false;

                    if (time() < $startMasuk) {
                        echo "*absensi-diluar-waktu*";
                    }

                    if (time() >= $startMasuk && time() <= $endMasuk) {
                        $absen = true;
                        $ket = "masuk";
                        $respon = "*masuk-tepat-waktu*";
                    }

                    if (time() > $endMasuk && time() <= $endMasuk + 3600) {
                        //3600 = 1 jam
                        $absen = true;
                        $ket = "masuk";
                        $respon = "*telat-masuk*";
                    }

                    if (time() > $endMasuk + 3600 && time() < $startKeluar) {
                        //3600 = 1 jam
                        echo "*absensi-diluar-waktu-masuk-dan-keluar*";
                    }

                    if (time() >= $startKeluar && time() <= $endKeluar + 3600) {
                        $absen = true;
                        $ket = "keluar";
                        $respon = "*keluar*";
                    }

                    if (time() > $endKeluar + 3600) {
                        echo "*absensi-diluar-waktu*";
                    }

                    if ($absen) {
                        $today = Carbon::now()->format('Y-m-d H:i:s');
                        $tomorrow = Carbon::tomorrow()->format('Y-m-d H:i:s');
                        $duplicate = 0;

                        $absenMasuk = Absensi::where('keterangan', 'masuk')->where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();

                        $duplicate = $absenMasuk ? 1 : 0;

                        $absenKeluar = Absensi::where('keterangan', 'keluar')->where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();

                        $duplicate = $absenKeluar ? 1 : 0;

                        if ($duplicate == 0) {
                            try {
                                Absensi::create([
                                    'device_id' => $device->id,
                                    'siswa_id' => $rfid->id,
                                    'hadir' => 1,
                                    'keterangan' => $ket
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

                        $startMasuk = strtotime($masuk[0]);
                        $endMasuk = strtotime($masuk[1]);
                        $startKeluar = strtotime($keluar[0]);
                        $endKeluar = strtotime($keluar[1]);

                        $absen = false;

                        if (time() < $startMasuk) {
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu'
                            ];
                            echo json_encode($response);
                        }

                        if (time() >= $startMasuk && time() <= $endMasuk) {
                            $absen = true;
                            $ket = "masuk";
                            $respon = "*masuk-tepat-waktu*";
                        }

                        if (time() > $endMasuk && time() <= $endMasuk + 3600) {
                            //3600 = 1 jam
                            $absen = true;
                            $ket = "masuk";
                            $respon = "*telat-masuk*";
                        }

                        if (time() > $endMasuk + 3600 && time() < $startKeluar) {
                            //3600 = 1 jam
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu masuk dan keluar'
                            ];
                            echo json_encode($response);
                        }

                        if (time() >= $startKeluar && time() <= $endKeluar + 3600) {
                            $absen = true;
                            $ket = "keluar";
                            $respon = "*keluar*";
                        }

                        if (time() > $endKeluar + 3600) {
                            $response = [
                                'status' => 'failed',
                                'ket' => 'absensi diluar waktu'
                            ];
                            echo json_encode($response);
                        }

                        if ($absen) {
                            $today = Carbon::now()->format('Y-m-d H:i:s');
                            $tomorrow = Carbon::tomorrow()->format('Y-m-d H:i:s');
                            $duplicate = 0;

                            $absenMasuk = Absensi::where('keterangan', 'masuk')->where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();

                            $duplicate = $absenMasuk ? 1 : 0;

                            $absenKeluar = Absensi::where('keterangan', 'keluar')->where('siswa_id', $rfid->id)->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->first();

                            $duplicate = $absenKeluar ? 1 : 0;

                            if ($duplicate == 0) {
                                try {
                                    Absensi::create([
                                        'device_id' => $device->id,
                                        'siswa_id' => $rfid->id,
                                        'hadir' => 1,
                                        'keterangan' => $ket
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
                                    echo json_encode($respon);
                                } catch (\Throwable $th) {
                                    $response = [
                                        'status' => 'failed',
                                        'ket' => 'gagal insert absensi'
                                    ];
                                    echo json_encode($respon);
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
