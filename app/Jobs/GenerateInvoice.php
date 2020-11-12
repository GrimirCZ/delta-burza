<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GenerateInvoice implements ShouldQueue
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
        $school = $order->school;
        $user = $school->main_contact();


        // some orders do not have this, perhapse remove later
        if($order->invoice_number == null){
            $current_year = Carbon::now()->isoFormat("YYYY");
            $last_invoice_number = Order::where("invoice_year", $current_year)->max("invoice_number");

            if($last_invoice_number == null)
                $last_invoice_number = 0; // first this year

            $order->update([
                'invoice_year' => $current_year,
                'invoice_number' => $last_invoice_number + 1
            ]);
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', [
            'order' => $order,
            'school' => $order->school
        ]);

        $name = $order->id . "_" . uniqid() . ".pdf";


        $filepath = 'invoices/' . $name;

        $s3 = Storage::disk("s3");
        $s3->put($filepath, $pdf->stream(), 'public');
        $url = $s3->url($filepath);


        $order->invoice = $url;
        $order->push();

        if($this->send_mail){
            Mail::to($school->email)->queue(new InvoiceMail($user, $order));
        }
        //
    }
}
