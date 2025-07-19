<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['success' => true, 'message' => 'Users retrieved successfully', 'data' => $users], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(['success' => true, 'message' => 'User retrieved successfully', 'data' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8',
                'phone_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'role' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()], 422);
            }

            // set default password to "password" if password is null
            if ($request->password == null) {
                $request['password'] = Hash::make('password');
            }

            $user = User::make($request->all());
            $user->saveOrFail();

            return response()->json(['success' => true, 'message' => 'User created successfully', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'role' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()], 422);
            }

            $user->fill($request->all());
            $user->saveOrFail();

            return response()->json(['success' => true, 'message' => 'User updated successfully', 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete user', 'error' => $e->getMessage()], 500);
        }
    }
}
