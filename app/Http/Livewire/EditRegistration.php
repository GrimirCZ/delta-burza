<?php

namespace App\Http\Livewire;

use App\Models\Registration;
use App\Models\School;
use App\Models\Exhibition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditRegistration extends Component
{
    public Registration $registration;
    public Exhibition $exhibition;

    public ?string $morning_event = null;

    public ?string $evening_event = null;

    protected $rules = [
        'morning_event' => 'nullable|url',
        'evening_event' => 'nullable|url',
    ];

    public function mount(Registration $registration)
    {
        if(Auth::user()->id != $registration->school->main_contact()->id){
            abort(403);
        }

        $this->registration = $registration;
        $this->exhibition = $registration->exhibition;

        if($this->exhibition->has_morning_event)
            $this->morning_event = $registration->morning_event;
        if($this->exhibition->has_evening_event)
            $this->evening_event = $registration->evening_event;
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function(){

            if($this->exhibition->has_morning_event)
                $this->registration->update([
                    'morning_event' => $this->morning_event,
                ]);

            if($this->exhibition->has_evening_event)
                $this->registration->update([
                    'evening_event' => $this->evening_event,
                ]);
        });

        $this->redirect("/dashboard");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.edit-registration');
    }
}
