<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function like($post_id)
    {
        // get auth user
        $user = auth()->user();

        //create and save the new comment
        $like = new Like([
            'post_id' => $post_id,
            'user_id' => $user->id,
        ]);

        $like->save();

        // return a success response
        return response()->json([
            'msg' => 'liked!'
        ]);
    }

    public function unlike($post_id)
    {

        // get auth user
        $user = auth()->user();

        $like = Like::where('post_id', $post_id)
            ->where('user_id', $user->id)
            ->get()
            ->first();

        $like->delete();
        // return a success response
        return response()->json([
            'msg' => 'unliked!'
        ]);
    }
}
