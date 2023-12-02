<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ViewedProduct;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Size;
use App\Models\Color;
use App\Models\Material;
use App\Models\ProductImage;
class APIProductController extends Controller
{
    public function getProductList(){
        $productList = Product::all();
        if(!$productList){
            return response()->json([
                'success' =>false,
                'message' =>'Product is not available! '
            ]);
        }
        return response()->json([
            'success'=>true,
            'data' =>$productList
        ]);
    }
    public function getOneProductDetail(Request $request,$productId){
        
        if (!$request->has(['product_id','customer_id', 'viewed_at'])) {
            return response()->json([
                'success' => false,
                'message' => 'Missing parameters!'
            ]);
        }
        if(!ViewedProduct::where('product_id',$productId)->where('customer_id',$request->customer_id)->exists()){
            ViewedProduct::create([
                'product_id' =>$request->product_id,
                'customer_id' =>$request->customer_id,
                'viewed_at' =>$request ->viewed_at
            ]);
        }
        
        $size = Size::all();
        $color = Color::all();
        $material = Material::all();
        $productImage = ProductImage::all();
        $product = Product::find($productId);
        if(!$product){
            return response()->json([
                'success'=>false,
                'message' =>'Product not found!'
            ]);
        }
        return response()->json([
            'success' =>true,
            'data' =>[
                'product' => $product,
                'sizes' => $size,
                'colors' => $color,
                'materials' => $material,
                'productImages' => $productImage,
            ]
        ]);
        
    }
}