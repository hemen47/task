<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Classes\Payment;
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


    public function showInvoices (Request $request, Helper $helper){

        $results = $helper->showInvoices($request);
        return response()->json([
            "Invoices" => $results,
        ], 200);
    }


    public function saveInvoice(Request $request, Helper $helper)
    {
        $helper->saveInvoice($request);
        return response()->json([
            "message" => "با موفقیت ثبت شد",
        ], 201);

    }

    public function payInvoices(Helper $helper)
    {
        $results = $helper->payInvoices();
        return response()->json([
            "results" => $results,
        ], 200);
    }
}
