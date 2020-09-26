<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $pdf_name;
    protected User $user;
    protected Order $order;

    public function __construct(User $user, Order $order, string $pdf_name)
    {
        $this->user = $user;
        $this->order = $order;
        $this->pdf_name = $pdf_name;
        //
    }

    public function build()
    {
        return $this->from("info@burzaskol.online")
            ->subject("Zálohová faktura k objednávce č. " . $this->order->id)
            ->view('emails.invoice')
            ->with([
                'user' => $this->user,
                'order' => $this->order
            ])
            ->attach(base_path("storage/app/public/invoices/" . $this->pdf_name), [
                'as' => 'faktura.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
