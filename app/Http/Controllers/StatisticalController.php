<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Product;
use App\Models\ImportInvoice;
class StatisticalController extends Controller
{
    public function viewStatistical(){
        // Lấy tổng doanh thu từ bảng SaleInvoice
    $totalSaleRevenue = SaleInvoice::sum('total_amount');

    // Lấy tổng chi phí từ bảng ImportInvoice
    $totalImportCost = ImportInvoice::sum('total_amount');

    // Lấy tổng giá trị sản phẩm từ bảng Product
    $totalProductValue = Product::sum('price');

    // Tính lợi nhuận bằng cách trừ tổng chi phí từ tổng doanh thu
    $profit = $totalSaleRevenue - $totalImportCost;

    return view('Statistical/statistical-view', compact('totalSaleRevenue', 'totalImportCost', 'totalProductValue', 'profit'));
       
    }
    
}