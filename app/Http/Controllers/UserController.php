<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nurse;
use App\Models\RegularUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // get all the emails of the user
    public function emails()
    {
        $emails = User::pluck("email")->toArray();
        return $emails;
    }

    //get auth user info
    public function authUser()
    {
        $user = auth()->user();

        if ($user->role === "nurse") {
            $nurse = Nurse::where('user_id', $user->id)->get()->first();
            $user->setAttribute('firstName', $nurse->firstName);
            $user->setAttribute('lastName', $nurse->lastName);
        } else {
            $regularUser = RegularUser::where('user_id', $user->id)->get()->first();
            $user->setAttribute('firstName', $regularUser->firstName);
            $user->setAttribute('lastName', $regularUser->lastName);
        }
        return $user;
    }
}
