<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\Registration;
use App\Models\School;
use Auth;
use DB;
use Livewire\Component;

class CreateRegistration extends Component
{
    public School $school;
    public ?int $exhibition_id;

    public ?string $morning_event;

    public ?string $evening_event;

    protected $rules = [
        'exhibition_id' => "exists:exhibitions,id",
        'morning_event' => 'required|url',
        'evening_event' => 'required|url',
    ];

    public function mount()
    {
        $this->school = Auth::user()->school;
    }

    public function submit()
    {
        $this->validate();


        Registration::create([
            'exhibition_id' => $this->exhibition_id,
            'school_id' => $this->school->id,
            'morning_event' => $this->morning_event,
            'evening_event' => $this->evening_event,
        ]);

        $this->redirect("/dashboard");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.create-registration', [
            'upcoming_exhibitions' => Exhibition::where("date", ">", DB::raw("CURRENT_DATE"))
                ->orderBy("date")
                ->get()
        ]);
    }
}
