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
    public function viewCreateColor(){
        return view('Color/create');
    }
    public function handleCreateColor(Request $request){
        if(empty($request)){
            return "Missing parametter";
        }
        $color = new Color();
        $color ->name = $request ->name;
        $color ->save();
        return redirect()->route('color.list')->with('status', 'Create new color successfully!');
    }
    public function viewUpdateColor($id){
        $color = Color::find($id);
        if(empty($color)){
            return "Color does not exist in system!";
        }
        return view('Color/update',compact('color'));
        

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
        $color ->save();
        return redirect()->route('color.list')->with('status', 'Update color successfully!');
    }
    public function handleDeleteColor($id){
        $color = Color::find($id);
        if(empty($color)){
            return 'Color not found!';
        }
        $color ->delete();
        return redirect()->route('color.list')->with('status', 'Delete finished!');
    }
}
