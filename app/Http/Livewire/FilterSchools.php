<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\FieldOfStudy;
use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\School;
use App\Models\Specialization;
use App\Models\TypeOfStudy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class FilterSchools extends Component
{
    //FILTER => filtering interface
    //SHOW => show filtered schools
    public string $state = "FILTER";

    public ?array $regions = [];

    public string $type = "all";

    public ?string $prescribed_specialization_id = "all";

    public ?string  $type_of_study_id = "all";
    public ?string  $field_of_study_id = "all";

    public bool $is_no_region_selected = false;

    public function updated($name, $value)
    {
        if($name == "type"){
            $this->type_of_study_id = "all";
        } else if($name == "type_of_study_id"){
            $this->field_of_study_id = "all";
        } else if($name == "field_of_study_id"){
            $this->prescribed_specialization_id = "all";
        } else if(str_starts_with($name, "regions")){
            $this->is_no_region_selected = false;
        }
    }

    public function show_filtered_schools()
    {
        $this->is_no_region_selected = collect($this->regions)
            ->every(fn($reg) => !$reg['selected']);

        if($this->is_no_region_selected){
            return;
        }

        $this->state = "SHOW";
    }

    public function show_filter()
    {
        $this->state = "FILTER";
    }

    public function clear_filter()
    {
        $this->type = "all";
        $this->type_of_study_id = 'all';
        $this->field_of_study_id = 'all';
        $this->prescribed_specialization_id = 'all';

        $this->regions = Region::orderBy("name")->get()->map(fn($reg) => [
            'id' => $reg->id,
            'name' => $reg->name,
            'selected' => false
        ])->toArray();
    }

    public function mount()
    {
        $this->clear_filter();
    }

    private function filtered_schools()
    {
        $q = School::query();

        $q = $this->filtered_schools_restrictions($q);

        return $q->select("schools.*");
    }

    private function filtered_schools_restrictions($q)
    {
        if($this->type == "skoly"){
            if($this->type_of_study_id != "all" && $this->field_of_study_id == "all"){
                $q = $q->join("specializations", "schools.id", "=", "specializations.school_id")
                    ->join("prescribed_specializations", "prescribed_specializations.id", "=", "specializations.prescribed_specialization_id")
                    ->join("field_of_studies", "field_of_studies.id", "=", "prescribed_specializations.field_of_study_id")
                    ->join("type_of_studies", "type_of_studies.id", "=", "field_of_studies.type_of_study_id")
                    ->where("type_of_studies.id", $this->type_of_study_id);

            } else if($this->type_of_study_id != "all" && $this->field_of_study_id != "all" && $this->prescribed_specialization_id == "all"){
                $q = $q->join("specializations", "schools.id", "=", "specializations.school_id")
                    ->join("prescribed_specializations", "prescribed_specializations.id", "=", "specializations.prescribed_specialization_id")
                    ->join("field_of_studies", "field_of_studies.id", "=", "prescribed_specializations.field_of_study_id")
                    ->where("field_of_studies.id", $this->field_of_study_id);
            } else if($this->prescribed_specialization_id != "all"){
                $q = $q->join("specializations", "schools.id", "=", "specializations.school_id")
                    ->join("prescribed_specializations", "prescribed_specializations.id", "=", "specializations.prescribed_specialization_id")
                    ->where("prescribed_specializations.id", $this->prescribed_specialization_id);
            }

            $q = $q->where("schools.is_school", true);
        } else if($this->type == "firmy"){
            $q = $q->where("schools.is_school", false);
        }

        $selected_region_ids = collect($this->regions)
            ->filter(fn($reg) => $reg['selected'])
            ->map(fn($reg) => $reg['id'])
            ->toArray();


        $q = $q
            ->join("districts", "schools.district_id", "=", "districts.id")
            ->join("regions", "districts.region_id", "=", "regions.id")
            ->whereIn("regions.id", $selected_region_ids);

        return $q;
    }

    private function filtered_exhibitions()
    {
        // nesahat
        $q = DB::table("exhibitions")
            ->join("registrations", "registrations.exhibition_id", "=", "exhibitions.id")
            ->join("schools", "registrations.school_id", "=", "schools.id")
            ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
            ->whereIn("schools.id", function($q){
                $q->select("schools.id")
                    ->from("schools");
                $q = $this->filtered_schools_restrictions($q);
            })
            ->where(function($q){
                $q->whereNotNull("order_registration.fulfilled_at")
                    ->orWhere("schools.is_trustworthy", true);
            })
            ->select(DB::raw("exhibitions.id as exhibition_id"), DB::raw("count(schools.id) as school_count"))
            ->groupBy("exhibitions.id");


        return Exhibition::joinSub($q, "exh_sch_count", function($join){
            $join->on("exhibitions.id", "=", "exh_sch_count.exhibition_id");
        })
            ->orderByDesc("exh_sch_count.school_count")
            ->orderBy("exhibitions.date")
            ->orderBy("exhibitions.city")
            ->orderBy("exhibitions.name")
            ->select("exhibitions.*", DB::raw("exh_sch_count.school_count as school_count"));
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
                'prescribed_specializations' => PrescribedSpecialization::where("field_of_study_id", $this->field_of_study_id)
                    ->orderBy("code")
                    ->orderBy("name")
                    ->get(),
                'field_of_studies' => FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->get(),
                'type_of_studies' => TypeOfStudy::all()
            ]);
        } else if($this->state == "SHOW"){
            return view('livewire.show-filtered-schools', [
                'schools' => $this->filtered_schools()->distinct()->get(),
                'exhibitions' => $this->filtered_exhibitions()->distinct()->get()
            ]);
        } else{
            return abort(500);
        }
    }
}
