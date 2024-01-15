<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
class APILoginFacebookController extends Controller
{
    public function loginWithFacebook(Request $request)
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->userFromToken($request->accessToken);

        // Kiểm tra xem người dùng đã đăng nhập trước đó chưa
        $user = Customer::where('social_id', $facebookUser->id)->first();

        if (!$user) {
            // Nếu người dùng chưa tồn tại, tạo một tài khoản mới
            $user = Customer::create([
                'name' => $facebookUser->name,
                'phone' => $facebookUser->phone,
                'social_id' => $facebookUser->id,
            ]);
        }

        // Tạo token và trả về cho người dùng
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json(['access_token' => $token]);
    }
}