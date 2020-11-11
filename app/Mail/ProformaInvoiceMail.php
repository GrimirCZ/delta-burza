<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class ProformaInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected User $user;
    protected Order $order;

    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
        //
    }

    public function build()
    {
        return $this->from("info@burzaskol.online")
            ->subject("Zálohová faktura k objednávce č. " . $this->order->id)
            ->view('emails.proforma-invoice')
            ->with([
                'user' => $this->user,
                'order' => $this->order
            ])
            ->attach($this->order->invoice, [
                'as' => 'faktura.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
