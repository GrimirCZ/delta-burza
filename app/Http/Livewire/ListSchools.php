<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\School;
use App\Models\Exhibition;
use Livewire\Component;

class ListSchools extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('livewire.list-schools', [
            'schools' => School::orderBy('name', 'asc')->paginate(14),
            "schoolsCount" => School::schools()->count(),
            "companiesCount" => School::companies()->count(),
            'exibitionsCount' => Exhibition::count()
        ]);
    }
}
