<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductsController::class);
});

Route::fallback(function(){
    return response()->json(['success'=>false,'message' => 'Not Found!'], 404);
});

// Route::get('products', [ProductsController::class, 'index'])->name('products.index');
// Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');

// Route::post('products', [ProductsController::class, 'store'])->name('products.store');

// Route::put('products/{product}', [ProductsController::class, 'update'])->name('products.update');

// Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
