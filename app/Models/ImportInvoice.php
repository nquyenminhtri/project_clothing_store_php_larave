<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoice extends Model
{
    use HasFactory;
    protected $table = 'import_invoices';
    public function importInvoice(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
}
