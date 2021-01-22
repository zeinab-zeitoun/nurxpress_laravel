<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nurse;
use App\Models\NurseEducation;
use App\Models\NurseExperience;

class NurseExperienceController extends Controller
{
    //get experience of auth nurse
    public function index()
    {
        // get id of the authenticated nurse
        $user_id = auth()->user()->id;
        // get the authenticated nurse
        $nurse = Nurse::where('user_id', $user_id)->get()->first();
        // get all education of the authenticated nurse
        $experience = $nurse->experience()->get()->all();
        return $experience;
    }

    // get experience of specific nurse
    public function getExperience($nurse_id)
    {
        $experience = NurseExperience::where('nurse_id', $nurse_id)->get();
        return $experience;
    }

    public function store(Request $request)
    {

        //validate the request data
        $request->validate([
            "position" => 'required|string',
            "company" => 'required|string',
            "employmentType" => 'required|string',
            'startYear' => 'nullable|string',
            'endYear' => 'nullable|string',
        ]);

        // get id of the authenticated user
        $user_id = auth()->user()->id;

        //get the nurse and his/her id
        $nurse = Nurse::where('user_id', $user_id)->get()->first();
        $nurse_id = $nurse->id;

        //create new of NurseEducation
        $nurseExperience = new NurseExperience([
            "position" => $request->position,
            "employmentType" => $request->employmentType,
            "company" => $request->company,
            'startYear' => $request->startYear,
            'endYear' => $request->endYear,
            'nurse_id' => $nurse_id,
        ]);

        $nurseExperience->save();

        // return a success response
        return response()->json([
            'msg' => 'Nurse Experience is successfulyy Added!'
        ]);
    }

    public function update(Request $request, $id)
    {

        //validate the request data
        $request->validate([
            "position" => 'required|string',
            "company" => 'required|string',
            "employmentType" => 'required|string',
            'startYear' => 'nullable|string',
            'endYear' => 'nullable|string',
        ]);

        // get the nurseEducation that need to be updated
        NurseExperience::findOrFail($id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'Nurse Education is successfulyy Updated!'
        ]);
    }

    public function destroy($id)
    {
        // get the nurseEducation that need to be deleted
        $nurseEducation = NurseExperience::findOrFail($id);
        $nurseEducation->delete();
    }

    public function show($id)
    {
        // get experience
        $experience = NurseExperience::findOrFail($id);
        return $experience;
    }
}
