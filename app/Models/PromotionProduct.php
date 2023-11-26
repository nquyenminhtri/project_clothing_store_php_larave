<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionProduct extends Model
{
    use HasFactory;
    protected $table = 'promotion_products';
    public  function promotionProductProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public  function promotionProductPromotion(){
        return $this->belongsTo(Promotion::class,'promotion_id');
    }
}
