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
        
    }
}
