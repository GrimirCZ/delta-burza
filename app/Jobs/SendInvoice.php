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
use Illuminate\Support\Facades\Storage;

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
        $user = $order->school->main_contact();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', [
            'order' => $order,
            'school' => $order->school
        ]);

        $filepath = 'invoices/' . $order->id . "_" . uniqid() . ".pdf";

        $s3 = Storage::disk("s3");
        $s3->put($filepath, $pdf->stream(), 'public');
        $url = $s3->url($filepath);


        $order->invoice = $url;
        $order->push();

        // Mail::to($user)->queue(new InvoiceMail($user, $order));
        //
    }
}
