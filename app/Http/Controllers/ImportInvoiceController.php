<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportInvoice;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Size;
use App\Models\Color;
use App\Models\Material;
use App\Models\ImportInvoiceDetail;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Validator;
class ImportInvoiceController extends Controller
{
    public function getImportInvoiceList(){
        $importInvoiceList = ImportInvoice::all();
        return view('Import-Invoice/list',compact('importInvoiceList'));
    }
    public function viewCreateImportInvoice(){
        
        $supplierList = Supplier::all();
        $productList = Product::all();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        return view('Import-Invoice/create',compact('supplierList','productList','sizeList','colorList','materialList'));
    }
    public function handleCreateImportInvoice(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'supplier_id' => 'required',
        'import_date' => 'required',
        // Add other required fields here
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ]);
    }

    // Create import invoice
    $importInvoice = ImportInvoice::create([
        'supplier_id' => $request->supplier_id,
        'import_date' => $request->import_date,
        'total_amount' => $request->total_amount,
    ]);

    // Create import invoice detail
    foreach ($request->productID as $key => $productId) {
        ImportInvoiceDetail::create([
            'import_invoice_id' => $importInvoice->id,
            'product_id' => $productId,
            'size_id' => $request->sizeID[$key],
            'color_id' => $request->colorID[$key],
            'material_id' => $request->materialID[$key],
            'quantity' => $request->quantity[$key],
            'import_price' => $request->importPrice[$key],
            'sale_price' => $request->salePrice[$key],
            'import_price_total' => $request->total[$key],
        ]);
    }
    foreach ($request->productID as $key => $productId) {
        ProductDetail::create([
            'product_id' => $productId,
            'size_id' => $request->sizeID[$key],
            'color_id' => $request->colorID[$key],
            'material_id' => $request->materialID[$key],
            'quantity' => $request->quantity[$key],
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Import invoice created successfully!',
    ]);
}
    public function handleUpdateImportInvoice(Request $request){
        
    }
    public function handleDeleteImportInvoice(Request $request){
        
    }
}