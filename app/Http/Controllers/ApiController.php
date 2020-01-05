<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function form(Request $request)
    {

        $this->validate($request, [
            'receiver' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $invoice = new Invoice;
        $invoice->receiver_id = $request->receiver;
        $invoice->amount = $request->amount;
        $invoice->description = $request->description;
        $invoice->save();


        return response()->json([
           "msg" => "با موفقیت ثبت شد",
        ]);

    }
}