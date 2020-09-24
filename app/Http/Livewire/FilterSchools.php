<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\Specialization;
use Livewire\Component;

class FilterSchools extends Component
{
    public array $regions;

    public function mount()
    {
        $this->regions = Region::orderBy("name")->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.filter-schools', [
            'regions' => Region::orderBy("name")->get(),
            'specializations' => Specialization::join("prescribed_specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
                ->orderBy("prescribed_specializations.code")
                ->orderBy("prescribed_specializations.name")
                ->orderBy("specializations.name")
                ->select("specializations.*")
                ->get(),
        ]);
    }
}
