<?php

namespace App\Http\Livewire;

use App\Models\Registration;
use App\Models\School;
use App\Models\SchoolContact;
use Livewire\Component;

class ContactSchool extends Component
{
    public School $school;
    public ?Registration $registration;

    public ?string $name;
    public ?string $email;
    public ?string $phone;
    public ?string $body;

    public ?bool $gdpr;

    protected $rules = [
        'name' => 'required|max:250',
        'email' => 'required|max:250|email',
        'phone' => 'sometimes|max:250',
        'body' => 'required|max:510'
    ];

    public function submit()
    {
        $this->validate();

        $sc = SchoolContact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'body' => $this->body,
            'school_id' => $this->school->id,
        ]);

        if($this->registration != null){
            $sc->registration_id = $this->registration->id;
        }



        $sc->push();

        $this->redirect("/");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.contact-school');
    }
}
