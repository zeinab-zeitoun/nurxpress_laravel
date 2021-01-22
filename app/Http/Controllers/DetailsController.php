<?php

namespace App\Http\Controllers;

use App\Models\Details;
use Illuminate\Http\Request;
use App\Models\User;

class DetailsController extends Controller
{
    // get all details of authenticated user
    public function index()
    {
        //get the auth nurse
        $user = auth()->user();
        $nurse = $user->nurse();

        $details = Details::where('nurse_id', $nurse->id)->get();

        return $details;
    }

    public function show($nurse_id)
    {
        $details = Details::where('nurse_id', $nurse_id)->get();
        return $details;
    }
    public function store(Request $request)
    {
        //get the auth nurse
        $user = auth()->user();
        $nurse = $user->nurse();

        //validate data
        $request->validate([
            'detail' => 'required|string',
        ]);

        //create and save the new detail
        $detail = new Details([
            'detail' => $request->detail,
            'nurse_id' => $nurse->id,
        ]);

        $detail->save();

        // return a success response
        return response()->json([
            'msg' => 'detail is successfulyy Added!'
        ]);
    }

    public function destroy($id)
    {
        $detail = Details::findOrFail($id);
        $detail->delete();

        return response()->json([
            'msg' => 'detail is successfulyy deleted!'
        ]);
    }
}
