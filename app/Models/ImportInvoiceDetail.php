<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'import_invoice_details';
    protected $fillable = [
        'import_invoice_id',
        'product_id',
        'size_id',
        'color_id',
        'material_id',
        'quantity',
        'import_price',
        'sale_price',
        'import_price_total',
    ];
    public function importInvoiceDetailImportInvoice(){
        return $this->belongsTo(ImportInvoice::class,'import_invoice_id');
    }
    public function importInvoiceDetailProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function importInvoiceDetailSize(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function importInvoiceDetailColor(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function importInvoiceDetailMaterial(){
        return $this->belongsTo(Material::class,'material_id');
    }
}