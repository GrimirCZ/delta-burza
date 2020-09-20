<?php

namespace App\Http\Livewire;

use App\Models\Registration;
use Livewire\Component;

class ShowRegistration extends Component
{
    public Registration $registration;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-registration')->layout('layouts.client');
    }
}
