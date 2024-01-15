<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
class ProductCategoryController extends Controller
{
    public function getProductCategoryList(){
        $productCategoryList = ProductCategory::all();
        return view('Product-Category/list',compact('productCategoryList'));
    }
    public function viewCreateProductCategory(){
        return view('Product-Category/create');
    }
    public function handleCreateProductCategory(Request $request){
        if(empty($request->name)){
            return 'Missing parametter!';
        }
        $productCategory = new ProductCategory();
        $productCategory ->name = $request->name;
        $productCategory->save();
        $productCategory = ProductCategory::all();
        return response()->json([
            'success' =>true,
            'message' =>'Product category created success!',
            'data' =>$productCategory,
        ]);
    }
    public function viewUpdateProductCategory($id){
        $productCategory = ProductCategory::find($id);
        if(empty($productCategory)){
            return 'Product category not found!';
        }
        return response()->json([
            'data' => $productCategory
        ]);
    }
    public function handleUpdateProductCategory(Request $request,$id){
        if(empty($request->name)){
            return 'Missing parametter!';
        }
        $productCategory = ProductCategory::find($id);
        if(empty($productCategory)){
            return 'Product category not found!';
        }
        $productCategory ->name = $request ->name;
        $productCategory ->save();
        $productCategory = ProductCategory::all();
        return response()->json([
            'success' =>true,
            'data' =>$productCategory
        ]);
    }
    public function handleDeleteProductCategory($id){
        $productCategory = ProductCategory::find($id);
        if(empty($productCategory)){
            return 'Product category not found!';
        }
        $productCategory->delete();
        $productCategory = ProductCategory::all();
        return response()->json([
            'success' =>true,
            'data' => $productCategory
        ]);
    }
}