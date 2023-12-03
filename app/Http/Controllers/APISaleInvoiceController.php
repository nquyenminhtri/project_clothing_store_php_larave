<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductDetail;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceDetail;
use App\Models\Customer;
class APISaleInvoiceController extends Controller
{
    public function handleCreateSaleInvoice(Request $request) {
        try{
            $data = $request->json()->all();
        if(empty($data['customer_phone'])){
           return response()->json([
            'success' => false,
            'message' =>'Missing phone number!'
           ], 400);
        }
        $customer = Customer::where('phone', $data['customer_phone'])->first();
        if(!$customer){
            $customer = Customer::create([
                'name' =>$data['customer_name'],
                'gender' =>$data['customer_gender'],
                'phone' =>$data['customer_phone'],
                'address' =>$data['customer_address'],
            ]);
        }
        $saleInvoice = SaleInvoice::create([
            'customer_id' =>$customer->id,
            'export_date' =>$data['export_date'],
            'status' =>'unconfimred',
            'total_amount' =>$data['total_amount']
        ]);
    
        $saleInvoiceDetails = [];
    
        foreach($data['saleInvoiceDetail'] as $item){
            $saleInvoiceDetail = new SaleInvoiceDetail([
                'sale_invoice_id' => $saleInvoice->id,
                'product_id' =>$item['productItemId'],
                'size_id' =>$item['sizeItemId'],
                'color_id' =>$item['colorItemId'],
                'material_id'=>$item['materialItemId'],
                'quantity'=>$item['quantityItem'],
                'unit_price'=>$item['unitPriceItem'],
                'price_total'=>$item['priceTotal']
            ]);
    
            $saleInvoiceDetail->save();
            $saleInvoiceDetails[] = $saleInvoiceDetail;
    
            $productDetail = ProductDetail::where('product_id', $item['productItemId'])
                ->where('size_id', $item['sizeItemId'])
                ->where('color_id', $item['colorItemId'])->where('material_id',$item['materialItemId'])
                ->first();
    
            if($productDetail){
                $productDetail->quantity -= $item['quantityItem'];
                $productDetail->save();
            }
        }
    
        return response()->json([
            'success' => true,
            'message' =>'Order Success!',
            'data' =>$saleInvoiceDetails
        ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
        
    }
    
    public function handleSuccessSaleInvoice($id){
        $saleInvoice = SaleInvoice::find($id);
        $saleInvoice ->status = 'successed';
        $saleInvoice->save();
        return response()->json([
            'success' =>true,
            'message' =>'The order has been delivered!',
        ]);
    }
}