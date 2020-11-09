<?php

namespace App\Console\Commands;

use App\Jobs\SendInvoice;
use App\Models\Order;
use Illuminate\Console\Command;

class RegenerateInvoice extends Command
{
    protected $signature = 'regenerate:invoice {order_id}';

    protected $description = 'Generate and send a new invoice for the order identifierd by {order_id}';

    public function handle()
    {
        $order = Order::findOrFail($this->argument("order_id"));

        $this->info("Sending new invoice...");

        SendInvoice::dispatch($order->id);

        $this->info("Sent");
        //
    }
}
