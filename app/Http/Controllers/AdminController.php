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
        if ( empty($request->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing password!',
            ]);
        }
        // Kiểm tra username đã tồn tại
        $existingAdmin = Admin::where('user_name', $request->user_name)->first();
        if ($existingAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin already in system!',
            ]);
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
        return response()->json([
            'success' => true,
            'message' => 'Account admin created successfully!',
        ]);
    }

    public function handleUpdateAdmin(Request $request, $id)
    {
    // Kiểm tra thiếu tham số
    if (empty($request->name) || empty($request->user_name)) {
        return response()->json([
            'success' => false,
            'error' => 'Missing parameters']);
    }

    $admin = Admin::find($id);
    if (empty($admin)) {
        return response()->json([
            'success' =>false,
            'error' => 'Admin does not exist!']);
    }

    // Kiểm tra và lưu ảnh nếu có
    if ($request->hasFile('image')) {
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
    // Trả về phản hồi JSON cho mã nguồn JavaScript
    return response()->json(['success' => true, 'message' => 'Update admin successfully']);
    }
    public function handleDeleteAdmin($id){
        $admin = Admin::find($id);
        if ($admin->image) {
            $imagePath = public_path('admin-images/' . $admin->image);
    
            // Kiểm tra xem tệp có tồn tại không trước khi xóa
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $admin->delete();
        return redirect()->route('admin.list')->with('status','Delete admin successfully!');
    }
}