<?php

namespace App\Events;

use App\Models\Messenger;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessenger implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Messenger $messenger;
    public int $new_messenger_id;

    public function __construct(Messenger $messenger, int $new_messenger_id)
    {
        $this->messenger = $messenger;
        $this->new_messenger_id = $new_messenger_id;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new_messenger.' . $this->messenger->id);
    }
}
