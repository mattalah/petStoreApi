<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;
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

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::group(['namespace' => 'Pet', 'prefix' => 'pet'], function () {
    Route::get('findByStatus', [PetController::class, 'indexByStatus'])->middleware('auth:sanctum');
    Route::post('', [PetController::class, 'store'])->middleware('auth:sanctum');
    Route::put('{petId}', [PetController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{petId}', [PetController::class, 'destroy'])->middleware('auth:sanctum');
});