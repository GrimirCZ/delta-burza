<?php

namespace App\Http\Livewire;

use App\Models\ContestResult;
use App\Models\School;
use App\Models\Specialization;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

class ShowSchool extends Component
{
    public School $school;
    public array $contest_results;
    public array $contest_result_years;
    public bool $has_only_non_maturita = false;

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

    public string $textBody = "Soutěže jsou podle své \"prestiže\" (počtu účastníků, tradice, sturktury - okresní/krajské/celostátní/mezinárodní kolo) rozřazeny do různých kategorií a podle toho hodnoceny.
Například za matematickou olympiádu získá účastník 1 bod, když se umístí do 6. místa v krajském kole a max. do 10. místa v celostátním kole.
    Za méně přestižní soutěže, které například okresní a krajská kola nemají a mají pouze celostátní, obdrží účastník 1 bod, když se umístí do 3. místa v celostátním kole. Podrobné informace o zařazení soutěží do jednotlivých kategorií najdete zde: <a href='http://excelence.msmt.cz/' class='link'>http://excelence.msmt.cz/</a>.";


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

        $allowed_years = collect([2019, 2018, 2017]);

        $this->contest_result_years = collect($contest_results)
            ->map(fn($cr) => $cr->year)
            ->unique()
            ->filter(fn($y) => $allowed_years->contains($y))
            ->toArray();

        $this->contest_results = $contest_results->toArray();

        $this->has_only_non_maturita = Specialization::query()
                ->join("prescribed_specializations", "prescribed_specializations.id", "=", "specializations.prescribed_specialization_id")
                ->join("field_of_studies", "field_of_studies.id", "=", "prescribed_specializations.field_of_study_id")
                ->join("type_of_studies", "type_of_studies.id", "=", "field_of_studies.type_of_study_id")
                ->where("school_id", $this->school->id)
                ->whereBetween("type_of_studies.id", [2, 4])
                ->count() == 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-school', [
            'specializations' => $this->school->ordered_specializations()->get(),
            'inspection_reports' => $this->school->inspection_reports,
        ]);
    }
}
