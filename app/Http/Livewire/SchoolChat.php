<?php

namespace App\Http\Livewire;

use App\Events\ActiveChatsChanged;
use App\Events\NewMessage;
use App\Models\Message;
use App\Models\Messenger;
use App\Models\Registration;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SchoolChat extends Component
{
    public Registration $registration;
    public School $school;

    public Messenger $me;

    public ?string $selected_messenger_id = null;

    protected $queryString = ['selected_messenger_id' => ['except' => '']];
    public $listeners = ['refresh' => 'number_of_responded_to_chats_changed'];

    public ?string $message = null;

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
        broadcast(new ActiveChatsChanged($this->registration->id, self::active_chats_count($this->me->id)));
    }

    public function set_messenger_id($messenger_id)
    {
        $this->selected_messenger_id = $messenger_id;
    }

    private static function all_chats($messenger_id)
    {
        return DB::query()->fromSub(function($q) use ($messenger_id){
            $q->from("messages")
                ->where("receiver_id", $messenger_id)
                ->orWhere("sender_id", $messenger_id)
                ->groupBy(DB::raw("id, receiver_id, sender_id"))
                ->select(
                    "receiver_id",
                    "sender_id",
                    DB::raw("receiver_id + sender_id as chat_id"),
                    DB::raw("messages.id as id"),
                    DB::raw("max(created_at) as time")
                );
        }, "chats")
            ->groupBy("chats.chat_id")
            ->select("chats.chat_id", DB::raw("max(chats.id) as id"), DB::raw("max(chats.time) as time"));
    }

    private function chats_waiting_for_answer()
    {
        $last_chat_messages = self::all_chats($this->me->id);

        return Message::joinSub($last_chat_messages, "last_chat", function($join){
            $join->on("messages.id", "=", "last_chat.id");
        })->join("messengers", "messengers.id", "=", "messages.sender_id")
            ->select("messages.body as message", "messages.created_at as time", "messengers.id as id")
            ->orderByDesc("messages.created_at")
            ->where("sender_id", "!=", $this->me->id);
    }

    private function chats_waiting_for_response()
    {
        $last_chat_messages = self::all_chats($this->me->id);

        return Message::joinSub($last_chat_messages, "last_chat", function($join){
            $join->on("messages.id", "=", "last_chat.id");
        })->join("messengers", "messengers.id", "=", "messages.receiver_id")
            ->select("messages.body as message", "messages.created_at as time", "messengers.id as id")
            ->orderByDesc("messages.created_at")
            ->where("sender_id", "=", $this->me->id);
    }

    public static function active_chats($messenger_id)
    {
        $last_chat_messages = self::all_chats($messenger_id);

        return Message::joinSub($last_chat_messages, "last_chat", function($join){
            $join->on("messages.id", "=", "last_chat.id");
        })->where("sender_id", "!=", $messenger_id);
    }

    public static function active_chats_count($messenger_id)
    {
        return self::active_chats($messenger_id)->where("last_chat.time", ">", DB::raw("DATE_SUB(NOW(), INTERVAL 15 MINUTE)"))->count();
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

        $this->dispatchBrowserEvent("rendered");

        return view('livewire.school-chat', [
            'messengers' => $this->get_messengers()->get(),
            "selected_messenger" => Messenger::find($this->selected_messenger_id),
            "messages" => Message::whereIn("sender_id", $us)
                ->whereIn('receiver_id', $us)
                ->orderBy("created_at")
                ->get(),
            "chats_waiting_for_answer" => $this->chats_waiting_for_answer()->get(),
            "chats_waiting_for_response" => $this->chats_waiting_for_response()->get(),
        ]);
    }
}
