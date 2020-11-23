<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\PrescribedSpecialization;
use App\Models\School;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditSpecialization extends Component
{
    use WithFileUploads;

    public Specialization $specialization;

    public ?string $name = null;
    public ?string $description = null;
    public ?int $prescribed_specialization_id = null;

    protected $rules = [
        'name' => 'required|max:500',
        'description' => 'required',
        'prescribed_specialization_id' => 'exists:prescribed_specializations,id',
    ];

    public function mount(Specialization $specialization)
    {
        if(Auth::user()->id != $specialization->school->main_contact()->id){
            return abort(400);
        }

        $this->specialization = $specialization;
        $this->name = $specialization->name;
        $this->description = $specialization->description;
        $this->prescribed_specialization_id = $specialization->prescribed_specialization_id;
    }

    public function submit()
    {
        $this->validate();


        $this->specialization->update([
            'name' => $this->name,
            'description' => html_clean($this->description),
            'prescribed_specialization_id' => $this->prescribed_specialization_id,
        ]);

        $this->redirect(url("/dashboard"));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.create-specialization', [
            'prescribed_specializations' => PrescribedSpecialization::orderBy('code')->orderBy("name")->get()
        ]);
    }
}
