<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\History;
use App\Models\Rfid;
use App\Models\SecretKey;
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
}
