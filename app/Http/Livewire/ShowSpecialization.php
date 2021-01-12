<?php

namespace App\Http\Livewire;

use App\Models\ExamResult;
use App\Models\School;
use App\Models\Specialization;
use App\Models\SpecializationGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

class ShowSpecialization extends Component
{
    public Specialization $specialization;
    public School $school;

    public $exam_results = [];
    public $subjects = [];
    public $years_to_display = [];
    public $spec_group = null;

    public function mount()
    {
        $this->school = $this->specialization->school;

        $this->spec_group = SpecializationGroup::query()
            ->join("prescribed_specializations", "specialization_groups.id", "=", "prescribed_specializations.specialization_group_id")
            ->join("specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->where("specializations.id", "=", $this->specialization->id)
            ->select("specialization_groups.*")
            ->first();

        $this->textSimiliarObory = $this->generateSimilarOboryText($this->spec_group);

        $this->max_year = intval(ExamResult::max("year"));

        for($i = $this->max_year; $i > $this->max_year - 5; $i--){
            array_push($this->years_to_display, $i);
        }

        $last_year = end($this->years_to_display);

        $this->exam_results = $this->get_exam_results()->where("year", ">=", $last_year)->distinct()->get();

        $this->subjects = $this->sort_subjects($this->exam_results->map(fn($exam_report) => $exam_report->subject)->unique());
    }

    private function generateSimilarOboryText(?SpecializationGroup $spec_group) : string
    {
        $res = "<div class='text-sm text-gray-500 font-normal'>CERMAT u škol bohužel nezobrazuje výsledky po jednotlivých oborech ale pouze po SKUPINÁCH oborů. U každého oboru školy se proto zobrazují výsledky, kterých škola dosáhla v rámci celé skupiny.</div>"
            . "<div class='mt-6 text-sm text-gray-500 font-normal'>Do skupiny oborů $spec_group->code - $spec_group->name spadají tyto obory:</div><ul class='mt-2'>";

        foreach($spec_group->prescribed_specializations as $ps){
            $res .= "<li class='text-sm text-gray-500 font-normal'>$ps->code - $ps->name</li>";
        }

        $res .= "</ul>";

        return $res;
    }

    private function sort_subjects(Collection $subjects) : Collection
    {
        //Sort subjects
        $subjectSortingPriorities = [
            "Anglický jazyk" => 3,
            "Matematika" => 2,
            "Český jazyk a literatura" => 1
        ];

        $sortedSubjects = [];

        foreach($subjects as $subject){
            $sortedSubjects[$subject] = $subjectSortingPriorities[$subject] ?? 0;
        }

        ksort($sortedSubjects);
        return collect(array_keys($sortedSubjects));
    }

    private function get_exam_results()
    {
        return ExamResult::query()
            ->join("specialization_groups", "exam_results.specialization_group_id", "=", "specialization_groups.id")
            ->join("prescribed_specializations", "prescribed_specializations.specialization_group_id", "=", "specialization_groups.id")
            ->join("specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->where("specializations.id", "=", $this->specialization->id)
            ->where("exam_results.school_id", "=", $this->specialization->school_id);
    }

    public string $textPercentil = "Percentil říká, jaké procento maturantů z celé ČR (gymnázia, střední školy i učební obory s maturitou) dopadlo hůře než konkrétní maturant. Průměrný percentil je zprůměrovaná hodnota za všechny maturanty oboru dané školy. Čím vyšší hodnota u školy je, tím lépe.";
    public string $textMedian = "Medián asi nejlépe odráží celkovou úroveň výuky předmětu na škole. Představme si, že bychom všechny studenty seřadili podle jejich výsledků od nejlepšího po nejhoršího. Medián je pak výsledek toho studenta \"přesně uprostřed\". Na rozdíl od průměru jej tolik neovlivňují výsledky několika málo extrémně dobrých nebo naopak špatných studentů.";
    public string $textUspesnost = "Celková úspěšnost říká, kolik procent studentů 4. ročníku u zkoušky <b>uspělo z celkově přihlášených.</b> Jako neúspěšní se počítají ti, kteří u zkoušky neuspěli, nedostavili se nebo k ní nebyli ani připuštěni (např. nedokončili úspěšně 4. ročník).";
    public string $textNeuspesnost = "Toto kritérium ukazuje především, jaké procento studentů <b>nebylo ke zkoušce připuštěno.</b> Spadnou sem však každoročně i \"speciální případy\" jako dlouhodobé nemoce, zanechání studia ve 4. ročníku před maturitou (po dovršení 18-ti let) apod.";
    public string $textDidaktak = "Server zobrazuje výsledky pouze z didaktických testů, protože ty jediné jsou objektivně porovnatelné. Ostatní zkoušky (písemnou práci i ústní zkoušku) hodnotí stovky různých hodnotitelů jejichž úroveň hodnocení se často diametrálně liší. Kompletní výsledky najdete na https://vysledky.cermat.cz.";
    public string $textLepsiNez = "Výsledek školy je v tomto kritériu lepší nebo stejný než ...% škol v ČR ze <b>stejné skupiny oborů</b>.";
    public string $textSimiliarObory = "";


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $fmt = fn($num) => fmod($num, 1) == 0 ? number_format($num, 0) : number_format($num, 1, ",", " ");


        return view('livewire.show-specialization', [
            'exam_results' => $this->exam_results,
            'subjects' => $this->subjects,
            'years_to_display' => $this->years_to_display,
            'fmt' => $fmt,
            'fmtPrc' => fn($num) => $fmt($num * 100)
        ]);
    }


}
