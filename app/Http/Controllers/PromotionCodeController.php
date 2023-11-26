<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionCode;
class PromotionCodeController extends Controller
{
    public function getProductCategoryList(){
        $productCategoryList = ProductCategory::all();
        return view('Product-Category/list',compact('productCategoryList'));
    }
    public function handleCreateProductCategory(Request $request){
        
    }
    public function handleUpdateProductCategory(Request $request){

    }
    public function handleDeleteProductCategory(Request $request){
        
    }
}
