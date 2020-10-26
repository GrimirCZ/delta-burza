<?php

namespace App\Events;

use App\Models\Messenger;
use Exception;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessenger implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Messenger $messenger;
    public int $messenger_id;
    public int $messenger_registration_id;

    public function __construct(Messenger $messenger, Messenger $new_messenger)
    {
        $this->messenger = $messenger;

        $this->messenger_id = $new_messenger->id;
        $this->messenger_registration_id = $new_messenger->data['registration_id'];
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->messenger->type == "school"){
            return new PrivateChannel('new_messenger.' . $this->messenger->data['school_id']);
        }else {
            throw new Exception("Messenger has to by of type school");
        }
    }
}
