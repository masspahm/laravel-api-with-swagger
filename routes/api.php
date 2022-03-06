<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\AuthController;
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

Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
], function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::post('register', 'store');
        Route::middleware('auth:sanctum')->get('', 'index');
        Route::middleware('auth:sanctum')->get('{id}', 'show');
        Route::middleware('auth:sanctum')->put('{id}', 'update');
    });
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('login', 'login');
        Route::middleware('auth:sanctum')->post('logout', 'logout');
    });
    Route::apiResource('event', EventController::class)->middleware('auth:sanctum');
});
