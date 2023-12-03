<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ImportInvoiceController;
use App\Http\Controllers\ImportInvoiceDetailController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\SaleInvoiceDetailController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SlideShowController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StatisticalController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layout');
// })->name('layout');



Route::middleware('auth:admin')->group(function(){

    //Home
    Route::get('',[HomeController::class,'index'])->name('layout');
    Route::get('sale-invoice/filter',[HomeController::class,'getData'])->name('sale-invoice.filter');


    //Admin
    Route::get('admin', [AdminController::class,'getAdminList'])->name('admin.list');
    Route::get('admin/create',[AdminController::class,'viewCreateAdmin'])->name('admin.create');
    Route::post('admin/create',[AdminController::class,'handleCreateAdmin'])->name('admin.handle-create');
    Route::get('admin/update/{id}',[AdminController::class,'viewUpdateAdmin'])->name('admin.update');
    Route::put('admin/update/{id}',[AdminController::class,'handleUpdateAdmin'])->name('admin.handle-update');
    Route::delete('admin/delete/{id}',[AdminController::class,'handleDeleteAdmin'])->name('admin.delete');

    //Customer
    Route::get('customer',[CustomerController::class,'getCustomerList'])->name('customer.list');
    Route::get('customer/create',[CustomerController::class,'viewCreateCustomer'])->name('customer.create');
    Route::post('customer/create',[CustomerController::class,'handleCreateCustomer'])->name('customer.handle-create');
    Route::get('customer/update/{id}',[CustomerController::class,'viewUpdateCustomer'])->name('customer.update');
    Route::put('customer/update/{id}',[CustomerController::class,'handleUpdateCustomer'])->name('customer.handle-update');
    Route::delete('customer/delete/{i}',[CustomerController::class,'handleDeleteCustomer'])->name('customer.delete');

    //Product
    Route::get('product',[ProductController::class,'getProductList'])->name('product.list');
    Route::get('product/create',[ProductController::class,'viewCreateProduct'])->name('product.create');
    Route::post('product/create',[ProductController::class,'handleCreateProduct'])->name('product.handle-create');
    Route::get('product/update/{id}',[ProductController::class,'viewUpdateProduct'])->name('product.update');
    Route::put('product/update/{id}',[ProductController::class,'handleUpdateProduct'])->name('product.handle-update');
    Route::delete('product/delete/{id}',[ProductController::class,'handleDeleteProduct'])->name('product.delete');

    //Product detail
    Route::get('product/detail/list/{id}',[ProductDetailController::class,'getProductDetailList'])->name('product.detail-list');
    Route::get('product/detail/update/{id}',[ProductDetailController::class,'viewUpdateProductDetail'])->name('product.detail-update');
    Route::put('product/detail/update/{id}',[ProductDetailController::class,'handleUpdateProductDetail'])->name('product.detail-handle-update');
    Route::delete('product/detail/delete/{id}',[ProductDetailController::class,'handleDeleteProductDetail'])->name('product.detail-delete');

    //Product Category
    Route::get('product-category',[ProductCategoryController::class,'getProductCategoryList'])->name('product-category.list');
    Route::get('product-category/create',[ProductCategoryController::class,'viewCreateProductCategory'])->name('product-category.create');
    Route::post('product-category/create',[ProductCategoryController::class,'handleCreateProductCategory'])->name('product-category.handle-create');
    Route::get('product-category/update/{id}',[ProductCategoryController::class,'viewUpdateProductCategory'])->name('product-category.update');
    Route::put('product-category/update/{id}',[ProductCategoryController::class,'handleUpdateProductCategory'])->name('product-category.handle-update');
    Route::delete('product-category/delete/{id}',[ProductCategoryController::class,'handleDeleteProductCategory'])->name('product-category.delete');


    //Color
    Route::get('color',[ColorController::class,'getColorList'])->name('color.list');
    Route::get('color/create',[ColorController::class,'viewCreateColor'])->name('color.create');
    Route::post('color/create',[ColorController::class,'handleCreateColor'])->name('color.handle-create');
    Route::get('color/update/{id}',[ColorController::class,'viewUpdateColor'])->name('color.update');
    Route::put('color/update/{id}',[ColorController::class,'handleUpdateColor'])->name('color.handle-update');
    Route::delete('color/delete/{id}',[ColorController::class,'handleDeleteColor'])->name('color.delete');


    //Size
    Route::get('size',[SizeController::class,'getSizeList'])->name('size.list');
    Route::get('size/create',[SizeController::class,'viewCreateSize'])->name('size.create');
    Route::post('size/create',[SizeController::class,'handleCreateSize'])->name('size.handle-create');
    Route::get('size/update/{id}',[SizeController::class,'viewUpdateSize'])->name('size.update');
    Route::put('size/update/{id}',[SizeController::class,'handleUpdateSize'])->name('size.handle-update');
    Route::delete('size/delete/{id}',[SizeController::class,'handleDeleteSize'])->name('size.delete');


    //Material
    Route::get('material',[MaterialController::class,'getMaterialList'])->name('material.list');
    Route::get('material/create',[MaterialController::class,'viewCreateMaterial'])->name('material.create');
    Route::post('material/create',[MaterialController::class,'handleCreateMaterial'])->name('material.handle-create');
    Route::get('material/update/{id}',[MaterialController::class,'viewUpdateMaterial'])->name('material.update');
    Route::put('material/update/{id}',[MaterialController::class,'handleUpdateMaterial'])->name('material.handle-update');
    Route::delete('material/delete/{id}',[MaterialController::class,'handleDeleteMaterial'])->name('material.delete');


    //Product Image
    //Sale invoice
    Route::get('sale-invoice',[SaleInvoiceController::class,'getSaleInvoiceList'])->name('sale-invoice.list');
    Route::post('sale-invoice/{id}',[SaleInvoiceController::class,'handleConfirmSaleInvoice'])->name('sale-invoice.confirm');
    Route::post('sale-invoice/cancel/{id}',[SaleInvoiceController::class,'handleCancelSaleInvoice'])->name('sale-invoice.cancel');


    //Sale invoice detail
    Route::get('sale-invoice/detail/list/{id}',[SaleInvoiceDetailController::class,'getSaleInvoiceDetailList'])->name('sale-invoice.detail-list');

    //Import invoice
    Route::get('import-invoice/list',[ImportInvoiceController::class,'getImportInvoiceList'])->name('import-invoice.list');
    Route::get('import-invoice/create',[ImportInvoiceController::class,'viewCreateImportInvoice'])->name('import-invoice.create');
    Route::post('import-invoice/create',[ImportInvoiceController::class,'handleCreateImportInvoice'])->name('import-invoice.handle-create');
    Route::get('import-invoice/update/{id}',[ImportInvoiceController::class,'viewUpdateImportInvoice'])->name('import-invoice.update');
    Route::put('import-invoice/update/{id}',[ImportInvoiceController::class,'handleUpdateImportInvoice'])->name('import-invoice.handle-update');
    Route::delete('import-invoice/delete/{id}',[ImportInvoiceController::class,'handleDeleteImportInvoice'])->name('import-invoice.delete');
    //import invoice detail
    Route::get('import-invoice/detail/list/{id}',[ImportInvoiceDetailController::class,'getImportInvoiceDetailList'])->name('import-invoice.detail-list');
    Route::get('import-invoice/detail/update/{id}',[ImportInvoiceDetailController::class,'viewUpdateImportInvoiceDetail'])->name('import-invoice.detail-update');
    Route::put('import-invoice/detail/update/{id}',[ImportInvoiceDetailController::class,'handleUpdateImportInvoiceDetail'])->name('import-invoice.detail-handle-update');
    Route::delete('import-invoice/detail/delete/{id}',[ImportInvoiceDetailController::class,'handleDeleteImportInvoiceDetail'])->name('import-invoice.detail-delete');
    

    //Slide
    Route::get('slide',[MaterialController::class,'getSlideList'])->name('slide.list');
    Route::get('slide/create',[SlideController::class,'viewCreateSlide'])->name('slide.create');
    Route::post('slide/create',[MaterialController::class,'handleCreateSlide'])->name('slide.handle-create');
    Route::get('slide/update/{id}',[SlideController::class,'viewUpdateSlide'])->name('slide.update');
    Route::put('slide/update/{id}',[SlideController::class,'handleUpdateSlide'])->name('slide.handle-update');
    Route::delete('slide/delete/{id}',[SlideController::class,'handleDeleteSlide'])->name('slide.delete');


    //Slide Show

    //Supplier
    Route::get('supplier',[SupplierController::class,'getSupplierList'])->name('supplier.list');
    Route::post('supplier/create',[SupplierController::class,'handleCreateSupplier'])->name('supplier.handle-create');
    Route::get('supplier/update/{id}',[SupplierController::class,'viewUpdateSupplier'])->name('supplier.update');
    Route::put('supplier/update/{id}',[SupplierController::class,'handleUpdateSupplier'])->name('supplier.handle-update');
    Route::delete('supplier/delete/{id}',[SupplierController::class,'handleDeleteSupplier'])->name('supplier.delete');

    //StatisticalController
    Route::get('/statistical',[StatisticalController::class,'viewStatistical']);
});



//Auth admin
Route::middleware('guest')->group(function(){
    Route::get('admin/login',[AdminAuthController::class,'indexLogin'])->name('admin.login');
    Route::post('admin/login',[AdminAuthController::class,'handleLogin'])->name('admin.handle-login');
});
Route::get('admin/logout',[AdminAuthController::class,'handleLogout'])->name('admin.logout');