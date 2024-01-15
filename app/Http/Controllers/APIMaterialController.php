<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
class APIMaterialController extends Controller
{
    public function getMaterialList(){
        $materialList = Material::all();
        if(empty($materialList)){
            return response()->json([
                'success' =>false,
                'message' => 'Material not found!'
            ]);
        }
        return response()->json([
            'success' =>true,
            'material' =>$materialList
        ]);
    }
}