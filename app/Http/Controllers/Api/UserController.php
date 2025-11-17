<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|min:10|max:15',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(1000, 9999);
        $expiresAt = Carbon::now()->addMinutes(5);

        $user = User::updateOrCreate(
            ['phone_number' => $request->phone_number],
            [
                'city_id' => $request->city_id,
                'otp_code' => $otp,
                'otp_expires_at' => $expiresAt
            ]
        );

        // Assign default role to new users (or ensure existing users have it)
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }

        // --- DEVELOPMENT / TESTING ---
        // Asal production app mein, yeh line SMS Gateway (jaise Twilio) ko call karegi
        // Abhi ke liye, hum OTP ko response mein wapas bhej rahe hain taake test kar sakein
        return response()->json([
            'message' => 'OTP sent successfully.',
            'development_otp' => $otp,
            'expires_at' => $expiresAt->toDateTimeString(),
        ], 200);
    }

    /**
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|exists:users,phone_number',
            'otp_code' => 'required|string|min:4|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if ($user->otp_code != $request->otp_code || $user->otp_expires_at->isPast()) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 401);
        }

        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
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
