<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $table = 'slides';
    public  function slideSlideShow(){
        return $this->belongsTo(SlideShow::class,'slideshow_id');
    }
}
