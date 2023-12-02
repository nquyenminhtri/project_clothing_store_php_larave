<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatables;
class Admin extends Authenticatables
{
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = ['name','user_name', 'password'];
}