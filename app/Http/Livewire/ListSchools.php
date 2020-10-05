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
            'schools' => School::orderBy('name', 'asc')->get(),
            "schoolsCount" => School::where('is_school', 1)->count(),
            "companiesCount" => School::where('is_school', 0)->count(),
            'exibitionsCount' => Exhibition::count()
        ]);
    }
}
