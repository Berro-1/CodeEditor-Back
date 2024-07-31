<?php

namespace App\Http\Controllers;

use App\Models\Codesubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CodesubmissionController extends Controller
{
    public function readAllCodes()
    {
        $code = Codesubmission::get();
        return response()->json([$code], 200);
    }
    public function readCode($id){
        $code=Codesubmission::find($id);
        return response()->json([
           $code
        ],200);
    }
    public function getUserCodes(Request $request)
    {
        $user = $request->user();

        // Debugging: Log the authenticated user
        Log::info('Authenticated user:', ['user' => $user]);

        $codes = Codesubmission::where('user_id', $user->id)->get();

        // Debugging: Log the codes retrieved for the user
        Log::info('Codes for user:', ['codes' => $codes]);

        return response()->json($codes, 200);
    }
    public function createCode(Request $request)
    {
        // Validate the incoming request
        $validated_data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|max:255',
            
        ]);
    
        $code = Codesubmission::create($validated_data);
    
        // Return the created user
        return response()->json([
           $code 
        ], 201);
    }

    public function deleteCode($id){
        $code=Codesubmission::find($id);
        $code->delete();
        return response()->json([
            "message" => "code  deleted successfully"
        ],204);

    }

    public function updateCode(Request $request ,$id){
        $code=Codesubmission::find($id);

        if($code){
            $validated_data=$request->validate([
                "user_id"=>"required|exists:users,id",
                 "code"=>"required|string|max:255",
                 
            ]);
        }
        $code->update($validated_data);
        return response()->json([
            "message"=>"Code updated successfully"
        ],204);

    }

        
}
