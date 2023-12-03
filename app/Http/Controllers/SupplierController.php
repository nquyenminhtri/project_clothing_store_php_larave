<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Validator;
class SupplierController extends Controller
{
    public function getSupplierList()
{
    $supplierList = Supplier::all();
    return view('Supplier/list', compact('supplierList'));
}
    public function handleCreateSupplier(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|string',
        ]);

        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Kiểm tra sự tồn tại của nhà cung cấp
        $existingSupplier = Supplier::where('name', $request->name)->first();
        if ($existingSupplier) {
            return response()->json(['error' => 'Supplier already exists in the system!'], 400);
        }

        // Tạo mới nhà cung cấp
        $newSupplier = new Supplier();
        $newSupplier->name = $request->name;
        $newSupplier->address = $request->address;
        $newSupplier->phone = $request->phone;
        $newSupplier->description = $request->description;
        $newSupplier->save();
       
        // Trả về thông báo thành công
        $supplierList = Supplier::all();
        return response()->json([
            'success' => true,
            'message' => 'Supplier created successfully!',
            'data' => $supplierList
        ]);

        //$newRowHtml = view('Supplier/list', ['supplier' => $newSupplier])->render();
        
    }
    public function viewUpdateSupplier($id)
    {
        // Fetch the supplier by ID
        $supplier = Supplier::find($id);

        // Check if the supplier exists
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        }

        // Return the supplier data as JSON
        return response()->json($supplier);
    }
    public function handleUpdateSupplier(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'description' => 'required',
        ]);
        $supplier = Supplier::find($id);
        if (empty($supplier)) {
            return abort(404);
        }
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->description = $request->description;
        $supplier->save();
        $supplierList = Supplier::all();
        return response()->json([
            'success' => true,
            'message' => 'Supplier updated successfully!',
            'data' => $supplierList
        ]);
        
        
    }
    public function handleDeleteSupplier($id){
        $supplier = Supplier::find($id);
        if(empty($supplier)){
            return redirect()->route('supplier.list')->with('status', 'Supplier not found!');
        }
        $supplier ->delete();
        $supplierList = Supplier::all();
        return response()->json([
            'success' => true,
            'status' => 'Supplier updated successfully!',
            'data' => $supplierList
        ]);
    }
}