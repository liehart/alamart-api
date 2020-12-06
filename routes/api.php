<?php

use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\UserController;
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

Route::resource('barang', BarangController::class);
Route::resource('user', UserController::class);
Route::get('verify/{token}', [UserController::class, 'verify']);
Route::post('login', [UserController::class, 'login']);
