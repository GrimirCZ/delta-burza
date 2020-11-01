<?php

namespace App\Http\Livewire;

use App\Events\ActiveChatsChanged;
use App\Events\NewMessage;
use App\Events\NewMessenger;
use App\Models\Message;
use App\Models\Messenger;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VisitorChat extends Component
{
    public Registration $registration;
    public ?Messenger $me;
    public ?Messenger $school;

    public ?string $message;

    private string $session_key;

    protected $rules = [
        'message' => 'required|max:500'
    ];

    public $listeners = ['refresh' => 'render'];

    public function mount()
    {
        $this->session_key = "messenger_key";

        $this->school = Messenger::firstOrCreate([
            'type' => 'school',
            'data->school_id' => $this->registration->school_id,
            'data->registration_id' => $this->registration->id,
        ]);

        if(session($this->session_key) == null){
            session([
                $this->session_key => rand_str(24)
            ]);

            $this->create_new_messenger();
        } else{
            $this->me = Messenger::where("data->session_id", "=", session($this->session_key))
                ->where("data->registration_id", "=", $this->registration->id)
                ->first();

            if($this->me == null){
                $this->create_new_messenger();
            }
        }
    }

    private function create_new_messenger()
    {
        $this->me = Messenger::create([
            'type' => 'anonymous',
            'data->session_id' => session($this->session_key),
            'data->registration_id' => $this->registration->id,
            'data->ip' => get_ip(),
        ]);
    }

    public function send()
    {
        $send_new_messenger = false;
        $this->validate();

        // send notification on first message
        if(!isset($this->me->data['has_sent_message']) || $this->me->data['has_sent_message'] == false){
            $send_new_messenger = true;

            $this->me->update([
                'data->has_sent_message' => true
            ]);
        }

        Message::create([
            'body' => $this->message,
            'sender_id' => $this->me->id,
            'receiver_id' => $this->school->id
        ]);

        $this->message = "";

        if($send_new_messenger)
            broadcast(new NewMessenger($this->school, $this->me));
        else
            broadcast(new NewMessage($this->me, $this->school));
        broadcast(new ActiveChatsChanged($this->registration->id, SchoolChat::active_chats_count($this->school->id)));
    }

    public function refresh()
    {
        $this->emit("refresh");
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public
    function render()
    {
        $us = [$this->me->id, $this->school->id];

        $this->dispatchBrowserEvent("rendered");

        return view('livewire.visitor-chat', [
            'messages' => Message::whereIn("sender_id", $us)
                ->whereIn('receiver_id', $us)
                ->orderBy("created_at")
                ->get(),
                'currently_responding_to' => SchoolChat::active_chats_count($this->school->id),
            'registration' => $this->registration
        ]);
    }
}
