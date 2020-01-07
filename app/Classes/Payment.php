<?php


namespace App\Classes;


abstract class Payment
{


    static public function pay($token, $accountNumber, $amount, $lang ="fa" ) {

        if ($lang === "fa") {
        return "$amount ریال به حساب $accountNumber با موفقیت واریز شد! ";
        }
            return "$amount Rials was successfully settled to the $accountNumber account number";

    }

}
