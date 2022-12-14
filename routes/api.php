<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


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

Route::get('/product/all', [ProductController::class, 'allProduct']);
Route::get('/product/single/{id}', [ProductController::class, 'singleProduct']);
Route::post('/product/create', [ProductController::class, 'createProduct']);
Route::put('/product/update/{id}', [ProductController::class, 'updateProduct']);
Route::post('/product/updateImage/{id}', [ProductController::class, 'updateProductImage']);
Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct']);
