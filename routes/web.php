<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/exam/{slug}', [ExamController::class, 'show'])->name('exam.show');
Route::post('/orders', [OrderController::class, 'create'])->name('order.store')->middleware('auth');
Route::get('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';

Route::get('/clear-cache', function () {

    $password = env('CACHE_CLEAR_PASSWORD');

    if (Request::query('password') !== $password) {
        return redirect('/')
            ->with('error', 'Unauthorized access.');
    }

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return redirect('/')
        ->with('success', 'Application cache cleared successfully!');
});


// Route::get('/__symlink', function () {
//     Artisan::call('storage:link');

//     return 'Symlink created';
// });
