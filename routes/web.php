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

Auth::routes(['register' => false]);

Route::middleware(['auth', 'isLogin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'update'])->name('profile.update');

    //Route Data Permission
    Route::resource('permission', PermissionController::class);

    //Route Data Role
    Route::resource('role', RoleController::class);

    //Route Data Users
    Route::post('/user/import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user/download', [UserController::class, 'download'])->name('user.download');
    Route::get('/dump/user', [UserController::class, 'dump'])->name('user.dump');
    Route::get('/user/{user:id}/status', [UserController::class, 'status'])->name('user.status');
    Route::get('/user/islogin', [UserController::class, 'islogin'])->name('user.islogin');
    Route::post('/user/{user:id}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::resource('user', UserController::class);

    //Route Data Kelas
    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');
    Route::get('/kelas/download', [KelasController::class, 'download'])->name('kelas.download');
    Route::get('/kelas/siswa', [KelasController::class, 'getSiswa'])->name('kelas.siswa');
    Route::post('/kelas/kenaikan', [KelasController::class, 'kenaikan'])->name('kelas.kenaikan');
    Route::resource('kelas', KelasController::class);

    //Route Data Siswa
    Route::get('/dump/siswa', [SiswaController::class, 'dump'])->name('siswa.dump');
    Route::get('/siswa/{siswa:id}/activated', [SiswaController::class, 'activated'])->name('siswa.activated');
    Route::get('/siswa/{siswa:id}/export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::post('/siswa/{siswa:id}/delete', [SiswaController::class, 'delete'])->name('siswa.delete');
    Route::resource('siswa', SiswaController::class);

    //Route Data Jadwal
    Route::get('/jadwal/set', [JadwalController::class, 'set'])->name('jadwal.set');
    Route::resource('jadwal', JadwalController::class);

    //Route Data Holiday
    Route::resource('holiday', HolidayController::class);

    //Route Data Device
    Route::post('/device/{device:id}/change', [DeviceController::class, 'change'])->name('device.change');
    Route::resource('device', DeviceController::class);

    //Route Data Rfid
    Route::resource('rfid', RfidController::class);

    //Route Data History
    Route::resource('history', HistoryController::class);

    //Route Data Absensi
    Route::get('/absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');
    Route::get('/absensi/report', [AbsensiController::class, 'report'])->name('absensi.report');
    Route::get('/absensi/export-report', [AbsensiController::class, 'generate'])->name('absensi.generate');
    Route::get('/absensi/{absensi:id}/change', [AbsensiController::class, 'change'])->name('absensi.change');
    Route::resource('absensi', AbsensiController::class);

    //Route Data Absensi Staff
    Route::get('/absensi-staff/export', [AbsensiStaffController::class, 'export'])->name('absensi-staff.export');
    Route::get('/absensi-staff/report', [AbsensiStaffController::class, 'report'])->name('absensi-staff.report');
    Route::get('/absensi-staff/export-report', [AbsensiStaffController::class, 'generate'])->name('absensi-staff.generate');
    Route::get('/absensi-staff/{absensiStaff:id}/change', [AbsensiStaffController::class, 'change'])->name('absensi-staff.change');
    Route::resource('absensi-staff', AbsensiStaffController::class);



    // Route Setting
    Route::post('setting-update-waktu/{id}', [DashboardController::class, 'updateWaktu'])->name('setting.update.waktu');
    Route::get('setting', [DashboardController::class, 'setting'])->name('setting');
});

// Route::get('/install', function () {
//     shell_exec('composer install');
//     shell_exec('cp .env.example .env');
//     Artisan::call('key:generate');
//     Artisan::call('migrate:fresh --seed');
//     Artisan::call('storage:link');
//     Artisan::call('cache:clear');
// });
