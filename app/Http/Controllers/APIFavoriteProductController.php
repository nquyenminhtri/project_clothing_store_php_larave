<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
class APIFavoriteProductController extends Controller
{
    public function getFavoriteProductList(){
        $favoriteProductList = FavoriteProduct::all();
        return view('Favorite-Product/list',compact('favoriteProductList'));
    }
    public function handleCreateFavoriteProduct(Request $request){
        $favoriteProduct = FavoriteProduct::find($request->product_id);
        if(!$favoriteProduct){
            FavoriteProduct::create([
                'customer_id' =>$request ->customer_id,
                'product_id'=> $request ->product_id
            ]);
        }
        return response()->json([
            'success' =>true,
            'message' =>'The product has been added to favorites!',
            'data' =>$favoriteProduct
        ]);
    }
    public function handleDeleteFavoriteProduct(Request $request){
        $favoriteProduct = FavoriteProduct::find($request->product_id);
        $favoriteProduct ->delete();
        return response()->json([
            'success' =>true,
            'message' =>'The product has been removed from favorites! '
        ]);
    }
}