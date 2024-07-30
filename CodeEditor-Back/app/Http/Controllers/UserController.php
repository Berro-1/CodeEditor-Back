<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function readAllUsers()
    {
        $users = User::get();
        return response()->json([$users], 200);
    }
    public function readUser($id){
        $user=User::find($id);
        return response()->json([
           $user
        ],200);
    }


    public function createUser(Request $request)
{
    // Validate the incoming request
    $validated_data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    // Encrypt the password
    $validated_data['password'] = bcrypt($validated_data['password']);

    // Create the user
    $user = User::create($validated_data);

    // Return the created user
    return response()->json([
       $user
    ], 201);
}
    
    //////
    public function updateUser(Request $request ,$id){
        $user=User::find($id);

        if($user){
            $validated_data=$request->validate([
                "name"=>"required|string|max:255",
                 "email"=>"required|string|email|max:255|unique:user,email",
                 "password"=>"required|string|min:8|confirmed"
            ]);
        }
        $user->update($validated_data);
        return response()->json([
            "message"=>"User updated successfully"
        ],204);

    }


    public function deleteUser($id){
        $user=User::find($id);
        $user->delete();
        return response()->json([
            "message" => "User deleted successfully"
        ],204);

    }
}
