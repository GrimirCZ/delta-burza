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
    public array $contest_results;
    public array $contest_result_years;

    public ?int $show_more_for_year = null;

    protected $listeners = [
        'openDetail' => 'open',
        'closeTooltip' => 'close',
    ];

    public function open($year)
    {
        $this->show_more_for_year = $year;
    }

    public function close()
    {
        $this->show_more_for_year = null;
    }

    public string $textBody = "";


    public function mount()
    {
        $contest_results = ContestResult::query()
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

        $this->contest_result_years = collect($contest_results)->map(fn($cr) => $cr->year)->unique()->toArray();

        $allowed_years = collect([2019, 2018, 2017]);

        $this->contest_results = $contest_results->filter(fn($y) => $allowed_years->contains($y))->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-school', [
            'inspection_reports' => $this->school->inspection_reports,
        ]);
    }
}
