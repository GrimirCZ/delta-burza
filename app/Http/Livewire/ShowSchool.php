<?php

namespace App\Http\Livewire;

use App\Models\School;
use Livewire\Component;

class ShowSchool extends Component
{
    public School $school;

    private function get_last_inspection_report()
    {
        return $this->school->inspection_reports()->orderByDesc("start_date")->limit(1);
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
