<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use Validator;
class SizeController extends Controller
{
    public function getSizeList()
    {
    $sizeList = Size::all();
    return view('Size/list', compact('sizeList'));
    }
    public function handleCreateSize(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $existingSize = Size::where('name', $request->name)->first();
        if ($existingSize) {
            return response()->json(['error' => 'Size already exists in the system!'], 400);
        }
        $newSize = new Size();
        $newSize->name = $request->name;
        $newSize->save();

       
        return response()->json(['message' => 'Size created successfully!']);
    }
    public function viewUpdateSize($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['error' => 'Size not found.'], 404);
        }
        return response()->json($size);
    }
    public function handleUpdateSize(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $size = Size::find($id);
        if (empty($size)) {
            return abort(404);
        }
        $size->name = $request->name;
        $size->save();
        return response()->json(['message' => 'Size updated successfully!']);
    }
    public function handleDeleteSize($id){
        $size = Size::find($id);
        if(empty($size)){
            return redirect()->route('size.list')->with('status', 'Size not found!');
        }
        $size ->delete();
        return redirect()->route('size.list')->with('status', 'Delete size successfully!');
    }
}