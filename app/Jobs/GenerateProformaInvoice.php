<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Mail\ProformaInvoiceMail;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GenerateProformaInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $order_id;
    protected bool $send_mail;

    public function __construct(int $order_id, bool $send_mail = true)
    {
        $this->order_id = $order_id;
        $this->send_mail = $send_mail;
    }

    public function handle()
    {
        $order = Order::find($this->order_id);
        $user = $order->school->main_contact();

        // some orders do not have this, perhapse remove later
        if($order->proforma_invoice_number == null){
            $order->update([
                'proforma_invoice_number' => "2020" . fill_number_to_length($order->id, 4)
            ]);
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.proforma-invoice', [
            'order' => $order,
            'school' => $order->school
        ]);

        $name = "proforma_" . $order->id . "_" . uniqid() . ".pdf";


        $filepath = 'invoices/' . $name;

        $s3 = Storage::disk("s3");
        $s3->put($filepath, $pdf->stream(), 'public');
        $url = $s3->url($filepath);


        $order->update([
            'proforma_invoice' => $url,
        ]);

        if($this->send_mail){
            Mail::to($user)->queue(new ProformaInvoiceMail($user, $order));
        }
        //
    }
}
