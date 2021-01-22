<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    // get the info of the authenticated nurse
    public function profile()
    {
        //get id of authenicated nurse
        $user_id = auth()->user()->id;
        // get the info corresponding to the id
        $nurse_info = Nurse::where('user_id', $user_id)->get()->first();
        return $nurse_info;
    }

    // get profile of a nurse with given id
    public function show($id)
    {
        $nurse = Nurse::findOrFail($id);
        return $nurse;
    }

    //get all nurses
    public function index()
    {
        $nurses = Nurse::all();
        return $nurses;
    }
    public function getNurseGivenUserId($user_id)
    {
        $nurse = Nurse::where("user_id", $user_id)
            ->get()
            ->first();
        return $nurse;
    }
    public function store(Request $request)
    {
        //validate the request data
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'contact' => 'required|string|min:8',

            'pricePer8Hour' => 'required|string',
            'pricePer12Hour' => 'required|string',
            'pricePer24Hour' => 'required|string',

            'latitude' => 'required|string',
            'longitude' => 'required|string',

        ]);
        //create new of Nurse
        $card = new Nurse([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'contact' => $request->contact,

            'pricePer8Hour' => $request->pricePer8Hour,
            'pricePer12Hour' => $request->pricePer12Hour,
            'pricePer24Hour' => $request->pricePer24Hour,

            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => auth()->user()->id
        ]);

        $card->save();

        // return a success response
        return response()->json([
            'msg' => 'Nurse information are successfulyy Added!'
        ]);
    }

    public function update(Request $request)
    {
        //validate the request data
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'contact' => 'required|string|min:8',

            'pricePer8Hour' => 'required|string',
            'pricePer12Hour' => 'required|string',
            'pricePer24Hour' => 'required|string',

            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        //get id of authenicated nurse
        $user_id = auth()->user()->id;

        //update info of nurse
        Nurse::where('user_id', $user_id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'Nurse information are successfulyy Updated!'
        ]);
    }

    public function changeLocation(Request $request)
    {
        //validate the request data
        $request->validate([
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        //get id of authenicated nurse
        $user_id = auth()->user()->id;

        //update info of nurse
        Nurse::where('user_id', $user_id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'Nurse Location is successfulyy Updated!'
        ]);
    }
}
