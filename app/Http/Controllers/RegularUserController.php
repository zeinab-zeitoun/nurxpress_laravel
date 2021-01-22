<?php

namespace App\Http\Controllers;

use App\Models\RegularUser;
use Illuminate\Http\Request;

class RegularUserController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $regular_user = RegularUser::where('user_id', $id)->get()->first();
        return $regular_user;
    }

    public function store(Request $request)
    {
        //validate the request data
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        //create new regular user
        $regularUser = new RegularUser([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => auth()->user()->id
        ]);

        $regularUser->save();

        // return a success response
        return response()->json([
            'msg' => 'Regular user information are successfulyy Added!'
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
        RegularUser::where('user_id', $user_id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'User Location is successfulyy Updated!'
        ]);
    }

    public function update(Request $request)
    {
        //validate the request data
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);

        //get id of authenicated nurse
        $user_id = auth()->user()->id;

        //update info of nurse
        RegularUser::where('user_id', $user_id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'User Full Name is successfulyy Updated!'
        ]);
    }
}
