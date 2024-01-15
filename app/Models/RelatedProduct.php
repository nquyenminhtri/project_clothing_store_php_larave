<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;
    protected $table = 'related_products';
    public function relatedProductProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function viewedProductProductId(){
        return $this->belongsTo(Product::class,'product_id');
    }
}