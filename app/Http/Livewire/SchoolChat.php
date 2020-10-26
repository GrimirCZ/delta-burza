<?php

namespace App\Http\Livewire;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\Messenger;
use App\Models\Registration;
use App\Models\School;
use Livewire\Component;

class SchoolChat extends Component
{
    public Registration $registration;
    public School $school;

    public Messenger $me;

    public ?string $selected_messenger_id = null;

    protected $queryString = ['selected_messenger_id' => ['except' => '']];
    public $listeners = ['refresh' => 'render'];

    public ?string $message;

    protected $rules = [
        'message' => 'required|max:500'
    ];

    public function mount()
    {
        $this->school = $this->registration->school;

        $this->me = Messenger::firstOrCreate([
            'type' => 'school',
            'data->school_id' => $this->registration->school_id,
            'data->registration_id' => $this->registration->id
        ]);
    }

    public function send()
    {
        $this->validate();

        $message = Message::create([
            'body' => $this->message,
            'sender_id' => $this->me->id,
            'receiver_id' => $this->selected_messenger_id
        ]);

        $this->message = "";

        broadcast(new NewMessage($this->me, Messenger::find($this->selected_messenger_id)));
    }

    public function get_messengers()
    {
        return Messenger::where("type", "=", "anonymous")
            ->where("data->registration_id", "=", $this->registration->id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $us = [$this->me->id, $this->selected_messenger_id];

        return view('livewire.school-chat', [
            'messengers' => $this->get_messengers()->get(),
            "selected_messenger" => Messenger::find($this->selected_messenger_id),
            "messages" => Message::whereIn("sender_id", $us)
                ->whereIn('receiver_id', $us)
                ->orderBy("created_at")
                ->get()
        ]);
    }
}
