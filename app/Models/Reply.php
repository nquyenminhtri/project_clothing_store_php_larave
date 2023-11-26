<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $table = 'replies';
    public  function ReplyComment(){
        return $this->belongsTo(Comment::class,'comment_id');
    }
    public  function ReplyAdmin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public  function ReplyCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
