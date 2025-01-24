<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\RabbitMQController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify/otp', [AuthController::class, 'verifyOTP']);
});

Route::prefix('users')->group(function () {
    Route::post('', [UsersController::class, "register"]);
    Route::get('', [UsersController::class, "users"]);
});

Route::post('/webhook/rabbitmq/process/file', [RabbitMQController::class, 'fileProcess']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('uploads')->group(function () {
        Route::get('', [UploadController::class, 'history']);
        Route::post('', [UploadController::class, 'upload']);
    });

    Route::prefix('files')->group(function () {
        Route::get('', [ContentController::class, 'contentFile']);
    });
});
