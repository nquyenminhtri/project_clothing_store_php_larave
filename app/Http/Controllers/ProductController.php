<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
class ProductController extends Controller
{
    public function getProductList(){
        $productList = Product::all();
        return view('Product/list',compact('productList'));
    }
    public function viewCreateProduct(){
        $productCategoryList = ProductCategory::all();
        return view('Product/create',compact('productCategoryList'));
    }
    public function viewUpdateProduct($id){
        $product = Product::find($id);
        return view('Product/create',compact('product'));
    }
    public function handleCreateProduct(Request $request){
        
    }
    public function handleUpdateProduct(Request $request){

    }
    public function handleDeleteProduct(Request $request){
        
    }
}
