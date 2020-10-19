<?php

namespace App\Http\Livewire;

use App\Events\NewMessage;
use App\Events\NewMessenger;
use App\Models\Message;
use App\Models\Messenger;
use App\Models\Registration;
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
        $this->session_key = "messenger_id_" . $this->registration->id;

        $this->school = Messenger::firstOrCreate([
            'type' => 'school',
            'data->school_id' => $this->registration->school_id,
            'data->registration_id' => $this->registration->id,
        ]);

        if(session($this->session_key) == null){
            $this->me = Messenger::create([
                'type' => 'anonymous',
                'data->ip' => get_ip(),
                'data->registration_id' => $this->registration->id,
            ]);

            session([
                $this->session_key => $this->me->id
            ]);

            broadcast(new NewMessenger($this->school, $this->me->id));
        } else{
            $this->me = Messenger::findOrFail(session($this->session_key));
        }
    }

    public function send()
    {
        $this->validate();

        $message = Message::create([
            'body' => $this->message,
            'sender_id' => $this->me->id,
            'receiver_id' => $this->school->id
        ]);

        $this->message = "";

        broadcast(new NewMessage($this->me->id, $this->school->id));
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

        return view('livewire.visitor-chat', [
            'messages' => Message::whereIn("sender_id", $us)
                ->whereIn('receiver_id', $us)
                ->orderBy("created_at")
                ->get()
        ]);
    }
}