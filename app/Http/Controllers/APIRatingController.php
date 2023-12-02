<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
class APIRatingController extends Controller
{
    public function handleCreateRating(Request $request){
        if (!$request->filled('customer_id') || !$request->filled('product_id') || !$request->filled('star')) {
            return response()->json([
                'success' =>false,
                'message' => 'Not enough information!',
            ], 400);
        }
        Rating::create([
            'customer_id' => $request ->customer_id,
            'product_id'=>$request ->product_id,
            'star' => $request ->star,
            'comment' =>$request ->comment
        ]);
        return response()->json([
            'success' =>true,
            'message' => 'Evaluation of success!',
            'data' => [
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'star' => $request->star,
                'comment' =>$request ->comment
            ]
        ]);

    }
}