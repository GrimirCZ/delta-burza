<?php

namespace App\Events;

use App\Models\Messenger;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $registration_id;

    public int $sender_id;
    public int $receiver_id;

    private Messenger $sender;
    private Messenger $receiver;

    public function __construct(Messenger $sender, Messenger $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;

        $this->sender_id = $sender->id;
        $this->receiver_id = $receiver->id;

        $this->registration_id = $receiver->data['registration_id'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->receiver->type == "anonymous"){
            return new Channel('chat.' . $this->receiver->data['session_id']);
        } else if($this->receiver->type == "school"){
            return new Channel('chat-school.' . $this->receiver->data['school_id']);
        } else{
            throw new Exception("Only supported receiver types are school and anonymous");
        }
    }
}
