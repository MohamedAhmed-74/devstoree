<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiProductController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/categories',[ApiCategoryController::class,'all'])->middleware('auth:sanctum');


// Route::get('/categories/show/{id}',[ApiCategoryController::class,'show']);

// Route::post('/categories/create',[ApiCategoryController::class,'create']);

// Route::put('/categories/update/{id}',[ApiCategoryController::class,'update']);

// Route::delete('/categories/delete/{id}',[ApiCategoryController::class,'delete']);



Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::post`




Route::get('/products/show/{id}',[ApiProductController::class,'show']);
