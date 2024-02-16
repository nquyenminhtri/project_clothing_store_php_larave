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
use App\Models\Rating;
use App\Models\RelatedProduct;
class APIProductController extends Controller
{
    public function getProductList(){
        $productList = Product::all();
    
        if($productList->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Product is not available!',
            ]);
        }
    
        $formattedProductList = $productList->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' =>$product->description,
                'category_id' =>$product->productProductCategory,
                'price' => $product->price,
                'image_path' => asset("product-images/{$product->image}"),
                
            ];
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Success!',
            'data' => $formattedProductList,
        ]);
    }
    
    public function getOneProductDetail(Request $request,$productId){
        
        if ($request->has(['customer_id', 'viewed_at'])) {
            if(!ViewedProduct::where('product_id',$productId)->where('customer_id',$request->customer_id)->exists()){
                ViewedProduct::create([
                    'product_id' =>$request->product_id,
                    'customer_id' =>$request->customer_id,
                    'viewed_at' =>$request ->viewed_at
                ]);
            }
        }
        
        $size = Size::all();
        $color = Color::all();
        $material = Material::all();
        $productDetail = ProductDetail::where('product_id',$productId)->get();
        $checkProductExist = (bool)ProductDetail::where('product_id', $productId)->where('quantity', '>', 0)->first();
        $productImage = ProductImage::where('product_id',$productId)->get();
        $productImagesData = [];
        foreach ($productImage as $image) {
            $productImagesData[] = [
                'id' => $image->id,
                'product_id' => $image->product_id,
                'image_path' => asset("product-images/{$image->name}"), // Đường dẫn đầy đủ tới hình ảnh
            ];
        }


        $product = Product::find($productId);
        
        $relatedProducts = $product->relatedProducts;
        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->image_path = asset("product-images/{$relatedProduct->image}");
        }
        $relatedProductsData = [];
        foreach ($relatedProducts as $relatedProduct) {
            $relatedProductsData[] = [
                'id' => $relatedProduct->id,
                'name' => $relatedProduct->name,
                'description' => $relatedProduct->description,
                'category_id' => $relatedProduct->category_id,
                'price' => $relatedProduct->price,
                'image_path' => $relatedProduct->image_path,
            ];
        }

        $averageRating = Rating::where('product_id', $productId)->avg('star');
        if(empty($averageRating)){
            $averageRating = false;
        }
        if(empty($checkProductExist)){
            $checkProductExist = 0;
        }
        if(!$product){
            return response()->json([
                'success'=>false,
                'message' =>'Product not found!'
            ]);
        }
        return response()->json([
            'success' =>true,
            'data' =>[
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' =>$product->description,
                    'category_id' =>$product->category_id,
                    'price' => $product->price,
                    'image_path' => asset("product-images/{$product->image}")
                ],
                'sizes' => $size,
                'colors' => $color,
                'materials' => $material,
                'productImages' => $productImagesData,
                'averageRating' =>$averageRating,
                'productDetail'=>$productDetail,
                'checkProductExist' =>$checkProductExist,
                'relatedProducts' =>$relatedProductsData 
            ]
        ]);
        
    }
}