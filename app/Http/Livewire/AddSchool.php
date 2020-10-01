<?php

namespace App\Http\Livewire;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddSchool extends Component
{
    public School $company;

    public ?string $selected_school_id;

    protected $rules = [
        'selected_school_id' => 'required|exists:schools,id'
    ];

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
        $this->validate();

        $this->company->related_schools()->attach(
            School::find($this->selected_school_id)
        );

        $this->redirect(route("dashboard"));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.add-school', [
            'schools' => $this->company->eligible_schools()->orderBy("schools.name")->get()
        ]);
    }
}
