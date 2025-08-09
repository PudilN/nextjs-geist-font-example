<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kita definisikan route API untuk aplikasi.
|
*/

Route::post('/submit', [FinancialController::class, 'submit']);

// Route tambahan bisa dibuat di sini sesuai kebutuhan, misal:
// Route::get('/user/{id}/advice', [AIAdviceController::class, 'getAdvice']);
// Route::post('/user/register', [AuthController::class, 'register']);
