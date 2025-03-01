<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

Route::resource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);

Route::Resource('category', CategoryController::class);

Route::resource('/users', UserController::class);
Route::get('/users/{user}/orders', [UserController::class, 'getUserOrders'])->name('users.orders');

Route::resource('orders', OrderController::class);

Route::resource('payments', PaymentController::class);
Route::get('/users/{user}/payments', [UserController::class, 'getUserPayments']);

Route::post('/products/attach-categories', [ProductController::class, 'attachCategories']);

Route::resource('employees', EmployeeController::class);
