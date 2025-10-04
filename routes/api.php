<?php

use App\Http\Controllers\Api\Admin\AddOns\AddOnController;
use App\Http\Controllers\Api\Admin\AddOns\ProductAddOnController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\Pricing\AvailabilityController;
use App\Http\Controllers\Api\Admin\Pricing\SeasonalPricingController;
use App\Http\Controllers\Api\Admin\Products\CategoryController;
use App\Http\Controllers\Api\Admin\Products\MediaController;
use App\Http\Controllers\Api\Admin\Products\ProductController;
use App\Http\Controllers\Api\Admin\Products\ProductUnitController;
use Illuminate\Http\Response;

Route::prefix('v1')->group(function () {
    // Admin Auth (public for login)
    Route::prefix('admin/auth')->group(function () {
        Route::post('login',  [LoginController::class, 'login'])->middleware('throttle:admin-login');
    });

    // Admin protected
    Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin,super_admin'])->group(function () {
        Route::get('auth/me',     [LoginController::class, 'me']);
        Route::post('auth/logout', [LoginController::class, 'logout']);
        Route::post('auth/logout-all', [LoginController::class, 'logoutAll']);

        Route::apiResource('products', ProductController::class);

        Route::apiResource('products.units', ProductUnitController::class)
            ->shallow()
            ->only(['index', 'store', 'update', 'destroy']);

        Route::apiResource('media', MediaController::class)->only(['store', 'destroy']);

        Route::apiResource('categories', CategoryController::class);

        Route::apiResource('seasonal-pricing', SeasonalPricingController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('availability', AvailabilityController::class)->only(['index', 'store', 'update', 'destroy']);

        Route::apiResource('add-ons', AddOnController::class);

        // Nested: products/{product}/add-ons (attach/list), shallow untuk update/destroy pivot
        Route::apiResource('products.add-ons', ProductAddOnController::class)
            ->shallow()
            ->only(['index', 'store', 'update', 'destroy']);
    });
});

Route::fallback(function ($e) {
    return errorResponse(
        name: 'Error::RequestError::NotFound',
        message: "The route $e could not be found.",
        statusCode: Response::HTTP_NOT_FOUND
    );
});
