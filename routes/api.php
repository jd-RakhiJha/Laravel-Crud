<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', ProductController::class)->only(['index', 'store', 'destroy']);
Route::put('/products/update/{id}', [ProductController::class, 'update']);


Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('/category/store', [CategoryController::class, 'store']);
