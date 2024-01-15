<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class APICommentController extends Controller
{
    public function handelCreateComment(Request $request){
        $newComment = new Comment();
        $newComment -> admin_id = $request -> admin_id;
        $newComment -> customer_id = $request ->customer_id;
        $newComment -> product_id = $request -> product_id;
        $newComment -> content = $request -> content;
        $newComment ->save();
        return response() ->json([
            'data' => $newComment,
            'message' => 'Comment created successfully !'
        ]);
    }
}