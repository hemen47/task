<?php


namespace App\Classes;

use App\Classes\BankApi;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterController
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


    public function payInvoices(){

        $Invoices = Invoice::where('paid', false)->with('receiver')->get();
        $checkedResults = BankApi::checkBank($Invoices);

        if($checkedResults == "invalid sheba") {
            return response()->json([
                "msg" => "one of the sheba account numbers is not valid"
            ], 200);
        };

        $meliInvoices = Invoice::with('receiver')->find($checkedResults["meli"]);
        $melatInvoices = Invoice::with('receiver')->find($checkedResults["melat"]);

        $meliPaidResults = bankApi::meli($meliInvoices);
        $melatPaidResults = bankApi::melat($melatInvoices);

        if(!empty($meliPaidResults) || !empty($melatPaidResults) ){

        return array_merge($meliPaidResults, $melatPaidResults);
        } else{
            return ["there are no unpaid factors left"];
            }
    }


    public function showInvoices(Request $request)
    {
        if ($request->paid == "true") {
            $invoices = Invoice::where('paid', true)->with('receiver')->get();
        } else if ($request->paid == "false") {
            $invoices = Invoice::where('paid', false)->with('receiver')->get();
        } else
            $invoices = Invoice::with('receiver')->get();
        return $invoices;
    }

}
