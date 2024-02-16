<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
class RatingController extends Controller
{
    public function getRating(){
        $ratingList = Rating::all();
        return view('Rating/list',compact('ratingList'));
    }
}