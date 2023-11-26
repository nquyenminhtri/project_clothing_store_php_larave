<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportInvoiceDetail;
class ImportInvoiceDetailController extends Controller
{
    public function getImportInvoiceDetailList(){
        $importInvoiceDetailList = ImportInvoiceDetail::all();
        return view('Import-Invoice-Detail/list',compact('importInvoiceDetailList'));
    }
    public function handleCreateImportInvoiceDetail(Request $request){
        
    }
    public function handleUpdateImportInvoiceDetail(Request $request){

    }
    public function handleDeleteImportInvoiceDetail(Request $request){
        
    }
}
