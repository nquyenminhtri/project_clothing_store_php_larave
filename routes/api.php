<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIProductController;
use App\Http\Controllers\APIFavoriteProductController;
use App\Http\Controllers\APIRatingController;
use App\Http\Controllers\APISaleInvoiceController;
use App\Http\Controllers\APICommentController;
use App\Http\Controllers\APICustomerAuthController;
use App\Http\Controllers\APISlideController;
use App\Http\Controllers\APILoginFacebookController;
use App\Http\Controllers\APIPromotionController;
use App\Http\Controllers\APIShippingController;
use App\Http\Controllers\APIMaterialController;
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
Route::get('/product/rating/{id}',[APIRatingController::class,'getRatingProductByProductId']);

//Sale invoice 
Route::post('/sale-invoice',[APISaleInvoiceController::class,'handleCreateSaleInvoice']);
Route::get('/sale-invoice/received/{id}',[APISaleInvoiceController::class,'handleSuccessSaleInvoice']);
Route::get('/sale-invoice/customer/{id}',[APISaleInvoiceController::class,'getSaleInvoiceByIdCustomer']);

//comment
Route::post('/comment/create',[APICommentController::class,'handelCreateComment']);

//Login Customer
Route::post('/customer/login',[APICustomerAuthController::class,'handleCustomerLogin']);
Route::post('/customer/logout', [APICustomerAuthController::class,'handleCustomerLogout']);

//Sign up Customer 
Route::post('/customer/sign-up',[APICustomerAuthController::class,'handleCustomerRegistration']);

//update account customer
Route::put('/customer/update',[APICustomerAuthController::class,'handleUpdateCustomerAccount']);

//reset password customer
Route::post('/customer/reset-password',[APICustomerAuthController::class,'resetPassword']);
Route::post('/customer/change-password',[APICustomerAuthController::class,'checkPasswordFromCustomer']);
Route::put('/customer/change-password',[APICustomerAuthController::class,'handleChangePassword']);
Route::middleware('auth:api')->group(function () {

});

//Slide
Route::get('/slide/list',[APISlideController::class,'getSlideList']);

//Promotion
Route::post('/promotion',[APIPromotionController::class,'handlePromotionCode']);

//Shipping Method
Route::get('/shipping',[APIShippingController::class,'getShinppingMethodList']);

//Material 
Route::get('/material/list',[APIMaterialController::class,'getMaterialList']);