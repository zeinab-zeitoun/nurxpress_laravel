<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nurse;
use App\Models\NurseEducation;

class NurseEducationController extends Controller
{
    // get all education of authenticated user
    public function index()
    {
        // get id of the authenticated nurse
        $user_id = auth()->user()->id;
        // get the authenticated nurse
        $nurse = Nurse::where('user_id', $user_id)->get()->first();
        // get all education of the authenticated nurse
        $education = $nurse->education()->get()->all();
        return $education;
    }

    // get education of specific user
    public function getEducation($nurse_id)
    {
        $education = NurseEducation::where('nurse_id', $nurse_id)->get();
        return $education;
    }

    public function store(Request $request)
    {

        //validate the request data
        $request->validate([

            "school" => 'required|string',
            "degree" => 'required|string',
            "graduationYear" => "nullable|string",
        ]);

        // get id of the authenticated user
        $user_id = auth()->user()->id;

        //get the nurse and his/her id
        $nurse = Nurse::where('user_id', $user_id)->get()->first();
        $nurse_id = $nurse->id;

        //create new of NurseEducation
        $nurseEducation = new NurseEducation([
            "school" => $request->school,
            "degree" => $request->degree,
            "graduationYear" => $request->graduationYear,
            'nurse_id' => $nurse_id
        ]);

        $nurseEducation->save();

        // return a success response
        return response()->json([
            'msg' => 'Nurse Education is successfulyy Added!'
        ]);
    }

    public function update(Request $request, $id)
    {

        //validate the request data
        $request->validate([

            "school" => 'required|string',
            "degree" => 'required|string',
            "graduationYear" => "nullable|string",
        ]);

        // get the nurseEducation that need to be updated
        NurseEducation::findOrFail($id)
            ->update($request->all());

        // return a success response
        return response()->json([
            'msg' => 'Nurse Education is successfulyy Updated!'
        ]);
    }

    public function destroy($id)
    {
        // get the nurseEducation that need to be deleted
        $nurseEducation = NurseEducation::findOrFail($id);
        $nurseEducation->delete();
    }

    public function show($id)
    {
        // get education
        $education = NurseEducation::findOrFail($id);
        return $education;
    }
}
