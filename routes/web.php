<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/warehouses', WarehouseController::class);

    Route::prefix('/warehouses/{warehouse}')->group(function () {
        Route::resource('/items', ItemController::class);

        Route::prefix('/items/{item}')->group(function () {
            Route::post('/store', [ItemLogController::class, 'store'])->name('logs.store');
            Route::get('/add', [ItemLogController::class, 'add'])->name('logs.add');
            Route::get('/remove', [ItemLogController::class, 'remove'])->name('logs.remove');
            Route::resource('/logs', ItemLogController::class);
            Route::get('/export', [ItemController::class, 'export'])->name('items.export');
        });
    });
});

require __DIR__ . '/auth.php';
