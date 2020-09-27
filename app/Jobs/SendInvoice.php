<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class SendInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    public function handle()
    {
        $order = Order::find($this->order_id);
        $pdf_name = str_replace(" ", "_", $order->school->name) . "_objednavka_" . $this->order_id . ".pdf";
        $user = $order->school->main_contact();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', [
            'order' => $order,
            'school' => $order->school
        ]);

        $pdf->save(public_path() . '/storage/invoices/' . $pdf_name);

        $order->invoice = $pdf_name;
        $order->push();

        Mail::to($user)->queue(new InvoiceMail($user, $order, $pdf_name));
        //
    }
}
