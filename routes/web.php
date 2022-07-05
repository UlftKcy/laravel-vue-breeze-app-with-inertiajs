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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/stocks', function () {
    return Inertia::render('Stocks/Index');
})->middleware(['auth', 'verified'])->name('stocks.index');

Route::post('/create-stock',[StockController::class,'store'])->name('create-stock.store');

require __DIR__.'/auth.php';
