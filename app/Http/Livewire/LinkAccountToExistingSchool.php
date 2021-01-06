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

        $normalized_ico = str_replace(" ", "", $this->ico);
        if($normalized_ico !== $sch->ico){
            $this->addError("ico", "Toto není zprávné IČ školy");
            return;
        }


        $user->school_id = $sch->id;
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
