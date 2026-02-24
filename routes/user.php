<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    DashboardController,
    OrderController,
    PaymentController,
    ProfileController,
};

Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{order}/cards', [OrderController::class, 'cards'])->name('orders.cards');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{order}', [PaymentController::class, 'show'])->name('payments.show');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

});
