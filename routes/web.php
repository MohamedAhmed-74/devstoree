<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::POST('/products',[ProductController::class,'store'])->name('products.store');
Route::get('/success',[ProductController::class , 'store()'])->name('products.success');
