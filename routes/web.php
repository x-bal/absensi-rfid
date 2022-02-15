<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
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

    //Route Data Kelas
    Route::resource('kelas', KelasController::class);

    //Route Data Siswa
    Route::resource('siswa', SiswaController::class);

    //Route Data Device
    Route::resource('device', DeviceController::class);

    //Route Data Rfid
    Route::resource('rfid', RfidController::class);

    // Route Setting
    Route::get('setting', [DashboardController::class, 'setting'])->name('setting');
    Route::post('setting-update-waktu/{id}', [DashboardController::class, 'updateWaktu'])->name('setting.update.waktu');
});
