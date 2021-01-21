<?php

namespace App\Http\Livewire;

use App\Models\ContestResult;
use App\Models\School;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;

class ShowSchool extends Component
{
    public School $school;
    public Collection $contest_results;
    public array $contest_result_years;

    public ?int $show_more_for_year = null;

    protected $listeners = [
        'openDetail' => 'open',
        'closeTooltip' => 'close',
    ];

    public function open($year)
    {
        dump($year);
        $this->show_more_for_year = $year;
        dd($this->show_more_for_year);
    }

    public function close()
    {
        $this->show_more_for_year = null;
    }

    private function get_last_inspection_report() : HasMany
    {
        return $this->school->inspection_reports()->orderByDesc("start_date")->limit(1);
    }

    public string $textBody = "";


    public function mount()
    {
        $this->contest_results = ContestResult::query()
            ->where("school_id", $this->school->id)
            ->whereNotNull("expoint")
            ->join("contests", "contests.id", "=", "contest_results.contest_id")
            ->join("contest_levels", "contest_levels.id", "=", "contest_results.contest_level_id")
            ->select(
                DB::raw("sum(expoint) AS points"),
                "contests.name AS name",
                "contest_levels.name AS level_name",
                "contest_levels.id",
                "place",
                "year"
            )
            ->orderByDesc("year")
            ->orderByDesc("points")
            ->orderByDesc("contest_levels.id")
            ->orderBy("contests.name")
            ->orderBy("place")
            ->groupBy("year", "contest_levels.name", "place", "contests.name", "contest_levels.id")
            ->get();

        $this->contest_result_years = collect($this->contest_results)->map(fn($cr) => $cr->year)->unique()->toArray();
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
        ]);
    }
}
