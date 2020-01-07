<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Classes\Payment;
use App\Receiver;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class InvoiceController extends BaseController
{


    public function showForm (){
        $receivers = Receiver::all();;
        return view("welcome")->with('receivers', $receivers);
    }


    public function showInvoices (Request $request, Helper $helper){
        $results = $helper->showInvoices($request);
        return view("invoices")->with('data', $results);
    }


    public function saveInvoice (Request $request, Helper $helper)
    {
        $helper->create($request);
        session()->flash('msg', "با موفقیت ثبت شد");
        return redirect()->back();

    }


    public function payInvoices ( Helper $helper){

        $results = $helper->payInvoices();
        session()->flash('results', $results);
        return redirect()->back();
    }


}
