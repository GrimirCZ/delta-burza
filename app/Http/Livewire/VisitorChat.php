<?php

namespace App\Http\Livewire;

use App\Models\Messenger;
use App\Models\Registration;
use Livewire\Component;

class VisitorChat extends Component
{
    public Registration $registration;
    public ?Messenger $me;
    public ?Messenger $school;

    public ?string $message;

    protected $rules = [
        'message' => 'required|max:500'
    ];

    public function mount()
    {
        if(session("messenger_id") == null){
            $this->me = Messenger::create([
                'type' => 'anonymous',
                'data->ip' => get_ip()
            ]);

            session([
                'messenger_id' => $this->me->id
            ]);
        } else{
            $this->me = Messenger::findOrFail(session('messenger_id'));
        }

        $this->school =  Messenger::firstOrCreate([
           'type' => 'school',
           'data->school_id' => $this->registration->school_id
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.visitor-chat');
    }
}
