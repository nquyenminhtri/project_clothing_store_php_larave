<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
class ProductImageController extends Controller
{
    public function getProductImageList(){
        $productImageList = ProductImage::all();
        return view('Product-Image/list',compact('productImageList'));
    }
    public function handleCreateProductImage(Request $request){
        
    }
    public function handleUpdateProductImage(Request $request){

    }
    public function handleDeleteProductImage(Request $request){
        
    }
}
