<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use DB;
use Livewire\Component;

class ShowExhibition extends Component
{
    public Exhibition $exhibition;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.show-exhibition', [
            'registrations' => $this->exhibition
                ->registrations()
                ->join("schools", "registrations.school_id", "=", "schools.id")
                ->orderBy("schools.name")
                ->select("registrations.*")
                ->get()
        ]);
    }
}
