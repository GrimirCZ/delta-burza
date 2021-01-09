<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\FieldOfStudy;
use App\Models\File;
use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\School;
use App\Models\Specialization;
use App\Models\TypeOfStudy;
use DB;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ShowExhibition extends Component
{
    use WithPagination;

    public Exhibition $exhibition;

    public string $type = "all";

    public ?string $prescribed_specialization_id = "all";

    public ?string $type_of_study_id = "all";
    public ?string $field_of_study_id = "all";

    public function updated($name, $value)
    {
        if($name == "type"){
            $this->type_of_study_id = "all";
            $this->resetPage();
        } else if($name == "type_of_study_id"){
            $this->field_of_study_id = "all";
            $this->resetPage();
        } else if($name == "field_of_study_id"){
            $this->prescribed_specialization_id = "all";
            $this->resetPage();
        } else if($name == "prescribed_specialization_id"){
            $this->resetPage();
        }
    }

    public function clear_filter()
    {
        $this->type = "all";
        $this->type_of_study_id = 'all';
        $this->field_of_study_id = 'all';
        $this->prescribed_specialization_id = 'all';
        $this->resetPage();
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
            $q = $q->where("entity_types.type", "school");
        } else if($this->type == "firmy"){
            $q = $q->where("entity_types.type", "company");
        }

        return $q;
    }


    public function get_registered_schools()
    {
        return $this->filtered_schools_restrictions(
            School::query()
                ->join("registrations", "schools.id", "=", "registrations.school_id")
                ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
                ->join("entity_types", "entity_type_id", "=", "entity_types.id")
                ->join("districts", "district_id", "=", "districts.id")
                ->where("registrations.exhibition_id", "=", $this->exhibition->id)
                ->where(function($q){
                    $q->whereNotNull("order_registration.fulfilled_at")
                        ->orWhere("schools.is_trustworthy", true);
                })
                ->orderByDesc("entity_types.data->importance")
                ->orderBy("schools.name")
        )
            ->select(
                "schools.id AS id",
                "registrations.id AS registration_id",
                DB::raw("if(hour(curtime()) <= 12, registrations.morning_event, registrations.evening_event) as try_link"),
                "registrations.morning_event AS morning_event",
                "registrations.evening_event AS evening_event",
                "schools.name AS name",
                "schools.web AS web",
                "schools.phone AS phone",
                "schools.email AS email",
                "schools.city AS city",
                "schools.entity_type_id",
                "districts.name as district_name",
                "entity_types.type AS type_name",
                "entity_types.data->importance AS importance",
                DB::raw("1 AS is_registered")
            );
    }

    function get_unregistered_schools()
    {
        return $this->filtered_schools_restrictions(
            School::unassociated_schools()
                ->join("districts", "district_id", "=", "districts.id")
                ->whereIn("schools.district_id", function($q){
                    $q->select("district_id")
                        ->where("exhibition_id", "=", $this->exhibition->id)
                        ->from("district_exhibition");
                })
                ->join("entity_types", "entity_type_id", "=", "entity_types.id")
        )->select(
            "schools.id AS id",
            DB::raw("0 AS registration_id"),
            DB::raw("null AS try_link"),
            DB::raw("null AS morning_event"),
            DB::raw("null AS evening_event"),
            "schools.name AS name",
            "schools.web AS web",
            "schools.phone AS phone",
            "schools.email AS email",
            "schools.city AS city",
            "schools.entity_type_id",
            "districts.name as district_name",
            "entity_types.type AS type_name",
            DB::raw("0 AS importance"),
            DB::raw("0 as is_registered")
        );
    }


    private function get_schools()
    {
        return $this->get_registered_schools()
            ->union($this->get_unregistered_schools())
            ->orderByDesc("is_registered")
            ->orderByDesc("importance")
            ->orderBy("name");
    }


    private function get_logos(Collection  $school_ids)
    {
        return File::query()
            ->whereIn("school_id", $school_ids)
            ->where("type", "=", "logo")
            ->select("name", "school_id");
    }

    private function get_specializations(Collection $school_ids)
    {
        $q = Specialization::query()->whereIn("school_id", $school_ids)
            ->join("prescribed_specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->join("field_of_studies", "field_of_studies.id", "=", "prescribed_specializations.field_of_study_id")
            ->join("type_of_studies", "type_of_studies.id", "=", "field_of_studies.type_of_study_id")
            ->orderBy("type_of_studies.id")
            ->orderBy("prescribed_specializations.code")
            ->orderBy("prescribed_specializations.name")
            ->orderBy("specializations.name")
            ->select(
                "specializations.*",
                "type_of_studies.id",
                "prescribed_specializations.code as prescribed_specialization_code",
                "prescribed_specializations.name as prescribed_specialization_name"
            );


        if($this->type_of_study_id == "all" && $this->field_of_study_id == "all" && $this->prescribed_specialization_id == "all"){
            return $q;
        } else if($this->field_of_study_id == "all" && $this->prescribed_specialization_id == "all"){
            $q = $q->where("type_of_studies.id", "=", $this->type_of_study_id);
        } else if($this->prescribed_specialization_id == "all"){
            $q = $q->where("field_of_studies.id", "=", $this->field_of_study_id);
        } else{
            $q = $q->where("prescribed_specialization_id", $this->prescribed_specialization_id);
        }

        return $q;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $title = $this->exhibition->district->region->name . " " . format_date($this->exhibition->date);

        if($this->exhibition->test_date != null){
            $title .= " (test proběhne " . format_date($this->exhibition->test_date) . ")";
        }

        $has_test = $this->exhibition->has_test_event;

        $schools = $this->get_schools()->distinct()->get();

        $school_ids = $schools->map(fn($sch) => $sch->id);

        $specializations = $this->get_specializations($school_ids)->distinct()->get();

        $logos = $this->get_logos($school_ids)->distinct()->get();

        return view('livewire.show-exhibition', [
            'title' => $title,
            'is_empty' => $this->exhibition->registrations()->count() == 0,
//            'registrations' => $this->get_registrations()->distinct()->get(),
//            'unregistered_schools' => $this->get_unregistered_schools()->distinct()->get(),
            'schools' => $schools,
            'specializations' => $specializations,
            'logos' => $logos,

            'has_morning' => $this->exhibition->has_morning_event,
            'has_evening' => $this->exhibition->has_evening_event,
            'has_chat' => $this->exhibition->has_chat,

            'enable_morning_join_buttons' => $this->exhibition->enable_morning_join_buttons() || ($this->exhibition->enable_test_join_buttons() && $has_test),
            'enable_evening_join_buttons' => $this->exhibition->enable_evening_join_buttons() || ($this->exhibition->enable_test_join_buttons() && $has_test),
            'enable_chat' => $this->exhibition->enable_chat() || ($this->exhibition->enable_test_join_buttons() && $has_test),

            // for filtering
            'prescribed_specializations' => PrescribedSpecialization::where("field_of_study_id", $this->field_of_study_id)
                ->orderBy("code")
                ->orderBy("name")
                ->get(),
            'field_of_studies' => FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->get(),
            'type_of_studies' => TypeOfStudy::all()
        ]);
    }


}
