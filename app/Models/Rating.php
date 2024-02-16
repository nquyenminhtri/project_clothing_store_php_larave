<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = [
        'customer_id',
        'product_id', 
        'star',
        'comment'
    ];
    public  function ratingCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public  function ratingProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
}