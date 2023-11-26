<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    public function commentAdmin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function commentCustomer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
