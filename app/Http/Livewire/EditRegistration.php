<?php

namespace App\Http\Livewire;

use App\Models\Registration;
use App\Models\School;
use Livewire\Component;

class EditRegistration extends Component
{
    public Registration $registration;

    public ?string $morning_event;

    public ?string $evening_event;

    protected $rules = [
        'morning_event' => 'required|max:255|url',
        'evening_event' => 'required|max:255|url',
    ];

    public function mount(Registration $registration)
    {
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
        return view('livewire.edit-registration');
    }
}
