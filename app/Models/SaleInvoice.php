<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected $table = 'sale_invoices';
    protected $fillable = [
        'customer_id',
        'export_date', 
        'status',
        'total_amount'
    ];
    public function saleInvoiceCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}