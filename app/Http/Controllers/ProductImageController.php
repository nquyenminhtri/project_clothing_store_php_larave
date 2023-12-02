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
    public function handleCreateProductImage(Request $request)
{
    // Validate the request

    if ($request->hasFile('images')) {
        $files = $request->file('images');

        foreach ($files as $file) {
            // Tạo tên tệp duy nhất
            $hashedFilename = time() . '_' . $file->getClientOriginalName();

            // Lưu tệp tin trong thư mục 'public/product-images'
            $file->storeAs('product-images', $hashedFilename, 'public');

            // Tạo một đối tượng ProductImage mới
            $productImage = new ProductImage();
            $productImage ->product_id = $request->product_id;
            $productImage->image = $hashedFilename;
            $productImage->save();
        }

        return redirect()->route('product-image.list')->with('success', 'Image product created success!');
    }

    return back()->with('status', 'Image not found!');
}

    public function handleUpdateProductImage(Request $request){

    }
    public function handleDeleteProductImage(Request $request){
        
    }
}