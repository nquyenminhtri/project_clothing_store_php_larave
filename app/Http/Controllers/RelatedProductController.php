<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RelatedProduct;
class RelatedProductController extends Controller
{
    public function getRelatedProduct(){
        $productList = Product::all();
        $relatedProduct = RelatedProduct::all();
        return view('Related-Product/list',compact('productList','relatedProduct'));
    }
}