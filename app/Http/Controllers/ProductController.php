<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Color;
use App\Models\Material;
class ProductController extends Controller
{
    public function getProductList(){
        $productList = Product::all();
        $productCategoryList = ProductCategory::all();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        $data =[
            'productList' => $productList,
            'productCategoryList' =>$productCategoryList,
            'sizeList' =>$sizeList,
            'colorList' =>$colorList,
            'materialList' =>$materialList
        ];
        //  return response()->json([
        //     'data' =>$data
        //  ]);
        return view('Product/list',compact('productList','productCategoryList','sizeList','colorList','materialList'));

    }
    public function viewCreateProduct(){
        $productCategoryList = ProductCategory::all();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        return view('Product/create',compact('productCategoryList','sizeList','colorList','materialList'));
    }
    public function viewUpdateProduct($id){
        $product = Product::find($id);
        $productCategoryList = ProductCategory::all();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        return response()->json([
            'data'=> $product
        ]);
    }
    public function handleCreateProduct(Request $request){

        $productExisting = Product::where('name',$request->name)->first();
        if($productExisting){
            return response()->json([
                'success'=> false,
                'message' =>'Product already in system!'
            ]);
        }
        $product = new Product();
        $product-> name = $request->name;
        $product-> description = $request->description;
        $product ->category_id = $request->category_id;
        $product ->price = $request ->price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hashedFilename = $file->hashName();
            $file->storeAs('product-images', $hashedFilename, 'public');
            $product->image = $hashedFilename;
        }
        $product->save();
        $product = Product::with('productProductCategory')->get();
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully!',
            'data' => $product
        ]);
    }
    public function handleUpdateProduct(Request $request,$id){
        
        $product = Product::where('id',$id)->first();
        if(!$product ){
            return response()->json([
                'success'=>false,
                'message'=>'Product not found!'
            ]);
        }
        $product-> name = $request->name;
        $product-> description = $request->description;
        $product ->category_id = $request->category_id;
        $product ->price = $request ->price;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hashedFilename = $file->hashName();
            $file->storeAs('product-images', $hashedFilename, 'public');
            $product->image = $hashedFilename;
        }
        $product->save();
        $product = Product::with('productProductCategory')->get();
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
            'data' => $product
        ]);
    }
    public function handleDeleteProduct($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'success'=>false,
                'message' =>'Product not found!'
            ]);
        }
        if ($product->image) {
            $imagePath = public_path('product-images/' . $product->image);
    
            // Kiểm tra xem tệp có tồn tại không trước khi xóa
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $product ->delete();
        $product = Product::with('productProductCategory')->get();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!',
            'data' => $product
        ]);
    }
}