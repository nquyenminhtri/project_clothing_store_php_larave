<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected $table = 'sale_invoices';
    public function saleInvoice(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
