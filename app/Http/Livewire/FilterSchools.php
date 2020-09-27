<?php

namespace App\Http\Livewire;

use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\School;
use App\Models\Specialization;
use Livewire\Component;

class FilterSchools extends Component
{
    //FILTER => filtering interface
    //SHOW => show filtered schools
    public string $state = "FILTER";

    public ?array $selected_regions = [];
    public ?int $region_id = null;

    public ?array $selected_prescribed_specializations = [];
    public ?int $prescribed_specialization_id;

    public function add_region()
    {
        if($this->region_id == null){
            return;
        }

        $region = Region::find($this->region_id);

        array_push($this->selected_regions, [
            'id' => $this->region_id,
            'name' => $region->name
        ]);

        $this->refresh();
    }

    public function add_prescribed_specialization()
    {
        if($this->prescribed_specialization_id == null){
            return;
        }

        $ps = PrescribedSpecialization::find($this->prescribed_specialization_id);

        array_push($this->selected_prescribed_specializations, [
            'id' => $ps->id,
            'code' => $ps->code,
            'name' => $ps->name
        ]);

        $this->refresh();
    }

    public function show_filtered_schools()
    {
        $this->state = "SHOW";
    }

    public function mount()
    {
        $this->refresh();
    }


    public function remove_region(int $region_id)
    {
        $this->selected_regions = collect($this->selected_regions)
            ->filter(fn($sr) => $sr['id'] != $region_id)
            ->toArray();

        $this->refresh();
    }

    public function remove_prescribed_specialization(int $prescribed_specialization_id)
    {
        $this->selected_prescribed_specializations = collect($this->selected_prescribed_specializations)
            ->filter(fn($sps) => $sps['id'] != $prescribed_specialization_id)
            ->toArray();

        $this->refresh();
    }

    private function refresh()
    {
        $arc = $this->available_regions()->count();
        if($arc > 0)
            $this->region_id = $this->available_regions()->first()->id;
        else{
            $this->region_id = null;
        }

        $psc = $this->available_prescribed_specializations()->count();
        if($psc > 0)
            $this->prescribed_specialization_id = $this->available_prescribed_specializations()->first()->id;
        else{
            $this->prescribed_specialization_id = null;
        }
    }

    private function available_regions()
    {
        return Region::whereNotIn('id', collect($this->selected_regions)->map(fn($sr) => $sr['id']))
            ->orderBy("name");
    }

    private function available_prescribed_specializations()
    {
        return PrescribedSpecialization::whereNotIn('id', collect($this->selected_prescribed_specializations)->map(fn($sr) => $sr['id']))
            ->orderBy("name");
    }

    private function filtered_schools()
    {
        $q = School::query();

        if(count($this->selected_prescribed_specializations) > 0){
            $q = $q
                ->join("specializations", "schools.id", "=", "specializations.school_id")
                ->join("prescribed_specializations", "prescribed_specializations.id", "=", "specializations.prescribed_specialization_id")
                ->whereIn("prescribed_specializations.id", collect($this->selected_prescribed_specializations)->map(fn($sr) => $sr['id']));
        }
        if(count($this->selected_regions) > 0){
            $q = $q
                ->join("districts", "schools.district_id", "=", "districts.id")
                ->join("regions", "districts.region_id", "=", "regions.id")
                ->whereIn("regions.id", collect($this->selected_regions)->map(fn($sr) => $sr['id']));
        }

        return $q->select("schools.*");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if($this->state == "FILTER"){
            return view('livewire.filter-schools', [
                'regions' => $this->available_regions()->get(),
                'prescribed_specializations' => $this->available_prescribed_specializations()->get()
            ]);
        } else if($this->state == "SHOW"){
            return view('livewire.show-filtered-schools', [
                'schools' => $this->filtered_schools()->get(),
            ]);
        } else{
            return abort(500);
        }
    }
}
