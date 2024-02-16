<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cache;
use Mail;
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

    public function handleCustomerRegistration(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|digits:10',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        if (Customer::where('phone', $request->input('phone'))->exists()) {
            return response()->json([
                'message' => 'Phone number is already in use'
            ], 200);
        }
        if (Customer::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'message' => 'Email is already in use'
            ], 200);
        }
        // Create a new user
        $user = new CUstomer();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->save();

        // Generate JWT token for the newly registered user
        $token = JWTAuth::fromUser($user);

        // Include user data and token in the response
        $userData = $user->toArray();
        $userData['image_path'] = null;  // Assuming no image is associated with the user during registration

        return response()->json([
            'token' => $token,
            'customerData' => $userData,
            'code' =>0,
            'message' => 'Account created successfully',
        ], 200);
    }
    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
        $randomPassword =Str::random(10);
        
        $customerData = Customer::where('email',$request->input('email'))->first();
        if(empty($customerData)){
            return response()->json([
                'message' => 'Email not found!',
            ]);
        }
        Mail::send('emails.reset_password',compact('randomPassword'),function($email)use ($customerData){
            $email->subject('Reset password account from cloting_store!.');
            $email->to($customerData['email']);
        });
        $customerData->password = Hash::make($randomPassword);
        $customerData->save();
        return response()->json([
            'message' => 'Password reset successfully. Check your email for the new password.',
            'code' => 0
        ]);
    }
    public function checkPasswordFromCustomer(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $customer = Customer::where('email', $email)->first();
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        if (Hash::check($password, $customer->password)) {
            $confirmationCode = rand(100000, 999999); // Mã xác nhận có thể là một số ngẫu nhiên
            Cache::put('confirmation_code_' . $email, $confirmationCode, 60); 
    
            Mail::send('emails.change_password', compact('confirmationCode'), function($email) use ($customer) {
                $email->subject('Authenticated encryption from clothing_store!');
                $email->to($customer->email);
            });
    
            return response()->json(['success' => true, 'message' => 'Password is correct']);
        } else {
            return response()->json(['success' => false,'error' => 'Incorrect password'],200);
        }
    }
    public function handleChangePassword(Request $request) {
        // Validation rules
    $rules = [
        'email' => 'required|email',
        'confirmation_code' => 'required',
        'new_password' => 'required|min:6', // Đặt các quy tắc validation khác tùy thuộc vào yêu cầu của bạn
    ];

    // Custom validation messages
    $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Invalid email format.',
        'confirmation_code.required' => 'Confirmation code is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least :min characters.',
    ];

    // Validate the request
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
    }
        $email = $request->input('email');
        $confirmationCode = $request->input('confirmation_code');
        $newPassword = $request->input('new_password');
    
        // Kiểm tra xem mã xác nhận có khớp với mã được lưu trong cache không
        $cachedCode = Cache::get('confirmation_code_' . $email);
    
        if ($confirmationCode != $cachedCode) {
            return response()->json(['success' => false,'code'=>1, 'error' => 'Verification code is invalid']);
        }
    
        // Nếu mã xác nhận hợp lệ, cập nhật mật khẩu mới cho khách hàng
        $customer = Customer::where('email', $email)->first();
    
        if ($customer) {
            $customer->password = Hash::make($newPassword);
            $customer->save();
    
            // Xóa mã xác nhận khỏi cache
            Cache::forget('confirmation_code_' . $email);
    
            return response()->json(['success' => true, 'message' => 'Your password change success!']);
        } else {
            return response()->json(['success' => false, 'error' => 'Customer mot found!']);
        }
    }
    public function handleUpdateCustomerAccount(Request $request)
    {
       
        $email = $request->input('email');
        $user = Customer::where('email', $email)->first();

        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found!'
            ], 401);
        }

        $user->name = $request->input('name');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->address = $request->input('address');

        if ($request->has('image')) {
            $imageData = $request->input('image');
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            // Tạo tên tệp tin duy nhất dựa trên thời gian và một số ngẫu nhiên
            $hashedFilename = time() . '_' . Str::random(10) . '.jpg';

            $imageBinary = base64_decode($imageData);

            // Lưu hình ảnh vào thư mục public/customer-images
            file_put_contents(public_path('customer-images/' . $hashedFilename), $imageBinary);

            $user->image = $hashedFilename;
        }
        $user->save();

        return response()->json([
            'customerData' => $user,
            'code' => 0,
            'message' => 'Account updated successfully',
        ], 200);
    }
}