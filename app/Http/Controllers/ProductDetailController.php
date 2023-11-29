<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Size;
use App\Models\Color;
use App\Models\Material;
class ProductDetailController extends Controller
{
    public function getProductDetailList($id){
        $productDetailList = ProductDetail::where('product_id',$id)->get();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        if(!$productDetailList){
            return view('Product-Detail/list',compact('productDetailList','sizeList','colorList','materialList'));
        }
        return view('Product-Detail/list',compact('productDetailList','sizeList','colorList','materialList'));
    }
    public function viewUpdateProductDetail(Request $request,$id){
        $productDetail = ProductDetail::find($id);
        
        if(!$productDetail){
            return response()->json([
                'success'=>false,
                'message'=>'Product not found!'
            ]);
        }

        return response()->json([
            'success'=>true,
            'data'=>$productDetail
        ]);
    }
    public function handleUpdateProductDetail(Request $request,$id){
        $productDetail = ProductDetail::find($id)->first();
        if(!$productDetail){
            return response()->json([
                'success'=>false,
                'message'=>'Product not found!'
            ]);
        }
        $productDetail ->size_id = $request->size_id;
        $productDetail ->color_id = $request->color_id;
        $productDetail ->material_id = $request->material_id;
        $productDetail->quantity = $request->quantity;
        $productDetail->save();
        return response()->json([
            'success'=>true,
            'message'=>'Product detail updated complete!'
        ]);
    }
    public function handleDeleteProductDetail($id){
        $productDetail = ProductDetail::find($id)->first();
        if(!$productDetail){
            return response()->json([
                'success'=>false,
                'message'=>'Product detail not found!'
            ]);
        }
        $productDetail ->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Product detail deleted completed!'
        ]);
    }
}