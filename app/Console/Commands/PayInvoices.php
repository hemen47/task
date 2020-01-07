<?php

namespace App\Console\Commands;

use App\Invoice;
use App\Classes\Helper;
use App\Classes\Payment;
use Illuminate\Console\Command;

class PayInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bulk payment for unpaid invoices';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $unpaidInvoices = Invoice::where('paid', false)->with('receiver')->get();
        $token = env("PAYMENT_API_TOKEN");



        if (empty($unpaidInvoices[0])) {
            $this->info("No unpaid invoices was found!");
        } else {

            $bar = $this->output->createProgressBar(count($unpaidInvoices));

            foreach ($unpaidInvoices as $unpaidInvoice) {
                $this->info(Payment::pay($token, $unpaidInvoice->receiver->sheba, $unpaidInvoice->amount, $lang ="en"));
                $unpaidInvoice->update(['paid' => "1"]);
                $bar->advance();
            };
            $bar->finish();
        }

    }
}
