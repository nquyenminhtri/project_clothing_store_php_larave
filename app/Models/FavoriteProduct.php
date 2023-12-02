<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use HasFactory;
    protected $table = 'favorite_products';
    protected $fillable = [
        'customer_id',
        'product_id', 

    ];
    public function FavoriteProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
}