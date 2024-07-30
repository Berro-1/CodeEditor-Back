<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function readAllUsers()
    {
        $users = User::get();
        return response()->json($users, 200);
    }

    public function readUser($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
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
        return response()->json($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $validated_data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Encrypt the password if it's provided in the request
            if (isset($validated_data['password'])) {
                $validated_data['password'] = Hash::make($validated_data['password']);
            }

            $user->update($validated_data);
            return response()->json([
                'message' => 'User updated successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

   public function bulkImport(Request $request)
    {
        $users = $request->all();
        $errors = [];
        $validUsers = [];

        foreach ($users as $index => $user) {
            $validator = Validator::make($user, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                $errors[$index] = $validator->errors();
            } else {
                $user['password'] = Hash::make($user['password']);
                $user['created_at'] = Carbon::now(); // Set current date and time
                $user['updated_at'] = Carbon::now(); // Set current date and time
                $validUsers[] = $user;
            }
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        User::insert($validUsers);

        return response()->json([
            'success' => true,
            'message' => 'Users imported successfully',
            'users' => User::whereIn('email', array_column($validUsers, 'email'))->get(),
        ]);
    }
}
