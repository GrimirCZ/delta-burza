<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\Exhibition;
use Livewire\Component;

class ListExhibitionsRegion extends Component
{
    public Region $region;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        $exhibitions = Exhibition::join('districts', 'exhibitions.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->orderBy('regions.name')
            ->orderBy('exhibitions.date')
            ->select('exhibitions.*')
            ->where('regions.id', '=', $this->region->id)
            ->get();

        return view('livewire.list-exhibitions', [
            'exhibitions' => $exhibitions,
            'regions' => Region::get(),
            'regionSelected' =>  $this->region->id
        ]);
    }
}
