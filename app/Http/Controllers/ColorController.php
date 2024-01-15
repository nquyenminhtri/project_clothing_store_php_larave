<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
class ColorController extends Controller
{
    public function getColorList(){
        $colorList = Color::all();
        return view('Color/list',compact('colorList'));
    }
    public function handleCreateColor(Request $request){
        if(empty($request)){
            return "Missing parametter";
        }
        $color = new Color();
        $color ->name = $request ->name;
        $color ->color_code = $request ->color;
        $color ->save();
        $color = Color::all();

        return response()->json([
            'success' =>true,
            'data' =>$color
        ]);
    }
    public function viewUpdateColor($id){
        $color = Color::find($id);
        if(empty($color)){
            return "Color does not exist in system!";
        }
        return response()->json([
            'success' =>true,
            'data' =>$color
        ]);
        

    }
    public function handleUpdateColor(Request $request,$id){
        if(empty($request->name)){
            return 'Missing parametter!';
        }
        $color = Color::find($id);
        if(empty($color)){
            return "Color not found!";
        }
        $color ->name = $request ->name;
        $color ->color_code = $request ->color;
        $color ->save();
        $color = Color::all();

        return response()->json([
            'success' =>true,
            'data' =>$color
        ]);
    }
    public function handleDeleteColor($id){
        $color = Color::find($id);
        if(empty($color)){
            return 'Color not found!';
        }
        $color ->delete();
        $color = Color::all();

        return response()->json([
            'success' =>true,
            'data' =>$color
        ]);
    }
}