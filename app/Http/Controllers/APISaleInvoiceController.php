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
        $cart = $request->input('requestData.cart');
        $customerData = $request->input('requestData.customerData');
        $discount = $request->input('requestData.discount');
        $paymentMethod = $request->input('requestData.paymentMethod');
        $shippingPrice = $request->input('requestData.shippingPrice');
        $shippingMethod = $request->input('requestData.shippingMethod');
        $totalPriceCart = $request->input('requestData.totalPriceCart');
        
        try{
            
            if(!$customerData['phone']){
                return response()->json([
                    'success' => false,
                    'message' =>'Missing phone number!'
                ]);
            }
            
            $customer = Customer::where('phone', $customerData['phone'])->first();
            if(!$customer){
                $customer = Customer::create([
                    'name' =>$customerData['name'],
                    'gender' =>$customerData['gender'],
                    'phone' =>$customerData['phone'],
                    'address' =>$customerData['address'],
                ]);
            }
            
            $saleInvoice = SaleInvoice::create([
                'customer_id' =>$customer->id,
                'export_date' => date('Y-m-d H:i:s'),
                'status' =>'unconfimred',
                'shipping_id'=>$shippingMethod['id'],
                'payment_method'=>$paymentMethod,
                'total_amount' =>$totalPriceCart,
            ]);
        
            $saleInvoiceDetails = [];
        
            foreach ($cart as $cartItem) {
                $saleInvoiceDetail = new SaleInvoiceDetail([
                    'sale_invoice_id' => $saleInvoice->id,
                    'product_id' => $cartItem['product']['id'],
                    'size_id' => $cartItem['size_id'],
                    'color_id' => $cartItem['color_id'],
                    'quantity' => $cartItem['quantity'],
                    'unit_price' => $cartItem['product']['price'],
                    'price_total' => $cartItem['quantity'] * $cartItem['product']['price'],
                ]);
            
                $saleInvoiceDetail->save();
                $saleInvoiceDetails[] = $saleInvoiceDetail;
            
                $productDetail = ProductDetail::where('product_id', $cartItem['product']['id'])
                    ->where('size_id', $cartItem['size_id'])
                    ->where('color_id', $cartItem['color_id'])
                    ->first();
            
                if ($productDetail) {
                    $productDetail->quantity -= $cartItem['quantity'];
                    $productDetail->save();
                }
            }
        
            return response()->json([
                'success' => true,
                'message' =>'Order Success!',
                'data' =>$saleInvoiceDetails
            ]);
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