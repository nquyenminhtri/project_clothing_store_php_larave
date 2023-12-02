<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIProductController;
use App\Http\Controllers\APIFavoriteProductController;
use App\Http\Controllers\APIRatingController;
use App\Http\Controllers\APISaleInvoiceController;
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

//Product 
Route::get('/product/list', [APIProductController::class, 'getProductList']);
Route::get('/product/{id}', [APIProductController::class, 'getOneProductDetail']);

//Favorite Product 
Route::get ('/product/favorite',[APIFavoriteProductController::class,'getFavoriteProductList']);
Route::post('/product/favorite/{id}',[APIFavoriteProductController::class,'handleCreateFavoriteProduct']);
Route::delete('/product/favorite/{id}',[APIFavoriteProductController::class,'handleDeleteFavoriteProduct']);

//Rating
Route::post('/product/rating',[APIRatingController::class,'handleCreateRating']);

//Sale invoice 
Route::post('/sale-invoice',[APISaleInvoiceController::class,'handleCreateSaleInvoice']);
Route::post('/sale-invoice/received/{id}',[APISaleInvoiceController::class,'handleSuccessSaleInvoice']);