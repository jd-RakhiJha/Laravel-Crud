<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Api\InventoryController;

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

Route::post('/files', [FileController::class, 'upload']);
Route::post('/files/multiple', [FileController::class, 'uploadMultiple']);
Route::delete('/files', [FileController::class, 'delete']);

Route::resource('products', ProductController::class);
Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('orders', OrderController::class);
Route::resource('payments', PaymentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('posts', PostController::class);
Route::resource('contacts', ContactController::class);
Route::resource('students', StudentController::class);
Route::resource('sections', SectionController::class);
Route::resource('classes', ClassesController::class);

Route::get('/users/{userId}/contacts', [UserController::class, 'checkUserContacts']);
Route::get('/classes-with-sections', [StudentController::class, 'classes_with_sections'])->name('classes-with-sections');
Route::post('/register', [RegisterController::class, 'register']);

// Inventory Routes
Route::prefix('inventory')->group(function () {
    Route::get('/', [InventoryController::class, 'index']);
    Route::get('/{inventory}', [InventoryController::class, 'show']);
    Route::post('/', [InventoryController::class, 'store']);
    Route::put('/{inventory}', [InventoryController::class, 'update']);
    Route::delete('/{inventory}', [InventoryController::class, 'destroy']);
    Route::get('/low-stock', [InventoryController::class, 'lowStock']);
    Route::get('/category/{categoryId}', [InventoryController::class, 'byCategory']);
    Route::get('/type/{type}', [InventoryController::class, 'byType']);
    Route::post('/{inventory}/stock/{quantity}/{operation?}', [InventoryController::class, 'updateStock']);
    Route::post('/attach/{modelType}/{modelId}', [InventoryController::class, 'attachToModel']);
    Route::get('/model/{modelType}/{modelId}', [InventoryController::class, 'getModelInventory']);
});
