<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
class SaleInvoiceController extends Controller
{
    public function getSaleInvoiceList() {
        $saleInvoiceList = SaleInvoice::all();
        return view('Sale-Invoice/list',compact('saleInvoiceList'));
    }
    public function handleConfirmSaleInvoice($id){
        $saleInvoice = SaleInvoice::find($id);
        $saleInvoice ->status = 'delivering';
        $saleInvoice ->save();
        $saleInvoiceList = SaleInvoice::all();
       return view('Sale-Invoice/list',compact('saleInvoiceList'));
    }
    public function handleCancelSaleInvoice($id) {
        // Tìm hóa đơn xuất theo ID
        $saleInvoice = SaleInvoice::find($id);
        $saleInvoice ->status = 'cancelled';
        $saleInvoice ->save();

        $saleInvoiceList = SaleInvoice::all();
       return view('Sale-Invoice/list',compact('saleInvoiceList'));
    }
}