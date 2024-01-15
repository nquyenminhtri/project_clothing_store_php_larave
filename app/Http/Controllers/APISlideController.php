<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
class APISlideController extends Controller
{
    public function getSlideList(){
        $slideList = Slide::all();
        $slidesData = [];
        foreach ($slideList as $slide) {
            $slidesData[] = array_merge(
                ['image_path' => asset("slide-images/{$slide->image_name}")],
                $slide->toArray()
            );
        }
        return response()->json([
            'slideData' => $slidesData,
        ]);
    }
}