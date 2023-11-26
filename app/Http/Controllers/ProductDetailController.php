<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
class ProductDetailController extends Controller
{
    public function getProductDetailList(){
        $productDetailList = ProductDetail::all();
        return view('Product-Detail/list',compact('productDetailList'));
    }
    public function handleCreateProductDetail(Request $request){
        
    }
    public function handleUpdateProductDetail(Request $request){

    }
    public function handleDeleteProductDetail(Request $request){
        
    }
}
