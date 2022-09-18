<?php

use App\Http\Controllers\API\AnggotaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('anggota', AnggotaController::class);
Route::get('/anggota', [AnggotaController::class, 'index']);
Route::get('/anggota/{id}', [AnggotaController::class, 'show']);
Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy']);
Route::post('/anggota', [AnggotaController::class, 'store']);
Route::post('/anggota/{id}', [AnggotaController::class, 'update']);

Route::post('/users', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/logout', [UserController::class, 'logout']);
    Route::get('/users', [UserController::class, 'show']);
});
