<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoice extends Model
{
    use HasFactory;
    protected $table = 'import_invoices';
    protected $fillable = [
       'admin_id', 'supplier_id','import_date','total_amount'
    ];
    public function importInvoiceSupplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function importInvoiceAdmin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
}