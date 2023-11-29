<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $table = 'product_details';
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'material_id',
        'quantity',
    ];
    public function productDetailProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function productDetailSize(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function productDetailColor(){
        return $this->belongsTo(Color::class,'color_id');
    }
    public function productDetailMaterial(){
        return $this->belongsTo(Material::class,'material_id');
    }
}