<?php

namespace App\Http\Livewire;

use App\Models\FieldOfStudy;
use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\School;
use App\Models\Specialization;
use App\Models\TypeOfStudy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FilterSchools extends Component
{
    //FILTER => filtering interface
    //SHOW => show filtered schools
    public string $state = "FILTER";

    protected $queryString = ['selected_regions', 'selected_prescribed_specializations'];

    public ?array $selected_regions_ids = [];
    public ?array $selected_regions = [];
    public ?int $region_id = null;

    public ?array $selected_prescribed_specializations_ids = [];
    public ?array $selected_prescribed_specializations = [];
    public ?int $prescribed_specialization_id;

    public ?int  $type_of_study_id;
    public ?int  $field_of_study_id;


    public function updated($name, $value)
    {
        if($name == "type_of_study_id"){
            $this->field_of_study_id = FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->orderBy("name")->first()->id ?? null;

            $this->refresh();
        } else if($name == "field_of_study_id"){
            $this->refresh();
        }
    }

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

    public function show_filter()
    {
        $this->state = "FILTER";
    }

    public function clear_filter()
    {
        $this->selected_prescribed_specializations = [];
        $this->selected_regions = [];

        $this->refresh();
    }

    public function mount()
    {
        $this->type_of_study_id = TypeOfStudy::first()->id;
        $this->field_of_study_id = FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->orderBy("name")->first()->id ?? null;

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

        $this->selected_regions_ids = collect($this->selected_prescribed_specializations)->map(fn($sr) => $sr['id'])->toArray();
        $this->selected_prescribed_specializations_ids = collect($this->selected_prescribed_specializations)->map(fn($sr) => $sr['id'])->toArray();
    }

    private function available_regions()
    {
        return Region::whereNotIn('id', collect($this->selected_regions)->map(fn($sr) => $sr['id']))
            ->orderBy("name");
    }

    private function available_prescribed_specializations()
    {
        $q = PrescribedSpecialization::join("field_of_studies", "prescribed_specializations.field_of_study_id", "=", "field_of_studies.id")
            ->whereNotIn("prescribed_specializations.id", collect($this->selected_prescribed_specializations)->map(fn($sr) => $sr['id']));

        if($this->field_of_study_id == null){
            $q = $q->where(DB::raw("0"), "=", DB::raw("1"));
        } else{

            $q = $q->where("field_of_studies.id", $this->field_of_study_id);
        }

        $q = $q->orderBy("prescribed_specializations.code")
            ->orderBy("prescribed_specializations.name")
            ->select("prescribed_specializations.*");

        return $q;
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
                'prescribed_specializations' => $this->available_prescribed_specializations()->get(),
                'field_of_studies' => FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->orderBy("name")->get(),
                'type_of_studies' => TypeOfStudy::orderBy("name")->get()
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
