<?php

namespace App\Http\Controllers;

use App\Models\Codesubmission;
use Illuminate\Http\Request;

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

}
