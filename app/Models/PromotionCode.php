<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;
    protected $table = 'promotion_codes';
    public  function promotionCodePromotion(){
        return $this->belongsTo(Promotion::class,'promotion_id');
    }
}
