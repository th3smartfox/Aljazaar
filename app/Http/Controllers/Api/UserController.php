<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class UserController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|min:10|max:15',
            'verification_id' => 'required|string',
            'city_id' => 'nullable|integer|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $idTokenString = $request->verification_id;

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');
        } catch (FailedToVerifyToken $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Firebase ID Token',
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token verification failed: ' . $e->getMessage(),
            ], 401);
        }

        $user = User::firstOrCreate(
            ['phone_number' => $request->phone_number],
            [
                'name' => 'User',
                'city_id' => $request->city_id,
            ]
        );

        $user->verification_id = $uid;
        if ($request->filled('city_id')) {
            $user->city_id = $request->city_id;
        }

        if (is_null($user->otp_verification)) {
            $user->otp_verification = Carbon::now();
        }

        $user->save();

        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }

        $user->tokens()->delete();

        $token = $user->createToken('royal-butcher')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User verified and logged in successfully.',
            'user' => $user->load('city'),
            'token' => $token,
        ], 200);
    }


    public function signUpCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = User::where('phone_number', $request->phone_number)->exists();

        if (!$exists) {
            return response()->json([
                'is_registered' => false,
            ], 200);
        }

        return response()->json([
            'is_registered' => true,
        ], 200);
    }

    public function logInCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $exists = User::where('phone_number', $request->phone_number)->exists();

        return response()->json([
            'status' => 'success',
            'is_registered' => $exists,
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
