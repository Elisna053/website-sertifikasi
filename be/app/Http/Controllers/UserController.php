<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Update the user's profile.
     */
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            $user = User::find(Auth::user()->id);
            $user->update($request->all());
            return response()->json(
                ['success' => true, 'message' => 'Profile updated successfully', 'data' => $user],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to update profile', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Get user details.
     */
    public function getUserDetails()
    {
        $user = User::find(Auth::user()->id);
        return response()->json(
            ['success' => true, 'message' => 'User details retrieved successfully', 'data' => $user],
            200
        );
    }
}
