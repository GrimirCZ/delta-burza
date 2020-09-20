<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\Exhibition;
use Livewire\Component;

class ListExhibitions extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.list-exhibitions', [
            'exhibitions' => Exhibition::join('districts', 'exhibitions.district_id', '=', 'districts.id')
                ->join('regions', 'districts.region_id', '=', 'regions.id')
                ->orderBy('regions.name')
                ->orderBy('exhibitions.date')
                ->select('exhibitions.*')
                ->paginate(10)
        ])->layout('layouts.client');
    }
}
