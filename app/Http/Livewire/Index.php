<?php

namespace App\Http\Livewire;

use App\Article;
use App\Models\Exhibition;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FileNotFoundException;
use Livewire\Component;

class Index extends Component
{
    private function get_current_exhibitions()
    {
        // nesahat
        $q = DB::table("exhibitions")
            ->join("registrations", "registrations.exhibition_id", "=", "exhibitions.id")
            ->join("schools", "registrations.school_id", "=", "schools.id")
            ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
            ->where(function($q){
                $q->whereNotNull("order_registration.fulfilled_at")
                    ->orWhere("schools.is_trustworthy", true);
            })
            ->where("date", "=", DB::raw("CURRENT_DATE"))
            ->select(DB::raw("exhibitions.id as exhibition_id"), DB::raw("count(schools.id) as school_count"))
            ->groupBy("exhibitions.id");

        return Exhibition::joinSub($q, "exh_sch_count", function($join){
            $join->on("exhibitions.id", "=", "exh_sch_count.exhibition_id");
        })
            ->orderByDesc("exh_sch_count.school_count")
            ->orderBy("exhibitions.date")
            ->orderBy("exhibitions.city")
            ->orderBy("exhibitions.name")
            ->select("exhibitions.*", DB::raw("exh_sch_count.school_count as school_count"));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.index', [
            "schoolsCount" => School::schools()->count(),
            "companiesCount" => School::companies()->count(),
            'exibitionsCount' => Exhibition::count(),
            'articles' => Article::where("show", true)
                ->orderByDesc("date")
                ->get(),
            'current_exhibitions' => $this->get_current_exhibitions()->get(),
            'upcoming_exhibitions' => Exhibition::where("date", ">", DB::raw("CURRENT_DATE"))
                ->orderBy("date")
                ->limit(4)
                ->get()
        ]);
    }
}
