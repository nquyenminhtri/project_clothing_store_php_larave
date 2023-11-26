<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'import_invoice_details';
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
        return $this->belongsTo(Product::class,'material_id');
    }
}
