<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Shipping;
class ShippingController extends Controller
{
    public function getListShipping(){
        $shippingList = Shipping::all();
        return view('Shipping/list',compact('shippingList'));
    }
    public function handleCreateShippingMethod(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'cost'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $existingShipping = Shipping::where('name', $request->name)->first();
        if ($existingShipping) {
            return response()->json(['error' => 'Shipping already exists in the system!'], 400);
        }
        $newShipping = new Shipping();
        $newShipping->name = $request->name;
        $newShipping ->cost = $request ->cost;
        $newShipping->save();

       $newShipping = Shipping::all();
        return response()->json(['success'=>true,'message' => 'Shipping created success!', 'data'=>$newShipping]);
    }
    public function viewUpdateShippingMethod($id){
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json(['error' => 'Shipping not found.'], 404);
        }
        return response()->json(['data'=>$shipping]);
    }
    public function handleUpdateShippingMethod(){
        $this->validate($request, [
            'name' => 'required',
            'cost'=>'required'
        ]);
        $shipping = Shipping::find($id);
        if (empty($shipping)) {
            return abort(404);
        }
        $shipping->name = $request->name;
        $shipping ->cost = $request->cost;
        $shipping->save();
        $shipping =Shipping::all();
        return response()->json(['success'=>true,'message' => 'Shipping updated successfully!','data'=>$shipping]);
    }
    public function handleDeleteShippingMethod($id){
        $shipping = Shipping::find($id);
        if(empty($shipping)){
            return redirect()->route('shipping.list')->with('status', 'Shipping not found!');
        }
        $shipping ->delete();
        $shipping = Shipping::all();
        return response()->json([
            'success' =>true,
            'data'=>$shipping
        ]);
    }
}