<?php

namespace App\Http\Livewire;

use App\Models\Registration;
use App\Models\School;
use App\Models\Exhibition;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditRegistration extends Component
{
    public Registration $registration;

    public ?string $morning_event = null;

    public ?string $evening_event = null;

    protected $rules = [
        'morning_event' => 'required|url',
        'evening_event' => 'required|url',
    ];

    public function mount(Registration $registration)
    {
        if(Auth::user()->id != $registration->school->main_contact()->id){
            return abort(400);
        }

        $this->registration = $registration;
        $this->morning_event = $registration->morning_event;
        $this->evening_event = $registration->evening_event;
    }

    public function submit()
    {
        $this->validate();


        $this->registration->update([
            'morning_event' => $this->morning_event,
            'evening_event' => $this->evening_event,
        ]);

        $this->redirect("/dashboard");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.edit-registration', [
            'exhibition' => Exhibition::find($this->registration->exhibition_id)
        ]);
    }
}
