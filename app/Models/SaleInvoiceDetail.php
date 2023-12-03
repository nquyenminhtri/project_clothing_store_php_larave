<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'sale_invoice_details';
    protected $fillable = [
        'sale_invoice_id',
        'customer_id',
        'product_id', 
        'color_id',
        'size_id',
        'material_id',
        'quantity',
        'unit_price',
        'price_total'
    ];
    public function saleInvoiceDetailSaleInvoice(){
        return $this->hasMany(SaleInvoice::class,'sale_invoice_id');
    }
    public function saleInvoiceDetailProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function saleInvoiceDetailSize(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function saleInvoiceDetailColor(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function saleInvoiceDetailMaterial(){
        return $this->belongsTo(Product::class,'material_id');
    }
}