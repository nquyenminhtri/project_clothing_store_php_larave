<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewedProduct extends Model
{
    use HasFactory;
    protected $table = 'viewed_products';
    protected $fillable = [
        'product_id', 
        'customer_id',
        'viewed_at',
    ];
    public function viewedProductCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function viewedProductProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
}