<?php

namespace App\Console\Commands;

use App\Jobs\GenerateInvoice;
use App\Models\Order;
use Exception;
use Illuminate\Console\Command;

class RegenerateInvoice extends Command
{
    protected $signature = 'regenerate:invoice {order_id*} {--M|send-mail}';

    protected $description = 'Generate and send a new invoice for the order identifierd by {order_id}';

    public function handle()
    {
        $send_mail = $this->option("send-mail");


        foreach($this->argument("order_id") as $order_id){
            try{
                $order = Order::findOrFail($order_id);

                GenerateInvoice::dispatch($order->id, $send_mail);
                $this->info(($send_mail ? "Sent" : "Generated") . " new invoice for order $order->id");
            } catch(Exception $e){
                $this->error("Failed to " . ($send_mail ? "send" : "generate") . " new invoice for order $order_id");
            }
        }
        //
    }
}
