<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    public function productDetailProduct(){
        return $this->belongsTo(Customer::class,'product_id');
    }
    public function productDetailSize(){
        return $this->belongsTo(Customer::class,'size_id');
    }
    public function productDetailColor(){
        return $this->belongsTo(Customer::class,'color_id');
    }
    public function productDetailMaterial(){
        return $this->belongsTo(Customer::class,'material_id');
    }
}
