<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Sign Up API
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'phone_number' => 'required|string|min:10|max:15|unique:users,phone_number',
            'city_id' => 'required|integer|exists:cities,id',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'password' => Hash::make($request->password),
            // otp_verification is initially null
        ]);

        // Assign 'user' role
        $user->assignRole('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Account created successfully. Please verify your phone number.',
            'user' => $user->load('city'),
        ], 201);
    }

    /**
     * Verify OTP API
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|exists:users,phone_number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        // Check if already verified
        if (!is_null($user->otp_verification)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone number already verified. Please login.',
            ], 400);
        }

        // Revoke existing tokens to prevent accumulation
        $user->tokens()->delete();

        $token = $user->createToken('royal-butcher')->plainTextToken;

        // Update otp_verification time to now
        $user->otp_verification = Carbon::now();
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Phone number verified successfully. You can now login.',
            'token' => $token,
        ], 200);
    }

    /**
     * Login API
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $loginField = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        $user = User::where($loginField, $request->email_or_phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Check if OTP is verified
        if (is_null($user->otp_verification)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your OTP is not verified.'
            ], 403);
        }

        // Revoke existing tokens to prevent accumulation
        $user->tokens()->delete();

        $token = $user->createToken('royal-butcher')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'user' => $user->load('city'),
            'token' => $token,
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user->load('city'),
        ], 200);
    }

    public function getUser(Request $request)
    {
        return response()->json($request->user()->load('city'));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
