<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class RegenerateProformaInvoiceNumbers extends Command
{
    protected $signature = 'generate:proforma-invoice-numbers {id*}';

    protected $description = 'Generate proforma numbers\nTo process all orders use all as the first argument';

    public function handle()
    {
        $ids = new Collection($this->argument("id"));

        if($ids[0] == "all"){ // regenerate all
            $ids = Order::query()->select("id")->get()->map(fn($x) => $x->id);
        } else{
            $ids = $ids->filter(fn($x) => is_numeric($x));
        }

        $ids->each(function($id){
            try{
                Order::findOrFail($id)->update([
                    'proforma_invoice_number' => Carbon::now()->isoFormat("YYYY") . fill_number_to_length($id, 4)
                ]);

                $this->info("Processed order $id");
            } catch(Exception $e){
                $this->error("Failed to process order $id");
            }
        });
        //
    }
}
