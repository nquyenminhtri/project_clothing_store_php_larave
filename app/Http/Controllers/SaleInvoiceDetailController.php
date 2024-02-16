<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceDetail;
class SaleInvoiceDetailController extends Controller
{
    public function getSaleInvoiceDetailList($saleInvoiceId){
        $saleInvoice = SaleInvoice::findOrFail($saleInvoiceId);
        $saleInvoiceDetailList = $saleInvoice->saleInvoiceSaleInvoiceDetail;
        return view('Sale-Invoice-Detail/list', compact('saleInvoiceDetailList'));
    }
}