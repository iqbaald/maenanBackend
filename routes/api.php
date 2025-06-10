<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{RegisteredUserController, AuthenticatedSessionController,PasswordResetLinkController, NewPasswordController};
use App\Http\Controllers\{UserController, QrCodeController};

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/all-users', [UserController::class, 'index']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('/generate-qr', [QrCodeController::class, 'generate']);
});

Route::post('/verify-qr', [QrCodeController::class, 'verify']);