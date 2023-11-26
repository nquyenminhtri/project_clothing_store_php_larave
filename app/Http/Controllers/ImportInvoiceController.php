<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportInvoice;
class ImportInvoiceController extends Controller
{
    public function getImportInvoiceList(){
        $importInvoiceList = ImportInvoice::all();
        return view('Import-Invoice/list',compact('importInvoiceList'));
    }
    public function handleCreateImportInvoice(Request $request){
        
    }
    public function handleUpdateImportInvoice(Request $request){

    }
    public function handleDeleteImportInvoice(Request $request){
        
    }
}
