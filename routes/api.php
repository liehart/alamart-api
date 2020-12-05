<?php

use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\UserController;
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

Route::resource('item', ItemController::class);
Route::resource('user', UserController::class);
Route::resource('transaksi', TransaksiController::class);
Route::get('verify/{token}', [UserController::class, 'verify']);
Route::post('login', [UserController::class, 'login']);
