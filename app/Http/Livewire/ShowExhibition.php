<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\FieldOfStudy;
use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\School;
use App\Models\TypeOfStudy;
use DB;
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

    public function get_registrations()
    {
        return $this->filtered_schools_restrictions(
            $this->exhibition
                ->registrations()
                ->join("schools", "registrations.school_id", "=", "schools.id")
                ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
                ->join("entity_types", "entity_type_id", "=", "entity_types.id")
                ->where(function($q){
                    $q->whereNotNull("order_registration.fulfilled_at")
                        ->orWhere("schools.is_trustworthy", true);
                })
                ->orderByDesc("entity_types.data->importance")
                ->orderBy("schools.name")
        )
            ->select("registrations.*", "schools.name", "entity_types.data->importance");
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

        return view('livewire.show-exhibition', [
            'title' => $title,
            'is_empty' => $this->exhibition->registrations()->count() == 0,
            'registrations' => $this->get_registrations()->distinct()->get(),
            'unregistered_schools' => School::unassociated_schools()->where("district_id", "=", $this->exhibition->district_id),

            'has_morning' => $this->exhibition->has_morning_event,
            'has_evening' => $this->exhibition->has_evening_event,
            'has_chat' => $this->exhibition->has_chat,

            'enable_morning_join_buttons' => $this->exhibition->enable_morning_join_buttons() || ($this->exhibition->enable_test_join_buttons() && $has_test),
            'enable_evening_join_buttons' => $this->exhibition->enable_evening_join_buttons() || ($this->exhibition->enable_test_join_buttons() && $has_test),
            'enable_chat' => $this->exhibition->enable_chat() || ($this->exhibition->enable_test_join_buttons() && $has_test),

            'prescribed_specializations' => PrescribedSpecialization::where("field_of_study_id", $this->field_of_study_id)
                ->orderBy("code")
                ->orderBy("name")
                ->get(),
            'field_of_studies' => FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->get(),
            'type_of_studies' => TypeOfStudy::all()
        ]);
    }
}
