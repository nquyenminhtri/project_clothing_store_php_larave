<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'sale_invoice_details';
    public function saleInvoiceDetailSaleInvoice(){
        return $this->belongsTo(SaleInvoice::class,'sale_invoice_id');
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
