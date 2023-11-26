<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
class FavoriteProductController extends Controller
{
    public function getFavoriteProductList(){
        $favoriteProductList = FavoriteProduct::all();
        return view('Favorite-Product/list',compact('favoriteProductList'));
    }
    public function handleCreateFavoriteProduct(Request $request){
        
    }
    public function handleUpdateFavoriteProduct(Request $request){

    }
    public function handleDeleteFavoriteProduct(Request $request){
        
    }
}
