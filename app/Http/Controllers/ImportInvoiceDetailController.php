<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportInvoiceDetail;
use App\Models\Size;
use App\Models\Color;
use App\Models\Material;
class ImportInvoiceDetailController extends Controller
{
    public function getImportInvoiceDetailList($id){
        $importInvoiceDetailList = ImportInvoiceDetail::where('import_invoice_id',$id)->get();
        $sizeList = Size::all();
        $colorList = Color::all();
        $materialList = Material::all();
        return view('Import-Invoice-Detail/list',compact('importInvoiceDetailList','sizeList','colorList','materialList'));

    }
    public function viewUpdateImportInvoiceDetail($id){
        $importInvoiceDetail = ImportInvoiceDetail::where('import_invoice_id',$id)->get();
        if(!$importInvoiceDetail){
            return response()->json([
                'success' =>false,
                'message' =>'Import invoice detail not found!'
            ]);
        }
        return response()->json([
            'success' =>true,
            'data'=>$importInvoiceDetail,
        ]);

    }
    public function handleUpdateImportInvoiceDetail(Request $request,$id){  
        if(empty($request)){
            return response()->json([
                'success' =>false,
                'message' =>'Missing parametters!'
            ]);
        }
        $importInvoiceDetail = ImportInvoiceDetail::find($id)->first();
        if(!$importInvoiceDetail){
            return response()->json([
                'success'=>false,
                'message'=>'Import invoice detail not found!'
            ]);
        }
        $importInvoiceDetail ->import_invoice_id = $request->import_invoice_id;
        $importInvoiceDetail ->product_id = $request->product_id;
        $importInvoiceDetail ->size_id = $request ->size_id;
        $importInvoiceDetail ->color_id = $request ->color_id;
        $importInvoiceDetail ->material_id = $request ->material_id;
        $importInvoiceDetail ->quantity = $request ->quantity;
        $importInvoiceDetail ->import_price = $request ->import_price;
        $importInvoiceDetail ->sale_price = $request ->sale_price;
        $importInvoiceDetail ->import_price_total = $request ->import_price_total;
        $importInvoiceDetail ->save();
        return response()->json([
            'success' =>true,
            'message' =>'Import invoice updated completed!'
        ]);
    }
    public function handleDeleteImportInvoiceDetail($id){
        $importInvoiceDetail = ImportInvoiceDetail::find($id);
        if(!$importInvoiceDetail){
            return response()->json([
                'success' =>false,
                'message' =>'Import invoice detail not found!',
            ]);
        }
        $importInvoiceDetail ->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Import invoice detail deleted successfully!'
        ]);
    }
}