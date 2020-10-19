<?php

namespace App\Http\Livewire;

use App\Models\SchoolContact;
use Livewire\Component;

class ShowContact extends Component
{
    public SchoolContact $contact;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-contact');
    }
}
