<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LotController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/create_new_lot', [LotController::class, 'store'])->name('dashboard.createLot');
    Route::delete('/delete_lot/{lot}', [LotController::class, 'destroy'])->name('dashboard.lot.destroy');
    Route::put('/update_lot/{lot}', [LotController::class, 'update'])->name('dashboard.updateLot');
});
Route::prefix('/admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard.index');
    Route::post('/new_category', [CategoryController::class, 'store'])->name('admin-dashboard.create_category');
    Route::put('/update_category/{category}', [CategoryController::class, 'update'])->name('admin-dashboard.update_category');
    Route::delete('/delete_category/{category}', [CategoryController::class, 'destroy'])->name('admin-dashboard.delete_category');
});
