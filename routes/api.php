<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [ApiController::class, 'index']);
Route::get('/getmode', [ApiController::class, 'getMode']);
Route::get('/getmodejson', [ApiController::class, 'getModeJson']);
Route::get('/addcard', [ApiController::class, 'addCard']);
Route::get('/addcardjson', [ApiController::class, 'addCardJson']);
Route::get('/absensi', [ApiController::class, 'absensi']);
Route::get('/absensijson', [ApiController::class, 'absensiJson']);
