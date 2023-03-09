<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getCategoriesList', [CategoryController::class, 'indexApi']);
Route::post('/getCategoriesLots', [CategoryController::class, 'getCategoriesLots']);
Route::post('/newLotPrice/{lot_id}', [LotController::class, 'setNewPrice']);
