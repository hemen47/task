<?php


namespace App\Classes;
use App\Invoice;

abstract class BankApi
{


    static public function checkBank($Invoices)
    {

        $meli = [];
        $melat = [];

        foreach ($Invoices as $Invoice) {
            $trim = substr($Invoice->receiver->sheba, 2, -19);
            if ($trim == "00000") {
                array_push($meli, $Invoice->id);
            } else if ($trim == "11111") {
                array_push($melat, $Invoice->id);
            } else {
                return "invalid sheba";
            }
        }
        return [
            "meli" => $meli,
            "melat" => $melat
        ];
    }


    static public function meli($invoices)
    {
        $bank = "Meli";
        return self::pay($bank, $invoices);
    }

    static public function melat($invoices)
    {
        $bank = "Melat";
        return self::pay($bank, $invoices);
    }



    static public function pay($bank, $invoices)
    {
        $paidResults =[];
        foreach ($invoices as $invoice) {
            array_push($paidResults, "{$invoice->amount} Rials was successfully sent to the {$invoice->receiver->sheba} account number in the {$bank} bank");
            Invoice::find($invoice->id)->update(['paid' => '1']);
        }
        return $paidResults;
    }




}
