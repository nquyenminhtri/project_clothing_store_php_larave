<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Product;
use App\Models\ImportInvoice;
use Carbon\Carbon;
class StatisticalController extends Controller
{
   

    public function viewStatistical()
    {
        // Lấy doanh thu theo ngày
        $dailyRevenue = SaleInvoice::selectRaw('date(created_at) as date, sum(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc') // or 'desc'
            ->pluck('total', 'date');
    
        // Lấy doanh thu theo tuần
        $weeklyRevenue = SaleInvoice::selectRaw('yearweek(created_at) as week, sum(total_amount) as total')
            ->groupBy('week')
            ->orderBy('week', 'asc') // or 'desc'
            ->pluck('total', 'week');
    
        // Lấy doanh thu theo tháng
        $monthlyRevenue = SaleInvoice::selectRaw('year(created_at) as year, month(created_at) as month, sum(total_amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc') // or 'desc'
            ->orderBy('month', 'asc') // or 'desc'
            ->pluck('total', ['year', 'month']);
    
        return view('Statistical/statistical-view', compact('dailyRevenue', 'weeklyRevenue', 'monthlyRevenue'));
    }
    
}