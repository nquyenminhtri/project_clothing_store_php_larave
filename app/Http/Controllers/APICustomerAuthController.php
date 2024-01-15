<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
class APICustomerAuthController extends Controller
{
    public function handleCustomerLogin(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        try {
            // Attempt to verify the credentials and create a token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $customerData = auth()->user();
        $customerData['image_path'] = asset("customer-images/{$customerData->image}");

        return response()->json([
            'token' => $token,
            'customerData' => $customerData, // Include customer data in the response
        ], 200);
    }

    public function handleCustomerLogout(Request $request)
    {
        Auth::logout();

        return Response::json([
            'message' => 'Logged out successfully'
        ]);
    }
}