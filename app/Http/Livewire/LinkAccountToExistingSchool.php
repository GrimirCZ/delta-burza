<?php

namespace App\Http\Livewire;

use App\Models\School;
use Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LinkAccountToExistingSchool extends Component
{
    public ?int $school_id = null;
    public ?string $ico = null;

    protected $rules = [
        'school_id' => 'required|exists:schools,id',
    ];

    public function submit()
    {
        $this->validate();

        $user = Auth::user();
        $sch = School::findOrFail($this->school_id);

        if($sch->main_contact() != null){
            abort(403);
        }
        if($user->school_id != null){
            abort(403);
        }

        $normalized_input_ico = str_replace(" ", "", $this->ico);
        $normalized_school_ico = str_replace(" ", "", $sch->ico);
        if($normalized_input_ico !== $normalized_school_ico){
            $this->addError("ico", "Toto není správné IČ školy");
            return;
        }


        $user->school_id = $sch->id;
        $user->is_main_contact = true;
        $user->push();

        $this->redirect("/entita/upravit");
    }

    public function mount()
    {
        if(Auth::user()->school_id != null){
            abort(403);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.link-account-to-existing-school', [
            'unassociated_schools' => School::unassociated_schools()->orderBy("schools.name")->get()
        ]);
    }
}
