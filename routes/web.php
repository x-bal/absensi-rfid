<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiStaffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Route Data Permission
    Route::resource('permission', PermissionController::class);

    //Route Data Role
    Route::resource('role', RoleController::class);

    //Route Data Users
    Route::resource('user', UserController::class);
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');

    //Route Data Kelas
    Route::resource('kelas', KelasController::class);
    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

    //Route Data Siswa
    Route::resource('siswa', SiswaController::class);

    //Route Data Jadwal
    Route::resource('jadwal', JadwalController::class);

    //Route Data Holiday
    Route::resource('holiday', HolidayController::class);

    //Route Data Device
    Route::resource('device', DeviceController::class);
    Route::post('/device/{device:id}/change', [DeviceController::class, 'change'])->name('device.change');

    //Route Data Rfid
    Route::resource('rfid', RfidController::class);

    //Route Data History
    Route::resource('history', HistoryController::class);

    //Route Data Absensi
    Route::resource('absensi', AbsensiController::class);
    Route::get('absensi-masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::get('absensi-keluar', [AbsensiController::class, 'keluar'])->name('absensi.keluar');

    //Route Data Absensi Staff
    Route::resource('absensi-staff', AbsensiStaffController::class);
    Route::get('absensi-staff-masuk', [AbsensiStaffController::class, 'masuk'])->name('absensi-staff.masuk');
    Route::get('absensi-staff-keluar', [AbsensiStaffController::class, 'keluar'])->name('absensi-staff.keluar');

    // Route Setting
    Route::get('setting', [DashboardController::class, 'setting'])->name('setting');
    Route::post('setting-update-waktu/{id}', [DashboardController::class, 'updateWaktu'])->name('setting.update.waktu');
});


Route::get('/install', function () {
    shell_exec('composer install');
    shell_exec('cp .env.example .env');
    Artisan::call('key:generate');
    Artisan::call('migrate:fresh --seed');
    Artisan::call('storage:link');
    Artisan::call('cache:clear');
});
