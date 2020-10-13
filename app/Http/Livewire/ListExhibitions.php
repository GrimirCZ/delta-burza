<?php

namespace App\Http\Livewire;

use App\Models\Region;
use App\Models\Exhibition;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListExhibitions extends Component
{
    public function exhibitions($region_id = null)
    {
        $exh_exhibitioners = DB::table("exhibitions")
            ->join("registrations", "registrations.exhibition_id", "=", "exhibitions.id")
            ->join("schools", "registrations.school_id", "=", "schools.id")
            ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
            ->whereIn("schools.id", function($q){
                $q->select("schools.id")
                    ->from("schools");
            })
            ->where(function($q){
                $q->whereNotNull("order_registration.fulfilled_at")
                    ->orWhere("schools.is_trustworthy", true);
            })
            ->where("exhibitions.date", ">=", DB::raw("CURRENT_TIMESTAMP"))
            ->select(DB::raw("exhibitions.id as exhibition_id"), DB::raw("count(schools.id) as school_count"))
            ->groupBy("exhibitions.id");

        $upcoming = Exhibition::join('districts', 'exhibitions.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->leftJoinSub($exh_exhibitioners, 'exh_sch_cnt', function($join){
                $join->on("exhibitions.id", "=", "exh_sch_cnt.exhibition_id");
            })
            ->where("exhibitions.date", ">=", DB::raw("CURRENT_TIMESTAMP"))
            ->select('exhibitions.*',
                DB::raw(" exh_sch_cnt.school_count as school_count"),
                DB::raw("0 as u"),
                "regions.name as region_name",
                "exhibitions.name as exhibition_name");

        $expired = Exhibition::join('districts', 'exhibitions.district_id', '=', 'districts.id')
            ->join('regions', 'districts.region_id', '=', 'regions.id')
            ->where("exhibitions.date", "<", DB::raw("CURRENT_TIMESTAMP"))
            ->orderBy('regions.name')
            ->orderBy('exhibitions.date')
            ->select('exhibitions.*',
                DB::raw("0 as school_count"),
                DB::raw("1 as u"),
                "regions.name as region_name",
                "exhibitions.name as exhibition_name");

        if($region_id != null){
            $upcoming = $upcoming->where('regions.id', "==", $region_id);
            $expired = $upcoming->where('regions.id', "==", $region_id);
        }

        return $upcoming->union($expired)
            ->orderBy("u")
            ->orderByDesc('school_count')
            ->orderBy('region_name')
            ->orderBy('exhibition_name');
//        return $upcoming;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.list-exhibitions', [
            'exhibitions' => $this->exhibitions()->get(),
            'regions' => Region::get(),
            'regionSelected' => 0
        ]);
    }

    public function showByRegionId($region_id)
    {
        return view('livewire.list-exhibitions', [
            'exhibitions' => $this->exhibitions($region_id),
            'regions' => Region::get(),
            'regionSelected' => 0
        ]);
    }
}
