<?php


namespace App\Classes;


abstract class BankApi
{


    static public function pay($accountNumber, $amount, $lang) {

        if ($lang === "fa") {
        return "$amount ریال به حساب $accountNumber با موفقیت واریز شد! ";
        }
            return "$amount Rials was successfully settled to the $accountNumber account number";
    }

}
