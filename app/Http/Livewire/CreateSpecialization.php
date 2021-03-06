<?php

namespace App\Http\Livewire;

use App\Models\File;
use App\Models\PrescribedSpecialization;
use App\Models\School;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateSpecialization extends Component
{
    use WithFileUploads;

    public School $school;

    public ?string $name = null;
    public ?string $description = null;
    public ?int $prescribed_specialization_id = null;

    protected $rules = [
        'name' => 'required|max:500',
        'description' => 'required',
        'prescribed_specialization_id' => 'exists:prescribed_specializations,id',
    ];

    public function mount()
    {
        $this->school = Auth::user()->school;
    }

    public
    function submit()
    {
        $this->validate();


        Specialization::create([
            'name' => $this->name,
            'description' => html_clean($this->description),
            'prescribed_specialization_id' => $this->prescribed_specialization_id,
            'school_id' => $this->school->id,
        ]);

        $this->redirect("/dashboard");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public
    function render()
    {
        return view('livewire.create-specialization', [
            'prescribed_specializations' => PrescribedSpecialization::orderBy('code')->orderBy('name')->get()
        ]);
    }
}
