<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $nurse_id)
    {
        //validate the request data
        $request->validate([
            "rating" => 'required|integer',
        ]);

        // get auth user
        $user = auth()->user();
        // get the corresponding regular user
        $regular_user = $user->regularUser();

        //create new rating
        $rating = new Rating([
            "rating" => $request->rating,
            "nurse_id" => $nurse_id,
            "regular_user_id" => $regular_user->id
        ]);

        $rating->save();

        // return a success response
        return response()->json([
            'msg' => 'Rating is successfulyy Added!'
        ]);
    }

    //function hat returns a boolean value
    //to determine whether the user already rated the nurse or not
    public function rated($nurse_id)
    {
        // get auth user
        $user = auth()->user();
        // get the corresponding regular user
        $regular_user = $user->regularUser();

        $check = Rating::where('nurse_id', $nurse_id)
            ->where('regular_user_id', $regular_user->id)
            ->get()
            ->first();
        return !is_null($check);
    }

    // rating fro specific nurse
    public function averageRating($nurse_id)
    {
        $rating = Rating::where('nurse_id', $nurse_id)
            ->avg('rating');
        return $rating;
    }

    // rating for auth nurse
    public function averageRatingAuth()
    {
        // get auth user
        $user = auth()->user();
        // get the corresponding nurse
        $nurse = $user->nurse();

        $rating = Rating::where('nurse_id', $nurse->id)
            ->avg('rating');
        return $rating;
    }
}
