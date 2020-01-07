<?php


namespace App\Classes;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Helper
{


    public function saveInvoice(Request $request)
    {

        $messages = [
            'amount.required' => 'لطفا مبلغ را وارد کنید!',
            'receiver.required' => 'لطفا گیرنده را وارد کنید!',
            'description.required' => 'لطفا توضیحات وارد کنید!'
        ];


        Validator::make($request->all(), [
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

        if (empty($results)) {
            return $results = [0 => "هیچ فاکتوری پرداخت نشده ای وجود ندارد!"];
        }else {

         return $results;
        }
    }

    public function showInvoices(Request $request) {
        if($request->paid == "true") {
            $invoices = Invoice::where('paid',true)->with('receiver')->get();
        } else if($request->paid == "false"){
            $invoices = Invoice::where('paid',false)->with('receiver')->get();
        } else
            $invoices = Invoice::with('receiver')->get();
        return $invoices;
    }

}
