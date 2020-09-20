<?php

namespace App\Http\Livewire;

use App\Models\School;
use Livewire\Component;

class ShowSchool extends Component
{
    public School $school;
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-school')->layout('layouts.client');
    }
}
