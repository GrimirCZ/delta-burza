<?php

namespace App\Http\Livewire;

use App\Helpers\ExhibitionSelection;
use App\Jobs\SendInvoice;
use App\Models\Exhibition;
use App\Models\Order;
use App\Models\OrderRegistration;
use App\Models\Registration;
use App\Models\School;
use Auth;
use Carbon\Carbon;
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

    public $listeners = ['transfer' => 'render', 'complete' => 'complete'];

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
        $this->exhibition_id = $this->selectable_exhibitions()->first()->id;
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
        $due_date = new Carbon(Exhibition::whereIn(
            "id",
            collect($this->selected_exhibitions)->map(fn($e) => $e['exhibition_id'])
        )
            ->where("date", ">", DB::raw("CURRENT_DATE"))
            ->min(DB::raw("DATE_ADD(date, INTERVAL -1 DAY)")));

        $first_exhibition_in = $due_date->diffInDays(Carbon::now());// how far is the first exhibition from current date

        if($first_exhibition_in > 14){
            $due_date = Carbon::now()->addDays(14);
        } else if($first_exhibition_in > 2 && $first_exhibition_in < 14){
            $due_date = $due_date->subDays(2);
        } else{
            $due_date = Carbon::today();
        }

        $is_first_order = $this->is_first_order();

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
                    'evening_event' => $se['evening_event'],
                    'is_disabled' => $is_first_order // make first enabled, rest after the payment is processed
                ]);


                if($is_first_order){
                    $is_first_order = false;


                    OrderRegistration::create([
                        'order_id' => $ord->id,
                        'registration_id' => $reg->id,
                        'fulfilled_at' => DB::raw("CURRENT_DATE"),
                        'price' => 0,
                    ]);
                } else{
                    OrderRegistration::create([
                        'order_id' => $ord->id,
                        'registration_id' => $reg->id,
                        'price' => 1000,
                    ]);

                }

            }

            SendInvoice::dispatch($ord->id);
        });

        $this->redirect(route("dashboard"));
    }

    protected $rules = [
        'exhibition_id' => 'required|exists:exhibitions,id',
        'morning_event' => 'required|url',
        'evening_event' => 'required|url',
    ];

    private function selectable_exhibitions()
    {
        return Exhibition::where("date", ">", DB::raw("CURRENT_DATE"))
            ->whereNotIn("id",
                collect($this->selected_exhibitions)->map(fn($ex) => $ex['exhibition_id'])
                    ->concat(
                        $this->school->registrations()->select("exhibition_id")->get()
                    )
            )
            ->orderBy("date");
    }

    private function is_first_order()
    {
        return $this->school
                ->orders()
                ->join("order_registration", "orders.id", "=", "order_registration.order_id")
                ->count() == 0;
    }

    private function price()
    {
        return $this->is_first_order() ?
            (count($this->selected_exhibitions) - 1) * 1000 :
            count($this->selected_exhibitions) * 1000;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if($this->state == "ALL")
            return view('livewire.create-order', [
                'selected_exhibitions' => $this->selected_exhibitions,
                'is_first_order' => $this->is_first_order(),
                'price' => $this->price()
            ]);
        else if($this->state == "EDIT" || $this->state == "NEW")
            return view("order.create", [
                'exhibitions' => $this->selectable_exhibitions()->get()
            ]);
        else
            return abort(500);
    }
}
