<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
class APIShippingController extends Controller
{
    public function getShinppingMethodList(){
        $shippingMethod = Shipping::all();
        if(empty($shippingMethod)){
            return response()->json([
                'success' => false,
                'message' => 'No shipping method found!',
            ]);
        }
        return response()->json([
            'success' =>true,
            'shippingMethod'=> $shippingMethod
        ]);
    }
}