<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
class AdminController extends Controller
{
    public function getAdminList(){
        $adminList = Admin::all();
        return view('Admin/list',compact('adminList'));
    }
    public function viewUpdateAdmin($id){
        $admin = Admin::find($id);
        if(empty($admin)){
            return 'Admin does not exist!';
        }
        return response()->json([
            'data'=>$admin]);
    }
    public function handleCreateAdmin(Request $request)
    {
        // Kiểm tra thiếu tham số
        if (empty($request->name) || empty($request->user_name) || empty($request->password)) {
            return 'Missing parameter';
        }
        // Kiểm tra username đã tồn tại
        $existingAdmin = Admin::where('user_name', $request->user_name)->first();
        if ($existingAdmin) {
            return 'Username already exists in the system!';
        }

        // Tạo mới admin
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->user_name = $request->user_name;
        $admin->password = Hash::make($request->password);
        //Lưu ảnh vào thư mục public
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $hashedFilename = $file->hashName();
            $file->storeAs('admin-images', $hashedFilename, 'public');
            $admin->image = $hashedFilename;
        }
        $admin->save();
        return redirect()->route('admin.list')->with('status','Admin created successfully!');
    }

    public function handleUpdateAdmin(Request $request, $id){
        // Kiểm tra thiếu tham số
        if (empty($request->name) || empty($request->user_name)) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }
    
        $admin = Admin::find($id);
        if(empty($admin)){
            return response()->json(['error' => 'Admin does not exist!'], 404);
        }
    
        // Kiểm tra và lưu ảnh nếu có
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $hashedFilename = $file->hashName();
            $file->storeAs('admin-images', $hashedFilename, 'public');
            $admin->image = $hashedFilename;
        }
    
        // Cập nhật thông tin admin
        $admin->name = $request->name;
        $admin->user_name = $request->user_name;
    
        // Lưu thay đổi
        $admin->save();
    
        return response()->json(['message' => 'Update admin successfully']);
    }
    public function handleDeleteAdmin($id){
        $admin = Admin::find($id);
        $admin->delete();
        return redirect()->route('admin.list')->with('status','Delete admin successfully!');
    }
}