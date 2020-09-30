<?php

namespace App\Http\Livewire;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddSchool extends Component
{
    private School $company;

    private ?string $selected_school_id;

    public function mount()
    {
        $this->company = Auth::user()->school;

        if($this->company->is_school){
            $this->redirect(url("/vystavy"));
            return;
        }
    }

    public function complete()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.add-school', [
            'schools' => $this->company->eligible_schools()->get()
        ]);
    }
}
