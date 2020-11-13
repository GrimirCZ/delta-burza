<?php

namespace App\Console\Commands;

use App\Mail\ProformaInvoiceMail;
use App\Models\Order;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendProformaInvoice extends Command
{
    protected $signature = 'send:proforma-invoice {order_ids*}';

    protected $description = 'Command description';

    public function handle()
    {
        if(!$this->confirm("Confirm operation")){
            return;
        }

        $i = 0;
        foreach($this->argument("order_ids") as $id){
            try{
                $order = Order::findOrFail($id);

                $school = $order->school;

                Mail::to($school->email)->send(new ProformaInvoiceMail($order));

                $i++; // try not to exceed aws limits
                if($i == 5){
                    sleep(1);
                    $i = 0;
                }

                $this->info("Sent proforma-invoice for order $id");
            } catch(Exception $e){
                $this->error("Failed to send proforma-invoice for order $id");
            }
        }
        //
    }
}
