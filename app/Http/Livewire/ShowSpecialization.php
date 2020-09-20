<?php

namespace App\Http\Livewire;

use App\Models\Specialization;
use Livewire\Component;

class ShowSpecialization extends Component
{
    public Specialization $specialization;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-specialization')->layout("layouts.client");
    }
}
