<?php

namespace App\Http\Livewire;

use App\Models\ContestResult;
use App\Models\School;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowSchool extends Component
{
    public School $school;
    public Collection $contest_results;

    private function get_last_inspection_report()
    {
        return $this->school->inspection_reports()->orderByDesc("start_date")->limit(1);
    }

    public string $textBody = "";


    public function mount()
    {
        $this->contest_results = ContestResult::query()
            ->where("school_id", $this->school->id)
            ->join("contests", "contests.id", "=", "contest_results.contest_id")
            ->join("contest_levels", "contest_levels.id", "=", "contest_results.contest_level_id")
            ->select(
                "expoint AS points",
                "contests.name AS name",
                "contest_levels.name AS level_name",
                "year"
            )
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-school', [
            'last_inspection_report' => $this->get_last_inspection_report()->first(),
            'inspection_reports' => $this->school->inspection_reports,
            'contest_result_years' => collect($this->contest_results)->map(fn($cr) => $cr->year)->unique()->toArray()
        ]);
    }
}
