<?php


namespace App\Classes;


abstract class Payment
{


    static public function pay($token, $accountNumber, $amount ) {
        return "$amount ریال به حساب $accountNumber با موفقیت واریز شد! ";
    }


}
