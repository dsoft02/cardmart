<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ExamTypeController;
use App\Http\Controllers\Admin\PinController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware(['web', 'auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Sales
        |--------------------------------------------------------------------------
        */
        Route::resource('orders', OrderController::class)
            ->only(['index', 'show']);

        Route::get('payments', [PaymentController::class, 'index'])
            ->name('payments.index');

        Route::get('payments/{order}', [PaymentController::class, 'show'])
            ->name('payments.show');


        /*
        |--------------------------------------------------------------------------
        | Inventory
        |--------------------------------------------------------------------------
        */
        Route::resource('exam-types', ExamTypeController::class);
        Route::post('exam-types/{examType}/import-pins', [ExamTypeController::class, 'importPins'])->name('exam-types.import-pins');

        Route::get('pins', [PinController::class, 'index'])->name('pins.index');
        Route::delete('pins/{pin}', [PinController::class, 'destroy'])->name('pins.destroy');
        Route::post('pins/import', [PinController::class, 'import'])->name('pins.import');
        Route::get('pins/template', [PinController::class, 'downloadTemplate'])->name('pins.template');
        Route::get('pins/import/failed-export', [PinController::class, 'exportFailed'])->name('pins.failed.export');


        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);

        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');


        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */
        Route::get('reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('reports/export/csv', [ReportController::class, 'exportCsv'])
            ->name('reports.export.csv');

        Route::get('reports/export/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.export.pdf');


        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */
        Route::get('settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('settings', [SettingController::class, 'update'])
            ->name('settings.update');


        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
