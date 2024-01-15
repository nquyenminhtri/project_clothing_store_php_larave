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
        'shipping_id',
        'payment_method',
        'total_amount'
    ];
    public function saleInvoiceCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function saleInvoiceSaleInvoiceDetail()
    {
        return $this->hasMany(SaleInvoiceDetail::class, 'sale_invoice_id');
    }
}