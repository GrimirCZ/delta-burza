<?php

namespace App\Mail;

use App\Models\SchoolContact;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected SchoolContact $contact;

    public function __construct(SchoolContact $contact)
    {
        $this->contact = $contact;
        //
    }

    public function build()
    {
        return $this->from("info@burzaskol.online")
                ->subject("Zpráva uchazeče o studiu prostřednictvím portálu BurzaŠkol.Online")
            ->view('emails.contact')
            ->with([
                'contact' => $this->contact,
            ]);
    }
}
