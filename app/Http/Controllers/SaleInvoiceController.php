<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
class SaleInvoiceController extends Controller
{
    public function index() {
        $dsExportInvoice = ExportInvoice::all();
        return response()->json(['data' => $dsExportInvoice]);
    }
    public function handleCreate(Request $request) {
        $data = $request->json()->all(); // Lấy dữ liệu từ request body
        // Xác minh xem dữ liệu đã được gửi đúng cấu trúc hay chưa
        if (!isset(  $data['name'],$data['email'],$data['phone'],$data['address'], $data['export_date'], $data['total_amount'], $data['detailExportInvoice'])) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
        }
        
        $customer = Customer::where('phone', $data['phone'])->first();

        if(empty($customer)){
            $customer = new Customer();
            $customer->name = $data['name'];
            $customer->email = $data['email'];
            $customer->phone = $data['phone'];
            $customer->address =$data['address'];
            $customer->save();
        }
        // Tạo ExportInvoice
        $exportInvoice = ExportInvoice::create([
            'customer_id' => $customer->id,
            'export_date' => $data['export_date'], 
            'total_amount' => $data['total_amount'],
        ]);
    
        $detailExportInvoiceData = $data['detailExportInvoice'];
    
        foreach ($detailExportInvoiceData as $item) {
            $detailExportInvoice = new DetailExportInvoice([
                'export_invoice_id' => $exportInvoice->id,
                'product_id' => $item['productIdItem'],
                'quantity' => $item['quantityItem'],
                'price' => $item['priceItem'],
                'total' => $item['totalItem'],
            ]);
    
            $detailExportInvoice->save();
            $savedDetailExportInvoices[] = $detailExportInvoice ;
    
             // Cập nhật lại số lượng sản phẩm
            $productSize = ProductSize::where('product_id',$item['productIdItem'])->where('size_id',$item['sizeIdItem'])->first();
            if($productSize){
                $productSize->quantity = $productSize->quantity - $item['quantityItem'];
                $productSize->save();
            }
            
        }
    
        return response()->json([
            'message' => 'Thêm thành công',
            'data' =>$detailExportInvoice
            ], 200);
    }
    public function handleDelete($id) {
        // Tìm hóa đơn xuất theo ID
        $exportInvoice = ExportInvoice::find($id);
    
        if (!$exportInvoice) {
            return response()->json(['message' => 'Hóa đơn xuất không tồn tại'], 404);
        }
    
        // Xóa hóa đơn xuất và các chi tiết
        $exportInvoice->delete();
    
        return response()->json(['message' => 'Xóa hóa đơn xuất thành công']);
    }
    public function handleUpdate(Request $request, $id) {
        $data = $request->json()->all(); // Lấy dữ liệu từ request body
    
        // Xác minh xem dữ liệu đã được gửi đúng cấu trúc hay chưa
        if (!isset($data['customer_id'], $data['export_date'], $data['total_amount'], $data['detailExportInvoice'])) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
        }
    
        $exportInvoice = ExportInvoice::find($id);
    
        if (!$exportInvoice) {
            return response()->json(['message' => 'Hóa đơn xuất không tồn tại.'], 404);
        }
    
        // Cập nhật thông tin hóa đơn xuất
        $exportInvoice->update([
            'customer_id' => $data['customer_id'],
            'export_date' => $data['export_date'],
            'total_amount' => $data['total_amount'],
        ]);
    
        // Xóa tất cả chi tiết hóa đơn xuất hiện trước đó
        DetailExportInvoice::where('export_invoice_id', $exportInvoice->id)->delete();
    
        $detailExportInvoiceData = $data['detailExportInvoice'];
    
        foreach ($detailExportInvoiceData as $item) {
            $detailExportInvoice = new DetailExportInvoice([
                'export_invoice_id' => $exportInvoice->id,
                'product_id' => $item['productIdItem'],
                'quantity' => $item['quantityItem'],
                'price' => $item['priceItem'],
                'total' => $item['totalItem'],
            ]);
    
            $detailExportInvoice->save();
    
            // Cập nhật lại số lượng sản phẩm
            
            $quantity = ProductSize::where('product_id', $item['productIdItem'])->where('size_id', $item['sizeIdItem'])->value('quantity');

            if($quantity < $item['quantityItem']){
                return response()->json([
                    'success' =>false,
                    'message' =>'Số lượng sản phẩm không đủ!'
                ]);
            }
            $productSize = ProductSize::where('product_id', $item['productIdItem'])
                ->where('size_id', $item['sizeIdItem'])
                ->first();
            if(empty($productSize)){
                return response()->json([
                    'success' =>false,
                    'message' =>"Không có sản phẩm size {$item['sizeIdItem']}"
                ]);
            }
            if ($productSize) {
                $productSize->quantity = $productSize->quantity - $item['quantityItem'];
                $productSize->save();
            }
        }
    
        return response()->json(['message' => 'Cập nhật thành công']);
    } 
}
