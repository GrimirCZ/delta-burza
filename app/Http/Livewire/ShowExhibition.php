<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\FieldOfStudy;
use App\Models\PrescribedSpecialization;
use App\Models\Region;
use App\Models\TypeOfStudy;
use DB;
use Livewire\Component;

class ShowExhibition extends Component
{
    public Exhibition $exhibition;

    public string $type = "skoly";

    public ?string $prescribed_specialization_id = "all";

    public ?string  $type_of_study_id = "all";
    public ?string  $field_of_study_id = "all";

    public function updated($name, $value)
    {
        if($name == "type"){
            $this->type_of_study_id = "all";
        } else if($name == "type_of_study_id"){
            $this->field_of_study_id = "all";
        } else if($name == "field_of_study_id"){
            $this->prescribed_specialization_id = "all";
        }
    }

    public function clear_filter()
    {
        $this->type = "all";
        $this->type_of_study_id = 'all';
        $this->field_of_study_id = 'all';
        $this->prescribed_specialization_id = 'all';
    }

    public function get_registrations()
    {
        return $this->filtered_schools_restrictions(
            $this->exhibition
                ->registrations()
                ->join("schools", "registrations.school_id", "=", "schools.id")
                ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
                ->where(function($q){
                    $q->whereNotNull("order_registration.fulfilled_at")
                        ->orWhere("schools.is_trustworthy", true);
                })
                ->orderBy("schools.name")
        )
            ->select("registrations.*", "schools.name");
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

        return $q;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-exhibition', [
            'is_empty' => $this->exhibition->registrations()->count() == 0,
            'registrations' => $this->get_registrations()->distinct()->get(),
            'enable_join_buttons' => $this->exhibition->show_join_buttons(),
            'prescribed_specializations' => PrescribedSpecialization::where("field_of_study_id", $this->field_of_study_id)
                ->orderBy("code")
                ->orderBy("name")
                ->get(),
            'field_of_studies' => FieldOfStudy::where("type_of_study_id", $this->type_of_study_id)->get(),
            'type_of_studies' => TypeOfStudy::all()
        ]);
    }
}
