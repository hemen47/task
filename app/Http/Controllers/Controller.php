<?php

namespace App\Http\Controllers;
use App\Receiver;
use App\Invoice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function welcome (){

        $receivers = Receiver::all();;
        return view("welcome")->with('receivers', $receivers);
    }


    public function index (){

        $data = Invoice::where('paid',false)->with('receiver')->get();

        return view("invoices")->with('data', $data);
    }


    public function pay (){
        $invoices = Invoice::with('receiver')->get();

        session()->flash('msg', "با موفقیت پرداخت شدند");
        return redirect()->back();
    }


    public function form (Request $request){

        $this->validate($request, [
            'receiver' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

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