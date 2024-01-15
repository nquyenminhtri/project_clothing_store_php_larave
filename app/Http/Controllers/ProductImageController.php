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
    public function getProductImageListByProductId($productId){
        $productImageList = ProductImage::where('product_id', $productId)->get();
        return view('Product-Image/list', ['productImageList' => $productImageList, 'productId' => $productId]);
    }
    public function handleCreateProductImage(Request $request)
    {
       
        // Validate the request
        if ($request->hasFile('images')) {
            $files = $request->file('images');
    
            foreach ($files as $file) {
                try {
                    // Validate file type if needed
    
                    // Create a unique file name
                    $hashedFilename = time() . '_' . $file->getClientOriginalName();
    
                    // Check and create storage directory if not exists
                    $storagePath = public_path('product-images');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }
    
                    // Save the file in the 'public/product-images' directory
                    $file->storeAs('product-images', $hashedFilename, 'public');
    
                    // Check if 'product_id' exists and is valid
    
                    // Create a new ProductImage object
                    $productImage = new ProductImage();
                    $productImage->product_id = $request->product_id;
                    $productImage->name = $hashedFilename;
                    $productImage->save();
                } catch (\Exception $e) {
                    // Handle exceptions (e.g., file type not allowed, directory creation failed)
                    return back()->with('error', 'Error uploading images: ' . $e->getMessage());
                }
            }
            $productImage = ProductImage::all();
            return response()->json([
                'success' =>true,
                'message' => 'Add image successfully !',
                'data' => $productImage,
            ]);
        }
    
        return back()->with('error', 'Images not found!');
    }

    public function handleUpdateProductImage(Request $request){

    }
    public function handleDeleteProductImage(Request $request){
        
    }
}