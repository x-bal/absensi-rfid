@extends('layouts.master', ['title' => 'Setting'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('setting.update.waktu', $waktu->id) }}" method="post">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-5 text-center">
                            <label for="waktu_masuk">Waktu Masuk Siswa</label>
                        </div>
                        <div class="col-md-5 text-center">
                            <label for="waktu_keluar">Waktu Keluar Siswa</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="telat_siswa">Batas Waktu Telat</label>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_masuk" id="waktu_awal_masuk" class="form-control text-center" value="{{ $masuk[0] ?? '-' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_masuk" id="waktu_akhir_masuk" class="form-control text-center" value="{{ $masuk[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_keluar" id="waktu_awal_keluar" class="form-control text-center" value="{{ $keluar[0] ?? '-' }}">
                                </div>

                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_keluar" id="waktu_akhir_keluar" class="form-control text-center" value="{{ $keluar[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="time" name="telat_siswa" id="telat_siswa" class="form-control text-center" value="{{ $waktu->telat ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 text-center">
                            <label for="waktu_masuk_week">Waktu Masuk Staff</label>
                        </div>
                        <div class="col-md-5 text-center">
                            <label for="waktu_keluar_week">Waktu Keluar Staff</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="telat_staff">Batas Waktu Telat</label>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_masuk_week" id="waktu_awal_masuk_week" class="form-control text-center" value="{{ $masukWeekday[0] ?? '-' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_masuk_week" id="waktu_akhir_masuk_week" class="form-control text-center" value="{{ $masukWeekday[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_keluar_week" id="waktu_awal_keluar_week" class="form-control text-center" value="{{ $keluarWeekday[0] ?? '-' }}">
                                </div>

                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_keluar_week" id="waktu_akhir_keluar_week" class="form-control text-center" value="{{ $keluarWeekday[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="time" name="telat_staff" id="telat_staff" class="form-control text-center" value="{{ $weekday->telat ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 text-center">
                            <label for="waktu_masuk_sat">Waktu Masuk Sabtu</label>
                        </div>
                        <div class="col-md-5 text-center">
                            <label for="waktu_keluar_sat">Waktu Keluar Sabtu</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="telat_sat">Batas Waktu Telat</label>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_masuk_sat" id="waktu_awal_masuk_sat" class="form-control text-center" value="{{ $masukSat[0] ?? '-' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_masuk_sat" id="waktu_akhir_masuk_sat" class="form-control text-center" value="{{ $masukSat[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="time" name="waktu_awal_keluar_sat" id="waktu_awal_keluar_sat" class="form-control text-center" value="{{ $keluarSat[0] ?? '-' }}">
                                </div>

                                <div class="col-md-6">
                                    <input type="time" name="waktu_akhir_keluar_sat" id="waktu_akhir_keluar_sat" class="form-control text-center" value="{{ $keluarSat[1] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="time" name="telat_sat" id="telat_sat" class="form-control text-center" value="{{ $saturday->telat ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Set Waktu</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mt-3">
                    <div class="col-sm-12 col-md-12">
                        <div class="card card-stats card-success card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="icon-big text-center">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                    <div class="col-10 col-stats">
                                        <div class="numbers">
                                            <h4 class="card-title">Secret Key</h4>
                                            <p class="card-category"><i class="fas fa-key"></i> {{ $secretKey->key }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->id == 1)
                    <div class="col-sm-12 col-md-12">
                        <div class="card card-stats card-warning card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="icon-big text-center">
                                            <i class="fas fa-link"></i>
                                        </div>
                                    </div>
                                    <div class="col-10 col-stats">
                                        <div class="numbers">
                                            <h4 class="card-title">Url Mode Device</h4>
                                            <p class="card-category">
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/getmode?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/getmodejson?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="card card-stats card-info card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="icon-big text-center">
                                            <i class="fas fa-link"></i>
                                        </div>
                                    </div>
                                    <div class="col-10 col-stats">
                                        <div class="numbers">
                                            <h4 class="card-title">Url Add Rfid Card</h4>
                                            <p class="card-category">
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/addcard?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/addcardjson?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="card card-stats card-secondary card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="icon-big text-center">
                                            <i class="fas fa-link"></i>
                                        </div>
                                    </div>
                                    <div class="col-10 col-stats">
                                        <div class="numbers">
                                            <h4 class="card-title">Url Absensi</h4>
                                            <p class="card-category">
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/absensi?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            <div>
                                                <i class="fab fa-chrome"></i> {{url()->to('/')}}/api/absensijson?key={{ $secretKey->key }}&iddev=XXX
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop