<?php

namespace App\Http\Livewire;

use App\Helpers\ExhibitionSelection;
use App\Models\Exhibition;
use App\Models\Order;
use App\Models\OrderRegistration;
use App\Models\Registration;
use App\Models\School;
use Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateOrder extends Component
{
    /**
     * Two states -> [ALL, SELECT]
     * ALL -> view all added exhibitions
     * EDIT -> to add new exhibition or edit exhibition already added to the order
     * @var string
     */
    public string $state = "ALL";

    public School $school;

    public array $selected_exhibitions;
    public ?array $selected_exhibition;

    public int $last_id = 0;

    public ?int $exhibition_id;
    public ?string $morning_event;
    public ?string $evening_event;

    public $listeners = ['transfer' => 'render'];

    public function mount()
    {
        $this->school = Auth::user()->school;
        $this->selected_exhibitions = [];
    }

    public function back()
    {
        $this->state = "ALL";
        $this->rerender();
    }

    public function edit($id)
    {
        $exhb = collect($this->selected_exhibitions)
            ->filter(fn($se) => $se['id'] == $id)
            ->first();

        $this->selected_exhibition = $exhb;

        $this->exhibition_id = $exhb['exhibition_id'];
        $this->morning_event = $exhb['morning_event'];
        $this->evening_event = $exhb['evening_event'];

        $this->state = "EDIT";
        $this->rerender();
    }

    public function remove(int $id)
    {
        $this->selected_exhibitions = collect($this->selected_exhibitions)
            ->filter(fn($se) => $se['id'] != $id)
            ->toArray();
        $this->rerender();
    }

    public function add()
    {
        $this->exhibition_id = null;
        $this->morning_event = null;
        $this->evening_event = null;

        $this->state = "NEW";
        $this->rerender();
    }

    public function submit()
    {
        $this->validate();

        $ex = Exhibition::findOrFail($this->exhibition_id);

        if($this->state == "NEW"){
            array_push(
                $this->selected_exhibitions,
                [
                    'id' => $this->last_id++,
                    'name' => $ex->name,
                    'date' => $ex->date,
                    'city' => $ex->city,
                    'exhibition_id' => $this->exhibition_id,
                    'morning_event' => $this->morning_event,
                    'evening_event' => $this->evening_event]
            );
        } else if($this->state == 'EDIT'){
            $this->selected_exhibitions[$this->selected_exhibition['id']]['name'] = $ex->name;
            $this->selected_exhibitions[$this->selected_exhibition['id']]['date'] = $ex->date;
            $this->selected_exhibitions[$this->selected_exhibition['id']]['city'] = $ex->city;
            $this->selected_exhibitions[$this->selected_exhibition['id']]['exhibition_id'] = $this->exhibition_id;
            $this->selected_exhibitions[$this->selected_exhibition['id']]['morning_event'] = $this->morning_event;
            $this->selected_exhibitions[$this->selected_exhibition['id']]['evening_event'] = $this->evening_event;
        }

        $this->state = "ALL";
        $this->rerender();
    }

    private function rerender()
    {
        $this->emit('transfer');
    }

    public function cancel()
    {
        $this->redirect(route("dashboard"));
    }

    public function complete()
    {
        $due_date = Exhibition::whereIn(
            "id",
            collect($this->selected_exhibitions)->map(fn($e) => $e['exhibition_id'])
        )->where("date", ">", DB::raw("CURRENT_DATE"))
            ->min(DB::raw("DATE_ADD(date, INTERVAL -1 DAY)"));

        $is_first_order = $this->school
                ->orders()
                ->join("order_registration", "orders.id", "=", "order_registration.order_id")
                ->count() == 0;

        DB::transaction(function() use ($due_date, $is_first_order){
            $ord = Order::create([
                'due_date' => $due_date,
                'school_id' => $this->school->id,
            ]);

            foreach($this->selected_exhibitions as $se){
//                TODO: add check for already having the exhibition
                $reg = Registration::create([
                    'school_id' => $this->school->id,
                    'exhibition_id' => $se['exhibition_id'],

                    'morning_event' => $se['morning_event'],
                    'evening_event' => $se['evening_event']
                ]);

                $amount = 1000;

                if($is_first_order){
                    $amount = 0;
                    $is_first_order = false;
                }

                OrderRegistration::create([
                    'order_id' => $ord->id,
                    'registration_id' => $reg->id,
                    'price' => $amount,
                ]);
            }
        });

        $this->redirect(route("dashboard"));
    }

    protected $rules = [
        'exhibition_id' => 'required|exists:exhibitions,id',
        'morning_event' => 'required|url',
        'evening_event' => 'required|url',
    ];

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if($this->state == "ALL")
            return view('livewire.create-order', [
                'selected_exhibitions' => $this->selected_exhibitions
            ]);
        else if($this->state == "EDIT" || $this->state == "NEW")
            return view("order.create", [
                'exhibitions' => Exhibition::where("date", ">", DB::raw("CURRENT_DATE"))
                    ->whereNotIn("id",
                        collect($this->selected_exhibitions)->map(fn($ex) => $ex['exhibition_id'])
                            ->concat(
                                $this->school->registrations()->select("exhibition_id")->get()
                            )
                    )
                    ->orderBy("date")
                    ->get()
            ]);
        else
            return abort(500);
    }
}
