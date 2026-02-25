<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/exam/{slug}', [ExamController::class, 'show'])->name('exam.show');
Route::post('/orders', [OrderController::class, 'create'])->name('order.store')->middleware('auth');
Route::get('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');
Route::post('/paystack/webhook', [WebhookController::class, 'handle']);

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/admin.php';
