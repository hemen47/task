<?php

namespace App\Http\Controllers;

use App\Classes\Payment;
use App\Receiver;
use App\Invoice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends BaseController
{


    public function showForm (){
        $receivers = Receiver::all();;
        return view("welcome")->with('receivers', $receivers);
    }


    public function showInvoices (Request $request){

        if($request->paid == "true") {
            $invoices = Invoice::where('paid',true)->with('receiver')->get();
        } else if($request->paid == "false"){
            $invoices = Invoice::where('paid',false)->with('receiver')->get();
        } else
            $invoices = Invoice::with('receiver')->get();
        return view("invoices")->with('data', $invoices);
    }


    public function payInvoices (){
        $unpaidInvoices = Invoice::where('paid',false)->with('receiver')->get();
        $token = env("PAYMENT_API_TOKEN");
        $results = [];
        foreach ($unpaidInvoices as $unpaidInvoice) {
            array_push($results, Payment::pay($token, $unpaidInvoice->receiver->sheba, $unpaidInvoice->amount));
            $unpaidInvoice->update(['paid' => "1"]);
        };


        session()->flash('results', $results);
        return redirect()->back();
    }


    public function saveInvoice (Request $request){


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


        session()->flash('msg', "با موفقیت ثبت شد");
        return redirect()->back();

    }

}
