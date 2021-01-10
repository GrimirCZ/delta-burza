<?php

namespace App\Http\Livewire;

use App\Models\ExamResult;
use App\Models\Specialization;
use Livewire\Component;

class ShowSpecialization extends Component
{
    public Specialization $specialization;

    private function get_exam_results()
    {
        return ExamResult::query()
            ->join("specialization_groups", "exam_results.specialization_group_id", "=", "specialization_groups.id")
            ->join("prescribed_specializations", "prescribed_specializations.specialization_group_id", "=", "specialization_groups.id")
            ->join("specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->where("specializations.id", "=", $this->specialization->id)
            ->where("exam_results.school_id", "=", $this->specialization->school_id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $exam_results = $this->get_exam_results()->distinct()->get();
        $subjects = $exam_results->map(fn($exam_report) => $exam_report->subject)->unique();

        return view('livewire.show-specialization', [
            'exam_results' => $exam_results,
            'subjects' => $subjects,
            'fmt' => fn($num) => fmod($num, 1) == 0 ? number_format($num, 0) : number_format($num, 1, ",", " "),
            'fmtPrc' => fn($num) => fmod($num, 1) == 0 ? number_format($num * 100, 0) : number_format($num * 100, 1, ",", " ")
        ]);
    }
}
