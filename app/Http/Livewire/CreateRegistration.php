<?php

namespace App\Http\Livewire;

use App\Models\Exhibition;
use App\Models\Registration;
use App\Models\School;
use DB;
use Livewire\Component;

class CreateRegistration extends Component
{
    public School $school;
    public ?int $exhibition_id;

    public ?string $morning_event;
    public ?string $morning_event_start = "8:00";
    public ?string $morning_event_end = "12:00";

    public ?string $evening_event;
    public ?string $evening_event_start = "18:00";
    public ?string $evening_event_end = "21:00";

    protected $rules = [
        'exhibition_id' => "exists:exhibitions,id",
        'morning_event' => 'required|max:255|url',
        'morning_event_start' => 'required|max:255',
        'morning_event_end' => 'required|max:255',
        'evening_event' => 'required|max:255|url',
        'evening_event_start' => 'required|max:255',
        'evening_event_end' => 'required|max:255',
    ];

    public function submit()
    {
        $this->validate();


        Registration::create([
            'exhibition_id' => $this->exhibition_id,
            'school_id' => $this->school->id,
            'morning_event' => $this->morning_event,
            'morning_event_start' => $this->morning_event_start,
            'morning_event_end' => $this->morning_event_end,
            'evening_event' => $this->evening_event,
            'evening_event_start' => $this->evening_event_start,
            'evening_event_end' => $this->evening_event_end,
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
