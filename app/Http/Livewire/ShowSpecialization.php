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

    public string $textPercentil = "Percentil říká, jaké procento maturantů z celé ČR (gymnázia, střední školy i učební obory s maturitou) dopadlo hůře než konkrétní maturant. Průměrný percentil je zprůměrovaná hodnota za všechny maturanty oboru dané školy. Čím vyšší hodnota u školy je, tím lépe.";
    public string $textMedian = "Pokud budete mít ve třídě například 3 génie, kteří dosáhnou 100 bodů a zbytek třídy bude podprůměrný, mohou ti 3 nejlepší výrazně zkreslit průměr celé třídy (stejně to samozřejmě platí i směrem dolů). Představme si však, že bychom studenty seřadili podle jejich výsledků od nejlepšího po nejhoršího. Medián je pak výsledek toho studenta \"přesně uprostřed\". Medián tak možná lépe ukazuje kvalitu výuky všeobecně vzdělávacích předmětů na škole. Netrpí také tolik zkreslením celkových výsledků génii a špatnými studenty.";
    public string $textUspesnost = "Celková úspěšnost říká, kolik % studentů 4. ročníku uspělo u zkoušky z celkově přihlášených. Jako neúspěšní jsou do tohoto kritéria započítáváni jak ti, kteří u zkoušky neuspěli, tak i ti, kteří se k ní buď nedostavili nebo k ní nebyli ani připuštěni (např. nedokončili úspěšně 4. ročník). ";
    public string $textNeuspesnost = "Toto kritérium ukazuje především, jaké % studentů nebylo ke zkoušce připuštěno. Spadnou sem však každoročně i \"speciální případy\" jako dlouhodobé nemoce, zanechání studia ve 4. ročníku před maturitou (po dovršení 18-ti let) apod.";
    public string $textDidaktak = "Server zobrazuje výsledky pouze z didaktických testů, protože ty jediné jsou objektivně porovnatelné. Další zkoušky - jak písemnou práci tak i ústní zkoušku hodnotí stovky různých hodnotitelů jejichž hodnocení se diametrálně liší.";


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $exam_results = $this->get_exam_results()->distinct()->get();
        $subjects = $exam_results->map(fn($exam_report) => $exam_report->subject)->unique();

        $fmt = fn($num) => fmod($num, 1) == 0 ? number_format($num, 0) : number_format($num, 1, ",", " ");

        return view('livewire.show-specialization', [
            'exam_results' => $exam_results,
            'subjects' => $subjects,
            'fmt' => $fmt,
            'fmtPrc' => fn($num) => $fmt($num * 100)
        ]);
    }
}
