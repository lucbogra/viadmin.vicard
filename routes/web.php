<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])->group(function () {

    Route::get('/', DashboardController::class);
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('customers/{customer}')->name('customers.')->group(function() {

        Route::get('cards', [CustomerController::class, 'cards'])->name('cards.index');

        Route::prefix('cards/{card}')->name('cards.')->group(function() {
            Route::get('/', [CustomerController::class, 'cardShow'])->name('show');
            Route::get('/transactions', [CustomerController::class, 'cardTransactions'])->name('transactions');
            Route::post('/withdraw',    [CustomerController::class, 'cardWithdraw'])->name('withdraw');
        });

        Route::get('card-requests', [CustomerController::class, 'cardRequests'])->name('card-requests.index');
        Route::put('card-requests/{card_request}', [CustomerController::class, 'cardRequestValidation'])->name('card-requests.update');
        
        Route::get('topup-requests', [CustomerController::class, 'cardTopupRequests'])->name('topup-requests.index');
        Route::put('topup-requests/{card_request}', [CustomerController::class, 'cardTopupRequestValidation'])->name('topup-requests.update');

    });

    Route::resource('/customers', CustomerController::class);

    Route::get('card-requests', [RequestController::class, 'cardRequests'])->name('card-requests.index');
    
    Route::get('topup-requests', [RequestController::class, 'topupRequests'])->name('topup-requests.index');
    
    Route::get('cards', [CardController::class, 'index'])->name('cards.index');

    Route::prefix('settings')->name('settings.')->group(function() {

        Route::resource('banks', BankController::class);

    });



});
