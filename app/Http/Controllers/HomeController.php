<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\SaleInvoice;
use App\Models\ImportInvoice;
use App\Models\ImportInvoiceDetail;
use App\Models\SaleInvoiceDetail;
class HomeController extends Controller
{
   public function index(Request $request){
    $newCustomerList = Customer::latest('created_at')->take(10)->get();
    $newSaleInvoiceList = SaleInvoice::latest('created_at')->take(10)->get();
    $request->session()->put('newCustomerList',$newCustomerList);
    $request->session()->put('newSaleInvoiceList',$newSaleInvoiceList);
    return view('layout', compact('newCustomerList', 'newSaleInvoiceList'));
    }
    
    public function getData(Request $request)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
            $this->validate($request, [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);

            // Truy vấn cơ sở dữ liệu sử dụng eager loading
            $customerCreatedByDate = Customer::whereBetween('created_at', [$request->startDate, $request->endDate])->count();

            $totalRevenue = SaleInvoice::whereBetween('created_at', [$request->startDate, $request->endDate])->sum('total_amount');

            $saleInvoiceSuccessed = SaleInvoice::where('status', 'successed')->whereBetween('created_at', [$request->startDate, $request->endDate])->count();

            $saleInvoiceCancelled = SaleInvoice::where('status', 'cancelled')->whereBetween('created_at', [$request->startDate, $request->endDate])->count();

            $saleInvoiceSuccessedDetails = SaleInvoice::with('saleInvoiceSaleInvoiceDetail')->where('status', 'successed')->whereBetween('created_at', [$request->startDate, $request->endDate])->get();

            $costOfSale = 0;

            foreach ($saleInvoiceSuccessedDetails as $invoice) {
                foreach ($invoice->saleInvoiceSaleInvoiceDetail as $detail) {
                    $importPrice = optional(ImportInvoiceDetail::where('product_id', $detail->product_id)->first())->import_price ?? 0;
                    $quantity = $detail->quantity;
                    $costOfSale += $importPrice * $quantity;
                }
            }

            // Tính toán lợi nhuận ròng
            $netProfit = ($totalRevenue - $costOfSale) * 0.2;
            $netProfit = round($netProfit, 0);
            $filteredData = [
                'totalRevenue' => $totalRevenue,
                'customerCreatedByDate' => $customerCreatedByDate,
                'saleInvoiceSuccessed' => $saleInvoiceSuccessed,
                'saleInvoiceCancelled' => $saleInvoiceCancelled,
                'netProfit' => $netProfit
            ];

            return response()->json(['data' => $filteredData]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}