<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Inventory\CategoryController;
use App\Http\Controllers\Api\Inventory\ItemController;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){

    // --- PUBLIC AUTH ROUTES (NO TOKEN REQUIRED) ---
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function(){

        //Inventory Item Routes (Crud with Search)
        Route::apiResource('items',ItemController::class);
        //Inventory Category Routes (Crud)
        Route::apiResource('categories', CategoryController::class);

        //Auth Roles Logout
        Route::post('logout',[AuthController::class, 'logout']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

    });




});
