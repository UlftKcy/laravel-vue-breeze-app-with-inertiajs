<?php

use App\Http\Controllers\StockController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Register', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/create-stock', [StockController::class, 'store'])->name('create-stock.store');
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::delete('/destroy/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
    Route::post('/update-stock/{id}', [StockController::class, 'update'])->name('update-stock.update');
});

require __DIR__ . '/auth.php';
