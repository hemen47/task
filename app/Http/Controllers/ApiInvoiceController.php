<?php

namespace App\Http\Controllers;

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


    public function showInvoices(Request $request)
    {

        if ($request->paid == "true") {
            $invoices = Invoice::where('paid', true)->with('receiver')->get();
        } else if ($request->paid == "false") {
            $invoices = Invoice::where('paid', false)->with('receiver')->get();
        } else
            $invoices = Invoice::with('receiver')->get();
        return response()->json([
            "Invoices" => $invoices,
        ], 200);
    }


    public function saveInvoice(Request $request)
    {
        $messages = [
            'amount.required' => 'لطفا مبلغ را وارد کنید!',
            'receiver.required' => 'لطفا گیرنده را وارد کنید!',
            'description.required' => 'لطفا توضیحات وارد کنید!'
        ];


        Validator::make($request->all(),[
            'amount' => 'required',
            'receiver' => 'required',
            'description' => 'required',
        ], $messages)->validate();


        $invoice = new Invoice;
        $invoice->receiver_id = $request->receiver;
        $invoice->amount = $request->amount;
        $invoice->description = $request->description;
        $invoice->paid = false;
        $invoice->save();

        return response()->json([
            "msg" => "با موفقیت ثبت شد",
        ], 201);

    }

    public function payInvoices()
    {
        $unpaidInvoices = Invoice::where('paid', false)->with('receiver')->get();
        $token = env("PAYMENT_API_TOKEN");
        $results = [];
        foreach ($unpaidInvoices as $unpaidInvoice) {
            array_push($results, Payment::pay($token, $unpaidInvoice->receiver->sheba, $unpaidInvoice->amount));
            $unpaidInvoice->update(['paid' => "1"]);
        };

        return response()->json([
            "results" => $results,
        ], 200);
    }
}
