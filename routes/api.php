<?php

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


Route::post('/auth/register', [\App\Http\Controllers\Api\AuthController::class, 'createUser']);
Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'loginUser']);

// Route::get('/coll/data', [\App\Http\Controllers\Api\NumbersController::class, 'index']);


################################ UserController ########################################


Route::get('index', [\App\Http\Controllers\Api\UserController::class, 'index']);
Route::get('index/{id}', [\App\Http\Controllers\Api\UserController::class, 'show']);
Route::post('store', [\App\Http\Controllers\Api\UserController::class, 'store']);
Route::post('update/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);
Route::delete('destroy/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy']);