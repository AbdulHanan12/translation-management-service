<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\LocaleController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\AuthController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Translation routes
    Route::apiResource('translations', TranslationController::class);
    
    // Locale routes
    Route::apiResource('locales', LocaleController::class);
    
    // Tag routes
    Route::apiResource('tags', TagController::class);
}); 