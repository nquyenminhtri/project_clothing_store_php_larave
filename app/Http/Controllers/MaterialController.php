<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Validator;
class MaterialController extends Controller
{
    public function getmaterialList()
    {
    $materialList = material::all();
    return view('material/list', compact('materialList'));
    }
    public function handleCreatematerial(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $existingmaterial = material::where('name', $request->name)->first();
        if ($existingmaterial) {
            return response()->json(['error' => 'material already exists in the system!'], 400);
        }
        $newmaterial = new material();
        $newmaterial->name = $request->name;
        $newmaterial->save();

       $newmaterial = material::all();
        return response()->json(['success'=>true,'message' => 'material created success!', 'data'=>$newmaterial]);
    }
    public function viewUpdatematerial($id)
    {
        $material = material::find($id);
        if (!$material) {
            return response()->json(['error' => 'material not found.'], 404);
        }
        return response()->json(['data'=>$material]);
    }
    public function handleUpdatematerial(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $material = material::find($id);
        if (empty($material)) {
            return abort(404);
        }
        $material->name = $request->name;
        $material->save();
        $material =material::all();
        return response()->json(['success'=>true,'message' => 'material updated successfully!','data'=>$material]);
    }
    public function handleDeletematerial($id){
        $material = material::find($id);
        if(empty($material)){
            return redirect()->route('material.list')->with('status', 'material not found!');
        }
        $material ->delete();
        $material = material::all();
        return response()->json([
            'success' =>true,
            'data'=>$material
        ]);
    }
}