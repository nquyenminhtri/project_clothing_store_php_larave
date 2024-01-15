<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function getCustomerList(){
        $customerList = Customer::all();
        return view('Customer/list',compact('customerList'));
    }
    public function handleCreateCustomer(Request $request){

    }
    public function handleUpdateCustomer(Request $request){

    }
    public function handleDeleteCustomer($id){
        $customer = Customer::find($id);
        if ($customer->image) {
            $imagePath = public_path('customer-images/' . $customer->image);
    
            // Kiểm tra xem tệp có tồn tại không trước khi xóa
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $customer->delete();
        return redirect()->route('customer.list')->with('status','Delete customer successfully!');
    }
}