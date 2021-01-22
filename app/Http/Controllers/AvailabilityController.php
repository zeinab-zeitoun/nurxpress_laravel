<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function index()
    {
        //get the auth nurse
        $user = auth()->user();
        $nurse = $user->nurse();

        $unavailable = Availability::where('unavailable', '>=', Carbon::today())
            ->where('nurse_id', $nurse->id)
            ->get()->pluck('unavailable');

        return $unavailable;
    }

    public function show($nurse_id)
    {
        $unavailable = Availability::where('nurse_id', $nurse_id)
            ->get()
            ->pluck('unavailable');;
        return $unavailable;
    }
    public function store(Request $request)
    {
        //add validate data

        //get the auth nurse
        $user = auth()->user();
        $nurse = $user->nurse();

        // get array of dates
        $dates = $request->dates;

        foreach ($dates as $date) {
            //check if the date already exists
            //try to get the date and then check if its null or not
            $checkDate = Availability::where('unavailable', $date)
                ->where('nurse_id', $nurse->id)
                ->get()->first();

            // if date doesnt already exit, then add
            if ($checkDate === null) {
                $unavailable = new Availability([
                    'nurse_id' => $nurse->id,
                    'unavailable' => $date,
                ]);
                $unavailable->save();
            }
        }
        return response()->json([
            'msg' => 'Dates are successfulyy Added!'
        ]);
    }

    public function destroy($date)
    {
        $unavailable = Availability::where('unavailable', $date)->get()->first();
        $unavailable->delete();
    }
}
