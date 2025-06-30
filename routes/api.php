<?php

use App\Http\Controllers\OfferPoolController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\CreditPackageController;
use App\Http\Controllers\CategoryController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/purchase', [PurchaseController::class, 'store']);
    Route::post('/product/redeem/{product_id}', [ProductController::class, 'redeem']);
    Route::get('/products/search', [ProductController::class, 'search']);

    Route::post('/ai/recommendation', [AIController::class, 'recommend']);

    // admin related routes
    Route::middleware(['is_admin'])->group(function () {

        //credit packages related apis
        Route::post('/creditpackage/add', [CreditPackageController::class, 'store']);
        Route::delete('/creditpackage/delete/{credit_package_id}', [CreditPackageController::class, 'destroy']);
        Route::put('/creditpackage/update/{credit_package_id}', [CreditPackageController::class, 'update']);

        //product related apis
        Route::post('/products/add', [ProductController::class, 'store']);
        Route::delete('/products/delete/{product_id}', [ProductController::class, 'destroy']);
        Route::put('/products/update/{product_id}', [ProductController::class, 'update']);

        //offerpool related apis
        Route::post('/offerpool/{product_id}', [OfferPoolController::class, 'store']);
        Route::delete('/offerpool/delete/{product_id}', [OfferPoolController::class, 'destroy']);

        //category related apis
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories/add', [CategoryController::class, 'store']);
        Route::delete('/categories/delete/{category_id}', [CategoryController::class, 'destroy']);
    });
});
