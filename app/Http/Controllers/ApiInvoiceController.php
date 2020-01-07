<?php

namespace App\Http\Controllers;

use App\Classes\MasterController;
use App\Classes\BankApi;
use App\Invoice;
use App\Receiver;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;


class ApiInvoiceController extends BaseController
{

    public function showForm()
    {
        $receivers = Receiver::all();;
        return response()->json([
            "receivers" => $receivers,
        ], 200);
    }

    public function showInvoices (Request $request, MasterController $helper){

        $results = $helper->showInvoices($request);
        return response()->json([
            "Invoices" => $results,
        ], 200);
    }


    public function saveInvoice(Request $request, MasterController $helper)
    {
        $helper->saveInvoice($request);
        return response()->json([
            "message" => "با موفقیت ثبت شد",
        ], 201);

    }

    public function payInvoices(MasterController $helper)
    {
        $results = $helper->payInvoices();
        return response()->json([
            "results" => $results,
        ], 200);
    }
}
