<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\PromotionCode;
class APIPromotionController extends Controller
{
    public function handlePromotionCode(Request $request){
        $promotionCode = PromotionCode::where('code',$request->code)->first();
        if(empty($promotionCode)){
            return response() ->json([
                'message' => 'Invalid promotional code!',
                'success' =>false,
            ]);
        }
        $promotion = Promotion::where('id',$promotionCode->promotion_id)->first();
        return response()->json([
            'success' =>true,
            'promotion' =>$promotion
        ]);
    }
}