<?php

namespace App\Console\Commands;

use App\Invoice;
use App\Classes\MasterController;
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
    public function handle(MasterController $helper)
    {

        $results = $helper->payInvoices();

        foreach ($results as $result){
            $this->info($result);
        }

    }
}
